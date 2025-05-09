<?php

namespace App\Jobs;

use App\Events\UserStatusChanged;
use App\Models\UserStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CleanupOfflineUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Get stale users in a single query
        $staleStatuses = UserStatus::query()
            ->where('last_seen', '<', now()->subMinutes(2))
            ->where('status', '!=', 'offline')
            ->get();

        if ($staleStatuses->isNotEmpty()) {
            // Bulk update all stale statuses
            UserStatus::whereIn('id', $staleStatuses->pluck('id'))
                ->update(['status' => 'offline']);

            // Broadcast updates
            $staleStatuses->each(function ($status) {
                broadcast(new UserStatusChanged($status->user_id, 'offline'))
                    ->toOthers();
            });
        }
    }
}