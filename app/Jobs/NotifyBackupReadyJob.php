<?php

namespace App\Jobs;

use App\Events\BackupReadyEvent;
use App\Http\Resources\ApiResource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;

class NotifyBackupReadyJob implements ShouldQueue
{
    use Queueable;
    protected $name;
    protected $date;
    protected $user;

    /**
     * Create a new job instance.
     */
    public function __construct(string $name, \DateTime $date, int $user)
    {
        $this->name = $name;
        $this->date = $date;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Artisan::call(sprintf('backup:run --only-db --filename="%s"', $this->name));

            broadcast(new BackupReadyEvent($this->name, $this->user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal melakukan backup' . $e->getMessage());
        }
    }
}
