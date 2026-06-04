<?php

namespace App\Services\Create;

use App\Models\Stall;
use App\Models\StallAccount;
use Illuminate\Support\Facades\DB;

class StallService {

    public function addStall(array $stallData) {
        $this->queryAddStall($stallData);
    }

    private function queryAddStall(array $stallData) {
        DB::transaction(function () use ($stallData) {
            
            $stall = Stall::create([
                'stall_code' => $stallData['stall_code'],
                'name' => $stallData['stall_name'],
                'owner_name' => $stallData['owner_name'],
            ]);

            StallAccount::create([
                'stall_id'     => $stall->stall_id,
                'phone_number' => $stallData['owner_number'],
                'password'     => $stallData['password'],
            ]);
        });
    }

}