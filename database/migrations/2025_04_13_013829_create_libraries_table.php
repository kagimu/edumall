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
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // book name
            $table->enum('category', ['textbook', 'NewCurriculum']); // Category
            $table->string('avatar')->nullable(); // Main book image
            $table->json('images')->nullable(); // Other book images
            $table->string('color')->nullable(); // book color
            $table->string('brand')->nullable(); // book brand
            $table->string('in_stock')->nullable(); // Stock quantity
            $table->enum('condition', ['new', 'old'])->default('new'); // Condition
            $table->string('price'); // book price
            $table->string('discount')->nullable(); // Discounted price
            $table->text('desc')->nullable(); // book description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
