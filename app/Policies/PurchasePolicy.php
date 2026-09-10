<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;

class PurchasePolicy
{
    /**
     * Determine whether the user can view any purchases.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can view the purchase.
     */
    public function view(User $user, Purchase $purchase): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can create purchases.
     */
    public function create(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can cancel a purchase.
     */
    public function cancel(User $user, Purchase $purchase): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can update a purchase.
     *
     * Purchases are financial/inventory transactions and are not
     * directly editable after creation.
     */
    public function update(User $user, Purchase $purchase): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete a purchase.
     *
     * Purchases must not be physically deleted.
     */
    public function delete(User $user, Purchase $purchase): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore a purchase.
     */
    public function restore(User $user, Purchase $purchase): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the purchase.
     */
    public function forceDelete(User $user, Purchase $purchase): bool
    {
        return false;
    }
}
