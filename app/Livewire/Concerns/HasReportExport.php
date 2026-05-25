<?php

/** Goal: Shared trait for report export Livewire components, Caller: ExportAbsensi/Cuti/etc, Deps: ExportReportJob, User */

namespace App\Livewire\Concerns;

use App\Jobs\ExportReportJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

trait HasReportExport
{
    #[Validate('required|date')]
    public string $fromDate = '';

    #[Validate('required|date|after_or_equal:fromDate')]
    public string $toDate = '';

    public ?string $filterBy = null;

    public ?string $filterValue = null;

    public ?string $exportFormat = 'xlsx';

    public function mountHasReportExport(): void
    {
        $this->fromDate = Carbon::today()->startOfWeek()->toDateString();
        $this->toDate = Carbon::today()->startOfWeek()->addDays(5)->toDateString();
    }

    public function showDaily(): void
    {
        $this->fromDate = Carbon::today()->startOfDay()->toDateString();
        $this->toDate = Carbon::today()->endOfDay()->toDateString();
    }

    public function showWeekly(): void
    {
        $this->fromDate = Carbon::today()->startOfWeek()->toDateString();
        $this->toDate = Carbon::today()->endOfWeek()->toDateString();
    }

    public function showMonthly(): void
    {
        $this->fromDate = Carbon::today()->startOfMonth()->toDateString();
        $this->toDate = Carbon::today()->endOfMonth()->toDateString();
    }

    public function showYearly(): void
    {
        $this->fromDate = Carbon::today()->startOfYear()->toDateString();
        $this->toDate = Carbon::today()->endOfYear()->toDateString();
    }

    public function updatedFilterBy(): void
    {
        $this->filterValue = null;
    }

    /**
     * Mengembalikan tipe laporan (e.g. 'absensi', 'cuti').
     */
    abstract protected function getReportType(): string;

    /**
     * Mengembalikan konfigurasi filter dinamis.
     *
     * @return array<string, array{label: string, column: string, relation: string|null}>
     */
    abstract protected function getFilterOptions(): array;

    /**
     * Mengambil daftar user untuk dropdown filter.
     */
    #[Computed]
    public function filterUsers(): Collection
    {
        return User::select(['id', 'kode_pegawai', 'name'])
            ->orderBy('name', 'asc')
            ->get();
    }

    public function export(): void
    {
        $this->validate();

        ExportReportJob::dispatch(
            Auth::id(),
            $this->getReportType(),
            $this->fromDate,
            $this->toDate,
            $this->filterBy,
            $this->filterValue,
            $this->exportFormat,
        )->delay(now()->addSeconds(2));

        $this->dispatch('swal',
            title: 'Berhasil',
            text: 'Permintaan export sedang diproses. Silahkan cek menu notifikasi nanti.',
            icon: 'success'
        );
    }
}
