<?php

/** Goal: Livewire export handler untuk Laporan Sales, Caller: dashboard.report.sales, Deps: HasReportExport trait, User model */

namespace App\Livewire\Handler\Report;

use App\Livewire\Concerns\HasReportExport;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ExportSales extends Component
{
    use HasReportExport;

    public array $selectedSales = [];
    public string $salesSearchQuery = '';

    public array $selectedValidators = [];
    public string $validatorSearchQuery = '';

    public ?string $status = null;
    public ?string $customerMakeOrder = null;
    public array $additionalFilters = [];

    protected function getReportType(): string
    {
        return 'sales';
    }

    protected function getFilterOptions(): array
    {
        return [];
    }

    #[Computed]
    public function salesSearchResults()
    {
        if (strlen($this->salesSearchQuery) < 1) {
            return [];
        }

        $selectedCodes = array_column($this->selectedSales, 'kode_pegawai');

        return \App\Models\User::select(['id', 'kode_pegawai', 'name'])
            ->whereNotNull('kode_pegawai')
            ->where(function ($q) {
                $q->where('kode_pegawai', 'like', '%'.$this->salesSearchQuery.'%')
                    ->orWhere('name', 'like', '%'.$this->salesSearchQuery.'%');
            })
            ->when(! empty($selectedCodes), fn ($q) => $q->whereNotIn('kode_pegawai', $selectedCodes))
            ->orderBy('name')
            ->limit(8)
            ->get();
    }

    #[Computed]
    public function validatorSearchResults()
    {
        if (strlen($this->validatorSearchQuery) < 1) {
            return [];
        }

        $selectedIds = array_column($this->selectedValidators, 'id');

        return \App\Models\User::select(['id', 'kode_pegawai', 'name'])
            ->where(function ($q) {
                $q->where('kode_pegawai', 'like', '%'.$this->validatorSearchQuery.'%')
                    ->orWhere('name', 'like', '%'.$this->validatorSearchQuery.'%');
            })
            ->when(! empty($selectedIds), fn ($q) => $q->whereNotIn('id', $selectedIds))
            ->orderBy('name')
            ->limit(8)
            ->get();
    }

    public function selectSales(string $kodePegawai, string $name): void
    {
        $this->selectedSales[] = [
            'kode_pegawai' => $kodePegawai,
            'name' => $name,
        ];
        $this->salesSearchQuery = '';
    }

    public function removeSales(string $kodePegawai): void
    {
        $this->selectedSales = array_filter($this->selectedSales, function ($item) use ($kodePegawai) {
            return $item['kode_pegawai'] !== $kodePegawai;
        });
        $this->selectedSales = array_values($this->selectedSales);
    }

    public function selectValidator(int $id, string $name): void
    {
        $this->selectedValidators[] = [
            'id' => $id,
            'name' => $name,
        ];
        $this->validatorSearchQuery = '';
    }

    public function removeValidator(int $id): void
    {
        $this->selectedValidators = array_filter($this->selectedValidators, function ($item) use ($id) {
            return $item['id'] !== $id;
        });
        $this->selectedValidators = array_values($this->selectedValidators);
    }

    public function export(): void
    {
        $this->validate();
        $this->sanitizeFilterBy();

        $this->additionalFilters = [
            'kode_pegawai' => !empty($this->selectedSales) ? array_column($this->selectedSales, 'kode_pegawai') : null,
            'validate_by' => !empty($this->selectedValidators) ? array_column($this->selectedValidators, 'id') : null,
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
