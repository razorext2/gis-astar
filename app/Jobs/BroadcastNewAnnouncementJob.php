<?php

namespace App\Jobs;

use App\Events\NewAnnouncementEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class BroadcastNewAnnouncementJob implements ShouldQueue
{
    use Queueable;

    protected $announcement;
    /**
     * Create a new job instance.
     */
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::select('id')->get();

        foreach ($users as $user) {
            try {
                broadcast(new NewAnnouncementEvent($user->id, $this->announcement));
            } catch (\Exception $e) {
                Log::error('Notify new assign job failed for user: ' . $user->id . ' - Error: ' . $e->getMessage());
            }
        }
    }
}
