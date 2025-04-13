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
        Schema::create('furniture', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // furniture name
            $table->enum('category', ['office', 'classroom']); // Category
            $table->string('avatar')->nullable(); // Main furniture image
            $table->json('images')->nullable(); // Other furniture images
            $table->string('color')->nullable(); // furniture color
            $table->string('brand')->nullable(); // furniture brand
            $table->string('in_stock')->nullable(); // Stock quantity
            $table->enum('condition', ['new', 'old'])->default('new'); // Condition
            $table->string('price'); // furniture price
            $table->string('discount')->nullable(); // Discounted price
            $table->text('desc')->nullable(); // furniture description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furniture');
    }
};
