<?php

/** Goal: Jalankan backup DB dan notify user saat siap, Caller: BackupController, Deps: BackupReadyEvent, Backup model, Artisan */

namespace App\Jobs;

use App\Events\BackupReadyEvent;
use App\Helpers\ErrorLogger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class NotifyBackupReadyJob implements ShouldQueue
{
    use Queueable;

    /** @var int Backup tidak perlu di-retry — sekali gagal langsung mark failed */
    public int $tries = 1;

    /** @var int Timeout harus cukup untuk proses backup + polling */
    public int $timeout = 600;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $name,
        public readonly \DateTime $date,
        public readonly int $user,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $exitCode = Artisan::call('backup:run', [
            '--only-db' => true,
            '--filename' => $this->name,
        ]);

        if ($exitCode !== 0) {
            $output = Artisan::output();
            throw new \RuntimeException(
                "Backup command failed (exit code {$exitCode}). Output: ".substr($output, 0, 500)
            );
        }

        // Loop verifikasi hingga file eksis dan ukurannya stabil
        $path = 'backup/'.$this->name;
        $disk = Storage::disk('local');
        $maxWait = 120;
        $waited = 0;
        $lastSize = -1;
        $isReady = false;

        while ($waited < $maxWait) {
            if ($disk->exists($path)) {
                $currentSize = $disk->size($path);

                if ($currentSize > 1024 && $currentSize === $lastSize) {
                    $isReady = true;
                    break;
                }

                $lastSize = $currentSize;
            }

            sleep(2);
            $waited += 2;
        }

        if (! $isReady) {
            throw new \RuntimeException(
                "File backup tidak ditemukan atau ukuran tidak stabil dalam {$maxWait} detik."
            );
        }

        broadcast(new BackupReadyEvent($this->name, $this->user));
    }

    /**
     * Handle a job failure — mark backup sebagai failed di database.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'NotifyBackupReadyJob permanently failed', [
            'backup_name' => $this->name,
            'user_id' => $this->user,
        ]);

        $backup = \App\Models\Backup::where('name', $this->name)->first();

        if ($backup) {
            $backup->update(['status' => 'failed']);
        }
    }
}
