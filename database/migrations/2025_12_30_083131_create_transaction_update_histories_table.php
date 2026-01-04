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
        if (!Schema::hasTable('transaction_update_histories')) {
            Schema::create('transaction_update_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('inventory_transaction_id');

                $table->foreignId('updated_by')->constrained('users');

                $table->json('previous_values');
                $table->json('new_values');

                $table->text('update_reason');
                $table->timestamp('updated_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_update_histories');
    }
};
