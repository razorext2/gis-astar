<?php

/** Goal: Form perujukan otomatis dengan algoritma A* — tampilan Analisis Rujukan, Caller: rujukan.create */

namespace App\Livewire\Handler\Rujukan;

use App\Enums\StatusRujukan;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\User;
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

    public function mount(?int $pasien = null): void
    {
        if ($pasien) {
            $this->pasienId = $pasien;
        } else {
            $firstPasien = Pasien::whereNotNull('latitude')->first();
            $this->pasienId = $firstPasien?->id_pasien;
        }

        $this->loadPasienCoordinates();

        // Run initial analysis automatically on page load if patient is available
        if ($this->pasienId) {
            $this->autoRunAnalysis();
        }
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
        $this->autoRunAnalysis();
    }

    public function updatedRumahSakitTarget(): void
    {
        $this->autoRunAnalysis();
    }

    public function updatedMetode(): void
    {
        $this->autoRunAnalysis();
    }

    public function updatedPrioritasRute(): void
    {
        $this->autoRunAnalysis();
    }

    public function searchReferral(): void
    {
        $this->autoRunAnalysis();
    }

    private function autoRunAnalysis(): void
    {
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
                requestedBy: auth()->user() ?? User::first(),
                radiusKm: $this->radiusKm,
            );

            $this->astarResult = $result->toArray();
            $this->rujukanId = $result->rujukan->id_rujukan;
            $this->showResult = true;

            $this->dispatch('astar-result-ready', result: $this->astarResult);
        }, 'Gagal menjalankan analisis A*');
    }

    public function confirmReferral(): void
    {
        if (! $this->rujukanId) {
            $this->dispatch('swal', title: 'Perhatian', text: 'Cari rujukan terlebih dahulu.', icon: 'warning');

            return;
        }

        $this->runSafely(function () {
            $rujukan = Rujukan::findOrFail($this->rujukanId);
            $rujukan->update(['status' => StatusRujukan::Disetujui->value]);

            $this->dispatch('swal', title: 'Berhasil', text: 'Rujukan berhasil dikonfirmasi.', icon: 'success');
            $this->redirect(route('rujukan.show', $this->rujukanId), navigate: true);
        }, 'Gagal mengkonfirmasi rujukan');
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
