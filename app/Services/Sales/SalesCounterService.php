<?php

namespace App\Services\Sales;

use App\Models\Sales;

class SalesCounterService
{
    public function countNeedsApproval()
    {
        $user = auth()->user();

        $permissionRoleMap = [
            'sales-export-agrotec' => 'Sales-Agrotec',
            'sales-export-idy' => 'Sales-IDY',
            'sales-export-jkt' => 'Sales-JKT',
            'sales-export-pku' => 'Sales-PKU',
            'sales-export-medan' => 'Sales',
            'sales-export-kurir-bank' => 'Kurir-Bank',
        ];

        // ambil role yang diizinkan user
        $allowedRoles = collect($permissionRoleMap)
            ->filter(fn ($role, $permission) => $user->can($permission))
            ->values()
            ->toArray();

        // kalau tidak ada akses → langsung 0
        if (empty($allowedRoles)) {
            return 0;
        }

        // query
        return Sales::whereHas('userRelasi.roles', function ($roles) use ($allowedRoles) {
            $roles->whereIn('name', $allowedRoles);
        })
            ->needApprove()
            ->count();
    }
}
