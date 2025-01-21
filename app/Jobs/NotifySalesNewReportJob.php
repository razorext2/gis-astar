<?php

namespace App\Jobs;

use App\Events\SalesNewReportEvent;
use App\Models\User;
use App\Notifications\SalesNewReport;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NotifySalesNewReportJob implements ShouldQueue
{
    use Queueable;

    protected $report_id;
    protected $created_at;

    /**
     * Create a new job instance.
     */
    public function __construct($report_id, $created_at)
    {
        $this->report_id = $report_id;
        $this->created_at = $created_at;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // cari user yang memiliki permission sales-approve
        $users = User::select('id')
            ->permission('sales-approve')
            ->get();

        foreach ($users as $user) {
            try {
                // berikan notifikasi saat ada laporan baru
                $user->notify(new SalesNewReport($this->report_id, $this->created_at));

                // ambil data notifikasi terakhir
                $notification = $user->notifications()->latest()->first();

                // lakukan broadcast
                broadcast(new SalesNewReportEvent(
                    $this->report_id,
                    $notification->id,
                    $this->created_at,
                    $user->id
                ));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
