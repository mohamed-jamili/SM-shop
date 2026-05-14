<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'shop_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('shop_name')->nullable()->after('role');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'shop_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('shop_name');
            });
        }
    }
};
