<div
    x-cloak
    x-show="createOpen"
    x-transition.opacity
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="create-purchase-title"
    role="dialog"
    aria-modal="true"
>
    <div
        class="flex min-h-full items-end justify-center bg-slate-950/50 px-4 py-6 sm:items-center sm:p-6"
        x-on:click.self="closeCreate()"
    >
        <div
            x-show="createOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="translate-y-3 opacity-0 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave-end="translate-y-3 opacity-0 sm:translate-y-0 sm:scale-95"
            class="w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="flex items-start justify-between gap-4 border-b border-sp-border px-5 py-4 sm:px-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-sp-primary">
                        <x-stockpilot.icon
                            name="shopping-cart"
                            class="h-4 w-4"
                        />
                        <span>Purchasing</span>
                    </div>

                    <h2
                        id="create-purchase-title"
                        class="mt-1 text-xl font-bold tracking-tight text-sp-text"
                    >
                        New purchase
                    </h2>

                    <p class="mt-1 text-sm text-sp-muted">
                        Record supplier stock received and update inventory atomically.
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-lg p-2 text-sp-muted transition hover:bg-sp-surface hover:text-sp-text focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                    x-on:click="closeCreate()"
                    aria-label="Close create purchase dialog"
                >
                    <x-stockpilot.icon
                        name="x"
                        class="h-5 w-5"
                    />
                </button>
            </div>

            <form
                method="POST"
                action="{{ route('admin.purchases.store') }}"
                class="max-h-[calc(100vh-9rem)] overflow-y-auto"
            >
                @csrf

                <div class="space-y-6 p-5 sm:p-6">
                    <section>
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-sp-text">
                                Purchase details
                            </h3>

                            <p class="mt-1 text-xs text-sp-muted">
                                Enter the supplier and purchase header information.
                            </p>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <div class="lg:col-span-2">
                                <label
                                    for="purchase_number"
                                    class="mb-1.5 block text-sm font-medium text-sp-text"
                                >
                                    Purchase number
                                    <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="purchase_number"
                                    name="purchase_number"
                                    type="text"
                                    required
                                    maxlength="50"
                                    x-model="createForm.purchase_number"
                                    placeholder="e.g. PO-2026-0001"
                                    class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm text-sp-text outline-none transition placeholder:text-slate-400 focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                />
                            </div>

                            <div class="lg:col-span-2">
                                <label
                                    for="supplier_id"
                                    class="mb-1.5 block text-sm font-medium text-sp-text"
                                >
                                    Supplier
                                    <span class="text-rose-500">*</span>
                                </label>

                                <select
                                    id="supplier_id"
                                    name="supplier_id"
                                    required
                                    x-model="createForm.supplier_id"
                                    class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm text-sp-text outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                >
                                    <option value="">Select supplier</option>

                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name }}
                                            @if ($supplier->company)
                                                — {{ $supplier->company }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label
                                    for="purchase_date"
                                    class="mb-1.5 block text-sm font-medium text-sp-text"
                                >
                                    Purchase date
                                    <span class="text-rose-500">*</span>
                                </label>

                                <input
                                    id="purchase_date"
                                    name="purchase_date"
                                    type="date"
                                    required
                                    value="{{ now()->toDateString() }}"
                                    x-model="createForm.purchase_date"
                                    class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm text-sp-text outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                />
                            </div>

                            <div>
                                <label
                                    for="discount_amount"
                                    class="mb-1.5 block text-sm font-medium text-sp-text"
                                >
                                    Header discount
                                </label>

                                <input
                                    id="discount_amount"
                                    name="discount_amount"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    value="0.00"
                                    x-model="createForm.discount_amount"
                                    class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm tabular-nums text-sp-text outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                />
                            </div>

                            <div>
                                <label
                                    for="tax_amount"
                                    class="mb-1.5 block text-sm font-medium text-sp-text"
                                >
                                    Header tax
                                </label>

                                <input
                                    id="tax_amount"
                                    name="tax_amount"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    value="0.00"
                                    x-model="createForm.tax_amount"
                                    class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm tabular-nums text-sp-text outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                />
                            </div>

                            <div class="lg:col-span-2">
                                <label
                                    for="notes"
                                    class="mb-1.5 block text-sm font-medium text-sp-text"
                                >
                                    Notes
                                </label>

                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="2"
                                    maxlength="5000"
                                    x-model="createForm.notes"
                                    placeholder="Optional internal notes"
                                    class="block w-full resize-y rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm text-sp-text outline-none transition placeholder:text-slate-400 focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                ></textarea>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <h3 class="text-sm font-semibold text-sp-text">
                                    Purchase items
                                </h3>

                                <p class="mt-1 text-xs text-sp-muted">
                                    Add each product and the quantity received.
                                </p>
                            </div>

                            <button
                                type="button"
                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-sp-primary/30 bg-sp-info px-3 py-2 text-xs font-semibold text-sp-primary transition hover:border-sp-primary hover:bg-sp-primary/10 focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                                x-on:click="addItem()"
                            >
                                <x-stockpilot.icon
                                    name="plus"
                                    class="h-4 w-4"
                                />
                                Add item
                            </button>
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-sp-border">
                            <div class="hidden bg-sp-surface px-4 py-3 text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted md:grid md:grid-cols-[minmax(0,2fr)_120px_140px_120px_40px] md:gap-3">
                                <div>Product</div>
                                <div>Quantity</div>
                                <div>Unit cost</div>
                                <div class="text-right">Line total</div>
                                <div></div>
                            </div>

                            <div class="divide-y divide-sp-border">
                                <template
                                    x-for="(item, index) in createForm.items"
                                    :key="item.key"
                                >
                                    <div class="p-4">
                                        <div class="grid gap-3 md:grid-cols-[minmax(0,2fr)_120px_140px_120px_40px] md:items-end">
                                            <div>
                                                <label
                                                    :for="`purchase_item_product_${index}`"
                                                    class="mb-1.5 block text-xs font-medium text-sp-muted md:hidden"
                                                >
                                                    Product
                                                </label>

                                                <select
                                                    :id="`purchase_item_product_${index}`"
                                                    :name="`items[${index}][product_id]`"
                                                    required
                                                    x-model="item.product_id"
                                                    x-on:change="syncItem(index)"
                                                    class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm text-sp-text outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                                >
                                                    <option value="">Select product</option>

                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->name }} — {{ $product->sku }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <p
                                                    x-show="item.product_id"
                                                    x-text="selectedProductLabel(item.product_id)"
                                                    class="mt-1.5 text-xs text-sp-muted"
                                                ></p>
                                            </div>

                                            <div>
                                                <label
                                                    :for="`purchase_item_quantity_${index}`"
                                                    class="mb-1.5 block text-xs font-medium text-sp-muted md:hidden"
                                                >
                                                    Quantity
                                                </label>

                                                <input
                                                    :id="`purchase_item_quantity_${index}`"
                                                    :name="`items[${index}][quantity]`"
                                                    type="number"
                                                    min="0.001"
                                                    step="0.001"
                                                    required
                                                    x-model="item.quantity"
                                                    x-on:input="syncItem(index)"
                                                    class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm tabular-nums text-sp-text outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                                />
                                            </div>

                                            <div>
                                                <label
                                                    :for="`purchase_item_unit_cost_${index}`"
                                                    class="mb-1.5 block text-xs font-medium text-sp-muted md:hidden"
                                                >
                                                    Unit cost
                                                </label>

                                                <input
                                                    :id="`purchase_item_unit_cost_${index}`"
                                                    :name="`items[${index}][unit_cost]`"
                                                    type="number"
                                                    min="0.01"
                                                    step="0.01"
                                                    required
                                                    x-model="item.unit_cost"
                                                    x-on:input="syncItem(index)"
                                                    class="block w-full rounded-xl border border-sp-border bg-white px-3.5 py-2.5 text-sm tabular-nums text-sp-text outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                                />
                                            </div>

                                            <div>
                                                <label
                                                    class="mb-1.5 block text-xs font-medium text-sp-muted md:hidden"
                                                >
                                                    Line total
                                                </label>

                                                <div class="rounded-xl bg-sp-surface px-3.5 py-2.5 text-right text-sm font-semibold tabular-nums text-sp-text">
                                                    Rs
                                                    <span x-text="formatMoney(item.line_total)"></span>
                                                </div>
                                            </div>

                                            <div class="flex justify-end">
                                                <button
                                                    type="button"
                                                    class="rounded-lg p-2 text-sp-muted transition hover:bg-rose-50 hover:text-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-500/20 disabled:cursor-not-allowed disabled:opacity-40"
                                                    x-on:click="removeItem(index)"
                                                    x-bind:disabled="createForm.items.length === 1"
                                                    aria-label="Remove purchase item"
                                                >
                                                    <x-stockpilot.icon
                                                        name="trash-2"
                                                        class="h-4 w-4"
                                                    />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-sp-border bg-sp-surface p-4 sm:p-5">
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div>
                                <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                                    Subtotal
                                </p>

                                <p class="mt-1 text-lg font-bold tabular-nums text-sp-text">
                                    Rs <span x-text="formatMoney(purchaseSubtotal())"></span>
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                                    Adjustments
                                </p>

                                <p class="mt-1 text-lg font-bold tabular-nums text-sp-text">
                                    Rs <span x-text="formatMoney(purchaseAdjustmentTotal())"></span>
                                </p>
                            </div>

                            <div class="sm:text-right">
                                <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                                    Estimated total
                                </p>

                                <p class="mt-1 text-2xl font-bold tabular-nums text-sp-primary">
                                    Rs <span x-text="formatMoney(purchaseTotal())"></span>
                                </p>
                            </div>
                        </div>

                        <p class="mt-3 text-xs text-sp-muted">
                            Final totals, discounts, taxes, product status, and stock changes are validated again on the server.
                        </p>
                    </section>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-sp-border bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-end sm:px-6">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border border-sp-border bg-white px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                        x-on:click="closeCreate()"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-sp-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-sp-primary/90 focus:outline-none focus:ring-2 focus:ring-sp-primary/30"
                    >
                        <x-stockpilot.icon
                            name="check"
                            class="h-4 w-4"
                        />
                        Save purchase
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
