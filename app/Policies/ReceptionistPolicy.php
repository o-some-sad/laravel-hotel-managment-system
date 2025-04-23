<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceptionistPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('manager');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('manager');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $receptionist): bool
    {
        return $user->id === $receptionist->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $receptionist): bool
    {
        return $user->id === $receptionist->created_by;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function toggleBan(User $user, User $receptionist)
    {
        return $user->id === $receptionist->created_by;
    }
}
