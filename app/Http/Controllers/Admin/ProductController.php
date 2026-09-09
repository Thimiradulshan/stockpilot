<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StockMovementType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StockAdjustmentRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use App\Services\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display the product management area.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Product::class);

        return response('product-management');
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $data = $request->validated();

        Product::query()->create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'sku' => $data['sku'],
            'cost_price' => $data['cost_price'],
            'selling_price' => $data['selling_price'],
            'reorder_level' => $data['reorder_level'],
            'description' => $data['description'] ?? null,
        ]);

        return to_route('admin.products.index');
    }

    /**
     * Update an existing product's master data.
     */
    public function update(
        UpdateProductRequest $request,
        Product $product,
    ): RedirectResponse {
        $this->authorize('update', $product);

        $data = $request->validated();

        $product->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'sku' => $data['sku'],
            'cost_price' => $data['cost_price'],
            'selling_price' => $data['selling_price'],
            'reorder_level' => $data['reorder_level'],
            'description' => $data['description'] ?? null,
        ]);

        return to_route('admin.products.index');
    }

    /**
     * Apply a manual stock adjustment.
     */
    public function adjustStock(
        StockAdjustmentRequest $request,
        Product $product,
        StockService $stockService,
    ): RedirectResponse {
        $this->authorize('adjustStock', $product);

        $data = $request->validated();

        $stockService->adjust(
            product: $product,
            signedQuantity: $data['signed_quantity'],
            actor: $request->user(),
            movementType: StockMovementType::ADJUSTMENT,
            reason: $data['reason'],
            notes: $data['notes'] ?? null,
        );

        return to_route('admin.products.index');
    }
}
