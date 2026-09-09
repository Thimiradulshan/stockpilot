<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the user list.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive() && $user->isAdmin();
    }

    /**
     * Determine whether the user can view a specific user.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isActive() && $user->isAdmin();
    }

    /**
     * Determine whether the user can create users.
     */
    public function create(User $user): bool
    {
        return $user->isActive() && $user->isAdmin();
    }

    /**
     * Determine whether the user can update a user.
     *
     * Role/status changes must only be performed by an
     * authorized administrative workflow.
     */
    public function update(User $user, User $model): bool
    {
        if (! $user->isActive() || ! $user->isAdmin()) {
            return false;
        }

        /*
         * Do not allow an administrator to deactivate their
         * own account through the normal user-management flow.
         */
        return $user->isNot($model);
    }

    /**
     * Determine whether the user can delete a user.
     *
     * StockPilot uses account deactivation instead of
     * destructive deletion for user management.
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore a user.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete a user.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
