<?php

/** Goal: Popup notifikasi approval laporan di dashboard, Caller: dashboard.blade.php / dashboard-user.blade.php, Deps: Sales, Driver, Technician, Collector, SpkMain, Production, AttendanceInquiry */

namespace App\Livewire\Dashboard;

use App\Models\Announcement;
use App\Models\AttendanceInquiry\AttendanceInquiry;
use App\Models\Collector;
use App\Models\Driver;
use App\Models\Sales;
use App\Models\Spk\Production;
use App\Models\Spk\SpkMain;
use App\Models\Technician;
use App\Models\User;
use App\Services\Driver\DriverRegionResolver;
use App\Services\Sales\SalesRegionResolver;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

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

    public ?string $message = null;

    public function mount(string $type, string $regionPermission = '', int $stackIndex = 0, ?string $message = null): void
    {
        $this->type = $type;
        $this->regionPermission = $regionPermission;
        $this->stackIndex = $stackIndex;
        $this->message = $message;
        $this->regionLabel = $this->resolveRegionLabel();

        $this->pendingCount = $this->countPending();
        $this->hasPending = $this->pendingCount > 0;
    }

    public function dismiss(): void
    {
        $this->showPopup = false;
    }

    /**
     * Get computed configuration property.
     *
     * @return array{title: string, icon: string, color: string, route: string}
     */
    #[Computed]
    public function config(): array
    {
        return match ($this->type) {
            'sales' => [
                'title' => 'Laporan Sales',
                'icon' => 'shopping-bag',
                'color' => 'blue',
                'route' => route('sales.index'),
            ],
            'driver' => [
                'title' => 'Laporan Driver',
                'icon' => 'truck',
                'color' => 'emerald',
                'route' => route('driver.index'),
            ],
            'technician' => [
                'title' => 'Laporan Teknisi',
                'icon' => 'hammer',
                'color' => 'purple',
                'route' => route('technician.index'),
            ],
            'collector' => [
                'title' => 'Laporan Kolektor',
                'icon' => 'cash-register',
                'color' => 'amber',
                'route' => route('collect.submitted'),
            ],
            'spk' => [
                'title' => 'SPK',
                'icon' => 'clipboard-list',
                'color' => 'red',
                'route' => route('spk.index'),
            ],
            'production' => [
                'title' => 'Produksi',
                'icon' => 'briefcase',
                'color' => 'cyan',
                'route' => route('production.index'),
            ],
            'production-assigned' => [
                'title' => 'Tugas Produksi',
                'icon' => 'clipboard-check',
                'color' => 'indigo',
                'route' => route('production.index'),
            ],
            'attendance-inquiry' => [
                'title' => 'Inquiry Absensi',
                'icon' => 'fingerprint',
                'color' => 'teal',
                'route' => route('attendance-inquiry.approval-center.index'),
            ],
            default => [
                'title' => 'Laporan',
                'icon' => 'clipboard',
                'color' => 'zinc',
                'route' => '#',
            ],
        };
    }

    public function render(): View
    {
        $this->pendingCount = $this->countPending();
        $this->hasPending = $this->pendingCount > 0;

        return view('livewire.dashboard.report-approval-popup');
    }

    /**
     * Count pending items based on component type and priorities.
     */
    private function countPending(): int
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            return 0;
        }

        // Prioritize unread announcements
        if (Announcement::hasUnreadForUser($user)) {
            return 0;
        }

        // Prioritize pending leave approvals unless forced or showing
        if (! $this->forceShowReports && ! $this->showPopup && LeaveApprovalPopup::hasPendingForUser($user)) {
            return 0;
        }

        return match ($this->type) {
            'sales' => $this->countSalesPending($user),
            'driver' => $this->countDriverPending($user),
            'technician' => $this->countTechnicianPending(),
            'collector' => $this->countCollectorPending(),
            'spk' => $this->countSpkPending(),
            'production' => $this->countProductionPending(),
            'production-assigned' => $this->countProductionAssignedPending($user),
            'attendance-inquiry' => $this->countAttendanceInquiryPending($user),
            default => 0,
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
    #[On('leave-popup-minimized')]
    public function handleLeaveClosed(): void
    {
        $this->forceShowReports = true;
        $this->pendingCount = $this->countPending();
        $this->hasPending = $this->pendingCount > 0;
        if ($this->hasPending) {
            $this->showPopup = true;
        }
    }

    /**
     * Count sales reports pending approval.
     */
    private function countSalesPending(User $user): int
    {
        $allowedRoles = SalesRegionResolver::resolveForUser($user);
        if (empty($allowedRoles)) {
            return 0;
        }

        return Sales::needApprove()
            ->whereHas('userRelasi.roles', fn ($q) => $q->whereIn('name', $allowedRoles))
            ->count();
    }

    /**
     * Count driver reports pending approval.
     */
    private function countDriverPending(User $user): int
    {
        $allowedRoles = DriverRegionResolver::resolveForUser($user);
        if (empty($allowedRoles)) {
            return 0;
        }

        return Driver::needApprove()
            ->whereNotNull('kode_pegawai')
            ->whereHas('user.roles', fn ($q) => $q->whereIn('name', $allowedRoles))
            ->count();
    }

    /**
     * Count technician reports pending approval.
     */
    private function countTechnicianPending(): int
    {
        return Technician::needApprove()->count();
    }

    /**
     * Count collector reports pending approval.
     */
    private function countCollectorPending(): int
    {
        return Collector::needApprove()->count();
    }

    /**
     * Count pending SPKs.
     */
    private function countSpkPending(): int
    {
        return SpkMain::query()
            ->where('status_approval', 0)
            ->where('is_cancelled', false)
            ->count();
    }

    /**
     * Count SPKs in production status.
     */
    private function countProductionPending(): int
    {
        return SpkMain::query()
            ->where('status_approval', 1)
            ->whereIn('status', [1, 2])
            ->where('is_cancelled', false)
            ->count();
    }

    /**
     * Count active production jobs assigned to the given user.
     */
    private function countProductionAssignedPending(User $user): int
    {
        return Production::where(function ($q) use ($user) {
            $q->where('assign_to', $user->id)
                ->orWhere('reassign_to', $user->id);
        })
            ->whereHas('spk', function ($q) {
                $q->where('status_approval', 1)
                    ->where('on_delay', 0)
                    ->where('is_booked', 0)
                    ->where('is_cancelled', false)
                    ->where('status', '>=', 2);
            })
            ->whereHas('productionHistories', function ($q) {
                $q->where('status_produksi', '>', 0);
            })
            ->whereDoesntHave('productionHistories', function ($q) use ($user) {
                $q->where('added_by', $user->id);
            })
            ->count();
    }

    /**
     * Count pending attendance inquiries where the user is HRD for the employee's placement.
     */
    private function countAttendanceInquiryPending(User $user): int
    {
        return AttendanceInquiry::where('status', 'pending')
            ->whereHas(
                'user.pegawai.jabatanRelasi.placementRelasi.hrds',
                fn ($q) => $q->where('users.id', $user->id)
            )
            ->count();
    }

    /**
     * Resolve region label for authorized regions.
     */
    private function resolveRegionLabel(): string
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            return '';
        }

        if ($this->type === 'sales') {
            if ($user->can('sales-export-all')) {
                return 'Semua Wilayah';
            }

            return collect(SalesRegionResolver::regionMap())
                ->keys()
                ->filter(fn ($permission) => $user->can($permission))
                ->map(fn ($permission) => SalesRegionResolver::regionLabel($permission))
                ->implode(', ');
        }

        if ($this->type === 'driver') {
            return collect(DriverRegionResolver::regionMap())
                ->keys()
                ->filter(fn ($permission) => $user->can($permission))
                ->map(fn ($permission) => DriverRegionResolver::regionLabel($permission))
                ->implode(', ');
        }

        return '';
    }
}
