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
        Schema::create('computer_labs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // computerlab name
            $table->enum('category', ['Desktops', 'routers', 'cameras', 'printers', 'repair']); // Category
            $table->string('avatar')->nullable(); // Main computerlab image
            $table->json('images')->nullable(); // Other computerlab images
            $table->string('color')->nullable(); // computerlab color
            $table->string('brand')->nullable(); // computerlab brand
            $table->string('in_stock')->nullable(); // Stock quantity
            $table->enum('condition', ['new', 'old'])->default('new'); // Condition
            $table->string('price'); // computerlab price
            $table->string('discount')->nullable(); // Discounted price
            $table->text('desc')->nullable(); // computerlab description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_labs');
    }
};
