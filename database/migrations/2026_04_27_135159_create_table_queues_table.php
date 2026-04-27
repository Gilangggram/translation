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
        Schema::create('table_queues', function (Blueprint $table) {
            $table->id('table_queue_id');
            $table->foreignId('table_id')->constrained('tables', 'table_id');
            $table->string('session_id');
            $table->json('reservation_data')->nullable();
            $table->timestamp('held_until');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_queues');
    }
};
