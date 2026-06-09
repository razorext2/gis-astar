<?php

/** Goal: Notify semua user berpermission sales-approve saat ada laporan sales baru, Caller: SalesController/Api, Deps: SalesNewReport, SalesNewReportEvent, User */

namespace App\Jobs;

use App\Events\SalesNewReportEvent;
use App\Helpers\ErrorLogger;
use App\Models\User;
use App\Notifications\SalesNewReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifySalesNewReportJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $reportId,
        public readonly string $createdAt,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::select('id')
            ->permission('sales-approve')
            ->get();

        foreach ($users as $user) {
            $user->notify(new SalesNewReport($this->reportId, $this->createdAt));

            $notification = $user->notifications()->latest()->first();

            broadcast(new SalesNewReportEvent(
                $this->reportId,
                $notification->id,
                $this->createdAt,
                $user->id,
            ));
        }
    }

    /**
     * Handle a job failure — dipanggil setelah semua retry habis.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'NotifySalesNewReportJob permanently failed', [
            'report_id' => $this->reportId,
            'created_at' => $this->createdAt,
        ]);
    }

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [10, 30, 60];
    }
}
