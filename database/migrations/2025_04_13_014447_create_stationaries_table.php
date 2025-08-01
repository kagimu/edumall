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
        Schema::create('stationaries', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // stationary name
            $table->string('category')->default('chalk'); // Category
            $table->string('avatar')->nullable(); // Main stationary image
            $table->json('images')->nullable(); // Other stationary images
            $table->string('color')->nullable(); // stationary color
            $table->string('brand')->nullable(); // stationary brand
            $table->string('in_stock')->nullable(); // Stock quantity
            $table->enum('condition', ['new', 'old'])->default('new'); // Condition
            $table->string('price'); // stationary price
            $table->string('discount')->nullable(); // Discounted price
            $table->text('desc')->nullable(); // stationary description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stationaries');
    }
};
