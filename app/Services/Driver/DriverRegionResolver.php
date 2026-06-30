<?php

/** Goal: Centralize Driver region access resolution, Caller: ReportApprovalPopup, DriverTable, Deps: Permission */

namespace App\Services\Driver;

use App\Models\User;

class DriverRegionResolver
{
    /**
     * Mapping: permission name → Driver role yang datanya boleh dilihat.
     *
     * @var array<string, string>
     */
    private const REGION_MAP = [
        'driver-list-jkt'   => 'Driver-Jkt',
        'driver-list-medan' => 'Driver-Medan',
    ];

    /**
     * Return the full region map.
     *
     * @return array<string, string>
     */
    public static function regionMap(): array
    {
        return self::REGION_MAP;
    }

    /**
     * Resolve role Driver yang boleh dilihat berdasarkan permission user.
     *
     * @return list<string>
     */
    public static function resolveForUser(User $user): array
    {
        return collect(self::REGION_MAP)
            ->filter(fn (string $role, string $permission) => $user->can($permission))
            ->values()
            ->toArray();
    }

    /**
     * Human-readable label untuk region permission.
     */
    public static function regionLabel(string $permission): string
    {
        return match ($permission) {
            'driver-list-jkt'   => 'Jakarta',
            'driver-list-medan' => 'Medan',
            default             => 'Unknown',
        };
    }
}
