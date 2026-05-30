<?php

/** Goal: Livewire export handler untuk Laporan Driver, Caller: dashboard.report.driver, Deps: HasReportExport trait */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Component;

class ExportDriver extends Component
{
    use HasReportExport;

    public ?string $tipeTagihan = null;
    public ?string $tipeKunjungan = null;
    public ?string $kodePegawai = null;
    public ?string $status = null;
    public ?string $statusPengantaran = null;
    public array $additionalFilters = [];

    protected function getReportType(): string
    {
        return 'driver';
    }

    protected function getFilterOptions(): array
    {
        return [
            'assign_by' => ['label' => 'Di-assign Oleh', 'column' => 'assign_by'],
        ];
    }

    public function export(): void
    {
        $this->validate();

        $this->additionalFilters = [
            'tipe_tagihan' => $this->tipeTagihan !== null && $this->tipeTagihan !== '' ? $this->tipeTagihan : null,
            'tipe_kunjungan' => $this->tipeKunjungan !== null && $this->tipeKunjungan !== '' ? $this->tipeKunjungan : null,
            'kode_pegawai' => $this->kodePegawai !== null && $this->kodePegawai !== '' ? $this->kodePegawai : null,
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
