<?php

namespace App\Livewire\Handler\PetaRute;

use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public ?int $pasienId = null;

    public ?int $rsId = null;

    public string $metode = 'Rute Terpendek';

    public $pasienList = [];

    public $rsList = [];

    public ?Pasien $selectedPasien = null;

    public ?Rujukan $rujukan = null;

    public function mount(): void
    {
        // Ambil pasien yang memiliki riwayat rujukan
        $this->pasienList = Pasien::whereIn('id_pasien', Rujukan::pluck('id_pasien'))
            ->orderBy('nama')
            ->get(['id_pasien', 'nama', 'nik', 'alamat', 'latitude', 'longitude']);
    }

    public function updatedPasienId(?int $value): void
    {
        $this->selectedPasien = $value ? Pasien::find($value) : null;
        $this->rsId = null;
        $this->rujukan = null;
        $this->rsList = [];

        if ($value) {
            // Ambil Rumah Sakit rujukan yang pernah ditugaskan kepada pasien ini
            $this->rsList = RumahSakit::whereIn('id_rumah_sakit', Rujukan::where('id_pasien', $value)->pluck('id_rumah_sakit'))
                ->orderBy('nama_rumah_sakit')
                ->get(['id_rumah_sakit', 'nama_rumah_sakit', 'alamat', 'latitude', 'longitude']);
        }
    }

    public function search(): void
    {
        $this->validate([
            'pasienId' => 'required',
            'rsId' => 'required',
        ]);

        $this->rujukan = Rujukan::where('id_pasien', $this->pasienId)
            ->where('id_rumah_sakit', $this->rsId)
            ->with(['detailRujukan.rute.titikRute', 'rumahSakit'])
            ->latest()
            ->first();

        if (! $this->rujukan) {
            $this->dispatch('swal', title: 'Perhatian', text: 'Riwayat rujukan tidak ditemukan untuk pasien dan rumah sakit terpilih.', icon: 'warning');

            return;
        }

        $detail = $this->rujukan->detailRujukan;
        $rute = $detail?->rute;

        if (! $rute) {
            $this->dispatch('swal', title: 'Error', text: 'Data rute tidak ditemukan.', icon: 'error');

            return;
        }

        // Hitung estimasi tiba (waktu sekarang + waktu tempuh dalam menit)
        $waktuTempuhMenit = Math_ceil($detail->waktu_tempuh / 60);
        $estimasiTiba = now()->addMinutes($waktuTempuhMenit)->format('H:i').' WIB';

        $this->dispatch('rute-loaded', [
            'pasien' => [
                'nama' => $this->selectedPasien->nama,
                'alamat' => $this->selectedPasien->alamat,
                'lat' => (float) $this->selectedPasien->latitude,
                'lng' => (float) $this->selectedPasien->longitude,
            ],
            'rs' => [
                'nama' => $this->rujukan->rumahSakit->nama_rumah_sakit,
                'alamat' => $this->rujukan->rumahSakit->alamat,
                'lat' => (float) $this->rujukan->rumahSakit->latitude,
                'lng' => (float) $this->rujukan->rumahSakit->longitude,
            ],
            'jarak' => (float) $detail->jarak,
            'waktu' => (int) $detail->waktu_tempuh,
            'estimasi_tiba' => $estimasiTiba,
            'kondisi' => 'Lancar',
            'metode' => $detail->metode,
        ]);
    }

    public function render(): View
    {
        return view('livewire.handler.peta-rute.index');
    }
}
