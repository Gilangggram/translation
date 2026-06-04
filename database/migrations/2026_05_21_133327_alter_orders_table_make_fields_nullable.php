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
            $table->uuid('validated_by')->nullable()->change();
            $table->string('payment_proof')->nullable()->change();
            $table->string('payment_method')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('validated_by')->nullable(false)->change();
            $table->string('payment_proof')->nullable(false)->change();
            $table->dropColumn('payment_method');
        });
    }
};
