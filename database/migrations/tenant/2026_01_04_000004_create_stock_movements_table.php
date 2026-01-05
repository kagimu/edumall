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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->foreignId('created_by');

            $table->enum('type', ['purchase', 'use', 'disposal', 'return']);
            $table->integer('quantity');

            $table->text('reason'); // REQUIRED for audit
            $table->text('notes')->nullable();

            $table->boolean('is_updated')->default(false);

            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};