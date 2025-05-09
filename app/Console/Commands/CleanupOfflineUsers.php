<?php

namespace App\Console\Commands;

use App\Jobs\CleanupOfflineUsers as CleanupOfflineUsersJob;
use Illuminate\Console\Command;

class CleanupOfflineUsers extends Command
{
    protected $signature = 'cleanup:offline-users';
    protected $description = 'Mark users offline if their last_seen is over two minutes old';

    public function handle(): int
    {
        CleanupOfflineUsersJob::dispatch();
        
        $this->info('Cleanup job dispatched.');
        return self::SUCCESS;
    }
}