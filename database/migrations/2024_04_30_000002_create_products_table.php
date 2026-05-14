<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the products table.
     * Each product belongs to a seller (User) and a category.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // The seller who created this product (references users table)
            $table->foreignId('seller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // The category this product belongs to
            $table->foreignId('category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            // Product display name
            $table->string('name');

            // Full product description shown to buyers
            $table->text('description')->nullable();

            // Price with up to 2 decimal places (e.g. 99.99)
            $table->decimal('price', 10, 2);

            // How many units are available for purchase
            $table->unsignedInteger('stock')->default(0);

            // Path to the product image stored in /storage
            $table->string('image_path')->nullable();

            // Seller can hide a product without deleting it
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Index for fast filtering by seller and category
            $table->index('seller_id');
            $table->index('category_id');
            $table->index('is_active');
        });
    }

    /**
     * Drop the products table on rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
