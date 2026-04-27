<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableQueue extends Model
{
    public $timestamps = false;
    const UPDATED_AT = null;

    protected $fillable = [
        'table_id',
        'session_id',
        'held_until',
    ];

    protected $casts = [
        'held_until' => 'datetime',
    ];

    public function table() {
        return $this->belongsTo(Table::class, 'table_id', 'table_id');
    }

    public function scopeActive($query) {
        return $query->where('held_until', '>', now());
    }

    public function scopeBySession($query, $sessionId) {
        return $query->where('session_id', $sessionId);
    }
}
