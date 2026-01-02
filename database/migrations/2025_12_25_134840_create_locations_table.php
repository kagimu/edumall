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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['shelf', 'drawer', 'bench', 'cabinet']);
            $table->enum('lab_type', ['chemistry', 'physics', 'biology', 'agriculture']);
            $table->unsignedInteger('capacity')->default(100);
            $table->timestamps();
            $table->unique(['school_id', 'name']); // prevent duplicates per school
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
