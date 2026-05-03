<?php

namespace App\Observers;

use App\Models\Stall;
use App\Models\StallLog;

class StallObserver
{
    public function created(Stall $stall)
    {
        StallLog::create([
            'stall_id' => $stall->stall_id,
            'action' => 'created',
            'new_data' => $stall->toJson(),
        ]);
    }

    public function updated(Stall $stall)
    {
        StallLog::create([
            'stall_id' => $stall->stall_id,
            'action' => 'updated',
            'old_data' => json_encode($stall->getOriginal()),
            'new_data' => $stall->toJson(),
        ]);
    }

    public function deleted(Stall $stall)
    {
        StallLog::create([
            'stall_id' => $stall->stall_id,
            'action' => 'deleted',
            'old_data' => $stall->toJson(),
        ]);

        $stall->menus()->delete();
        $stall->stall_account()->delete();
    }
}
