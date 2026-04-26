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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('customer_id')->constrained('customers', 'customer_id');
            $table->string('order_number')->unique();
            $table->enum('order_type', ['dine_in', 'delivery', 'reservation']);
            $table->foreignId('table_id')->nullable()->constrained('tables', 'table_id');
            $table->text('customer_address')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('payment_proof');
            $table->foreignUuid('validated_by')->constrained('admin_accounts', 'admin_account_id');
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
