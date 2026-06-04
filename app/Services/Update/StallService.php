<?php

namespace App\Services\Update;

use App\Models\Stall;
use App\Models\StallAccount;
use Illuminate\Support\Facades\DB;

class StallService {
    
    public function updateStall(int $stallId, array $stallData) {
        $this->queryUpdateStall($stallId, $stallData);
    }

    private function queryUpdateStall(int $stallId, array $stallData) {
        DB::transaction(function () use ($stallId, $stallData) {
            
            Stall::withTrashed()
                ->where('stall_id', $stallId)
                ->firstOrFail()
                ->update([
                    'name' => $stallData['stall_name'],
                    'owner_name' => $stallData['owner_name'],
                ]);

            StallAccount::withTrashed()
                ->where('stall_id', $stallId)
                ->firstOrFail()
                ->update([
                    'phone_number' => $stallData['owner_number'],
                ]);
        });
    }
}