<?php

/** Goal: Form perujukan otomatis dengan algoritma A* — tampilan Analisis Rujukan, Caller: rujukan.create */

namespace App\Livewire\Handler\Rujukan;

use App\Enums\StatusRujukan;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Pasien;
use App\Models\RiwayatRujukan;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Services\HospitalScoringService;
use App\Services\ReferralService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

    // Form state
    public ?int $pasienId = null;

    public ?string $rumahSakitTarget = 'semua';

    public string $metode = 'astar';

    public string $prioritasRute = 'jarak';

    public ?string $layanan = null;

    public int $radiusKm = 50;

    public ?float $pasienLat = null;

    public ?float $pasienLng = null;

    // A* result state
    public ?array $astarResult = null;

    public ?int $rujukanId = null;

    public bool $showResult = false;

    /** ID rumah sakit yang dipilih user di tabel hasil analisis */
    public ?int $selectedRumahSakitId = null;

    public function mount(?int $pasien = null): void
    {
        if ($pasien) {
            $this->pasienId = $pasien;
        } else {
            $firstPasien = Pasien::whereNotNull('latitude')->first();
            $this->pasienId = $firstPasien?->id_pasien;
        }

        $this->loadPasienCoordinates();
    }

    protected function rules(): array
    {
        return [
            'pasienId' => 'required|exists:pasien,id_pasien',
        ];
    }

    protected array $messages = [
        'pasienId.required' => 'Pilih pasien terlebih dahulu.',
        'pasienId.exists' => 'Pasien tidak ditemukan.',
    ];

    public function updatedPasienId(): void
    {
        $this->loadPasienCoordinates();
        $this->resetResult();
    }

    public function searchReferral(): void
    {
        $this->autoRunAnalysis();
    }

    private function autoRunAnalysis(): void
    {
        abort_unless(auth()->check(), 403);

        if (! $this->pasienId) {
            $this->resetResult();

            return;
        }

        $this->runSafely(function () {
            $pasien = Pasien::findOrFail($this->pasienId);

            if ($this->pasienLat && $this->pasienLng) {
                $pasien->latitude = $this->pasienLat;
                $pasien->longitude = $this->pasienLng;
            }

            $layananSearch = $this->layanan;
            if (! $layananSearch) {
                $available = app(HospitalScoringService::class)->getAllAvailableLayanan();
                $layananSearch = $available[0] ?? 'Katarak';
            }

            $result = app(ReferralService::class)->processReferral(
                pasien: $pasien,
                layananDibutuhkan: $layananSearch,
                requestedBy: auth()->user(),
                radiusKm: $this->radiusKm,
                targetHospitalId: $this->rumahSakitTarget !== 'semua' ? (int) $this->rumahSakitTarget : null,
            );

            $this->astarResult = $result->astarResult->toArray();
            $this->rujukanId = $result->rujukan->id_rujukan;
            $this->showResult = true;

            $this->dispatch('astar-result-ready', result: $this->astarResult);
        }, 'Gagal menjalankan analisis A*');
    }

    public function confirmReferral(): void
    {
        abort_unless(auth()->check(), 403);

        if (! $this->rujukanId) {
            $this->dispatch('swal', title: 'Perhatian', text: 'Cari rujukan terlebih dahulu.', icon: 'warning');

            return;
        }

        $this->runSafely(function () {
            $rujukan = Rujukan::findOrFail($this->rujukanId);
            $rujukan->update(['status' => StatusRujukan::Disetujui->value]);

            $this->dispatch('swal', title: 'Berhasil', text: 'Rujukan berhasil dikonfirmasi.', icon: 'success', redirect: [
                'url' => route('rujukan.show', $this->rujukanId),
                'delay' => 1500,
            ]);
        }, 'Gagal mengkonfirmasi rujukan');
    }

    /**
     * Simpan riwayat rujukan berdasarkan rumah sakit yang dipilih user di tabel hasil analisis.
     * Jika RS yang dipilih berbeda dari RS terbaik A*, rujukan diperbarui ke RS tersebut.
     */
    public function simpanRiwayat(int $rumahSakitId): void
    {
        abort_unless(auth()->check(), 403);

        if (! $this->rujukanId) {
            $this->dispatch('swal', title: 'Perhatian', text: 'Jalankan analisis terlebih dahulu.', icon: 'warning');

            return;
        }

        $this->runSafely(function () use ($rumahSakitId) {
            $rujukan = Rujukan::findOrFail($this->rujukanId);

            // Perbarui RS tujuan jika user memilih RS berbeda dari hasil A*
            if ($rujukan->id_rumah_sakit !== $rumahSakitId) {
                $rujukan->update(['id_rumah_sakit' => $rumahSakitId]);
            }

            RiwayatRujukan::create([
                'id_rujukan' => $rujukan->id_rujukan,
                'status_lama' => $rujukan->status->value,
                'status_baru' => $rujukan->status->value,
                'keterangan' => 'Riwayat rujukan disimpan dari hasil analisis A*. RS dipilih: ID '.$rumahSakitId,
                'diubah_oleh' => auth()->id(),
                'waktu_perubahan' => now(),
            ]);

            $this->dispatch('swal', title: 'Berhasil', text: 'Riwayat rujukan berhasil disimpan.', icon: 'success', redirect: [
                'url' => route('rujukan.show', $this->rujukanId),
                'delay' => 1500,
            ]);
        }, 'Gagal menyimpan riwayat rujukan');
    }

    private function loadPasienCoordinates(): void
    {
        if ($this->pasienId) {
            $pasien = Pasien::find($this->pasienId);
            if ($pasien) {
                $this->pasienLat = (float) $pasien->latitude;
                $this->pasienLng = (float) $pasien->longitude;
            }
        }
    }

    private function resetResult(): void
    {
        $this->astarResult = null;
        $this->rujukanId = null;
        $this->showResult = false;
        $this->selectedRumahSakitId = null;
    }

    public function render(): View
    {
        return view('livewire.handler.rujukan.create', [
            'pasienList' => Pasien::orderBy('nama')->get(['id_pasien', 'nama', 'nik', 'alamat', 'latitude', 'longitude']),
            'rumahSakitList' => RumahSakit::orderBy('nama_rumah_sakit')->get(['id_rumah_sakit', 'nama_rumah_sakit', 'alamat', 'latitude', 'longitude']),
            'layananList' => app(HospitalScoringService::class)->getAllAvailableLayanan(),
        ]);
    }
}
