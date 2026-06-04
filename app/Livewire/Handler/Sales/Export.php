<?php

/** Goal: Logika export sales dengan filter tanggal, role, dan nama sales, Caller: Dashboard, Deps: ExportSalesToExcelJob, Sales, User */

namespace App\Livewire\Handler\Sales;

use App\Jobs\ExportSalesToExcelJob;
use App\Models\Sales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Export extends Component
{
    /** Status modal sync dengan Alpine.js */
    public bool $showModal = false;

    #[Validate('required|date')]
    public string $fromDate = '';

    #[Validate('required|date|after_or_equal:fromDate')]
    public string $toDate = '';

    #[Validate('required|string')]
    public string $role = 'All';

    public ?string $sales = null;

    /** Format tanggal default pada saat komponen dimuat */
    public function mount(): void
    {
        $this->fromDate = Carbon::today()->startOfWeek()->toDateString();
        $this->toDate = Carbon::today()->startOfWeek()->addDays(5)->toDateString();
    }

    /** Set periode harian */
    public function showDaily(): void
    {
        $this->fromDate = Carbon::today()->startOfDay()->toDateString();
        $this->toDate = Carbon::tomorrow()->endOfDay()->toDateString();
    }

    /** Set periode mingguan */
    public function showWeekly(): void
    {
        $this->fromDate = Carbon::today()->startOfWeek()->toDateString();
        $this->toDate = Carbon::today()->endOfWeek()->toDateString();
    }

    /** Set periode bulanan */
    public function showMonthly(): void
    {
        $this->fromDate = Carbon::today()->startOfMonth()->toDateString();
        $this->toDate = Carbon::today()->endOfMonth()->toDateString();
    }

    /** Set periode tahunan */
    public function showYearly(): void
    {
        $this->fromDate = Carbon::today()->startOfYear()->toDateString();
        $this->toDate = Carbon::today()->endOfYear()->toDateString();
    }

    /**
     * Mengambil daftar role yang tersedia berdasarkan permission user
     */
    #[Computed]
    public function availableRoles(): array
    {
        $user = Auth::user();
        $roles = [];

        if ($user->can('sales-export-all')) {
            $roles['All'] = 'Semua';
        }

        $permissionMap = [
            'sales-export-medan'      => ['Sales' => 'Sales Medan'],
            'sales-export-jkt'        => ['Sales-JKT' => 'Sales Jakarta'],
            'sales-export-pku'        => ['Sales-PKU' => 'Sales Pekanbaru'],
            'sales-export-idy'        => ['Sales-IDY' => 'Sales Indodaya'],
            'sales-export-kurir-bank' => ['Kurir-Bank' => 'Kurir Bank'],
            'sales-export-agrotec'    => ['Sales-Agrotec' => 'Sales Agrotec'],
        ];

        foreach ($permissionMap as $permission => $mapping) {
            if ($user->can($permission)) {
                $roles = array_merge($roles, $mapping);
            }
        }

        return $roles;
    }

    /**
     * Daftar role murni (hanya nama) untuk query User
     */
    #[Computed]
    protected function allowedRoleNames(): array
    {
        $roles = $this->availableRoles();
        unset($roles['All']);
        return array_keys($roles);
    }

    /**
     * Memproses export data ke file Excel via Background Job
     */
    public function export()
    {
        $this->validate();

        $query = Sales::query()
            ->whereDate('created_at', '>=', $this->fromDate)
            ->whereDate('created_at', '<=', $this->toDate);

        // Filter berdasarkan role jika bukan 'All'
        if ($this->role !== 'All') {
            $query->whereHas('userRelasi.roles', function ($q) {
                $q->where('name', $this->role);
            });
        }

        // Filter berdasarkan spesifik teknisi/sales
        if ($this->sales) {
            $query->where('kode_pegawai', $this->sales);
        }

        if (! $query->exists()) {
            return $this->dispatch('swal', title: 'Gagal', text: 'Data tidak ditemukan untuk periode ini', icon: 'error');
        }

        ExportSalesToExcelJob::dispatch(
            Auth::id(),
            $this->fromDate,
            $this->toDate,
            $this->role,
            $this->sales
        )->delay(now()->addSeconds(2));

        $this->showModal = false;

        return $this->dispatch('swal', 
            title: 'Berhasil', 
            text: 'Permintaan export sedang diproses. Silahkan cek menu export nanti.', 
            icon: 'success'
        );
    }

    public function render()
    {
        $sales = User::select(['id', 'kode_pegawai', 'name', 'is_active'])
            ->whereHas('roles', fn ($query) => $query->whereIn('name', $this->allowedRoleNames()))
            ->orderBy('kode_pegawai', 'asc')
            ->get();

        return view('livewire.handler.sales.export', [
            'salesData' => $sales,
            'roles'     => $this->availableRoles(),
        ]);
    }
}
