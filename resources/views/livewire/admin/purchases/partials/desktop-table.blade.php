<div class="hidden overflow-hidden rounded-2xl border border-sp-border bg-white shadow-sm lg:block">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-sp-border">
            <thead class="bg-sp-surface">
                <tr>
                    <th
                        scope="col"
                        class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                    >
                        Purchase
                    </th>

                    <th
                        scope="col"
                        class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                    >
                        Supplier
                    </th>

                    <th
                        scope="col"
                        class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                    >
                        Date
                    </th>

                    <th
                        scope="col"
                        class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                    >
                        Items
                    </th>

                    <th
                        scope="col"
                        class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                    >
                        Total
                    </th>

                    <th
                        scope="col"
                        class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                    >
                        Status
                    </th>

                    <th
                        scope="col"
                        class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-[0.08em] text-sp-muted"
                    >
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-sp-border bg-white">
                @forelse ($purchases as $purchase)
                    @php
                        $statusClasses = match ($purchase->status) {
                            'completed' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',
                            'cancelled' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200',
                            default => 'bg-slate-50 text-slate-700 ring-1 ring-inset ring-slate-200',
                        };
                    @endphp

                    <tr class="transition hover:bg-sp-surface/60">
                        <td class="px-5 py-4 align-top">
                            <div class="flex items-start gap-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sp-info/70 text-sp-primary"
                                >
                                    <x-stockpilot.icon
                                        name="shopping-cart"
                                        class="h-5 w-5"
                                    />
                                </div>

                                <div class="min-w-0">
                                    <p class="font-semibold text-sp-text">
                                        {{ $purchase->purchase_number }}
                                    </p>

                                    <p class="mt-1 text-xs text-sp-muted">
                                        {{ $purchase->createdBy?->name ?? 'System' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-5 py-4 align-top">
                            <div class="min-w-[180px]">
                                <p class="font-medium text-sp-text">
                                    {{ $purchase->supplier?->name ?? '—' }}
                                </p>

                                @if ($purchase->supplier?->company)
                                    <p class="mt-1 text-xs text-sp-muted">
                                        {{ $purchase->supplier->company }}
                                    </p>
                                @endif
                            </div>
                        </td>

                        <td class="px-5 py-4 align-top">
                            <p class="text-sm font-medium text-sp-text">
                                {{ $purchase->purchase_date?->format('d M Y') ?? '—' }}
                            </p>

                            <p class="mt-1 text-xs text-sp-muted">
                                {{ $purchase->purchase_date?->format('l') ?? '' }}
                            </p>
                        </td>

                        <td class="px-5 py-4 text-right align-top">
                            <span
                                class="inline-flex min-w-8 items-center justify-center rounded-lg bg-sp-info px-2.5 py-1 text-sm font-semibold text-sp-primary"
                            >
                                {{ $purchase->items_count }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-right align-top">
                            <p class="font-semibold tabular-nums text-sp-text">
                                Rs {{ number_format((float) $purchase->total_amount, 2) }}
                            </p>

                            @if ((float) $purchase->discount_amount > 0 || (float) $purchase->tax_amount > 0)
                                <div class="mt-1 space-y-0.5 text-xs text-sp-muted">
                                    @if ((float) $purchase->discount_amount > 0)
                                        <p>
                                            Discount:
                                            Rs {{ number_format((float) $purchase->discount_amount, 2) }}
                                        </p>
                                    @endif

                                    @if ((float) $purchase->tax_amount > 0)
                                        <p>
                                            Tax:
                                            Rs {{ number_format((float) $purchase->tax_amount, 2) }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-center align-top">
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $statusClasses }}"
                            >
                                {{ $purchase->status }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-right align-top">
                            <div class="flex justify-end gap-2">
                                <button
                                    type="button"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-sp-border bg-white px-3 py-2 text-xs font-semibold text-sp-text transition hover:border-sp-primary hover:text-sp-primary focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                                    x-on:click='openView(@js($purchase))'
                                >
                                    <x-stockpilot.icon
                                        name="eye"
                                        class="h-4 w-4"
                                    />
                                    View
                                </button>

                                @can('cancel', $purchase)
                                    @if ($purchase->status === 'completed')
                                        <button
                                            type="button"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100 focus:outline-none focus:ring-2 focus:ring-rose-500/20"
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="7"
                            class="px-6 py-14 text-center"
                        >
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
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($purchases->hasPages())
        <div class="border-t border-sp-border bg-white px-5 py-4">
            {{ $purchases->links() }}
        </div>
    @endif
</div>
