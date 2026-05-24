<?php

namespace App\Services;

use App\Models\Stall;

class StallService {

    public function getStallsCount(): int {  
        return Stall::count();
    }

}