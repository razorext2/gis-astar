<?php

/** Goal: Livewire export handler untuk Laporan Absensi, Caller: dashboard.report.absensi, Deps: HasReportExport trait, Spatie Role, ExportReportJob */

namespace App\Livewire\Handler\Report;

use App\Jobs\ExportReportJob;
use App\Livewire\Concerns\HasReportExport;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ExportAbsensi extends Component
{
    use HasReportExport;

    public array $selectedPegawai = [];

    public string $pegawaiSearchQuery = '';

    public ?int $roleId = null;

    public ?int $positionStatus = null;

    public string $attendanceType = 'masuk';

    public ?string $verifiedStatus = null;

    public array $additionalFilters = [];

    protected function getReportType(): string
    {
        return 'absensi';
    }

    protected function getFilterOptions(): array
    {
        return [
            'kode_pegawai' => ['label' => 'Pegawai (Kode)', 'column' => 'kode_pegawai'],
        ];
    }

    #[Computed]
    public function pegawaiSearchResults()
    {
        if (strlen($this->pegawaiSearchQuery) < 1) {
            return [];
        }

        $selectedCodes = array_column($this->selectedPegawai, 'kode_pegawai');

        return Pegawai::select(['kode_pegawai', 'full_name'])
            ->where(function ($q) {
                $q->where('kode_pegawai', 'like', '%'.$this->pegawaiSearchQuery.'%')
                    ->orWhere('full_name', 'like', '%'.$this->pegawaiSearchQuery.'%');
            })
            ->when(! empty($selectedCodes), fn ($q) => $q->whereNotIn('kode_pegawai', $selectedCodes))
            ->orderBy('full_name')
            ->limit(8)
            ->get();
    }

    public function selectPegawai(int $kodePegawai, string $fullName): void
    {
        $this->selectedPegawai[] = [
            'kode_pegawai' => $kodePegawai,
            'full_name' => $fullName,
        ];

        $this->pegawaiSearchQuery = '';
    }

    public function removePegawai(int $kodePegawai): void
    {
        $this->selectedPegawai = array_filter($this->selectedPegawai, function ($item) use ($kodePegawai) {
            return $item['kode_pegawai'] !== $kodePegawai;
        });
        $this->selectedPegawai = array_values($this->selectedPegawai);
    }

    public function export(): void
    {
        $this->validate();
        $this->sanitizeFilterBy();

        $verified = null;
        if ($this->verifiedStatus === '1') {
            $verified = 1;
        } elseif ($this->verifiedStatus === '0') {
            $verified = 0;
        }

        $this->additionalFilters = [
            'role_id' => $this->roleId,
            'position_status' => $this->positionStatus,
            'attendance_type' => $this->attendanceType,
            'verified' => $verified,
        ];

        if (! empty($this->selectedPegawai)) {
            $this->filterBy = 'kode_pegawai';
            $this->filterValue = implode(',', array_column($this->selectedPegawai, 'kode_pegawai'));
        } else {
            $this->filterBy = null;
            $this->filterValue = null;
        }

        ExportReportJob::dispatch(
            Auth::id(),
            $this->getReportType(),
            $this->fromDate,
            $this->toDate,
            $this->filterBy,
            $this->filterValue,
            $this->exportFormat,
            $this->additionalFilters,
        )->delay(now()->addSeconds(2));

        $this->dispatch('swal',
            title: 'Berhasil',
            text: 'Permintaan export sedang diproses. Silahkan cek menu notifikasi nanti.',
            icon: 'success'
        );
    }

    #[Computed]
    public function roles()
    {
        return Role::select(['id', 'name'])->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.handler.report.export-absensi', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
            'roles' => $this->roles(),
        ]);
    }
}
