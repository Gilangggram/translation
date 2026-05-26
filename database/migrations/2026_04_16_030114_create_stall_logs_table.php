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
        Schema::create('stall_logs', function (Blueprint $table) {
            $table->id('stall_log_id');
            $table->foreignId('stall_id')->constrained('stalls', 'stall_id');
            $table->enum('action', ['created', 'updated', 'deleted']);
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stall_logs');
    }
};
