<?php

/** Goal: Notify semua user berpermission driver-approve saat ada laporan driver baru, Caller: DriverController/Api, Deps: DriverNewReport, DriverNewReportEvent, User */

namespace App\Jobs;

use App\Events\DriverNewReportEvent;
use App\Helpers\ErrorLogger;
use App\Models\User;
use App\Notifications\DriverNewReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifyNewDriverReportJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $driverId,
        public readonly string $createdAt,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::select('id')
            ->permission('driver-approve')
            ->get();

        foreach ($users as $user) {
            $user->notify(new DriverNewReport($this->driverId, $this->createdAt));

            broadcast(new DriverNewReportEvent($this->createdAt, $user->id));
        }
    }

    /**
     * Handle a job failure — dipanggil setelah semua retry habis.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'NotifyNewDriverReportJob permanently failed', [
            'driver_id' => $this->driverId,
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
