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
        Schema::create('menu_logs', function (Blueprint $table) {
            $table->id('menu_log_id');
            $table->foreignId('menu_id')->constrained('menus', 'menu_id');
            $table->enum('action', ['created', 'updated', 'deleted', 'restored']);
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
        Schema::dropIfExists('menu_logs');
    }
};
