<?php

/** Goal: Livewire export handler untuk Laporan Sales, Caller: dashboard.report.sales, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportSales extends Component
{
    use HasReportExport;

    public ?string $kodePegawai = null;
    public ?string $status = null;
    public ?string $customerMakeOrder = null;
    public array $additionalFilters = [];

    protected function getReportType(): string
    {
        return 'sales';
    }

    protected function getFilterOptions(): array
    {
        return [
            'validate_by' => ['label' => 'Divalidasi Oleh', 'column' => 'validate_by'],
        ];
    }

    public function export(): void
    {
        $this->validate();

        $this->additionalFilters = [
            'kode_pegawai' => $this->kodePegawai !== null && $this->kodePegawai !== '' ? $this->kodePegawai : null,
            'status' => $this->status !== null && $this->status !== '' ? $this->status : null,
            'customer_make_order' => $this->customerMakeOrder !== null && $this->customerMakeOrder !== '' ? $this->customerMakeOrder : null,
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
        return view('livewire.handler.report.export-sales', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
