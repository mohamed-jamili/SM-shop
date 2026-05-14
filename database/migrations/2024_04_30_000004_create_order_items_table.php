<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the order_items table.
     * Each row is one product line inside an order.
     * The seller can accept or reject each item individually.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // The parent order this item belongs to
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // The product that was ordered
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            // The seller who owns the product (cached here for easy seller dashboard queries)
            $table->foreignId('seller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // How many units the buyer ordered
            $table->unsignedInteger('quantity');

            // Price per unit at the time of purchase
            // IMPORTANT: we save the price here so order history stays correct
            // even if the seller changes the product price later
            $table->decimal('unit_price', 10, 2);

            // Seller can accept or reject their item independently
            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
            ])->default('pending');

            $table->timestamps();

            // Index for fast lookup of items by order, product, and seller
            $table->index('order_id');
            $table->index('product_id');
            $table->index('seller_id');
            $table->index('status');
        });
    }

    /**
     * Drop the order_items table on rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
