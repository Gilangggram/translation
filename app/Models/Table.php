<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = 'tables';
    protected $primaryKey = 'table_id';
    const CREATED_AT = NULL;

    protected $fillable = [
        'table_number',
        'is_available',
    ];

    public function orders() {
        return $this->hasMany(Order::class, 'table_id', 'table_id');
    }

    public function queues() {
        return $this->hasMany(TableQueue::class, 'table_id', 'table_id');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'table_id', 'table_id');
    }
}
