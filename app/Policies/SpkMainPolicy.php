<?php

namespace App\Policies;

use App\Models\User;

class SpkMainPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('spk-list');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('spk-detail');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('spk-create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('spk-edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('spk-delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->hasPermissionTo('spk-restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasPermissionTo('spk-force-delete');
    }

    public function billingIndex(User $user)
    {
        return $user->hasPermissionTo('spk-billing-index');
    }

    public function billingUpdate(User $user)
    {
        return $user->hasPermissionTo('spk-billing-update');
    }

    /**
     * Check if user has permission to update no tagihan IDC PPN
     */
    public function updateNoTagihanIdcPpn(User $user)
    {
        return $user->hasPermissionTo('spk-update-no-tagihan-idcppn');
    }

    /**
     * Check if user has permission to update no tagihan IDC Non PPN
     */
    public function updateNoTagihanIdcNonPpn(User $user)
    {
        return $user->hasPermissionTo('spk-update-no-tagihan-idcnonppn');
    }

    /**
     * Check if user has permission to update information of pengiriman
     */
    public function updateInformasiPengiriman(User $user)
    {
        return $user->hasPermissionTo('spk-update-informasi-pengiriman');
    }

    /**
     * Check if user has permission to update kontrak pengiriman
     */
    public function updateKontrakPengiriman(User $user)
    {
        return $user->hasPermissionTo('spk-update-kontrak-pengiriman');
    }
}
