<?php

namespace App\Services\Restore;

use App\Models\Stall;
use App\Models\StallAccount;
use Illuminate\Support\Facades\DB;

class StallService {

    public function restoreStall(string $stallId) {
        $this->queryRestoreStall($stallId);
    }

    private function queryRestoreStall(string $stallId) {
        Stall::onlyTrashed()
        ->where('stall_id', $stallId)
        ->firstOrFail()
        ->restore();
    }
}