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
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // sports name
            $table->enum('category', ['balls', 'jerseys', 'board_games', 'indoor_games']); // Category
            $table->string('avatar')->nullable(); // Main sports image
            $table->json('images')->nullable(); // Other sports images
            $table->string('color')->nullable(); // sports color
            $table->string('brand')->nullable(); // sports brand
            $table->string('in_stock')->nullable(); // Stock quantity
            $table->enum('condition', ['new', 'old'])->default('new'); // Condition
            $table->string('price'); // sports price
            $table->string('discount')->nullable(); // Discounted price
            $table->text('desc')->nullable(); // sports description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};
