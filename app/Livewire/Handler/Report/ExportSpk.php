<?php

/** Goal: Livewire export handler untuk Laporan SPK, Caller: dashboard.report.spk, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportSpk extends Component
{
    use HasReportExport;

    protected function getReportType(): string
    {
        return 'spk';
    }

    protected function getFilterOptions(): array
    {
        return [
            'added_by' => ['label' => 'Dibuat Oleh', 'column' => 'added_by'],
            'assign_to' => ['label' => 'Assign Ke', 'column' => 'assign_to'],
        ];
    }

    public function render()
    {
        return view('livewire.handler.report.export-spk', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
