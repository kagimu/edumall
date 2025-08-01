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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // events name
            $table->enum('category', ['sound', 'tents']); // Category
            $table->string('avatar')->nullable(); // Main events image
            $table->json('images')->nullable(); // Other events images
            $table->string('color')->nullable(); // events color
            $table->string('brand')->nullable(); // events brand
            $table->string('in_stock')->nullable(); // Stock quantity
            $table->enum('condition', ['new', 'old'])->default('new'); // Condition
            $table->string('price'); // events price
            $table->string('discount')->nullable(); // Discounted price
            $table->text('desc')->nullable(); // events description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
