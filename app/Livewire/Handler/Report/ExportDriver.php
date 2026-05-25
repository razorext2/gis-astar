<?php

/** Goal: Livewire export handler untuk Laporan Driver, Caller: dashboard.report.driver, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportDriver extends Component
{
    use HasReportExport;

    protected function getReportType(): string
    {
        return 'driver';
    }

    protected function getFilterOptions(): array
    {
        return [
            'kode_pegawai' => ['label' => 'Driver (Kode Pegawai)', 'column' => 'kode_pegawai'],
            'assign_by' => ['label' => 'Di-assign Oleh', 'column' => 'assign_by'],
        ];
    }

    public function render()
    {
        return view('livewire.handler.report.export-driver', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
