<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    const UPDATED_AT = null;

    protected $fillable = [
        'customer_id',
        'order_type',
        'table_number',
        'customer_address',
        'total_price',
        'payment_status',
        'payment_proof',
        'is_completed',
        'validated_by',
        'validated_at',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    
    public function table() {
        return $this->belongsTo(Table::class, 'table_id', 'table_id');
    }

    public function adminAccount() {
        return $this->belongsTo(AdminAccount::class, 'validated_by', 'admin_account_id');
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
