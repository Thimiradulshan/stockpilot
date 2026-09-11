<div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-2xl border border-sp-border bg-sp-surface p-5 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-[0.12em] text-sp-text-muted">
            {{ __('Total purchases') }}
        </p>

        <p class="mt-2 text-3xl font-bold text-sp-brand-dark dark:text-white">
            {{ number_format($totalPurchases) }}
        </p>
    </div>

    <div class="rounded-2xl border border-sp-border bg-sp-surface p-5 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-[0.12em] text-sp-text-muted">
            {{ __('Completed') }}
        </p>

        <p class="mt-2 text-3xl font-bold text-sp-success">
            {{ number_format($completedPurchases) }}
        </p>
    </div>

    <div class="rounded-2xl border border-sp-border bg-sp-surface p-5 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-[0.12em] text-sp-text-muted">
            {{ __('Cancelled') }}
        </p>

        <p class="mt-2 text-3xl font-bold text-sp-danger">
            {{ number_format($cancelledPurchases) }}
        </p>
    </div>

    <div class="rounded-2xl border border-sp-border bg-sp-surface p-5 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-[0.12em] text-sp-text-muted">
            {{ __('Completed value') }}
        </p>

        <p class="mt-2 text-2xl font-bold text-sp-brand-dark dark:text-white">
            LKR {{ number_format((float) $completedPurchaseValue, 2) }}
        </p>
    </div>
</div>
