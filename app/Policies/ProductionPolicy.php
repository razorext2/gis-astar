<?php

namespace App\Policies;

use App\Models\User;

class ProductionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('produksi-list');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->can('produksi-detail');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('produksi-create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->can('produksi-edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('produksi-delete');
    }

    public function updatePackingList(User $user)
    {
        return $user->can('produksi-update-packing-list');
    }

    public function validate(User $user)
    {
        return $user->can('produksi-validate');
    }
}
