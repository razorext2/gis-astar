<?php

/** Goal: Livewire export handler untuk Laporan Invoice, Caller: dashboard.report.invoice, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportInvoice extends Component
{
    use HasReportExport;

    public string $dateType = 'created_at';
    public ?string $tipeTagihan = null;
    public ?string $tipeInvoice = null;
    public ?string $statusPengiriman = null;
    public array $additionalFilters = [];

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

    public function export(): void
    {
        $this->validate();
        $this->sanitizeFilterBy();

        $this->additionalFilters = [
            'date_type' => $this->dateType,
            'tipe_tagihan' => $this->tipeTagihan,
            'tipe_invoice' => $this->tipeInvoice,
            'status_pengiriman' => $this->statusPengiriman !== null && $this->statusPengiriman !== '' ? $this->statusPengiriman : null,
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
        return view('livewire.handler.report.export-invoice', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
