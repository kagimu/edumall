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
        Schema::table('users', function (Blueprint $table) {
            $table->string('institution_name')->nullable();
            $table->string('centre_number')->nullable();
            $table->string('district')->nullable();
            $table->string('subcounty')->nullable();
            $table->string('parish')->nullable();
            $table->string('village')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('admin_designation')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('admin_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
