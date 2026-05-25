<?php

/** Goal: Livewire export handler untuk Laporan Kolektor, Caller: dashboard.report.kolektor, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportKolektor extends Component
{
    use HasReportExport;

    protected function getReportType(): string
    {
        return 'kolektor';
    }

    protected function getFilterOptions(): array
    {
        return [
            'kode_pegawai' => ['label' => 'Kolektor (Kode Pegawai)', 'column' => 'kode_pegawai'],
            'filled_by' => ['label' => 'Diisi Oleh', 'column' => 'filled_by'],
        ];
    }

    public function render()
    {
        return view('livewire.handler.report.export-kolektor', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
