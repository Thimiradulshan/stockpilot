<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    /**
     * Determine whether the user can view any invoices.
     */
    public function viewAny(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSalesUser());
    }

    /**
     * Determine whether the user can view the invoice.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSalesUser());
    }

    /**
     * Determine whether the user can create invoices.
     */
    public function create(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSalesUser());
    }

    /**
     * Determine whether the user can void an invoice.
     *
     * Voiding is only a valid transition from a completed and
     * unpaid invoice to a voided invoice.
     */
    public function void(User $user, Invoice $invoice): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSalesUser())
            && $invoice->status === 'completed'
            && $invoice->payment_status === 'unpaid';
    }

    /**
     * Determine whether the user can record a payment against the invoice.
     */
    public function pay(User $user, Invoice $invoice): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSalesUser())
            && $invoice->status === 'completed';
    }

    /**
     * Determine whether the user can update an invoice.
     *
     * Invoices are financial/inventory transactions and are not
     * directly editable after creation.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete an invoice.
     *
     * Invoices must not be physically deleted.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore an invoice.
     */
    public function restore(User $user, Invoice $invoice): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the invoice.
     */
    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return false;
    }
}
