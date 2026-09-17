<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInvoiceRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use LogicException;

class InvoiceController extends Controller
{
    /**
     * Store a completed sale invoice.
     */
    public function store(
        StoreInvoiceRequest $request,
        InvoiceService $invoiceService,
    ): RedirectResponse {
        $this->authorize('create', Invoice::class);

        $data = $request->validated();

        $customer = Customer::query()
            ->whereKey($data['customer_id'])
            ->firstOrFail();

        try {
            $invoiceService->create(
                customer: $customer,
                invoiceNumber: $data['invoice_number'],
                invoiceDate: $data['invoice_date'],
                items: $data['items'],
                discountAmount: $data['discount_amount'],
                taxRate: $data['tax_rate'],
                actor: $request->user(),
                notes: $data['notes'] ?? null,
            );
        } catch (LogicException $e) {
            Log::warning('Invoice creation rejected', [
                'invoice_number' => $data['invoice_number'] ?? null,
                'user_id' => $request->user()?->getKey(),
                'message' => $e->getMessage(),
            ]);

            return back()
                ->with('error', $e->getMessage());
        }

        return to_route('admin.sales.index')
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Void a completed, unpaid invoice and restore its stock.
     */
    public function void(
        Invoice $invoice,
        InvoiceService $invoiceService,
    ): RedirectResponse {
        $this->authorize('void', $invoice);

        try {
            $invoiceService->void(
                invoice: $invoice,
                actor: request()->user(),
            );
        } catch (LogicException $e) {
            Log::warning('Invoice void rejected', [
                'invoice_id' => $invoice->getKey(),
                'user_id' => request()->user()?->getKey(),
                'message' => $e->getMessage(),
            ]);

            return back()
                ->with('error', $e->getMessage());
        }

        return to_route('admin.sales.index')
            ->with('success', 'Invoice voided successfully.');
    }

    /**
     * Render the printable receipt for an invoice.
     */
    public function print(Invoice $invoice): View
    {
        $this->authorize('view', $invoice);

        $invoice->load([
            'items.product:id,name,sku',
            'customer:id,name,phone,email,address',
            'payments',
            'createdBy:id,name',
        ]);

        $paidTotal = round(
            (float) $invoice->payments->sum('amount'),
            2,
        );

        return view('admin.invoices.print', [
            'invoice' => $invoice,
            'paidTotal' => $paidTotal,
        ]);
    }
}
