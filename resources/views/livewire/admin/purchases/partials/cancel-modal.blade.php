<div
    x-cloak
    x-show="cancelOpen"
    x-transition.opacity
    class="fixed inset-0 z-[60] overflow-y-auto"
    aria-labelledby="cancel-purchase-title"
    role="dialog"
    aria-modal="true"
>
    <div
        class="flex min-h-full items-end justify-center bg-slate-950/60 px-4 py-6 sm:items-center sm:p-6"
        x-on:click.self="closeCancel()"
    >
        <div
            x-show="cancelOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="translate-y-3 opacity-0 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
            x-transition:leave-end="translate-y-3 opacity-0 sm:translate-y-0 sm:scale-95"
            class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <div class="border-b border-sp-border px-5 py-4 sm:px-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                        <x-stockpilot.icon
                            name="alert-triangle"
                            class="h-5 w-5"
                        />
                    </div>

                    <div class="min-w-0">
                        <h2
                            id="cancel-purchase-title"
                            class="text-lg font-bold text-sp-text"
                        >
                            Cancel purchase?
                        </h2>

                        <p class="mt-1 text-sm leading-5 text-sp-muted">
                            This will reverse the stock quantities associated with this purchase.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="ml-auto rounded-lg p-2 text-sp-muted transition hover:bg-sp-surface hover:text-sp-text focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                        x-on:click="closeCancel()"
                        aria-label="Close cancellation dialog"
                    >
                        <x-stockpilot.icon
                            name="x"
                            class="h-5 w-5"
                        />
                    </button>
                </div>
            </div>

            <div class="space-y-4 px-5 py-5 sm:px-6">
                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-rose-600">
                        Purchase
                    </p>

                    <p
                        class="mt-1 text-base font-bold text-rose-900"
                        x-text="cancelPurchase.purchase_number || '—'"
                    ></p>

                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-medium text-rose-700">
                                Supplier
                            </p>

                            <p
                                class="mt-0.5 truncate text-sm font-medium text-rose-950"
                                x-text="cancelPurchase.supplier?.name || '—'"
                            ></p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-rose-700">
                                Current status
                            </p>

                            <p
                                class="mt-0.5 text-sm font-medium capitalize text-rose-950"
                                x-text="cancelPurchase.status || '—'"
                            ></p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-rose-700">
                                Purchase date
                            </p>

                            <p
                                class="mt-0.5 text-sm font-medium text-rose-950"
                                x-text="cancelPurchase.purchase_date ? formatDate(cancelPurchase.purchase_date) : '—'"
                            ></p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-rose-700">
                                Total
                            </p>

                            <p class="mt-0.5 text-sm font-bold tabular-nums text-rose-950">
                                Rs
                                <span x-text="formatMoney(cancelPurchase.total_amount)"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-sp-border bg-sp-surface p-4">
                    <div class="flex gap-3">
                        <x-stockpilot.icon
                            name="info"
                            class="mt-0.5 h-5 w-5 shrink-0 text-sp-primary"
                        />

                        <div class="text-sm leading-6 text-sp-muted">
                            <p class="font-semibold text-sp-text">
                                Inventory impact
                            </p>

                            <p class="mt-1">
                                The system will create reversing stock movements inside the same
                                transaction. The original purchase record and stock ledger remain
                                auditable.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <p class="text-sm font-medium leading-5 text-amber-900">
                        Cancellation cannot be undone automatically. Confirm that you want to proceed.
                    </p>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-sp-border bg-white px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-xl border border-sp-border bg-white px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                    x-on:click="closeCancel()"
                >
                    Keep purchase
                </button>

                <form
                    method="POST"
                    x-bind:action="cancelPurchase.id ? `{{ url('/admin/purchases') }}/${cancelPurchase.id}/cancel` : '#'"
                >
                    @csrf

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500/30 sm:w-auto"
                    >
                        <x-stockpilot.icon
                            name="x-circle"
                            class="h-4 w-4"
                        />
                        Confirm cancellation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
