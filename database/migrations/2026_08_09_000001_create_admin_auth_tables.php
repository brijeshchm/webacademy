<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mirrors the Node/PostgreSQL admin auth tables (admin_settings singleton row
 * + hashed session tokens) so the React admin panel works unchanged.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('password_hash');
            $table->string('otp_hash')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->unsignedInteger('otp_attempts')->default(0);
            $table->timestamp('last_otp_sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('admin_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('token_hash', 64)->unique();
            $table->timestamp('expires_at');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_sessions');
        Schema::dropIfExists('admin_settings');
    }
};
