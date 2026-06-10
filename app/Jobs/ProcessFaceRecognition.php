<?php

/** Goal: Kirim foto ke API face recognition, update status absensi, dan notify user hasilnya, Caller: AttendanceController, AttendanceOutController, Deps: RecognitionEvent, SendNotifAttendance, User, Http */

namespace App\Jobs;

use App\Enums\AttendanceStatus;
use App\Events\RecognitionEvent;
use App\Helpers\ErrorLogger;
use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\User;
use App\Notifications\SendNotifAttendance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessFaceRecognition implements ShouldQueue
{
    use Queueable;

    /** @var array<string, class-string> Whitelist model yang diizinkan */
    private const MODEL_MAP = [
        'Attendance' => Attendance::class,
        'AttendanceOut' => AttendanceOut::class,
    ];

    /** @var float Batas maksimal cosine distance agar dianggap cocok */
    private const DISTANCE_THRESHOLD = 0.65;

    public int $tries = 1;

    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $model,
        public readonly int $id,
        public readonly string $imgPath,
        public readonly int $userId,
        public readonly string $kodePegawai,
        public readonly string $filename,
        public readonly ?string $noVt,
        public readonly ?string $keterangan,
        public readonly ?string $lokasi,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $modelClass = self::MODEL_MAP[$this->model] ?? null;

        if (! $modelClass) {
            throw new \RuntimeException("Model [{$this->model}] tidak terdaftar di whitelist.");
        }

        $data = $modelClass::find($this->id);
        $type = $this->model === 'Attendance' ? 'Masuk' : 'Keluar';
        $fullPath = storage_path('app/'.$this->imgPath.'/'.$this->filename);

        if (! $data) {
            throw new \RuntimeException("Model [{$this->model}] dengan ID [{$this->id}] tidak ditemukan.");
        }

        if (! file_exists($fullPath)) {
            throw new \RuntimeException("File capture tidak ditemukan: {$fullPath}");
        }

        $responseData = $this->callRecognitionApi($fullPath);

        // Pindahkan file ke lokasi permanen
        $targetPath = "public/labels/{$this->kodePegawai}/capturedImg/{$this->filename}";

        if (! Storage::move("{$this->imgPath}/{$this->filename}", $targetPath)) {
            throw new \RuntimeException('Gagal memindahkan file hasil capture.');
        }

        // Wajah tidak dikenali / error dari API
        if ($responseData['error']) {
            $data->update([
                'status' => AttendanceStatus::Failed->value,
                'verified' => true,
                'verified_by' => 'System',
            ]);

            $this->notifyAndBroadcast(
                $type,
                'error',
                'Gagal',
                $responseData['error_message'] ?? 'Terjadi kesalahan',
                "Absensi {$type} gagal: ".$responseData['error_message']
            );

            return;
        }

        // Wajah dikenali dan confidence cukup
        if ($responseData['verified'] && $responseData['distance'] < self::DISTANCE_THRESHOLD) {
            $data->update([
                'status' => AttendanceStatus::Verified->value,
                'verified' => true,
                'verified_by' => 'System',
                'distance' => $responseData['distance'],
            ]);

            SyncAttendanceToExternalServerJob::dispatch(
                $this->userId,
                $this->kodePegawai,
                $data->waktuori,
                $this->sanitize($this->noVt),
                $this->sanitize($this->keterangan),
                $this->sanitize($this->lokasi)
            );

            $this->notifyAndBroadcast(
                $type,
                'success',
                'Berhasil',
                'Absensi berhasil diverifikasi, lihat hasilnya di halaman absensi.',
                "Absensi {$type} berhasil diverifikasi, lihat hasilnya di halaman absensi."
            );

            return;
        }

        // Wajah dikenali tapi confidence kurang — pending manual HRD
        $data->update([
            'verified' => false,
            'distance' => $responseData['distance'],
            'status' => AttendanceStatus::Pending->value,
        ]);

        $this->notifyAndBroadcast(
            $type,
            'error',
            'Menunggu persetujuan',
            'Absensi berhasil, namun wajah tidak dikenali. Silahkan menunggu hingga HRD memverifikasi.',
            "Absensi {$type} berhasil, namun wajah tidak dikenali. Silahkan menunggu hingga HRD memverifikasi."
        );
    }

    /**
     * Handle a job failure — mark absensi sebagai gagal dan notify user.
     */
    public function failed(\Throwable $exception): void
    {
        ErrorLogger::log($exception, 'ProcessFaceRecognition permanently failed', [
            'model' => $this->model,
            'id' => $this->id,
            'kode_pegawai' => $this->kodePegawai,
        ]);

        $this->log()->error('Job permanently failed', [
            'model' => $this->model,
            'id' => $this->id,
            'kode_pegawai' => $this->kodePegawai,
            'error' => $exception->getMessage(),
        ]);

        $type = $this->model === 'Attendance' ? 'Masuk' : 'Keluar';

        // Mark absensi sebagai gagal (status=2) tanpa menghapus record
        $modelClass = self::MODEL_MAP[$this->model] ?? null;
        $data = $modelClass ? $modelClass::find($this->id) : null;

        if ($data) {
            $data->update([
                'status' => AttendanceStatus::Failed->value,
                'verified' => true,
                'verified_by' => 'System',
            ]);
        }

        $this->notifyAndBroadcast(
            $type,
            'error',
            'Gagal',
            $exception->getMessage(),
            "Absensi {$type} gagal diproses: {$exception->getMessage()}. Silahkan coba kembali."
        );
    }

    /**
     * Panggil API face recognition dengan file handling yang aman.
     *
     * @return array<string, mixed>
     */
    private function callRecognitionApi(string $fullPath): array
    {
        $file = fopen($fullPath, 'r');

        try {
            $response = Http::withoutVerifying()
                ->attach('file', $file)
                ->post(config('services.face_recognition.url'), [
                    'kode_pegawai' => $this->kodePegawai,
                    'no_vt' => $this->sanitize($this->noVt),
                ]);
        } finally {
            if (is_resource($file)) {
                fclose($file);
            }
        }

        $responseData = $response->json();

        if (! is_array($responseData) || ! isset($responseData['error'])) {
            throw new \RuntimeException('Respons dari API face recognition tidak valid.');
        }

        $this->log()->info('API response received', [
            'kode_pegawai' => $this->kodePegawai,
            'verified' => $responseData['verified'] ?? null,
            'distance' => $responseData['distance'] ?? null,
            'error' => $responseData['error'],
        ]);

        return $responseData;
    }

    /**
     * Kirim notifikasi dan broadcast event sekaligus.
     */
    private function notifyAndBroadcast(string $type, string $eventType, string $title, string $broadcastMessage, string $notifMessage): void
    {
        $this->sendNotif($notifMessage);

        broadcast(new RecognitionEvent(
            $this->userId,
            $eventType,
            $title,
            $broadcastMessage,
        ));
    }

    /**
     * Kirim notifikasi ke user terkait.
     */
    private function sendNotif(string $message): void
    {
        $user = User::where('kode_pegawai', $this->kodePegawai)->first();

        if ($user) {
            $user->notify(new SendNotifAttendance($message, $this->id, $this->model));
        }
    }

    /**
     * Sanitize value: hilangkan karakter yang berpotensi digunakan untuk injection.
     */
    private function sanitize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return preg_replace('/[\'"]/', '', $value);
    }

    /**
     * Shortcut ke log channel khusus face recognition.
     */
    private function log(): \Psr\Log\LoggerInterface
    {
        return Log::channel('face_recognition');
    }
}
