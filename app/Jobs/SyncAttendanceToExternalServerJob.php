<?php

/** Goal: Kirim data absensi yang sudah terverifikasi ke server utama secara asynchronous, Caller: ProcessFaceRecognition, api.php proxy route, Deps: User, Http, Log, ErrorLogger */

namespace App\Jobs;

use App\Helpers\ErrorLogger;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncAttendanceToExternalServerJob implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    /** @var int Jumlah retry jika job gagal */
    public int $tries = 5;

    /** @var int Timeout per attempt dalam detik */
    public int $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $userId,
        public readonly string $kodePegawai,
        public readonly string $waktuOri,
        public readonly ?string $noVt,
        public readonly ?string $keterangan,
        public readonly ?string $lokasi,
    ) {}

    /**
     * Unique ID untuk mencegah duplikasi dispatch pada user & waktu yang sama.
     */
    public function uniqueId(): string
    {
        return "{$this->userId}:{$this->waktuOri}";
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);

        if (! $user) {
            throw new \RuntimeException("User dengan ID [{$this->userId}] tidak ditemukan.");
        }

        $url = ($user->hasRole('Employee-Agrotec'))
            ? config('services.attendance_sync.agrotec_url')
            : config('services.attendance_sync.default_url');

        $payload = array_filter([
            'kode_jari' => $this->kodePegawai,
            'waktu' => $this->waktuOri,
            'kodebarcode' => $this->noVt,
            'keterangan' => $this->keterangan,
            'lokasi' => $this->lokasi,
        ], fn ($value) => $value !== null);

        $response = Http::withoutVerifying()->post($url, $payload);

        if ($response->failed()) {
            $this->log()->warning('HTTP failed', [
                'user_id' => $this->userId,
                'kode_pegawai' => $this->kodePegawai,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException('Gagal mengirim data absensi ke server tujuan. Status: '.$response->status());
        }

        $this->log()->info('Berhasil dikirim', [
            'user_id' => $this->userId,
            'kode_pegawai' => $this->kodePegawai,
            'waktu' => $this->waktuOri,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
    }

    /**
     * Handle a job failure — dipanggil setelah semua retry habis.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'SyncAttendanceToExternalServerJob permanently failed', [
            'user_id' => $this->userId,
            'kode_pegawai' => $this->kodePegawai,
        ]);

        $this->log()->error('Permanently failed', [
            'user_id' => $this->userId,
            'kode_pegawai' => $this->kodePegawai,
            'error' => $exception->getMessage(),
        ]);
    }

    /**
     * Hitung backoff delay antar retry (exponential).
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [15, 60, 300, 900];
    }

    /**
     * Shortcut ke log channel khusus attendance sync.
     */
    private function log(): \Psr\Log\LoggerInterface
    {
        return Log::channel('attendance_sync');
    }
}
