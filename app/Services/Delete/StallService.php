<?php

namespace App\Services\Delete;

use App\Models\Stall;

class StallService {

    public function deleteStall(string $stallId) {
        $this->queryDeleteStall($stallId);
    }

    private function queryDeleteStall(string $stallId) {
        Stall::where('stall_id', $stallId)
        ->firstOrFail()
        ->delete();
    }
}