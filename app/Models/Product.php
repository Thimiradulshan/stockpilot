<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'category_id',
    'name',
    'sku',
    'cost_price',
    'selling_price',
    'reorder_level',
    'description',
    'status',
])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * Get the category for this product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the suppliers associated with this product.
     */
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class)
            ->withPivot([
                'supplier_product_code',
                'last_cost',
                'is_preferred',
            ])
            ->withTimestamps();
    }

    /**
     * Get the purchase items for this product.
     */
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Get the invoice items for this product.
     */
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the stock movements for this product.
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Get the cost price as a decimal value.
     */
    protected function casts(): array
    {
        return [
            'cost_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'quantity' => 'decimal:3',
            'reorder_level' => 'decimal:3',
        ];
    }

    /**
     * Determine whether the product is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Determine whether the product is at or below its reorder level.
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    /**
     * Determine whether the product currently has stock.
     */
    public function hasStock(): bool
    {
        return $this->quantity > 0;
    }
}
