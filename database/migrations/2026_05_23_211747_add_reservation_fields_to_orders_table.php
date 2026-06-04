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
        Schema::table('orders', function (Blueprint $table) {
            $table->date('reservation_date')->nullable()->after('table_id');
            $table->string('reservation_time')->nullable()->after('reservation_date');
            $table->integer('number_of_people')->nullable()->after('reservation_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['reservation_date', 'reservation_time', 'number_of_people']);
        });
    }
};
