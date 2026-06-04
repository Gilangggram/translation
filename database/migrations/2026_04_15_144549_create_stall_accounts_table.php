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
        Schema::create('stall_accounts', function (Blueprint $table) {
            $table->uuid('stall_account_id')->primary();
            $table->foreignId('stall_id')->constrained('stalls', 'stall_id');
            $table->string('phone_number')->unique();
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stall_accounts');
    }
};
