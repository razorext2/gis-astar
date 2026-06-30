<?php

/** Goal: Popup notifikasi approval laporan di dashboard, Caller: dashboard.blade.php / dashboard-user.blade.php, Deps: Sales, Driver, Technician, Collector, SpkMain */

namespace App\Livewire\Dashboard;

use App\Models\Collector;
use App\Models\Driver;
use App\Models\Sales;
use App\Models\Spk\SpkMain;
use App\Models\Technician;
use App\Services\Driver\DriverRegionResolver;
use App\Services\Sales\SalesRegionResolver;
use Livewire\Component;
use Livewire\Attributes\On;

class ReportApprovalPopup extends Component
{
    public string $type;

    public string $regionPermission = '';

    public bool $forceShowReports = false;

    public int $stackIndex;

    public bool $showPopup = false;

    public bool $hasPending = false;

    public int $pendingCount = 0;

    public string $regionLabel = '';

    public function mount(string $type, string $regionPermission = '', int $stackIndex = 0): void
    {
        $this->type = $type;
        $this->regionPermission = $regionPermission;
        $this->stackIndex = $stackIndex;
        $this->regionLabel = $this->resolveRegionLabel();

        $this->pendingCount = $this->countPending();
        $this->hasPending = $this->pendingCount > 0;
    }

    public function dismiss(): void
    {
        $this->showPopup = false;
    }

    /**
     * @return array{title: string, icon: string, color: string, route: string}
     */
    public function getConfigProperty(): array
    {
        return match ($this->type) {
            'sales' => [
                'title' => 'Laporan Sales',
                'icon'  => 'shopping-bag',
                'color' => 'blue',
                'route' => route('sales.index'),
            ],
            'driver' => [
                'title' => 'Laporan Driver',
                'icon'  => 'truck',
                'color' => 'emerald',
                'route' => route('driver.index'),
            ],
            'technician' => [
                'title' => 'Laporan Teknisi',
                'icon'  => 'hammer',
                'color' => 'purple',
                'route' => route('technician.index'),
            ],
            'collector' => [
                'title' => 'Laporan Kolektor',
                'icon'  => 'cash-register',
                'color' => 'amber',
                'route' => route('collect.submitted'),
            ],
            'spk' => [
                'title' => 'SPK',
                'icon'  => 'clipboard-list',
                'color' => 'red',
                'route' => route('spk.index'),
            ],
            'production' => [
                'title' => 'Produksi',
                'icon'  => 'briefcase',
                'color' => 'cyan',
                'route' => route('production.index'),
            ],
            default => [
                'title' => 'Laporan',
                'icon'  => 'clipboard',
                'color' => 'zinc',
                'route' => '#',
            ],
        };
    }

    public function render(): \Illuminate\View\View
    {
        $this->pendingCount = $this->countPending();
        $this->hasPending = $this->pendingCount > 0;

        return view('livewire.dashboard.report-approval-popup');
    }

    private function countPending(): int
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return 0;
        }

        // Prioritize unread announcements
        if (\App\Models\Announcement::hasUnreadForUser($user)) {
            return 0;
        }

        // Prioritize pending leave approvals unless forced
        if (!$this->forceShowReports && \App\Livewire\Dashboard\LeaveApprovalPopup::hasPendingForUser($user)) {
            return 0;
        }

        return match ($this->type) {
            'sales'      => $this->countSalesPending(),
            'driver'     => $this->countDriverPending(),
            'technician' => $this->countTechnicianPending(),
            'collector'  => $this->countCollectorPending(),
            'spk'        => $this->countSpkPending(),
            'production' => $this->countProductionPending(),
            default      => 0,
        };
    }

    #[On('announcement-closed')]
    public function handleAnnouncementClosed(): void
    {
        $this->pendingCount = $this->countPending();
        $this->hasPending = $this->pendingCount > 0;
        if ($this->hasPending) {
            $this->showPopup = true;
        }
    }

    #[On('leave-closed')]
    public function handleLeaveClosed(): void
    {
        $this->forceShowReports = true;
        $this->pendingCount = $this->countPending();
        $this->hasPending = $this->pendingCount > 0;
        if ($this->hasPending) {
            $this->showPopup = true;
        }
    }

    private function countSalesPending(): int
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return 0;
        }
        $allowedRoles = SalesRegionResolver::resolveForUser($user);

        if (empty($allowedRoles)) {
            return 0;
        }

        return Sales::needApprove()
            ->whereHas('userRelasi.roles', fn ($q) => $q->whereIn('name', $allowedRoles))
            ->count();
    }

    private function countDriverPending(): int
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return 0;
        }
        $allowedRoles = DriverRegionResolver::resolveForUser($user);

        if (empty($allowedRoles)) {
            return 0;
        }

        return Driver::needApprove()
            ->whereNotNull('kode_pegawai')
            ->whereHas('user.roles', fn ($q) => $q->whereIn('name', $allowedRoles))
            ->count();
    }

    private function countTechnicianPending(): int
    {
        return Technician::needApprove()->count();
    }

    private function countCollectorPending(): int
    {
        return Collector::needApprove()->count();
    }

    private function countSpkPending(): int
    {
        return SpkMain::query()
            ->where('status_approval', 0)
            ->where('is_cancelled', false)
            ->count();
    }

    private function countProductionPending(): int
    {
        return SpkMain::query()
            ->where('status_approval', 1)
            ->whereIn('status', [1, 2])
            ->where('is_cancelled', false)
            ->count();
    }

    private function resolveRegionLabel(): string
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return '';
        }

        if ($this->type === 'sales') {
            if ($user->can('sales-export-all')) {
                return 'Semua Wilayah';
            }
            $labels = [];
            $salesRegionMap = SalesRegionResolver::regionMap();
            foreach ($salesRegionMap as $permission => $role) {
                if ($user->can($permission)) {
                    $labels[] = SalesRegionResolver::regionLabel($permission);
                }
            }
            return implode(', ', $labels);
        }

        if ($this->type === 'driver') {
            $labels = [];
            $driverRegionMap = DriverRegionResolver::regionMap();
            foreach ($driverRegionMap as $permission => $role) {
                if ($user->can($permission)) {
                    $labels[] = DriverRegionResolver::regionLabel($permission);
                }
            }
            return implode(', ', $labels);
        }

        return '';
    }
}
