<?php

/** Goal: Notify kolektor yang di-assign task baru, Caller: ApiCollectTaskController, ApiCollectTaskPpnController, ApiCollectIdyPpnController, Deps: NewTaskAssigned, NewTaskAssignedEvent, User */

namespace App\Jobs;

use App\Events\NewTaskAssignedEvent;
use App\Helpers\ErrorLogger;
use App\Models\User;
use App\Notifications\NewTaskAssigned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class NotifyCollectorNewAssignedJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $assignTo,
        public readonly int $collectId,
        public readonly string $noSr,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::select(['id', 'kode_pegawai'])
            ->where('kode_pegawai', $this->assignTo)
            ->first();

        if (! $user) {
            throw new \RuntimeException("User dengan kode_pegawai [{$this->assignTo}] tidak ditemukan.");
        }

        $user->notify(new NewTaskAssigned($user->id, $this->collectId, $this->noSr));

        $notification = $user->notifications()->latest()->first();

        broadcast(new NewTaskAssignedEvent($notification->id, $user->id, $this->collectId, $this->noSr));
    }

    /**
     * Handle a job failure — dipanggil setelah semua retry habis.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'NotifyCollectorNewAssignedJob permanently failed', [
            'assign_to' => $this->assignTo,
            'collect_id' => $this->collectId,
            'no_sr' => $this->noSr,
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
