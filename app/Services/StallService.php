<?php

namespace App\Services;

use App\Models\Stall;

class StallService {

    public function getActiveStallsSum(): int {  
        return Stall::count();
    }

}