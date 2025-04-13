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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // holiday class name
            $table->enum('category', ['soccer', 'music']); // Category
            $table->string('avatar')->nullable(); // Main holiday class image
            $table->json('images')->nullable(); // Other holiday class images
            $table->string('color')->nullable(); // holiday class color
            $table->string('brand')->nullable(); // holiday class brand
            $table->string('in_stock')->nullable(); // Stock quantity
            $table->enum('condition', ['new', 'old'])->default('new'); // Condition
            $table->string('price'); // holiday class price
            $table->string('discount')->nullable(); // Discounted price
            $table->text('desc')->nullable(); // holiday class description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
