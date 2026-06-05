<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'menus';
    protected $primaryKey = 'menu_id';

    protected $fillable = [
        'stall_id',
        'name',
        'description',
        'image_path',
        'price',
        'is_chef_favorite',
        'is_available',
        'is_chef_recommendation',
        'category',
    ];

    public function stall()
    {
        return $this->belongsTo(Stall::class, 'stall_id', 'stall_id');
    }

    public function orders()
    {
        return $this->hasMany(OrderItem::class, 'menu_id', 'menu_id');
    }

    public function menuLogs()
    {
        return $this->hasMany(MenuLog::class, 'menu_id', 'menu_id');
    }
}
