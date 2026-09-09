<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any products.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can view the product.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can create products.
     */
    public function create(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can update the product's master data.
     *
     * This does not authorize direct stock quantity changes.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can manage stock for the product.
     *
     * This is intentionally separate from normal product updates.
     */
    public function adjustStock(User $user, Product $product): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isStockUser());
    }

    /**
     * Determine whether the user can delete the product.
     */
    public function delete(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the product.
     */
    public function restore(User $user, Product $product): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the product.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
