<?php

/** Goal: Livewire export handler untuk Laporan SPK, Caller: dashboard.report.spk, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportSpk extends Component
{
    use HasReportExport;

    public ?string $tipeTagihan = null;
    public ?string $tipeTimbangan = null;
    public ?string $status = null;
    public ?string $statusApproval = null;
    public array $additionalFilters = [];

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

    public function export(): void
    {
        $this->validate();
        $this->sanitizeFilterBy();

        $this->additionalFilters = [
            'tipe_tagihan' => $this->tipeTagihan !== null && $this->tipeTagihan !== '' ? $this->tipeTagihan : null,
            'tipe_timbangan' => $this->tipeTimbangan !== null && $this->tipeTimbangan !== '' ? $this->tipeTimbangan : null,
            'status' => $this->status !== null && $this->status !== '' ? $this->status : null,
            'status_approval' => $this->statusApproval !== null && $this->statusApproval !== '' ? $this->statusApproval : null,
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
        return view('livewire.handler.report.export-spk', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}
