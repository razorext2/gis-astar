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
        return [
            [
                'label' => 'Total Masuk',
                'count' => LeaveRequest::whereYear('created_at', date('Y'))->count(),
                'indicator' => 'Pengajuan',
                'icon' => 'icons.envelope',
                'color' => 'blue',
                'permission' => 'all',
            ],
            [
                'label' => 'Butuh Review',
                'count' => LeaveRequest::whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])->count(),
                'indicator' => 'Pengajuan',
                'icon' => 'icons.clock',
                'color' => 'yellow',
                'permission' => 'all',
            ],
            [
                'label' => 'Selesai Diproses',
                'count' => LeaveRequest::whereIn('status', ['approved', 'rejected'])->whereYear('created_at', date('Y'))->count(),
                'indicator' => 'Pengajuan',
                'icon' => 'icons.badge-check',
                'color' => 'green',
                'permission' => 'all',
            ],
        ];
    }

    /**
     * Card data for HRD Manage Balances
     */
    public function getManageBalanceCards(): array
    {
        $year = date('Y');

        return [
            [
                'label' => 'Kuota Terdistribusi',
                'count' => LeaveBalance::where('year', $year)->sum('total_quota'),
                'indicator' => 'Hari',
                'icon' => 'icons.users',
                'color' => 'blue',
                'permission' => 'all',
            ],
            [
                'label' => 'Total Cuti Terpakai',
                'count' => LeaveBalance::where('year', $year)->sum('used_quota'),
                'indicator' => 'Hari',
                'icon' => 'icons.clock',
                'color' => 'red',
                'permission' => 'all',
            ],
            [
                'label' => 'Sisa Kuota Aktif',
                'count' => LeaveBalance::where('year', $year)->sum('total_quota') - LeaveBalance::where('year', $year)->sum('used_quota'),
                'indicator' => 'Hari',
                'icon' => 'icons.calendar',
                'color' => 'green',
                'permission' => 'all',
            ],
        ];
    }
}
