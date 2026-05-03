<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StallAccount;
use App\Models\Menu;
use App\Models\StallLog;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stall extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $table = 'stalls';
    protected $primaryKey = 'stall_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'owner_name',
        'is_open',
        'stall_account_id',
    ];

    public function stallAccount() {
        return $this->hasOne(StallAccount::class, 'stall_id', 'stall_id');
    }

    public function menus() {
        return $this->hasMany(Menu::class, 'stall_id', 'stall_id');
    }

    public function stallLogs() {
        return $this->hasMany(StallLog::class, 'stall_id', 'stall_id');
    }
}
