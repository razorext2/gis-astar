<?php

/** Goal: Livewire export handler untuk Laporan Sales, Caller: dashboard.report.sales, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportSales extends Component
{
    use HasReportExport;

    protected function getReportType(): string
    {
        return 'sales';
    }

    protected function getFilterOptions(): array
    {
        return [
            'kode_pegawai' => ['label' => 'Sales (Kode Pegawai)', 'column' => 'kode_pegawai'],
            'validate_by' => ['label' => 'Divalidasi Oleh', 'column' => 'validate_by'],
        ];
    }

    public function render()
    {
        return view('livewire.handler.report.export-sales', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
