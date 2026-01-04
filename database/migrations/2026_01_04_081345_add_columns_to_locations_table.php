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
        Schema::table('locations', function (Blueprint $table) {
            $table->enum('type', ['shelf', 'drawer', 'bench', 'cabinet'])->default('shelf');
            $table->enum('lab_type', ['chemistry', 'physics', 'biology', 'agriculture'])->default('chemistry');
            $table->unsignedInteger('capacity')->default(100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['type', 'lab_type', 'capacity']);
        });
    }
};
