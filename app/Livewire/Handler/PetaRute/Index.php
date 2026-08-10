<?php

namespace App\Livewire\Handler\PetaRute;

use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{
    public ?int $rujukanId = null;

    public ?int $pasienId = null;

    public ?int $rsId = null;

    public string $metode = 'Rute Terpendek';

    /** @var Collection<int, Rujukan> */
    public Collection $rujukanList;

    /** @var Collection<int, RumahSakit> */
    public Collection $rsList;

    public ?Pasien $selectedPasien = null;

    public ?Rujukan $rujukan = null;

    public function mount(): void
    {
        // Ambil semua riwayat rujukan untuk inisialisasi awal pilihan dropdown.
        // Semua handler dapat melihat seluruh data rujukan.
        $this->rujukanList = Rujukan::with(['pasien', 'rumahSakit', 'detailRujukan'])
            ->latest()
            ->get();

        // Ambil semua Rumah Sakit agar input select Rumah Sakit (read-only) dapat menampilkan label terpilih
        $this->rsList = RumahSakit::orderBy('nama_rumah_sakit')
            ->get(['id_rumah_sakit', 'nama_rumah_sakit']);
    }

    public function updatedRujukanId(?int $value): void
    {
        // Gunakan eager load ringan — detail rute tidak diperlukan sampai tombol 'Tarik Data Rute' diklik
        $this->rujukan = $value
            ? Rujukan::with(['pasien', 'rumahSakit', 'detailRujukan'])->find($value)
            : null;

        if ($this->rujukan) {
            $this->pasienId = $this->rujukan->id_pasien;
            $this->selectedPasien = $this->rujukan->pasien;
            $this->rsId = $this->rujukan->id_rumah_sakit;

            $detail = $this->rujukan->detailRujukan;
            $this->metode = $detail ? $detail->metode : 'Rute Terpendek';
        } else {
            $this->pasienId = null;
            $this->selectedPasien = null;
            $this->rsId = null;
            $this->metode = 'Rute Terpendek';
        }

        // Reset visual rute pada peta & tabel sampai tombol 'Tarik Data Rute' diklik
        $this->dispatch('clear-route');
    }

    public function search(): void
    {
        if (! $this->rujukanId) {
            $this->dispatch('swal', title: 'Perhatian', text: 'Pilih riwayat rujukan terlebih dahulu.', icon: 'warning');

            return;
        }

        // Load penuh dengan relasi titik rute untuk membangun turn-by-turn navigation
        $this->rujukan = Rujukan::with(['pasien', 'rumahSakit', 'detailRujukan.rute.titikRute'])
            ->find($this->rujukanId);

        if (! $this->rujukan) {
            $this->dispatch('swal', title: 'Perhatian', text: 'Data rujukan tidak ditemukan.', icon: 'warning');

            return;
        }

        $this->selectedPasien = $this->rujukan->pasien;
        $this->pasienId = $this->rujukan->id_pasien;
        $this->rsId = $this->rujukan->id_rumah_sakit;

        $detail = $this->rujukan->detailRujukan;
        $this->metode = $detail ? $detail->metode : 'Rute Terpendek';
        $rute = $detail?->rute;

        if (! $rute || ! $this->selectedPasien || ! $this->rujukan->rumahSakit) {
            $this->dispatch('swal', title: 'Error', text: 'Data rute atau lokasi tidak lengkap.', icon: 'error');

            return;
        }

        // Hitung estimasi tiba — pastikan waktu_tempuh tidak null sebelum operasi aritmetika
        $waktuTempuhDetik = (int) ($detail->waktu_tempuh ?? 0);
        $waktuTempuhMenit = (int) ceil($waktuTempuhDetik / 60);
        $estimasiTiba = now()->addMinutes($waktuTempuhMenit)->format('H:i').' WIB';

        $this->dispatch('rute-loaded',
            pasien: [
                'nama' => $this->selectedPasien->nama,
                'alamat' => $this->selectedPasien->alamat ?? '-',
                'lat' => (float) $this->selectedPasien->latitude,
                'lng' => (float) $this->selectedPasien->longitude,
            ],
            rs: [
                'nama' => $this->rujukan->rumahSakit->nama_rumah_sakit,
                'alamat' => $this->rujukan->rumahSakit->alamat ?? '-',
                'lat' => (float) $this->rujukan->rumahSakit->latitude,
                'lng' => (float) $this->rujukan->rumahSakit->longitude,
            ],
            jarak: (float) $detail->jarak,
            waktu: $waktuTempuhDetik,
            estimasi_tiba: $estimasiTiba,
            kondisi: 'Lancar',
            metode: $this->metode,
        );
    }

    public function render(): View
    {
        return view('livewire.handler.peta-rute.index');
    }
}
