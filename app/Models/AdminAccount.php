<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminAccount extends Authenticatable
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $table = 'admin_accounts';
    protected $primaryKey = 'admin_account_id';

    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'role',
    ];

    public function orders() {
        return $this->hasMany(Order::class, 'validated_by', 'admin_account_id');
    }
}
