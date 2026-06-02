<?php

/** Goal: Centralize Sales region access resolution, Caller: SalesController, SalesCardService, SalesRouteTable, Deps: Permission */

namespace App\Services\Sales;

use App\Models\User;

class SalesRegionResolver
{
    /**
     * Mapping: permission name → Sales role yang datanya boleh dilihat.
     * Tambah region baru = cukup tambah 1 baris di sini.
     *
     * @var array<string, string>
     */
    private const REGION_MAP = [
        'sales-export-idy' => 'Sales-IDY',
        'sales-export-kurir-bank' => 'Kurir-Bank',
        'sales-export-medan' => 'Sales',
        'sales-export-jkt' => 'Sales-JKT',
        'sales-export-pku' => 'Sales-PKU',
        'sales-export-agrotec' => 'Sales-Agrotec',
    ];

    /**
     * Semua role Sales yang terdaftar di region map.
     *
     * @return list<string>
     */
    public static function allSalesRoles(): array
    {
        return array_values(self::REGION_MAP);
    }

    /**
     * Apakah user punya full access ke semua region Sales.
     */
    public static function hasFullAccess(User $user): bool
    {
        return $user->can('sales-export-all');
    }

    /**
     * Resolve role Sales yang boleh dilihat berdasarkan permission user.
     * Jika user punya full access, return semua roles.
     * Jika tidak, filter berdasarkan permission masing-masing region.
     *
     * @return list<string>
     */
    public static function resolveForUser(User $user): array
    {
        if (self::hasFullAccess($user)) {
            return self::allSalesRoles();
        }

        return collect(self::REGION_MAP)
            ->filter(fn (string $role, string $permission) => $user->can($permission))
            ->values()
            ->toArray();
    }
}
