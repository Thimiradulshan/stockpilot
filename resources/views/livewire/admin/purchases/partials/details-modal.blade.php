<div
    x-cloak
    x-show="viewOpen"
    x-transition.opacity
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="view-purchase-title"
    role="dialog"
    aria-modal="true"
>
    <div
        class="flex min-h-full items-end justify-center bg-slate-950/50 px-4 py-6 sm:items-center sm:p-6"
        x-on:click.self="closeView()"
    >
        <div
            x-show="viewOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="translate-y-3 opacity-0 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave-end="translate-y-3 opacity-0 sm:translate-y-0 sm:scale-95"
            class="w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="flex items-start justify-between gap-4 border-b border-sp-border px-5 py-4 sm:px-6">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-sp-primary">
                        <x-stockpilot.icon
                            name="file-text"
                            class="h-4 w-4"
                        />
                        <span>Purchase details</span>
                    </div>

                    <h2
                        id="view-purchase-title"
                        class="mt-1 truncate text-xl font-bold tracking-tight text-sp-text"
                        x-text="viewPurchase.purchase_number || 'Purchase'"
                    ></h2>

                    <p
                        class="mt-1 text-sm text-sp-muted"
                        x-text="viewPurchase.purchase_date ? formatDate(viewPurchase.purchase_date) : '—'"
                    ></p>
                </div>

                <button
                    type="button"
                    class="rounded-lg p-2 text-sp-muted transition hover:bg-sp-surface hover:text-sp-text focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                    x-on:click="closeView()"
                    aria-label="Close purchase details dialog"
                >
                    <x-stockpilot.icon
                        name="x"
                        class="h-5 w-5"
                    />
                </button>
            </div>

            <div class="max-h-[calc(100vh-9rem)] overflow-y-auto">
                <div class="space-y-6 p-5 sm:p-6">
                    <section class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-xl border border-sp-border bg-sp-surface p-4">
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                                Supplier
                            </p>

                            <p
                                class="mt-1 truncate text-sm font-semibold text-sp-text"
                                x-text="viewPurchase.supplier?.name || '—'"
                            ></p>

                            <p
                                x-show="viewPurchase.supplier?.company"
                                class="mt-0.5 truncate text-xs text-sp-muted"
                                x-text="viewPurchase.supplier?.company"
                            ></p>
                        </div>

                        <div class="rounded-xl border border-sp-border bg-sp-surface p-4">
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                                Status
                            </p>

                            <span
                                class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize"
                                :class="statusBadgeClasses(viewPurchase.status)"
                                x-text="viewPurchase.status || '—'"
                            ></span>
                        </div>

                        <div class="rounded-xl border border-sp-border bg-sp-surface p-4">
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                                Created by
                            </p>

                            <p
                                class="mt-1 truncate text-sm font-semibold text-sp-text"
                                x-text="viewPurchase.created_by?.name || viewPurchase.createdBy?.name || 'System'"
                            ></p>
                        </div>

                        <div class="rounded-xl border border-sp-border bg-sp-surface p-4">
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                                Items
                            </p>

                            <p
                                class="mt-1 text-sm font-semibold tabular-nums text-sp-text"
                                x-text="(viewPurchase.items || []).length"
                            ></p>
                        </div>
                    </section>

                    <section>
                        <div class="mb-3">
                            <h3 class="text-sm font-semibold text-sp-text">
                                Purchased products
                            </h3>
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-sp-border">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-sp-border">
                                    <thead class="bg-sp-surface">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                                            >
                                                Product
                                            </th>

                                            <th
                                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                                            >
                                                Qty
                                            </th>

                                            <th
                                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                                            >
                                                Unit cost
                                            </th>

                                            <th
                                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                                            >
                                                Line total
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-sp-border bg-white">
                                        <template
                                            x-for="item in (viewPurchase.items || [])"
                                            :key="item.id"
                                        >
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <p
                                                        class="text-sm font-medium text-sp-text"
                                                        x-text="item.product?.name || 'Product'"
                                                    ></p>

                                                    <p
                                                        x-show="item.product?.sku"
                                                        class="mt-0.5 text-xs text-sp-muted"
                                                        x-text="item.product?.sku"
                                                    ></p>
                                                </td>

                                                <td
                                                    class="px-4 py-3 text-right text-sm tabular-nums text-sp-text"
                                                    x-text="formatQuantity(item.quantity)"
                                                ></td>

                                                <td
                                                    class="px-4 py-3 text-right text-sm tabular-nums text-sp-text"
                                                >
                                                    Rs
                                                    <span x-text="formatMoney(item.unit_cost)"></span>
                                                </td>

                                                <td
                                                    class="px-4 py-3 text-right text-sm font-semibold tabular-nums text-sp-text"
                                                >
                                                    Rs
                                                    <span x-text="formatMoney(item.line_total)"></span>
                                                </td>
                                            </tr>
                                        </template>

                                        <tr x-show="!(viewPurchase.items || []).length">
                                            <td
                                                colspan="4"
                                                class="px-4 py-8 text-center text-sm text-sp-muted"
                                            >
                                                No purchase items available.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <section class="grid gap-6 lg:grid-cols-[1fr_280px]">
                        <div>
                            <h3 class="text-sm font-semibold text-sp-text">
                                Notes
                            </h3>

                            <div class="mt-3 min-h-24 rounded-2xl border border-sp-border bg-sp-surface p-4">
                                <p
                                    class="whitespace-pre-wrap text-sm leading-6 text-sp-text"
                                    x-text="viewPurchase.notes || 'No notes recorded.'"
                                ></p>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-sp-border bg-sp-surface p-4">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-sm text-sp-muted">
                                        Subtotal
                                    </span>

                                    <span class="font-medium tabular-nums text-sp-text">
                                        Rs
                                        <span x-text="formatMoney(viewPurchase.subtotal)"></span>
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-sm text-sp-muted">
                                        Discount
                                    </span>

                                    <span class="font-medium tabular-nums text-sp-text">
                                        Rs
                                        <span x-text="formatMoney(viewPurchase.discount_amount)"></span>
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-sm text-sp-muted">
                                        Tax
                                    </span>

                                    <span class="font-medium tabular-nums text-sp-text">
                                        Rs
                                        <span x-text="formatMoney(viewPurchase.tax_amount)"></span>
                                    </span>
                                </div>

                                <div class="border-t border-sp-border pt-3">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-sm font-semibold text-sp-text">
                                            Total
                                        </span>

                                        <span class="text-lg font-bold tabular-nums text-sp-primary">
                                            Rs
                                            <span x-text="formatMoney(viewPurchase.total_amount)"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="flex justify-end border-t border-sp-border bg-white px-5 py-4 sm:px-6">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-xl border border-sp-border bg-white px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                    x-on:click="closeView()"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
