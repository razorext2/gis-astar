<?php

/** Goal: Livewire export handler untuk Laporan Piutang, Caller: dashboard.report.piutang, Deps: HasReportExport trait, User, Spatie Role, ExportReportJob */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ExportPiutang extends Component
{
    use HasReportExport;

    public string $dateType = 'created_at';

    public ?string $srType = null;

    public ?int $billStatus = null;

    public array $additionalFilters = [];

    protected function getReportType(): string
    {
        return 'piutang';
    }

    protected function getFilterOptions(): array
    {
        return [
            'assign_to' => ['label' => 'Assign Ke (Kolektor)', 'column' => 'assign_to', 'value_type' => 'kode_pegawai'],
            'assign_by' => ['label' => 'Di-assign Oleh', 'column' => 'assign_by', 'value_type' => 'kode_pegawai'],
        ];
    }

    #[Computed]
    public function filterUsers()
    {
        if ($this->filterBy === 'assign_to') {
            return User::select(['id', 'kode_pegawai', 'name', 'is_active'])
                ->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['Collector', 'collector', 'kasir-bank', 'Kasir']);
                })
                ->orderBy('name', 'asc')
                ->get();
        }

        if ($this->filterBy === 'assign_by') {
            return User::select(['id', 'kode_pegawai', 'name', 'is_active'])
                ->whereHas('roles', function ($q) {
                    $q->whereIn('name', [
                        'Piutang', 'piutang',
                        'Piutang-JKT', 'piutang-jkt',
                        'Piutang-PKU', 'piutang-pku',
                    ]);
                })
                ->orderBy('name', 'asc')
                ->get();
        }

        return collect();
    }

    public function export(): void
    {
        $this->validate();
        $this->sanitizeFilterBy();

        $this->additionalFilters = [
            'date_type' => $this->dateType,
            'sr_type' => $this->srType,
            'bill_status' => $this->billStatus,
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
        return view('livewire.handler.report.export-piutang', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
