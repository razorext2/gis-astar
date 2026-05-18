<?php

namespace App\Policies;

use App\Models\Spk\SpkMain;
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
    public function view(User $user, SpkMain $spkMain): bool
    {
        return $user->hasPermissionTo('spk-create')
            || ($user->hasPermissionTo('spk-detail') && ($user->id === $spkMain->assign_to || $user->id === $spkMain->reassign_to));
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
    public function update(User $user, SpkMain $spk): bool
    {
        if ($user->hasAnyRole(['Admin', 'Management'])) {
            return $user->hasPermissionTo('spk-edit');
        }

        return $user->hasPermissionTo('spk-edit')
            && $user->id === $spk->added_by;
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
     * Check if user has permission to update information of pengiriman
     */
    public function validatePengiriman(User $user)
    {
        return $user->hasPermissionTo('spk-validate-pengiriman');
    }

    /**
     * Check if user has permission to update kontrak pengiriman
     */
    public function updateKontrakPengiriman(User $user)
    {
        return $user->hasPermissionTo('spk-update-kontrak-pengiriman');
    }

    /**
     * Check if user has permission to validate SPK
     */
    public function validate(User $user)
    {
        return $user->hasPermissionTo('spk-validate');
    }
}
