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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('userType');
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('accountType')->default('individual'); // Default to 'individual'
            $table->string('customUserType')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('centre_number')->nullable();
            $table->string('district')->nullable();
            $table->string('subcounty')->nullable();
            $table->string('parish')->nullable();
            $table->string('village')->nullable();
            $table->string('adminName')->nullable();
            $table->string('customDesignation')->nullable();
            $table->string('adminEmail')->nullable();
            $table->string('adminPhone')->nullable();
            $table->string('bankAccount')->nullable();
            $table->string('mobileMoneyNumber')->nullable();
            $table->json('paymentMethods')->nullable(); // Store payment methods as JSON
            $table->string('role')->default('client'); // Default role
            $table->string('position')->nullable(); // Nullable position field
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
