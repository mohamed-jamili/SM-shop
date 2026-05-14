<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the categories table.
     * Categories are used to organise products (e.g. Electronics, Clothing).
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Category display name (e.g. "Electronics")
            $table->string('name');

            // URL-friendly version of the name (e.g. "electronics")
            $table->string('slug')->unique();

            // Optional longer description of the category
            $table->text('description')->nullable();

            // Hide/show category without deleting it
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Drop the categories table on rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
