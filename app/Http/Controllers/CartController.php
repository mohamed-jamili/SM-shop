<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Notifications\ProductAddedToCartNotification;
use App\Support\SessionCart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('checkout', [
            'cartItems' => SessionCart::items(),
            'cartCount' => SessionCart::count(),
            'cartTotal' => SessionCart::total(),
        ]);
    }

    public function shipping()
    {
        return view('checkout-shipping', [
            'cartItems' => SessionCart::items(),
            'cartCount' => SessionCart::count(),
            'cartTotal' => SessionCart::total(),
        ]);
    }

    public function storeShipping(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->session()->put('checkout_shipping', $request->only([
            'full_name',
            'phone',
            'shipping_address',
            'apartment',
            'shipping_city',
            'state',
            'shipping_postal_code',
            'shipping_country',
            'save_address'
        ]));

        return redirect()->route('buyer.checkout.payment');
    }

    public function payment()
    {
        return view('checkout-payment', [
            'cartItems' => SessionCart::items(),
            'cartCount' => SessionCart::count(),
            'cartTotal' => SessionCart::total(),
            'shipping' => session('checkout_shipping', []),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        if (!$product->is_active || $product->stock < 1) {
            return back()->with('error', 'This product is currently unavailable.');
        }

        $requestedQty = $validated['quantity'] ?? 1;
        if ($requestedQty > $product->stock) {
            return back()->with('error', 'Not enough stock available.');
        }

        SessionCart::add($product, $requestedQty);

        // Sync to database so seller can see "En cours"
        $this->syncCartToDatabase();

        $draftOrder = Order::query()
            ->where('buyer_id', auth()->id())
            ->whereNull('ordered_at')
            ->first();

        if ($draftOrder) {
            $orderItem = OrderItem::query()
                ->where('order_id', $draftOrder->id)
                ->where('product_id', $product->id)
                ->first();

            if ($orderItem && $orderItem->status === OrderItem::STATUS_PENDING) {
                $product->seller->notify(new ProductAddedToCartNotification(auth()->user(), $product));
            }
        }

        return back()->with('success', 'Product added to your cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        SessionCart::update($product, $validated['quantity']);
        
        // Sync update to database
        $this->syncCartToDatabase();

        return back()->with('success', 'Cart updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        SessionCart::remove($product->id);

        // Mark as rejected in database when removed from cart
        $this->markAsRejectedInDatabase($product->id);

        return back()->with('success', 'Product removed from your cart.');
    }

    public function clear(): RedirectResponse
    {
        $items = SessionCart::items();
        foreach($items as $item) {
            $this->markAsRejectedInDatabase($item['id']);
        }

        SessionCart::clear();

        return back()->with('success', 'Your cart has been cleared.');
    }

    protected function syncCartToDatabase()
    {
        $user = auth()->user();
        if (!$user) return;

        $cartItems = SessionCart::items();
        
        // Find or create a draft order (ordered_at is null)
        $order = \App\Models\Order::firstOrCreate(
            ['buyer_id' => $user->id, 'ordered_at' => null],
            [
                'total_amount' => 0,
                'status' => 'pending',
                'shipping_address' => 'Pending Checkout',
                'shipping_city' => 'Pending',
                'shipping_postal_code' => '00000',
                'shipping_country' => 'Pending',
                'payment_method' => 'Pending',
            ]
        );

        foreach ($cartItems as $item) {
            \App\Models\OrderItem::updateOrCreate(
                ['order_id' => $order->id, 'product_id' => $item['id']],
                [
                    'seller_id' => $item['seller_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'status' => 'pending',
                ]
            );
        }

        $order->update(['total_amount' => SessionCart::total()]);
    }

    protected function markAsRejectedInDatabase($productId)
    {
        $user = auth()->user();
        if (!$user) return;

        $order = \App\Models\Order::where('buyer_id', $user->id)
            ->whereNull('ordered_at')
            ->first();

        if ($order) {
            \App\Models\OrderItem::where('order_id', $order->id)
                ->where('product_id', $productId)
                ->update(['status' => 'rejected']);
            
            $order->update(['total_amount' => SessionCart::total()]);
        }
    }

    public static function restoreCartSession($user)
    {
        if (!$user || !$user->isBuyer()) return;

        $order = \App\Models\Order::where('buyer_id', $user->id)
            ->whereNull('ordered_at')
            ->with(['items.product'])
            ->first();

        if ($order) {
            // Clear current session first to avoid duplicates
            SessionCart::clear();

            foreach ($order->items as $item) {
                if ($item->status === 'pending' && $item->product) {
                    SessionCart::add($item->product, $item->quantity);
                }
            }
        }
    }
}
