<?php

namespace App\Models;

use Database\Factories\PurchaseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'purchase_number',
    'supplier_id',
    'purchase_date',
    'subtotal',
    'discount_amount',
    'tax_amount',
    'total_amount',
    'status',
    'notes',
    'created_by',
])]
class Purchase extends Model
{
    /** @use HasFactory<PurchaseFactory> */
    use HasFactory;

    /**
     * Supplier associated with the purchase.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * User who created the purchase.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Items belonging to the purchase.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Cast model attributes to appropriate PHP types.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }
}
