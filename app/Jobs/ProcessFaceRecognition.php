<?php

namespace App\Jobs;

use App\Events\BasicEvent;
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

    /**
     * Create a new job instance.
     */
    public function __construct($model, $id, $img_path, $user_id, $kode_pegawai, $filename)
    {
        $this->model = $model;
        $this->id = $id;
        $this->img_path = $img_path;
        $this->user_id = $user_id;
        $this->kode_pegawai = $kode_pegawai;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $modelClass = "\\App\\Models\\{$this->model}";
        $file = fopen(storage_path('app/' . $this->img_path . '/' . $this->filename), 'r');

        $response = Http::attach('file', $file)
            ->post('http://127.0.0.1:9223/recognize', [
                'kode_pegawai' => $this->kode_pegawai,
            ])->json();

        if ($response['error']) {
            $modelClass::where('id', $this->id)->delete();
            Storage::delete("{$this->img_path}/{$this->filename}");

            return broadcast(new BasicEvent($this->user_id, 'error', $response['error_message']));
        }

        Storage::move($this->img_path . '/' . $this->filename, "public/labels/{$this->kode_pegawai}/capturedImg/{$this->filename}");

        if ($response['verified'] && $response['distance'] < 0.65) {
            $modelClass::where('id', $this->id)->update([
                'verified' => true,
                'verified_by' => 'System',
                'distance' => $response['distance'],
            ]);

        } else {
            $modelClass::where('id', $this->id)->update([
                'verified' => false,
                'distance' => $response['distance'],
            ]);
        }

        return broadcast(new BasicEvent($this->user_id, 'success', 'Absensi berhasil diverifikasi, lihat hasilnya di halaman absensi.'));
    }
}
