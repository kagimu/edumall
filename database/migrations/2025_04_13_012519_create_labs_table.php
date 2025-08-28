<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('labs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Product name
            $table->enum('category', ['laboratory','textbooks','stationery','school_accessories','boardingSchool','sports','food','health','furniture','technology']); // Category
            $table->string('avatar')->nullable(); // Main product image
            $table->json('images')->nullable(); // Other product images
            $table->string('color')->nullable(); // Product color
            $table->string('rating')->nullable(); // Product brand
            $table->string('in_stock')->nullable(); // Stock quantity
            $table->enum('condition', ['new', 'old'])->default('new'); // Condition
            $table->string('price'); // Product price
            $table->string('unit')->nullable(); // Discounted price
            $table->text('desc')->nullable(); // Product description
            $table->string('purchaseType')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labs');
    }
};
