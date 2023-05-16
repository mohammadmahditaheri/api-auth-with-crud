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
        Schema::create('reset_password_secrets', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('secret', 10);
            $table->timestamp('secret_expires_at');
            $table->boolean('password_reset_happened')->default(false);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reset_password_secrets');
    }
};
