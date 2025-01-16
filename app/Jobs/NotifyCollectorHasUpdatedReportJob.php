<?php

namespace App\Jobs;

use App\Events\CollectorUpdatedReportEvent;
use App\Models\User;
use App\Notifications\CollectorUpdatedReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NotifyCollectorHasUpdatedReportJob implements ShouldQueue
{
    use Queueable;

    protected $no_sr;
    protected $date;
    protected $collect_id;

    /**
     * Create a new job instance.
     */
    public function __construct($no_sr, $collect_id, $date)
    {
        $this->no_sr = $no_sr;
        $this->collect_id = $collect_id;
        $this->date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // cari user yang memiliki permission collect-approve
        $users = User::select('id')
            ->permission('collect-approve')
            ->get();

        foreach ($users as $user) { // loop through user
            try {
                // berikan notifikasi disaat ada laporan baru
                $user->notify(new CollectorUpdatedReport($this->no_sr, $this->collect_id, $this->date));

                $notification = $user->notifications()->latest()->first();

                broadcast(new CollectorUpdatedReportEvent(
                    $notification->id,
                    $this->no_sr,
                    $user->id,
                    $this->collect_id,
                    $this->date
                ));
            } catch (\Exception $e) {
                Log::error('Notify new assign job failed for user: ' . $user->id . ' - Error: ' . $e->getMessage());
            }
        }
    }
}
