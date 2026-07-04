<?php

/** Goal: Authorize SPK actions based on roles and permissions, Caller: SpkController, Deps: SpkMain */

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
        return $user->hasPermissionTo('spk-list')
            || $user->hasPermissionTo('spk-list-own-only');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SpkMain $spkMain): bool
    {
        return $user->hasPermissionTo('spk-create')
            || $user->hasPermissionTo('spk-list')
            || ($user->hasPermissionTo('spk-list-own-only') && ($user->id === $spkMain->added_by || $user->id === $spkMain->assign_to || $user->id === $spkMain->reassign_to))
            || ($user->hasPermissionTo('spk-view') && ($user->id === $spkMain->assign_to || $user->id === $spkMain->reassign_to));
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
        if ($user->can('spk-edit-all')) {
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

    public function billingIndex(User $user): bool
    {
        return $user->hasPermissionTo('spk-billing-list');
    }

    public function billingUpdate(User $user): bool
    {
        return $user->hasPermissionTo('spk-billing-edit');
    }

    /**
     * Check if user has permission to update no tagihan IDC PPN
     */
    public function updateNoTagihanIdcPpn(User $user): bool
    {
        return $user->hasPermissionTo('spk-no-tagihan-idcppn-edit');
    }

    /**
     * Check if user has permission to update no tagihan IDC Non PPN
     */
    public function updateNoTagihanIdcNonPpn(User $user): bool
    {
        return $user->hasPermissionTo('spk-no-tagihan-idcnonppn-edit');
    }

    /**
     * Check if user has permission to unassign no tagihan from SPK
     */
    public function unassignNoTagihan(User $user): bool
    {
        return $user->hasPermissionTo('spk-no-tagihan-unassign');
    }

    /**
     * Check if user has permission to update information of pengiriman
     */
    public function updateInformasiPengiriman(User $user): bool
    {
        return $user->hasPermissionTo('spk-informasi-pengiriman-edit');
    }

    /**
     * Check if user has permission to update information of pengiriman
     */
    public function validatePengiriman(User $user): bool
    {
        return $user->hasPermissionTo('spk-pengiriman-approve');
    }

    /**
     * Check if user has permission to update kontrak pengiriman
     */
    public function updateKontrakPengiriman(User $user): bool
    {
        return $user->hasPermissionTo('spk-no-kontrak-pengiriman-edit');
    }

    /**
     * Check if user has permission to validate SPK
     */
    public function validate(User $user): bool
    {
        return $user->hasPermissionTo('spk-approve');
    }
}
