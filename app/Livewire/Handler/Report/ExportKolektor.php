<?php

/** Goal: Livewire export handler untuk Laporan Kolektor, Caller: dashboard.report.kolektor, Deps: HasReportExport trait, User model */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ExportKolektor extends Component
{
    use HasReportExport;

    public ?string $billType = null;
    public ?int $havePaid = null;
    public ?int $status = null;
    public array $additionalFilters = [];

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

    #[Computed]
    public function filterUsers(): \Illuminate\Support\Collection
    {
        return \App\Models\User::select(['id', 'kode_pegawai', 'name'])
            ->when($this->filterBy === 'kode_pegawai', function ($q) {
                $q->role('Collector');
            })
            ->orderBy('name', 'asc')
            ->get();
    }

    public function export(): void
    {
        $this->validate();
        $this->sanitizeFilterBy();

        $this->additionalFilters = [
            'bill_type' => $this->billType,
            'have_paid' => $this->havePaid !== null && $this->havePaid !== '' ? (int) $this->havePaid : null,
            'status' => $this->status !== null && $this->status !== '' ? (int) $this->status : null,
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
        return view('livewire.handler.report.export-kolektor', [
            'filterOptions' => $this->getFilterOptions(),
            'users' => $this->filterUsers(),
        ]);
    }
}

