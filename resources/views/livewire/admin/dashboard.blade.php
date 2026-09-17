<x-stockpilot.admin-page>
    <x-stockpilot.page-header
        :section-label="__('Workspace')"
        :section-current="__('Dashboard')"
        :title="__('Dashboard')"
        :subtitle="__('Business overview')"
        :description="__('A snapshot of your sales, payments, and stock health for today.')"
        :tags="[
            ['label' => __('Overview'), 'tone' => 'primary'],
            ['label' => __('Live'), 'tone' => 'info'],
        ]"
    />

    @if ($canSeeSales)
        <section aria-label="{{ __('Sales summary') }}">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <x-stockpilot.kpi-card
                    :label="__('Sales today')"
                    :value="'Rs. ' . number_format($todaySalesTotal, 2)"
                    :hint="__('Completed invoices today')"
                    icon="receipt"
                    tone="primary"
                />

                <x-stockpilot.kpi-card
                    :label="__('Total sales')"
                    :value="'Rs. ' . number_format($totalSales, 2)"
                    :hint="__('All completed invoices')"
                    icon="reports"
                    tone="info"
                />

                <x-stockpilot.kpi-card
                    :label="__('Invoices today')"
                    :value="number_format($todayInvoiceCount)"
                    :hint="__('Completed invoices')"
                    icon="file-text"
                    tone="success"
                />

                <x-stockpilot.kpi-card
                    :label="__('Outstanding credit')"
                    :value="'Rs. ' . number_format($outstandingBalance, 2)"
                    :hint="__('Unpaid customer balance')"
                    icon="credit-card"
                    tone="warning"
                />

            </div>
        </section>
    @endif

    @if ($canSeeStock)
        <section aria-label="{{ __('Stock summary') }}">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

                <x-stockpilot.kpi-card
                    :label="__('Total products')"
                    :value="number_format($totalProducts)"
                    :hint="__('Entire product catalog')"
                    icon="products"
                    tone="info"
                />

                <x-stockpilot.kpi-card
                    :label="__('Total suppliers')"
                    :value="number_format($totalSuppliers)"
                    :hint="__('Vendor partners')"
                    icon="suppliers"
                    tone="info"
                />

                <x-stockpilot.kpi-card
                    :label="__('Stock value')"
                    :value="'Rs. ' . number_format($stockValue, 2)"
                    :hint="__('Active catalog at cost')"
                    icon="products"
                    tone="info"
                />

                <x-stockpilot.kpi-card
                    :label="__('Low stock')"
                    :value="number_format($lowStockCount)"
                    :hint="__('Needs reordering')"
                    icon="alert-triangle"
                    tone="warning"
                />

                <x-stockpilot.kpi-card
                    :label="__('Out of stock')"
                    :value="number_format($outOfStockCount)"
                    :hint="__('Immediate attention')"
                    icon="x-circle"
                    tone="danger"
                />

            </div>
        </section>
    @endif

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">

        @if ($canSeeSales)
            <x-stockpilot.page-table mobile="lg" aria-label="{{ __('Recent invoices') }}">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gradient-to-r from-sp-primary/15 via-sp-surface-muted to-sp-info-soft/70 dark:from-sp-brand-dark dark:via-sp-surface-muted dark:to-sp-info-soft">
                        <tr class="border-b border-sp-border-strong dark:border-sp-border-strong">
                            <th colspan="2" scope="col" class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-[0.10em] text-sp-text">
                                {{ __('Recent invoices') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sp-border dark:divide-sp-border">
                        @forelse ($recentInvoices as $invoice)
                            <tr class="transition duration-150 odd:bg-sp-surface even:bg-sp-surface-muted/40 dark:odd:bg-sp-surface dark:even:bg-sp-surface-muted">
                                <td class="px-6 py-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sp-primary/10 text-sp-primary dark:bg-sp-brand-dark dark:text-sp-success">
                                            <x-stockpilot.icon name="receipt" class="h-5 w-5" />
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-extrabold text-sp-text">
                                                {{ $invoice->invoice_number }}
                                            </p>
                                            <p class="mt-0.5 truncate text-xs font-semibold text-sp-text-subtle">
                                                {{ $invoice->customer?->name ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <p class="text-sm font-extrabold text-sp-primary dark:text-sp-success">
                                        Rs. {{ number_format((float) $invoice->total_amount, 2) }}
                                    </p>
                                    <p class="mt-0.5 text-xs font-semibold text-sp-text-subtle">
                                        {{ $invoice->invoice_date->toFormattedDateString() }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center">
                                    <x-stockpilot.empty-state
                                        icon="receipt"
                                        :title="__('No invoices yet')"
                                        :message="__('Create your first sale to see it here.')"
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-stockpilot.page-table>
        @endif

        @if ($canSeeSales)
            <x-stockpilot.page-table mobile="lg" aria-label="{{ __('Recent payments') }}">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gradient-to-r from-sp-success/15 via-sp-surface-muted to-sp-info-soft/70 dark:from-sp-brand-dark dark:via-sp-surface-muted dark:to-sp-info-soft">
                        <tr class="border-b border-sp-border-strong dark:border-sp-border-strong">
                            <th colspan="2" scope="col" class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-[0.10em] text-sp-text">
                                {{ __('Recent payments') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sp-border dark:divide-sp-border">
                        @forelse ($recentPayments as $payment)
                            <tr class="transition duration-150 odd:bg-sp-surface even:bg-sp-surface-muted/40 dark:odd:bg-sp-surface dark:even:bg-sp-surface-muted">
                                <td class="px-6 py-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sp-success-soft text-sp-success dark:bg-sp-success-soft dark:text-sp-success">
                                            <x-stockpilot.icon name="credit-card" class="h-5 w-5" />
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-extrabold text-sp-text">
                                                {{ $payment->invoice?->invoice_number ?? '—' }}
                                            </p>
                                            <p class="mt-0.5 truncate text-xs font-semibold text-sp-text-subtle">
                                                {{ $payment->receivedBy?->name ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <p class="text-sm font-extrabold text-sp-success">
                                        Rs. {{ number_format((float) $payment->amount, 2) }}
                                    </p>
                                    <p class="mt-0.5 text-xs font-semibold text-sp-text-subtle">
                                        {{ $payment->payment_date->toDayDateTimeString() }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center">
                                    <x-stockpilot.empty-state
                                        icon="credit-card"
                                        :title="__('No payments yet')"
                                        :message="__('Payments received will appear here.')"
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-stockpilot.page-table>
        @endif

        @if ($canSeeStock)
            <x-stockpilot.page-table mobile="lg" aria-label="{{ __('Low stock products') }}">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gradient-to-r from-sp-warning/15 via-sp-surface-muted to-sp-info-soft/70 dark:from-sp-brand-dark dark:via-sp-surface-muted dark:to-sp-info-soft">
                        <tr class="border-b border-sp-border-strong dark:border-sp-border-strong">
                            <th scope="col" class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-[0.10em] text-sp-text">
                                {{ __('Low stock') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-extrabold uppercase tracking-[0.10em] text-sp-text">
                                {{ __('Qty') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sp-border dark:divide-sp-border">
                        @forelse ($lowStockProducts as $product)
                            <tr class="transition duration-150 odd:bg-sp-surface even:bg-sp-surface-muted/40 dark:odd:bg-sp-surface dark:even:bg-sp-surface-muted">
                                <td class="px-6 py-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sp-warning-soft text-sp-warning dark:bg-sp-warning-soft dark:text-sp-warning">
                                            <x-stockpilot.icon name="alert-triangle" class="h-5 w-5" />
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-extrabold text-sp-text">
                                                {{ $product->name }}
                                            </p>
                                            <p class="mt-0.5 truncate text-xs font-semibold text-sp-text-subtle">
                                                {{ $product->sku }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <p class="text-sm font-extrabold text-sp-warning">
                                        {{ number_format((float) $product->quantity, 3) }}
                                    </p>
                                    <p class="mt-0.5 text-xs font-semibold text-sp-text-subtle">
                                        {{ __('Reorder at') }} {{ number_format((float) $product->reorder_level, 3) }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center">
                                    <x-stockpilot.empty-state
                                        icon="check"
                                        :title="__('Stock is healthy')"
                                        :message="__('No products are running low right now.')"
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-stockpilot.page-table>
        @endif

    </div>
</x-stockpilot.admin-page>