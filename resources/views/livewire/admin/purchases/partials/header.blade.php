<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-sp-primary">
            <x-stockpilot.icon name="shopping-cart" class="h-4 w-4" />

            {{ __('Purchasing') }}
        </div>

        <h1 class="mt-1 text-2xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
            {{ __('Purchases') }}
        </h1>

        <p class="mt-1 text-sm text-sp-text-muted">
            {{ __('Record stock purchases and manage incoming inventory.') }}
        </p>
    </div>

    @can('create', \App\Models\Purchase::class)
        <button
            type="button"
            x-on:click="openCreate()"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-sp-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sp-brand-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-primary/40"
        >
            <x-stockpilot.icon name="plus" class="h-4 w-4" />

            {{ __('New purchase') }}
        </button>
    @endcan
</div>
