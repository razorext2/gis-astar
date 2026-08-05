<?php

/** Goal: Form perujukan otomatis dengan algoritma A*, Caller: rujukan.create */

namespace App\Livewire\Handler\Rujukan;

use App\Enums\StatusRujukan;
use App\Livewire\Concerns\HandlesErrors;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Services\HospitalScoringService;
use App\Services\ReferralService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

    // Form state
    public ?int $pasienId = null;

    public ?string $layanan = null;

    public int $radiusKm = 50;

    public ?float $pasienLat = null;

    public ?float $pasienLng = null;

    // A* result state
    public ?array $astarResult = null;

    public ?int $rujukanId = null;

    public bool $showResult = false;

    // Pre-selected pasien dari query string (dari tombol Rujuk di PasienTable)
    public function mount(?int $pasien = null): void
    {
        if ($pasien) {
            $this->pasienId = $pasien;
            $this->loadPasienCoordinates();
        }
    }

    protected function rules(): array
    {
        return [
            'pasienId' => 'required|exists:pasien,id_pasien',
            'layanan' => 'required|string',
            'radiusKm' => 'required|integer|min:5|max:200',
        ];
    }

    protected array $messages = [
        'pasienId.required' => 'Pilih pasien terlebih dahulu.',
        'pasienId.exists' => 'Pasien tidak ditemukan.',
        'layanan.required' => 'Pilih layanan yang dibutuhkan.',
    ];

    /** Load koordinat pasien saat pasien dipilih */
    public function updatedPasienId(): void
    {
        $this->loadPasienCoordinates();
        $this->resetResult();
    }

    /** Reset hasil A* saat layanan berubah */
    public function updatedLayanan(): void
    {
        $this->resetResult();
    }

    /** Sinkron koordinat pasien ke state saat map picker berubah */
    public function updateCoordinates(float $lat, float $lng): void
    {
        $this->pasienLat = $lat;
        $this->pasienLng = $lng;
        $this->resetResult();
    }

    /**
     * Jalankan algoritma A* secara synchronous.
     * Dipanggil saat dokter klik "Cari Rujukan Terbaik".
     */
    public function searchReferral(): void
    {
        $this->validate();

        $this->runSafely(function () {
            $pasien = Pasien::findOrFail($this->pasienId);

            // Override koordinat jika sudah diupdate dari map picker
            if ($this->pasienLat && $this->pasienLng) {
                $pasien->latitude = $this->pasienLat;
                $pasien->longitude = $this->pasienLng;
            }

            $result = app(ReferralService::class)->processReferral(
                pasien: $pasien,
                layananDibutuhkan: $this->layanan,
                requestedBy: auth()->user(),
                radiusKm: $this->radiusKm,
            );

            $this->astarResult = $result->toArray();
            $this->rujukanId = $result->rujukan->id_rujukan;
            $this->showResult = true;

            $this->dispatch('astar-result-ready', result: $this->astarResult);
        }, 'Gagal menjalankan algoritma A*', [
            'pasien_id' => $this->pasienId,
            'layanan' => $this->layanan,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Konfirmasi rujukan yang sudah dipilih → update status ke 'disetujui'.
     */
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
        }, 'Gagal mengkonfirmasi rujukan', ['rujukan_id' => $this->rujukanId]);
    }

    private function loadPasienCoordinates(): void
    {
        if ($this->pasienId) {
            $pasien = Pasien::find($this->pasienId);
            if ($pasien) {
                $this->pasienLat = $pasien->latitude;
                $this->pasienLng = $pasien->longitude;
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
            'pasienList' => Pasien::orderBy('nama')->limit(200)->get(['id_pasien', 'nama', 'nik', 'latitude', 'longitude']),
            'layananList' => app(HospitalScoringService::class)->getAllAvailableLayanan(),
        ]);
    }
}
