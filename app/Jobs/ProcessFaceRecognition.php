<?php

/** Goal: Kirim foto ke API face recognition, update status absensi, dan notify user hasilnya, Caller: AttendanceController, AttendanceOutController, Deps: RecognitionEvent, SendNotifAttendance, User, Http */

namespace App\Jobs;

use App\Events\RecognitionEvent;
use App\Helpers\ErrorLogger;
use App\Models\User;
use App\Notifications\SendNotifAttendance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProcessFaceRecognition implements ShouldQueue
{
    use Queueable;

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
    ) {
        // Sanitize dilakukan di constructor agar data bersih sebelum di-serialize ke queue
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $modelClass = "\\App\\Models\\{$this->model}";
        $data = $modelClass::where('id', $this->id)->first();
        $type = $this->model === 'Attendance' ? 'Masuk' : 'Keluar';
        $fullPath = storage_path('app/'.$this->imgPath.'/'.$this->filename);

        if (! $data) {
            throw new \RuntimeException("Model [{$this->model}] dengan ID [{$this->id}] tidak ditemukan.");
        }

        if (! file_exists($fullPath)) {
            throw new \RuntimeException("File capture tidak ditemukan: {$fullPath}");
        }

        $file = fopen($fullPath, 'r');
        $response = Http::withoutVerifying()
            ->attach('file', $file)
            ->post('https://verify.indodacin.com/recognize', [
                'kode_pegawai' => $this->kodePegawai,
                'no_vt' => $this->sanitize($this->noVt),
            ]);

        fclose($file);

        $responseData = $response->json();

        if (! is_array($responseData) || ! isset($responseData['error'])) {
            throw new \RuntimeException('Respons dari API face recognition tidak valid.');
        }

        // Pindahkan file ke lokasi permanen
        $targetPath = "public/labels/{$this->kodePegawai}/capturedImg/{$this->filename}";

        if (! Storage::move("{$this->imgPath}/{$this->filename}", $targetPath)) {
            throw new \RuntimeException('Gagal memindahkan file hasil capture.');
        }

        // Wajah tidak dikenali / error dari API
        if ($responseData['error']) {
            $data->update([
                'status' => 2,
                'verified' => true,
                'verified_by' => 'System',
            ]);

            $this->sendNotif("Absensi {$type} gagal: ".$responseData['error_message']);

            broadcast(new RecognitionEvent(
                $this->userId,
                'error',
                'Gagal',
                $responseData['error_message'] ?? 'Terjadi kesalahan',
            ));

            return;
        }

        // Wajah dikenali dan confidence cukup
        if ($responseData['verified'] && $responseData['distance'] < 0.65) {
            $data->update([
                'status' => 1,
                'verified' => true,
                'verified_by' => 'System',
                'distance' => $responseData['distance'],
            ]);

            $user = User::where('id', $this->userId)->first();
            $url = ($user && $user->hasRole('Employee-Agrotec'))
                ? 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendanceAgrotec'
                : 'https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendance';

            Http::withoutVerifying()->post($url, [
                'kode_jari' => $this->kodePegawai,
                'waktu' => $data->waktuori,
                'kodebarcode' => $this->sanitize($this->noVt),
                'keterangan' => $this->sanitize($this->keterangan),
                'lokasi' => $this->sanitize($this->lokasi),
            ]);

            $this->sendNotif("Absensi {$type} berhasil diverifikasi, lihat hasilnya di halaman absensi.");

            broadcast(new RecognitionEvent(
                $this->userId,
                'success',
                'Berhasil',
                'Absensi berhasil diverifikasi, lihat hasilnya di halaman absensi.',
            ));

            return;
        }

        // Wajah dikenali tapi confidence kurang — pending manual HRD
        $data->update([
            'verified' => false,
            'distance' => $responseData['distance'],
            'status' => 0,
        ]);

        $this->sendNotif("Absensi {$type} berhasil, namun wajah tidak dikenali. Silahkan menunggu hingga HRD memverifikasi.");

        broadcast(new RecognitionEvent(
            $this->userId,
            'error',
            'Menunggu persetujuan',
            'Absensi berhasil, namun wajah tidak dikenali. Silahkan menunggu hingga HRD memverifikasi.',
        ));
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

        $type = $this->model === 'Attendance' ? 'Masuk' : 'Keluar';

        // Mark absensi sebagai gagal (status=2) tanpa menghapus record
        $modelClass = "\\App\\Models\\{$this->model}";
        $data = $modelClass::find($this->id);

        if ($data) {
            $data->update(['status' => 2, 'verified' => true, 'verified_by' => 'System']);
        }

        $this->sendNotif("Absensi {$type} gagal diproses: {$exception->getMessage()}. Silahkan coba kembali.");

        broadcast(new RecognitionEvent(
            $this->userId,
            'error',
            'Gagal',
            $exception->getMessage(),
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

        return preg_replace("/['\"]/", '', $value);
    }
}
