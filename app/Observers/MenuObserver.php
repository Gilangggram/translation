<?php

namespace App\Observers;

use App\Models\Menu;
use App\Models\MenuLog;

class MenuObserver
{
    public function created(Menu $menu)
    {
        MenuLog::create([
            'menu_id' => $menu->menu_id,
            'action' => 'created',
            'new_data' => $menu->toJson(),
        ]);
    }

    public function updated(Menu $menu)
    {
        MenuLog::create([
            'menu_id' => $menu->menu_id,
            'action' => 'updated',
            'old_data' => json_encode($menu->getOriginal()),
            'new_data' => $menu->toJson(),
        ]);
    }

    public function deleted(Menu $menu)
    {
        MenuLog::create([
            'menu_id' => $menu->menu_id,
            'action' => 'deleted',
            'old_data' => $menu->toJson(),
        ]);
    }

    public function restored(Menu $menu)
    {
        MenuLog::create([
            'menu_id' => $menu->menu_id,
            'action' => 'restored',
            'new_data' => $menu->toJson(),
        ]);
    }
}
