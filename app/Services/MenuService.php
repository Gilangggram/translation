<?php

namespace App\Services;

use App\Models\Menu;

class MenuService {

    public function getMenusCount(): int {  
        return Menu::count();
    }

}