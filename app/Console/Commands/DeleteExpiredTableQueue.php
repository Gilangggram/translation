<?php

namespace App\Console\Commands;

use App\Models\TableQueue;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('tables:delete-expired-table-queue')]
#[Description('Delete Expired Table Queue')]
class DeleteExpiredTableQueue extends Command
{
    /**
     * Execute the console command.
     */
    public function handle() {
        $deletedTotal = TableQueue::where('held_until', '<', now())->delete();
        $this->info("$deletedTotal expired table queue(s) has been deleted.");
    }
}
