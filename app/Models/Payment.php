<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'invoice_id',
    'payment_date',
    'amount',
    'payment_method',
    'reference',
    'idempotency_key',
    'notes',
    'received_by',
])]
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    /**
     * Invoice that received this payment.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * User who received this payment.
     */
    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Cast model attributes to appropriate PHP types.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }
}
