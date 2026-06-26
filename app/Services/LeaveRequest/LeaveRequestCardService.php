<?php

namespace App\Services\LeaveRequest;

/** Goal: Provide card data for various Leave Request views, Caller: App\Livewire\Components\Card, Deps: LeaveRequest, LeaveBalance */

use App\Models\LeaveRequest\LeaveBalance;
use App\Models\LeaveRequest\LeaveRequest;

class LeaveRequestCardService
{
    /**
     * Card data for Employee's own requests dashboard
     */
    public function getMyRequestCards(): array
    {
        $user = auth()->user();
        $balance = $user->currentLeaveBalance();

        return [
            [
                'label' => 'Sisa Cuti Tahunan',
                'count' => $balance ? ($balance->total_quota - $balance->used_quota) : 0,
                'indicator' => 'Hari',
                'icon' => 'icons.calendar',
                'color' => 'blue',
                'permission' => 'all',
            ],
            [
                'label' => 'Menunggu Approval',
                'count' => $user->leaveRequests()->whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])->count(),
                'indicator' => 'Pengajuan',
                'icon' => 'icons.clock',
                'color' => 'yellow',
                'permission' => 'all',
            ],
            [
                'label' => 'Cuti Terpakai (YTD)',
                'count' => $user->leaveRequests()->where('status', 'approved')->whereYear('start_date', date('Y'))->sum('total_days'),
                'indicator' => 'Hari',
                'icon' => 'icons.badge-check',
                'color' => 'green',
                'permission' => 'all',
            ],
        ];
    }

    /**
     * Card data for Approval Center
     */
    public function getApprovalCenterCards(): array
    {
        $user = auth()->user();
        $hasPegawai = $user->pegawai !== null;

        $baseQuery = fn () => $hasPegawai
            ? LeaveRequest::where(function ($q) use ($user) {
                $this->scopeByApproverRole($q, $user);
                $q->orWhere('user_id', $user->id);
            })
            : LeaveRequest::query();

        return [
            [
                'label' => 'Total Masuk',
                'count' => $baseQuery()->whereYear('created_at', date('Y'))->count(),
                'indicator' => 'Pengajuan',
                'icon' => 'icons.envelope',
                'color' => 'blue',
                'permission' => 'all',
            ],
            [
                'label' => 'Butuh Review',
                'count' => $hasPegawai
                    ? LeaveRequest::whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])
                        ->where(fn ($q) => $this->scopeByApproverRole($q, $user))
                        ->count()
                    : LeaveRequest::whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])->count(),
                'indicator' => 'Pengajuan',
                'icon' => 'icons.clock',
                'color' => 'yellow',
                'permission' => 'all',
            ],
            [
                'label' => 'Selesai Diproses',
                'count' => $baseQuery()->whereIn('status', ['approved', 'rejected'])->whereYear('created_at', date('Y'))->count(),
                'indicator' => 'Pengajuan',
                'icon' => 'icons.badge-check',
                'color' => 'green',
                'permission' => 'all',
            ],
        ];
    }

    /**
     * Scope query to only include requests where the user is the designated approver.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\User  $user
     */
    private function scopeByApproverRole($query, $user): void
    {
        $query->where(function ($q) use ($user) {
            $q->where(function ($sq) use ($user) {
                $sq->where('status', 'pending_backup')->where('backup_person_id', $user->id);
            });

            $q->orWhere(function ($sq) use ($user) {
                $sq->where('status', 'pending_spv')
                    ->whereHas('user.pegawai.jabatanRelasi.supervisors', fn ($jq) => $jq->where('users.id', $user->id));
            });

            $q->orWhere(function ($sq) use ($user) {
                $sq->where('status', 'pending_hrd')
                    ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.hrds', fn ($jq) => $jq->where('users.id', $user->id));
            });

            $q->orWhere(function ($sq) use ($user) {
                $sq->where('status', 'pending_management')
                    ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.managements', fn ($jq) => $jq->where('users.id', $user->id));
            });
        });
    }

    /**
     * Card data for HRD Manage Balances
     */
    public function getManageBalanceCards(): array
    {
        $year = date('Y');

        $stats = LeaveBalance::where('year', $year)
            ->selectRaw('SUM(total_quota) as total_quota, SUM(used_quota) as used_quota')
            ->first();

        $totalQuota = $stats->total_quota ?? 0;
        $usedQuota = $stats->used_quota ?? 0;

        return [
            [
                'label' => 'Kuota Terdistribusi',
                'count' => $totalQuota,
                'indicator' => 'Hari',
                'icon' => 'icons.users',
                'color' => 'blue',
                'permission' => 'all',
            ],
            [
                'label' => 'Total Cuti Terpakai',
                'count' => $usedQuota,
                'indicator' => 'Hari',
                'icon' => 'icons.clock',
                'color' => 'red',
                'permission' => 'all',
            ],
            [
                'label' => 'Sisa Kuota Aktif',
                'count' => $totalQuota - $usedQuota,
                'indicator' => 'Hari',
                'icon' => 'icons.calendar',
                'color' => 'green',
                'permission' => 'all',
            ],
        ];
    }
}
