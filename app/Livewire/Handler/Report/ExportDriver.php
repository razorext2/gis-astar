<?php

/** Goal: Livewire export handler untuk Laporan Driver, Caller: dashboard.report.driver, Deps: HasReportExport trait, User model */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ExportDriver extends Component
{
    use HasReportExport;

    public ?string $tipeTagihan = null;
    public ?string $tipeKunjungan = null;

    public array $selectedDrivers = [];
    public string $driverSearchQuery = '';

    public array $selectedAssigners = [];
    public string $assignerSearchQuery = '';

    public ?string $status = null;
    public ?string $statusPengantaran = null;
    public array $additionalFilters = [];

    protected function getReportType(): string
    {
        return 'driver';
    }

    protected function getFilterOptions(): array
    {
        return [];
    }

    #[Computed]
    public function driverSearchResults()
    {
        if (strlen($this->driverSearchQuery) < 1) {
            return [];
        }

        $selectedCodes = array_column($this->selectedDrivers, 'kode_pegawai');

        return \App\Models\User::select(['id', 'kode_pegawai', 'name'])
            ->whereNotNull('kode_pegawai')
            ->where(function ($q) {
                $q->where('kode_pegawai', 'like', '%'.$this->driverSearchQuery.'%')
                    ->orWhere('name', 'like', '%'.$this->driverSearchQuery.'%');
            })
            ->when(! empty($selectedCodes), fn ($q) => $q->whereNotIn('kode_pegawai', $selectedCodes))
            ->orderBy('name')
            ->limit(8)
            ->get();
    }

    #[Computed]
    public function assignerSearchResults()
    {
        if (strlen($this->assignerSearchQuery) < 1) {
            return [];
        }

        $selectedIds = array_column($this->selectedAssigners, 'id');

        return \App\Models\User::select(['id', 'kode_pegawai', 'name'])
            ->where(function ($q) {
                $q->where('kode_pegawai', 'like', '%'.$this->assignerSearchQuery.'%')
                    ->orWhere('name', 'like', '%'.$this->assignerSearchQuery.'%');
            })
            ->when(! empty($selectedIds), fn ($q) => $q->whereNotIn('id', $selectedIds))
            ->orderBy('name')
            ->limit(8)
            ->get();
    }

    public function selectDriver(string $kodePegawai, string $name): void
    {
        $this->selectedDrivers[] = [
            'kode_pegawai' => $kodePegawai,
            'name' => $name,
        ];
        $this->driverSearchQuery = '';
    }

    public function removeDriver(string $kodePegawai): void
    {
        $this->selectedDrivers = array_filter($this->selectedDrivers, function ($item) use ($kodePegawai) {
            return $item['kode_pegawai'] !== $kodePegawai;
        });
        $this->selectedDrivers = array_values($this->selectedDrivers);
    }

    public function selectAssigner(int $id, string $name): void
    {
        $this->selectedAssigners[] = [
            'id' => $id,
            'name' => $name,
        ];
        $this->assignerSearchQuery = '';
    }

    public function removeAssigner(int $id): void
    {
        $this->selectedAssigners = array_filter($this->selectedAssigners, function ($item) use ($id) {
            return $item['id'] !== $id;
        });
        $this->selectedAssigners = array_values($this->selectedAssigners);
    }

    public function export(): void
    {
        $this->validate();

        $this->additionalFilters = [
            'tipe_tagihan' => $this->tipeTagihan !== null && $this->tipeTagihan !== '' ? $this->tipeTagihan : null,
            'tipe_kunjungan' => $this->tipeKunjungan !== null && $this->tipeKunjungan !== '' ? $this->tipeKunjungan : null,
            'kode_pegawai' => !empty($this->selectedDrivers) ? array_column($this->selectedDrivers, 'kode_pegawai') : null,
            'assign_by' => !empty($this->selectedAssigners) ? array_column($this->selectedAssigners, 'id') : null,
            'status' => $this->status !== null && $this->status !== '' ? $this->status : null,
            'status_pengantaran' => $this->statusPengantaran !== null && $this->statusPengantaran !== '' ? $this->statusPengantaran : null,
        ];

        \App\Jobs\ExportReportJob::dispatch(
            \Illuminate\Support\Facades\Auth::id(),
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

    public function render()
    {
        return view('livewire.handler.report.export-driver', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}

