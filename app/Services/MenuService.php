<?php

namespace App\Services;

use App\Models\Menu;

class MenuService {

    public function getAllMenusSum(): int {  
        return Menu::count();
    }

}