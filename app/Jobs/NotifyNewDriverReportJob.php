<?php

namespace App\Jobs;

use App\Events\DriverNewReportEvent;
use App\Models\User;
use App\Notifications\DriverNewReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NotifyNewDriverReportJob implements ShouldQueue
{
    use Queueable;

    protected $driver_id;
    protected $created_at;

    /**
     * Create a new job instance.
     */
    public function __construct($driver_id, $created_at)
    {
        $this->driver_id = $driver_id;
        $this->created_at = $created_at;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::select('id')
            ->permission('driver-approve')
            ->get();

        foreach ($users as $user) {
            try {
                $user->notify(new DriverNewReport($this->driver_id, $this->created_at));

                // lakukan broadcast
                broadcast(new DriverNewReportEvent(
                    $this->created_at,
                    $user->id
                ));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
