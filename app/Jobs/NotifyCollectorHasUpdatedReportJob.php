<?php

/** Goal: Notify semua user berpermission collect-approve saat kolektor update laporan, Caller: CollectController, Deps: CollectorUpdatedReport, CollectorUpdatedReportEvent, User */

namespace App\Jobs;

use App\Events\CollectorUpdatedReportEvent;
use App\Helpers\ErrorLogger;
use App\Models\User;
use App\Notifications\CollectorUpdatedReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifyCollectorHasUpdatedReportJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $noSr,
        public readonly int $collectId,
        public readonly string $date,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::select('id')
            ->permission('collect-approve')
            ->get();

        foreach ($users as $user) {
            $user->notify(new CollectorUpdatedReport($this->noSr, $this->collectId, $this->date));

            $notification = $user->notifications()->latest()->first();

            broadcast(new CollectorUpdatedReportEvent(
                $notification->id,
                $this->noSr,
                $user->id,
                $this->collectId,
                $this->date,
            ));
        }
    }

    /**
     * Handle a job failure — dipanggil setelah semua retry habis.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'NotifyCollectorHasUpdatedReportJob permanently failed', [
            'no_sr' => $this->noSr,
            'collect_id' => $this->collectId,
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
