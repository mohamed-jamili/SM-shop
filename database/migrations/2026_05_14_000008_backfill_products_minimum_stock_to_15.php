<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'minimum_stock')) {
            return;
        }

        DB::table('products')
            ->where('minimum_stock', 0)
            ->update(['minimum_stock' => 15]);

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE products MODIFY minimum_stock INT UNSIGNED NOT NULL DEFAULT 15');
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('products', 'minimum_stock')) {
            return;
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE products MODIFY minimum_stock INT UNSIGNED NOT NULL DEFAULT 0');
        }
    }
};
