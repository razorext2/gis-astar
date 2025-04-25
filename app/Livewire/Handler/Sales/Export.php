<?php

namespace App\Livewire\Handler\Sales;

use App\Jobs\ExportSalesToExcelJob;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Export extends Component
{
    public $showModal = false;
    public $fromDate;
    public $toDate;
    public $role;

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
            if (Auth::user()->hasRole('Management')) {
                $filterRole = 'Sales';
            } elseif (Auth::user()->hasRole('Management-JKT')) {
                $filterRole = 'Sales-JKT';
            } else {
                $filterRole = $this->role;
            }

            $data = $data->whereHas('userRelasi.roles', function ($q) use ($filterRole) {
                $q->where('name', $filterRole);
            });
        }

        if (!$data->exists()) {
            return $this->dispatch('swal', title: 'Gagal', text: 'Data tidak ditemukan', icon: 'error');
        }

        $user = Auth::id();
        $fromDate = $this->fromDate;
        $toDate = $this->toDate;
        $role = $this->role;

        ExportSalesToExcelJob::dispatch($user, $fromDate, $toDate, $role)->delay(now()->addSeconds(5));

        $this->showModal = false;
        return $this->dispatch('swal', title: 'Berhasil', text: 'Data berhasil di export', icon: 'success');
    }

    public function render()
    {
        return view('livewire.handler.sales.export');
    }
}
