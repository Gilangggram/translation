<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StallAccount extends Authenticatable
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $table = 'stall_accounts';
    protected $primaryKey = 'stall_account_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'stall_id',
        'phone_number',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function stall() {
        return $this->belongsTo(Stall::class, 'stall_id', 'stall_id');
    }
}
