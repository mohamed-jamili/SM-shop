<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'minimum_stock')) {
                $table->unsignedInteger('minimum_stock')
                    ->default(15)
                    ->after('stock');
            }

            if (! Schema::hasColumn('products', 'discount')) {
                $table->decimal('discount', 5, 2)
                    ->default(0)
                    ->after(Schema::hasColumn('products', 'minimum_stock') ? 'minimum_stock' : 'stock');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('products', 'minimum_stock')) {
                $columnsToDrop[] = 'minimum_stock';
            }

            if (Schema::hasColumn('products', 'discount')) {
                $columnsToDrop[] = 'discount';
            }

            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
