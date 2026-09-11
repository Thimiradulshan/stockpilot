<div class="space-y-3 lg:hidden">
    @forelse ($purchases as $purchase)
        @php
            $statusClasses = match ($purchase->status) {
                'completed' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',
                'cancelled' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200',
                default => 'bg-slate-50 text-slate-700 ring-1 ring-inset ring-slate-200',
            };
        @endphp

        <article class="rounded-2xl border border-sp-border bg-white p-4 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="flex min-w-0 items-start gap-3">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sp-info text-sp-primary"
                    >
                        <x-stockpilot.icon
                            name="shopping-cart"
                            class="h-5 w-5"
                        />
                    </div>

                    <div class="min-w-0">
                        <p class="truncate font-semibold text-sp-text">
                            {{ $purchase->purchase_number }}
                        </p>

                        <p class="mt-1 text-xs text-sp-muted">
                            {{ $purchase->purchase_date?->format('d M Y') ?? '—' }}
                        </p>
                    </div>
                </div>

                <span
                    class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $statusClasses }}"
                >
                    {{ $purchase->status }}
                </span>
            </div>

            <div class="mt-4 rounded-xl bg-sp-surface p-3">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                            Supplier
                        </p>

                        <p class="mt-1 truncate text-sm font-semibold text-sp-text">
                            {{ $purchase->supplier?->name ?? '—' }}
                        </p>

                        @if ($purchase->supplier?->company)
                            <p class="mt-0.5 truncate text-xs text-sp-muted">
                                {{ $purchase->supplier->company }}
                            </p>
                        @endif
                    </div>

                    <div class="shrink-0 text-right">
                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                            Items
                        </p>

                        <p class="mt-1 text-sm font-semibold text-sp-text">
                            {{ $purchase->items_count }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-3">
                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                        Total
                    </p>

                    <p class="mt-1 text-base font-bold tabular-nums text-sp-text">
                        Rs {{ number_format((float) $purchase->total_amount, 2) }}
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-xs font-medium uppercase tracking-[0.08em] text-sp-muted">
                        Created by
                    </p>

                    <p class="mt-1 truncate text-sm font-medium text-sp-text">
                        {{ $purchase->createdBy?->name ?? 'System' }}
                    </p>
                </div>
            </div>

            @if ((float) $purchase->discount_amount > 0 || (float) $purchase->tax_amount > 0)
                <div class="mt-4 flex flex-wrap gap-x-4 gap-y-1 border-t border-sp-border pt-3 text-xs text-sp-muted">
                    @if ((float) $purchase->discount_amount > 0)
                        <span>
                            Discount:
                            Rs {{ number_format((float) $purchase->discount_amount, 2) }}
                        </span>
                    @endif

                    @if ((float) $purchase->tax_amount > 0)
                        <span>
                            Tax:
                            Rs {{ number_format((float) $purchase->tax_amount, 2) }}
                        </span>
                    @endif
                </div>
            @endif

            <div class="mt-4 flex gap-2 border-t border-sp-border pt-3">
                <button
                    type="button"
                    class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-sp-border bg-white px-3 py-2.5 text-xs font-semibold text-sp-text transition hover:border-sp-primary hover:text-sp-primary focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                    x-on:click='openView(@js($purchase))'
                >
                    <x-stockpilot.icon
                        name="eye"
                        class="h-4 w-4"
                    />
                    View details
                </button>

                @can('cancel', $purchase)
                    @if ($purchase->status === 'completed')
                        <button
                            type="button"
                            class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2.5 text-xs font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100 focus:outline-none focus:ring-2 focus:ring-rose-500/20"
                            x-on:click='openCancel(@js($purchase))'
                        >
                            <x-stockpilot.icon
                                name="x-circle"
                                class="h-4 w-4"
                            />
                            Cancel
                        </button>
                    @endif
                @endcan
            </div>
        </article>
    @empty
        <div class="rounded-2xl border border-sp-border bg-white px-6 py-14 text-center shadow-sm">
            <div class="mx-auto flex max-w-md flex-col items-center">
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sp-info text-sp-primary"
                >
                    <x-stockpilot.icon
                        name="shopping-cart"
                        class="h-7 w-7"
                    />
                </div>

                <h3 class="mt-4 text-base font-semibold text-sp-text">
                    No purchases found
                </h3>

                <p class="mt-1 text-sm text-sp-muted">
                    @if ($this->hasActiveFilters())
                        Try changing your search or status filter.
                    @else
                        Create your first purchase to start tracking incoming stock.
                    @endif
                </p>

                @if ($this->hasActiveFilters())
                    <button
                        type="button"
                        class="mt-4 text-sm font-semibold text-sp-primary hover:underline"
                        wire:click="clearFilters"
                    >
                        Clear filters
                    </button>
                @endif
            </div>
        </div>
    @endforelse

    @if ($purchases->hasPages())
        <div class="pt-2">
            {{ $purchases->links() }}
        </div>
    @endif
</div>
