<?php

namespace App\Livewire\Handler\Sales;

use App\Jobs\ExportSalesToExcelJob;
use App\Models\Sales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Export extends Component
{
    public $showModal = false;

    public $fromDate;

    public $toDate;

    public $role;

    public $sales;

    public function authUser()
    {
        return Auth::user();
    }

    public function mount()
    {
        $this->fromDate = Carbon::today()->startOfWeek()->toDateString();
        $this->toDate = Carbon::today()->startOfWeek()->addDays(5)->toDateString();
    }

    public function showDaily()
    {
        $this->fromDate = Carbon::today()->startOfDay()->toDateString();
        $this->toDate = Carbon::tomorrow()->endOfDay()->toDateString();
    }

    public function showWeekly()
    {
        $this->fromDate = Carbon::today()->startOfWeek()->toDateString();
        $this->toDate = Carbon::today()->endOfWeek()->toDateString();
    }

    public function showMonthly()
    {
        $this->fromDate = Carbon::today()->startOfMonth()->toDateString();
        $this->toDate = Carbon::today()->endOfMonth()->toDateString();
    }

    public function showYearly()
    {
        $this->fromDate = Carbon::today()->startOfYear()->toDateString();
        $this->toDate = Carbon::today()->endOfYear()->toDateString();
    }

    public function export()
    {
        $data = Sales::where('created_at', '>=', $this->fromDate)
            ->where('created_at', '<=', $this->toDate);

        // Apply role filter for non-Admin users when a specific role is selected
        if ($this->role !== 'All') {
            $data = $data->whereHas('userRelasi.roles', function ($q) {
                $q->where('name', $this->role);
            });
        }

        // jika pilih nama, maka munculkan laporan sesuai nama yg dipilih
        if ($this->sales) {
            $data = $data->where('kode_pegawai', $this->sales);
        }

        if (! $data->exists()) {
            return $this->dispatch('swal', title: 'Gagal', text: 'Data tidak ditemukan', icon: 'error');
        }

        $user = $this->authUser()->id;
        $fromDate = $this->fromDate;
        $toDate = $this->toDate;
        $role = $this->role;
        $sales = $this->sales;

        ExportSalesToExcelJob::dispatch($user, $fromDate, $toDate, $role, $sales)->delay(now()->addSeconds(5));

        $this->showModal = false;

        return $this->dispatch('swal', title: 'Berhasil', text: 'Data berhasil di export', icon: 'success');
    }

    public function render()
    {
        $user = $this->authUser();

        $allowedRoles = match (true) {
            $user->can('sales-export-all') => ['Sales', 'Sales-JKT', 'Sales-PKU', 'Sales-IDY', 'Kurir-Bank'],
            $user->can('sales-export-medan') => ['Sales'],
            $user->can('sales-export-idy') => ['Sales-IDY'],
            $user->can('sales-export-jkt') => ['Sales-JKT'],
            $user->can('sales-export-kurir-bank') => ['Kurir-Bank'],
            $user->can('sales-export-pku') => ['Sales-PKU'],
            default => [],
        };

        if (empty($allowedRoles)) {
            abort(403);
        }

        $sales = User::select(['id', 'kode_pegawai', 'name'])
            ->whereHas('roles', fn ($query) => $query->whereIn('name', $allowedRoles))
            ->orderBy('kode_pegawai', 'asc')
            ->get();

        return view('livewire.handler.sales.export', [
            'salesData' => $sales,
        ]);
    }
}
