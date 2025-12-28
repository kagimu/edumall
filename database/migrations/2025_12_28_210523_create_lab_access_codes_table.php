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
        Schema::create('lab_access_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('access_code')->unique();
            $table->string('user_name');
            $table->string('email')->nullable();
            $table->string('role'); // admin, department-head, teacher, lab-agent
            $table->json('permissions')->nullable(); // e.g., ['view_inventory', 'edit_inventory']
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // admin who created
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_access_codes');
    }
};
