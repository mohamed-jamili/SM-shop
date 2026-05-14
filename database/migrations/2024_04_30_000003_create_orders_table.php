<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the orders table.
     * An order is created by a buyer and contains one or more order items.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // The buyer who placed this order (references users table)
            $table->foreignId('buyer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Total price of all items at time of purchase
            $table->decimal('total_amount', 10, 2);

            // Order lifecycle status
            // pending = waiting for sellers to accept
            // accepted = all items accepted
            // rejected = all items rejected
            // partially_accepted = some accepted, some rejected
            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
                'partially_accepted',
            ])->default('pending');

            // Shipping information provided at checkout
            $table->string('shipping_address');
            $table->string('shipping_city', 100);
            $table->string('shipping_postal_code', 20);
            $table->string('shipping_country', 100);

            // Payment method chosen at checkout (e.g. "cash_on_delivery")
            $table->string('payment_method', 100);

            // Exact timestamp when the buyer confirmed the order
            $table->timestamp('ordered_at')->nullable();

            $table->timestamps();

            // Index for fast lookup of orders by buyer and status
            $table->index('buyer_id');
            $table->index('status');
        });
    }

    /**
     * Drop the orders table on rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
