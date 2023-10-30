<?php

namespace App\Policies;

use App\Models\Sighting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SightingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_sighting');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sighting $sighting): bool
    {
        return $user->can('view_sighting');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_sighting');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sighting $sighting): bool
    {
        return $user->can('update_sighting');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sighting $sighting): bool
    {
        return $user->can('delete_sighting');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_sighting');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Sighting $sighting): bool
    {
        return $user->can('force_delete_sighting');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_sighting');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Sighting $sighting): bool
    {
        return $user->can('restore_sighting');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_sighting');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Sighting $sighting): bool
    {
        return $user->can('replicate_sighting');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_sighting');
    }
}
