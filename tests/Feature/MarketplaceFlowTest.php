<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockAlertNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketplaceFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_are_redirected_to_their_role_dashboard_after_authentication(): void
    {
        $sellerData = [
            'name' => 'Seller User',
            'email' => 'seller-flow@example.com',
            'role' => User::ROLE_SELLER,
            'shop_name' => 'Seller Shop',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->post(route('register.store'), $sellerData)
            ->assertRedirect(route('seller.home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => $sellerData['email'],
            'role' => User::ROLE_SELLER,
        ]);

        $this->post(route('logout'))->assertRedirect(route('home'));

        $this->post(route('login.store'), [
            'email' => $sellerData['email'],
            'password' => $sellerData['password'],
        ])->assertRedirect(route('seller.home'));

        $this->post(route('logout'))->assertRedirect(route('home'));

        $this->post(route('register.store'), [
            'name' => 'Buyer User',
            'email' => 'buyer-flow@example.com',
            'role' => User::ROLE_BUYER,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('buyer.home'));
    }

    public function test_checkout_keeps_order_pending_for_seller_validation_while_reserving_stock_and_supports_tracking_progression(): void
    {
        $seller = User::factory()->seller()->create([
            'email' => 'seller@example.com',
        ]);

        $this->actingAs($seller)
            ->post(route('seller.products.store'), [
                'name' => 'Mechanical Keyboard',
                'category' => 'Accessories',
                'description' => 'Hot-swappable keyboard with tactile switches.',
                'price' => 149.99,
                'stock' => 6,
                'minimum_stock' => 5,
                'discount' => 20,
            ])
            ->assertRedirect(route('seller.home'));

        /** @var Product $product */
        $product = Product::query()->firstOrFail();

        $buyer = User::factory()->buyer()->create([
            'email' => 'buyer@example.com',
        ]);

        $this->actingAs($buyer)
            ->get(route('buyer.home'))
            ->assertOk()
            ->assertSee('Mechanical Keyboard');

        $this->actingAs($buyer)
            ->post(route('buyer.cart.store', $product), [
                'quantity' => 2,
            ])
            ->assertRedirect();

        $this->get(route('buyer.checkout'))
            ->assertOk()
            ->assertSee('Mechanical Keyboard');

        $this->post(route('buyer.orders.store'), [
            'shipping_address' => '123 Market Street',
            'shipping_city' => 'Casablanca',
            'shipping_postal_code' => '20000',
            'shipping_country' => 'Morocco',
            'payment_method' => 'card',
        ])->assertRedirect();

        /** @var Order $order */
        $order = Order::query()->with('items')->firstOrFail();
        /** @var OrderItem|null $orderItem */
        $orderItem = $order->items->first();

        $this->assertSame(Order::STATUS_PENDING, $order->status);
        $this->assertCount(1, $order->items);
        $this->assertNotNull($orderItem);
        $this->assertSame(2, $orderItem->quantity);
        $this->assertSame(119.99, (float) $orderItem->unit_price);
        $this->assertSame(OrderItem::STATUS_PENDING, $orderItem->status);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 4,
            'minimum_stock' => 5,
            'discount' => 20.00,
        ]);

        $seller->refresh();
        $lowStockNotifications = $seller->notifications()->where('type', LowStockAlertNotification::class)->get();
        $this->assertCount(1, $lowStockNotifications);

        $this->actingAs($seller)
            ->patch(route('seller.orders.items.status', $orderItem), [
                'status' => OrderItem::STATUS_ACCEPTED,
            ])
            ->assertRedirect();

        $order->refresh();
        $orderItem->refresh();

        $this->assertSame(Order::STATUS_ACCEPTED, $order->status);
        $this->assertSame(OrderItem::STATUS_ACCEPTED, $orderItem->status);

        $this->actingAs($seller)
            ->patch(route('seller.orders.status', $order), [
                'status' => OrderItem::STATUS_PREPARING,
            ])
            ->assertRedirect();

        $order->refresh();
        $orderItem->refresh();

        $this->assertSame(Order::STATUS_PREPARING, $order->status);
        $this->assertSame(OrderItem::STATUS_PREPARING, $orderItem->status);

        $this->actingAs($seller)
            ->patch(route('seller.orders.status', $order), [
                'status' => OrderItem::STATUS_SHIPPING,
            ])
            ->assertRedirect();

        $order->refresh();
        $orderItem->refresh();

        $this->assertSame(Order::STATUS_SHIPPING, $order->status);
        $this->assertSame(OrderItem::STATUS_SHIPPING, $orderItem->status);

        $this->actingAs($seller)
            ->patch(route('seller.orders.status', $order), [
                'status' => OrderItem::STATUS_DELIVERED,
            ])
            ->assertRedirect();

        $order->refresh();
        $orderItem->refresh();

        $this->assertSame(Order::STATUS_DELIVERED, $order->status);
        $this->assertSame(OrderItem::STATUS_DELIVERED, $orderItem->status);
    }

    public function test_deleting_a_product_with_existing_order_history_archives_it_instead_of_removing_it(): void
    {
        $seller = User::factory()->seller()->create();
        $buyer = User::factory()->buyer()->create();

        $product = Product::query()->create([
            'seller_id' => $seller->id,
            'category_id' => \App\Models\Category::query()->create([
                'name' => 'Accessories',
                'slug' => 'accessories',
                'is_active' => true,
            ])->id,
            'name' => 'Archived Product',
            'description' => 'Test product',
            'price' => 100,
            'stock' => 1,
            'minimum_stock' => 0,
            'discount' => 0,
            'is_active' => true,
        ]);

        $order = Order::query()->create([
            'buyer_id' => $buyer->id,
            'total_amount' => 100,
            'status' => Order::STATUS_ACCEPTED,
            'shipping_address' => '123 Main Street',
            'shipping_city' => 'Casablanca',
            'shipping_postal_code' => '20000',
            'shipping_country' => 'Morocco',
            'payment_method' => 'card',
            'ordered_at' => now(),
        ]);

        OrderItem::query()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'seller_id' => $seller->id,
            'quantity' => 1,
            'unit_price' => 100,
            'status' => OrderItem::STATUS_ACCEPTED,
        ]);

        $this->actingAs($seller)
            ->delete(route('seller.products.destroy', $product))
            ->assertRedirect();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);
    }
}
