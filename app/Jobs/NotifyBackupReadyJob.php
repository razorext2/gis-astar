<?php

namespace App\Jobs;

use App\Events\BackupReadyEvent;
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
            // Kita gunakan array parameter agar penanganan argumen oleh Symfony Process lebih aman
            $exitCode = Artisan::call('backup:run', [
                '--only-db' => true,
                '--filename' => $this->name,
            ]);

            // Jika Artisan mengembalikan exit code non-zero, berarti dumper atau zipping gagal
            if ($exitCode !== 0) {
                $output = Artisan::output();
                throw new \Exception("Backup command failed with exit code {$exitCode}. Output: " . substr($output, 0, 500));
            }

            // Path relatif terhadap root disk 'local'
            $path = 'backup/' . $this->name;
            $disk = \Illuminate\Support\Facades\Storage::disk('local');
            
            // Loop verifikasi hingga file eksis dan ukurannya stabil (selesai di-write oleh OS)
            // Untuk database 40MB+, proses I/O bisa memakan waktu beberapa detik setelah Artisan selesai
            $maxWait = 120; // Kita naikkan menjadi 120 detik (2 menit) untuk database besar
            $waited = 0;
            $lastSize = -1;
            $isReady = false;

            while ($waited < $maxWait) {
                if ($disk->exists($path)) {
                    $currentSize = $disk->size($path);
                    
                    // File dianggap siap jika ukurannya > 1KB dan tidak berubah dalam 2 detik terakhir
                    if ($currentSize > 1024 && $currentSize === $lastSize) {
                        $isReady = true;
                        break;
                    }
                    $lastSize = $currentSize;
                }
                sleep(2);
                $waited += 2;
            }

            if ($isReady) {
                // Beri tahu dashboard bahwa file sudah siap diunduh
                broadcast(new BackupReadyEvent($this->name, $this->user));
            } else {
                throw new \Exception("File backup divalidasi gagal: File tidak ditemukan atau ukuran tidak stabil dalam batas waktu.");
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Backup Error: ' . $e->getMessage());

            // Pastikan status di database berubah menjadi failed agar user tahu prosesnya gugur
            $backup = \App\Models\Backup::where('name', $this->name)->first();
            if ($backup) {
                $backup->update(['status' => 'failed']);
            }
        }
    }
}
