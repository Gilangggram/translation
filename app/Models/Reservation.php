<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'reservation_id';

    protected $fillable = [
        'order_id',
        'table_id',
        'date',
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function table() {
        return $this->belongsTo(Table::class, 'table_id', 'table_id');
    }
}
