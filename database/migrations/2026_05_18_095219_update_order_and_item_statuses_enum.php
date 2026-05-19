<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify orders table status column
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `status` ENUM('pending', 'accepted', 'rejected', 'partially_accepted', 'preparing', 'shipping', 'delivered') NOT NULL DEFAULT 'pending'");

        // Modify order_items table status column
        DB::statement("ALTER TABLE `order_items` MODIFY COLUMN `status` ENUM('pending', 'accepted', 'rejected', 'preparing', 'shipping', 'delivered') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert order_items table status column
        DB::statement("ALTER TABLE `order_items` MODIFY COLUMN `status` ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending'");

        // Revert orders table status column
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `status` ENUM('pending', 'accepted', 'rejected', 'partially_accepted') NOT NULL DEFAULT 'pending'");
    }
};
