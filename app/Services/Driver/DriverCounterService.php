<?php

namespace App\Services\Driver;

use App\Models\Driver;

class DriverCounterService
{
    public function countNeedsApproval()
    {
        $user = auth()->user();

        $permissionRoleMap = [
            'driver-list-jkt' => 'Driver-Jkt',
            'driver-list-medan' => 'Driver-Medan',
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
        return Driver::whereHas('user.roles', function ($roles) use ($allowedRoles) {
            $roles->whereIn('name', $allowedRoles);
        })
            ->needApprove()
            ->count();
    }
}
