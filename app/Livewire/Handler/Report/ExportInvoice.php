<?php

/** Goal: Livewire export handler untuk Laporan Invoice, Caller: dashboard.report.invoice, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportInvoice extends Component
{
    use HasReportExport;

    protected function getReportType(): string
    {
        return 'invoice';
    }

    protected function getFilterOptions(): array
    {
        return [
            'added_by' => ['label' => 'Ditambahkan Oleh', 'column' => 'added_by'],
        ];
    }

    public function render()
    {
        return view('livewire.handler.report.export-invoice', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
