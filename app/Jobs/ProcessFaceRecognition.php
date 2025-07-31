<?php

namespace App\Jobs;

use App\Events\RecognitionEvent;
use App\Http\Resources\ApiResource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProcessFaceRecognition implements ShouldQueue
{
    use Queueable;

    protected string $img_path;
    protected int $user_id;
    protected int $kode_pegawai;
    protected string $filename;
    protected int $id;
    protected string $model;
    protected $no_vt;

    /**
     * Create a new job instance.
     */
    public function __construct($model, $id, $img_path, $user_id, $kode_pegawai, $filename, $no_vt)
    {
        $this->model = $model;
        $this->id = $id;
        $this->img_path = $img_path;
        $this->user_id = $user_id;
        $this->kode_pegawai = $kode_pegawai;
        $this->filename = $filename;
        $this->no_vt = $no_vt;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $modelClass = "\\App\\Models\\{$this->model}";
        $data = $modelClass::where('id', $this->id)->first();

        $fullPath = storage_path('app/' . $this->img_path . '/' . $this->filename);

        try {
            // Pastikan file ada
            if (!file_exists($fullPath)) {
                throw new \Exception('File tidak ditemukan.');
            }

            $file = fopen($fullPath, 'r');

            $response = Http::attach('file', $file)
                ->post('https://verify.indodacin.com/recognize', [
                    'kode_pegawai' => $this->kode_pegawai,
                    'no_vt' => $this->no_vt,
                ]);

            dump($response->json());

            fclose($file); // Selalu tutup file

            $responseData = $response->json();

            if (!is_array($responseData) || !isset($responseData['error'])) {
                throw new \Exception('Respons dari API tidak valid.');
            }

            // Pindahkan file
            $targetPath = "public/labels/{$this->kode_pegawai}/capturedImg/{$this->filename}";
            if (!Storage::move("{$this->img_path}/{$this->filename}", $targetPath)) {
                throw new \Exception('Gagal memindahkan file hasil capture.');
            }

            if ($responseData['error']) {
                $data->update([
                    'status' => 2,
                    'verified' => true,
                    'verified_by' => 'System',
                ]); // lebih aman daripada delete

                return broadcast(new RecognitionEvent(
                    $this->user_id,
                    'error',
                    'Gagal',
                    $responseData['error_message'] ?? 'Terjadi kesalahan'
                ));
            }

            if ($responseData['verified'] && $responseData['distance'] < 0.65) {
                // update data absensi otomatis
                $data->update([
                    'status' => 1,
                    'verified' => true,
                    'verified_by' => 'System',
                    'distance' => $responseData['distance'],
                ]);

                // langsung kirim ke API
                $api = Http::post('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=insertAttendance', [
                    'kode_jari' => $this->kode_pegawai,
                    'waktu' => $data->waktu_ori,
                    'kodebarcode' => $this->no_vt,
                ]);

                dump($api->json());

                return broadcast(new RecognitionEvent(
                    $this->user_id,
                    'success',
                    'Berhasil',
                    'Absensi berhasil diverifikasi, lihat hasilnya di halaman absensi.'
                ));
            } else {
                $data->update([
                    'verified' => false,
                    'distance' => $responseData['distance'],
                    'status' => 0, // pending manual
                ]);

                return broadcast(new RecognitionEvent(
                    $this->user_id,
                    'error',
                    'Menunggu persetujuan',
                    'Absensi berhasil, namun wajah tidak dikenali. Silahkan menunggu hingga HRD memverifikasi.'
                ));
            }

        } catch (\Exception $e) {
            $data->delete();
            Storage::delete("{$this->img_path}/{$this->filename}");

            return broadcast(new RecognitionEvent(
                $this->user_id,
                'error',
                'Gagal',
                $e->getMessage()
            ));
        }
    }
}
