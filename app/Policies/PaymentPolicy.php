<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Determine whether the user can view any payments.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSalesUser());
    }

    /**
     * Determine whether the user can view the payment.
     */
    public function view(User $user, Payment $payment): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSalesUser());
    }

    /**
     * Determine whether the user can record a payment for an invoice.
     */
    public function create(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSalesUser());
    }

    /**
     * Determine whether the user can update a payment.
     *
     * Payments are recorded against the payment ledger and must not
     * be edited after creation.
     */
    public function update(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete a payment.
     *
     * Payments must not be physically deleted.
     */
    public function delete(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore a payment.
     */
    public function restore(User $user, Payment $payment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the payment.
     */
    public function forceDelete(User $user, Payment $payment): bool
    {
        return false;
    }
}
