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
    use SoftDeletes, HasFactory;

    protected $table = 'stalls';
    protected $primaryKey = 'stall_id';

    protected $fillable = [
        'stall_code',
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

    public static function generateStallCode(): string
    {
        $last = static::orderByDesc('stall_code')->value('stall_code');

        if (!$last) return 'ST-A001';

        $letter = $last[3]; 
        $number = (int) substr($last, 4);

        if ($number < 999) {
            return 'ST-' . $letter . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
        }

        if ($letter === 'Z') {
            throw new \Exception('Kode stall sudah habis (ST-Z999).');
        }

        return 'ST-' . chr(ord($letter) + 1) . '001';
    }
}
