<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePurchaseRequest;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Services\PurchaseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PurchaseController extends Controller
{
    /**
     * Display the purchase management area.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', Purchase::class);

        return response('purchase-management');
    }

    /**
     * Store a completed purchase.
     */
    public function store(
        StorePurchaseRequest $request,
        PurchaseService $purchaseService,
    ): RedirectResponse {
        $this->authorize('create', Purchase::class);

        $data = $request->validated();

        $supplier = Supplier::query()->findOrFail(
            $data['supplier_id']
        );

        $purchaseService->create(
            supplier: $supplier,
            purchaseNumber: $data['purchase_number'],
            purchaseDate: $data['purchase_date'],
            items: $data['items'],
            discountAmount: $data['discount_amount'],
            taxAmount: $data['tax_amount'],
            actor: $request->user(),
        );

        return to_route('admin.purchases.index');
    }

    /**
     * Cancel a completed purchase and reverse its stock.
     */
    public function cancel(
        Purchase $purchase,
        PurchaseService $purchaseService,
    ): RedirectResponse {
        $this->authorize('cancel', $purchase);

        $purchaseService->cancel(
            purchase: $purchase,
            actor: request()->user(),
        );

        return to_route('admin.purchases.index');
    }
}
