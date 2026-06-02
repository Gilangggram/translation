<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';
    const UPDATED_AT = NULL;

    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price_each_at_transaction',
        'total_price',
        'notes',
        'status',
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }
}
