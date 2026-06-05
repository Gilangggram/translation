<?php

namespace App\Console\Commands;

use App\Models\TableQueue;
use Illuminate\Console\Command;

class DeleteExpiredTableQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tables:delete-expired-table-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Expired Table Queue';
    /**
     * Execute the console command.
     */
    public function handle() {
        $deletedTotal = TableQueue::where('held_until', '<', now())->delete();
        $this->info("$deletedTotal expired table queue(s) has been deleted.");
    }
}
