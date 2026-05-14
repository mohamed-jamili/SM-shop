<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Notifications\BuyerOrderStatusNotification;
use App\Notifications\NewOrderReceivedNotification;
use App\Support\OrderStatusFlow;
use App\Support\SessionCart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Handle the checkout process (Buyer creating an order)
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_postal_code' => 'required|string',
            'shipping_country' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $cartItems = SessionCart::items();

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $order = null;
        $lowStockProductIds = [];

        DB::transaction(function () use ($request, $cartItems, &$order, &$lowStockProductIds) {
            $order = Order::query()->firstOrCreate(
                ['buyer_id' => auth()->id(), 'ordered_at' => null],
                [
                    'total_amount' => 0,
                    'status' => Order::STATUS_PENDING,
                    'shipping_address' => 'Pending Checkout',
                    'shipping_city' => 'Pending',
                    'shipping_postal_code' => '00000',
                    'shipping_country' => 'Pending',
                    'payment_method' => 'Pending',
                ]
            );

            $orderTotal = 0;

            foreach ($cartItems as $item) {
                $product = Product::query()
                    ->with('seller')
                    ->lockForUpdate()
                    ->find($item['id']);

                if (! $product || ! $product->is_active) {
                    throw ValidationException::withMessages([
                        'cart' => "The product {$item['name']} is no longer available.",
                    ]);
                }

                $existingItem = OrderItem::query()
                    ->where('order_id', $order->id)
                    ->where('product_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                $requestedQuantity = (int) $item['quantity'];
                $previousReservedQuantity = $existingItem
                    && $order->ordered_at !== null
                    && in_array($existingItem->status, [
                        OrderItem::STATUS_PENDING,
                        OrderItem::STATUS_ACCEPTED,
                    ], true)
                    ? (int) $existingItem->quantity
                    : 0;

                $quantityDelta = $requestedQuantity - $previousReservedQuantity;

                if ($quantityDelta > 0) {
                    if ($product->stock < $quantityDelta) {
                        throw ValidationException::withMessages([
                            'cart' => "Sorry, not enough stock left for {$product->name}.",
                        ]);
                    }

                    $product->decrement('stock', $quantityDelta);
                    $product->refresh();

                    if ($product->is_low_stock) {
                        $lowStockProductIds[] = $product->id;
                    }
                } elseif ($quantityDelta < 0) {
                    $product->increment('stock', abs($quantityDelta));
                    $product->refresh();
                }

                $unitPrice = (float) ($item['price'] ?? $product->final_price);

                OrderItem::updateOrCreate(
                    ['order_id' => $order->id, 'product_id' => $product->id],
                    [
                        'seller_id' => $product->seller_id,
                        'quantity' => $requestedQuantity,
                        'unit_price' => $unitPrice,
                        'status' => OrderItem::STATUS_PENDING,
                    ]
                );

                $orderTotal += $unitPrice * $requestedQuantity;
            }

            $order->update([
                'total_amount' => round($orderTotal, 2),
                'status' => Order::STATUS_PENDING,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_country' => $request->shipping_country,
                'payment_method' => $request->payment_method,
                'ordered_at' => now(),
            ]);

            SessionCart::clear();
        });

        Product::query()
            ->with('seller')
            ->whereIn('id', array_unique($lowStockProductIds))
            ->get()
            ->each
            ->notifySellerAboutLowStock();

        if ($order) {
            $order->loadMissing('buyer');
            $sellerIds = collect($cartItems)->pluck('seller_id')->unique()->filter()->values();
            $sellers = \App\Models\User::query()
                ->whereIn('id', $sellerIds)
                ->get();

            foreach ($sellers as $seller) {
                $seller->notify(new NewOrderReceivedNotification($order));
            }
        }

        return redirect()->route('buyer.order.confirmation', ['order' => $order->id]);
    }

    /**
     * Show the order confirmation page
     */
    public function confirmation(Order $order): View
    {
        if ($order->buyer_id !== auth()->id()) {
            abort(403);
        }

        return view('order-confirmation', compact('order'));
    }

    /**
     * Handle Seller action: Accept or Reject an item
     */
    public function updateItemStatus(Request $request, OrderItem $item): RedirectResponse
    {
        if ($item->seller_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:' . implode(',', OrderStatusFlow::itemStatuses()),
        ]);

        $statusChanged = false;

        DB::transaction(function () use ($request, $item, &$statusChanged) {
            $lockedItem = OrderItem::query()
                ->with('order.buyer')
                ->lockForUpdate()
                ->findOrFail($item->id);

            $statusChanged = $this->transitionItemStatus($lockedItem, $request->string('status')->toString());

            if ($statusChanged) {
                $this->notifyBuyerAboutStatusUpdate($lockedItem->order, $lockedItem->status);
            }
        });

        return redirect()->back()->with('success', 'Item status updated successfully.');
    }

    /**
     * Batch update all seller-owned items in an order without affecting other sellers.
     */
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $sellerId = (int) auth()->id();

        $request->validate([
            'status' => 'required|in:' . implode(',', OrderStatusFlow::itemStatuses()),
        ]);

        $targetStatus = $request->string('status')->toString();
        $order->load([
            'items' => fn ($query) => $query->where('seller_id', $sellerId),
        ]);

        $sellerItems = $order->sellerItems($sellerId);

        if ($sellerItems->isEmpty()) {
            abort(403);
        }

        $availableTransitions = OrderStatusFlow::availableBatchTransitions($sellerItems);

        if (! in_array($targetStatus, $availableTransitions, true)) {
            throw ValidationException::withMessages([
                'status' => 'This order cannot be moved to the selected status right now.',
            ]);
        }

        $updatedAny = false;

        DB::transaction(function () use ($order, $sellerItems, $targetStatus, &$updatedAny) {
            $lockedItems = OrderItem::query()
                ->whereIn('id', $sellerItems->pluck('id'))
                ->with('order.buyer')
                ->lockForUpdate()
                ->get();

            $sourceStatuses = OrderStatusFlow::batchSourcesForTarget($targetStatus);
            $updatedAny = false;

            foreach ($lockedItems as $lockedItem) {
                if (! in_array($lockedItem->status, $sourceStatuses, true)) {
                    continue;
                }

                $this->transitionItemStatus($lockedItem, $targetStatus, false);
                $updatedAny = true;
            }

            if (! $updatedAny) {
                throw ValidationException::withMessages([
                    'status' => 'No order items were eligible for that status update.',
                ]);
            }

            $freshOrder = Order::query()->with('buyer')->findOrFail($order->id);
            $freshOrder->syncStatusFromItems();

            if ($freshOrder->buyer) {
                $this->notifyBuyerAboutStatusUpdate($freshOrder, $targetStatus);
            }
        });

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Apply a validated item status transition and keep stock/order data in sync.
     */
    protected function transitionItemStatus(OrderItem $item, string $newStatus, bool $syncOrder = true): bool
    {
        if ($item->status === $newStatus) {
            return false;
        }

        if (! $item->canTransitionTo($newStatus)) {
            throw ValidationException::withMessages([
                'status' => 'Invalid status transition.',
            ]);
        }

        if ($newStatus === OrderItem::STATUS_ACCEPTED && $item->status === OrderItem::STATUS_REJECTED) {
            $product = Product::query()
                ->with('seller')
                ->where('id', $item->product_id)
                ->lockForUpdate()
                ->first();

            if (! $product || $product->stock < $item->quantity) {
                throw ValidationException::withMessages([
                    'status' => 'Sorry, not enough stock left for ' . ($product?->name ?? 'this product') . '.',
                ]);
            }

            $product->decrement('stock', $item->quantity);
            $product->refresh();

            if ($product->is_low_stock) {
                $product->notifySellerAboutLowStock();
            }
        }

        if ($newStatus === OrderItem::STATUS_REJECTED && $item->status !== OrderItem::STATUS_REJECTED) {
            $product = Product::query()
                ->where('id', $item->product_id)
                ->lockForUpdate()
                ->first();

            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        $item->update(['status' => $newStatus]);

        if ($syncOrder) {
            $item->order->syncStatusFromItems();
        }

        return true;
    }

    protected function notifyBuyerAboutStatusUpdate(Order $order, string $status): void
    {
        if (! $order->buyer) {
            return;
        }

        $order->buyer->notify(new BuyerOrderStatusNotification($order, $status));
    }
}
