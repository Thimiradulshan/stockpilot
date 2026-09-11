<div class="sp-page">
    <div class="relative space-y-6">
        {{-- =========================================================
            SOFT AMBIENT BACKGROUND
        ========================================================== --}}
        <div
            class="pointer-events-none absolute -top-10 start-1/3 h-72 w-72 rounded-full bg-sp-info/[0.07] blur-3xl"
            aria-hidden="true"
        ></div>

        <div
            class="pointer-events-none absolute end-0 top-72 h-80 w-80 rounded-full bg-sp-secondary/[0.05] blur-3xl"
            aria-hidden="true"
        ></div>

        {{-- =========================================================
            PAGE HEADER
        ========================================================== --}}
        <section class="relative overflow-hidden rounded-2xl border border-sp-border bg-sp-surface shadow-sm">
            <div class="absolute inset-y-0 start-0 w-1 bg-sp-primary"></div>

            <div class="bg-sp-info/[0.045] px-5 py-6 sm:px-7 sm:py-7">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div class="min-w-0">
                        <div class="mb-3 flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.16em]">
                            <span class="text-sp-text-muted">
                                {{ __('Workspace') }}
                            </span>

                            <span class="text-sp-text-subtle">
                                /
                            </span>

                            <span class="text-sp-primary">
                                {{ __('Products') }}
                            </span>
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-sp-brand-dark dark:text-white sm:text-3xl">
                            {{ __('Products') }}
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-sp-text-muted sm:text-base">
                            {{ __('Manage your product catalog, pricing, stock levels, and availability.') }}
                        </p>
                    </div>

                    <div class="shrink-0">
                        @if (Route::has('admin.products.create'))
                            <a
                                href="{{ route('admin.products.create') }}"
                                wire:navigate
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sp-primary px-4 py-2.5 text-sm font-semibold text-sp-primary-foreground shadow-sm transition duration-150 hover:-translate-y-0.5 hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-sp-primary/30 sm:w-auto"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="h-4 w-4"
                                    aria-hidden="true"
                                >
                                    <path d="M12 5v14"/>
                                    <path d="M5 12h14"/>
                                </svg>

                                {{ __('Add product') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- =====================================================
                INTERNAL TABS
            ====================================================== --}}
            <div class="border-t border-sp-border bg-sp-surface px-4 sm:px-6">
                <div class="flex items-center gap-1 overflow-x-auto">
                    <a
                        href="{{ route('admin.products.index') }}"
                        wire:navigate
                        aria-current="page"
                        class="relative inline-flex shrink-0 items-center gap-2 px-4 py-3 text-sm font-semibold text-sp-primary"
                    >
                        <x-stockpilot.icon
                            name="products"
                            class="h-4 w-4"
                        />

                        {{ __('Products') }}

                        <span
                            class="absolute inset-x-2 bottom-0 h-0.5 rounded-full bg-sp-primary"
                            aria-hidden="true"
                        ></span>
                    </a>

                    @if (Route::has('admin.categories.index'))
                        <a
                            href="{{ route('admin.categories.index') }}"
                            wire:navigate
                            class="inline-flex shrink-0 items-center gap-2 px-4 py-3 text-sm font-semibold text-sp-text-muted transition hover:text-sp-text"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-4 w-4"
                                aria-hidden="true"
                            >
                                <path d="M4 7h16"/>
                                <path d="M4 12h10"/>
                                <path d="M4 17h16"/>
                            </svg>

                            {{ __('Categories') }}
                        </a>
                    @endif
                </div>
            </div>
        </section>

        {{-- =========================================================
            KPI CARDS
        ========================================================== --}}
        <section aria-label="{{ __('Product summary') }}">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Total --}}
                <article class="relative overflow-hidden rounded-xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-1 bg-sp-brand-dark"></div>

                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-sp-text-muted">
                                {{ __('Total products') }}
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
                                {{ number_format($totalProducts) }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-sp-text-muted">
                                {{ __('Entire catalog') }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sp-brand-dark/10 text-sp-brand-dark dark:bg-white/10 dark:text-white">
                            <x-stockpilot.icon
                                name="products"
                                class="h-6 w-6"
                            />
                        </div>
                    </div>
                </article>

                {{-- Active --}}
                <article class="relative overflow-hidden rounded-xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-1 bg-sp-success"></div>

                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-sp-text-muted">
                                {{ __('Active products') }}
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
                                {{ number_format($activeProducts) }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-sp-text-muted">
                                {{ __('Available for operations') }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sp-success/10 text-sp-success">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-6 w-6"
                                aria-hidden="true"
                            >
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </div>
                    </div>
                </article>

                {{-- Low stock --}}
                <article class="relative overflow-hidden rounded-xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-1 bg-sp-warning"></div>

                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-sp-text-muted">
                                {{ __('Low stock') }}
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
                                {{ number_format($lowStockProducts) }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-sp-text-muted">
                                {{ __('Needs attention') }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sp-warning/20 text-sp-warning-foreground">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-6 w-6"
                                aria-hidden="true"
                            >
                                <path d="M12 9v4"/>
                                <path d="M12 17h.01"/>
                                <path d="M10.3 3.7 2.6 17a2 2 0 0 0 1.7 3h15.4a2 2 0 0 0 1.7-3L13.7 3.7a2 2 0 0 0-3.4 0Z"/>
                            </svg>
                        </div>
                    </div>
                </article>

                {{-- Out of stock --}}
                <article class="relative overflow-hidden rounded-xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-1 bg-sp-danger"></div>

                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-sp-text-muted">
                                {{ __('Out of stock') }}
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
                                {{ number_format($outOfStockProducts) }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-sp-text-muted">
                                {{ __('Immediate attention') }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sp-danger/10 text-sp-danger">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-6 w-6"
                                aria-hidden="true"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="m15 9-6 6"/>
                                <path d="m9 9 6 6"/>
                            </svg>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- =========================================================
            PRODUCT CATALOG
        ========================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-sp-border bg-sp-surface shadow-sm">

            {{-- Catalog header --}}
            <div class="border-b border-sp-border bg-sp-info/[0.035] px-5 py-5 sm:px-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex min-w-0 items-start gap-3">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sp-info/15 text-sp-info-foreground">
                            <x-stockpilot.icon
                                name="products"
                                class="h-6 w-6"
                            />
                        </div>

                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-sp-brand-dark dark:text-white">
                                {{ __('Product catalog') }}
                            </h2>

                            <p class="mt-1 text-sm text-sp-text-muted">
                                {{ __('Search and filter your inventory.') }}
                            </p>
                        </div>
                    </div>

                    <div
                        wire:loading
                        wire:target="search,category,status"
                        class="inline-flex shrink-0 items-center gap-2 rounded-full bg-sp-info/10 px-3 py-1.5 text-xs font-bold text-sp-info-foreground"
                    >
                        <svg
                            class="h-3.5 w-3.5 animate-spin"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4Z"
                            ></path>
                        </svg>

                        {{ __('Updating results') }}
                    </div>
                </div>

                {{-- Filter container --}}
                <div class="mt-5 rounded-xl border border-sp-info/20 bg-sp-surface p-4 shadow-sm">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-[minmax(0,1.7fr)_minmax(190px,0.8fr)_minmax(170px,0.7fr)_auto]">

                        {{-- Search --}}
                        <div>
                            <label
                                for="product-search"
                                class="mb-2 block text-[11px] font-bold uppercase tracking-[0.1em] text-sp-text-muted"
                            >
                                {{ __('Search') }}
                            </label>

                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5 text-sp-text-muted">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="h-5 w-5"
                                        aria-hidden="true"
                                    >
                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="m20 20-4-4"/>
                                    </svg>
                                </div>

                                <input
                                    id="product-search"
                                    type="search"
                                    wire:model.live.debounce.300ms="search"
                                    placeholder="Search by product name or SKU..."
                                    autocomplete="off"
                                    class="block w-full rounded-lg border border-sp-border bg-sp-surface py-2.5 pe-4 ps-11 text-sm text-sp-text shadow-sm outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                >
                            </div>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label
                                for="product-category"
                                class="mb-2 block text-[11px] font-bold uppercase tracking-[0.1em] text-sp-text-muted"
                            >
                                {{ __('Category') }}
                            </label>

                            <select
                                id="product-category"
                                wire:model.live="category"
                                class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                            >
                                <option value="">
                                    {{ __('All categories') }}
                                </option>

                                @foreach ($categories as $categoryOption)
                                    <option value="{{ $categoryOption->id }}">
                                        {{ $categoryOption->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label
                                for="product-status"
                                class="mb-2 block text-[11px] font-bold uppercase tracking-[0.1em] text-sp-text-muted"
                            >
                                {{ __('Status') }}
                            </label>

                            <select
                                id="product-status"
                                wire:model.live="status"
                                class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                            >
                                <option value="active">
                                    {{ __('Active') }}
                                </option>

                                <option value="inactive">
                                    {{ __('Inactive') }}
                                </option>

                                <option value="">
                                    {{ __('All statuses') }}
                                </option>
                            </select>
                        </div>

                        {{-- Clear --}}
                        <div class="flex items-end">
                            @if ($this->hasActiveFilters())
                                <button
                                    type="button"
                                    wire:click="clearFilters"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted focus:outline-none focus:ring-2 focus:ring-sp-primary/20 xl:w-auto"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="h-4 w-4"
                                        aria-hidden="true"
                                    >
                                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                                        <path d="M3 3v5h5"/>
                                    </svg>

                                    {{ __('Clear filters') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- =====================================================
                DESKTOP TABLE
            ====================================================== --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-sp-border bg-sp-surface-muted/70">
                            <th
                                scope="col"
                                class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Product') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Category') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-right text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Selling price') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-right text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Current stock') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-right text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Reorder level') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Status') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-sp-border">
                        @forelse ($products as $product)
                            @php
                                $isOutOfStock = $product->quantity <= 0;
                                $isLowStock = !$isOutOfStock && $product->quantity <= $product->reorder_level;
                            @endphp

                            <tr
                                wire:key="product-row-{{ $product->id }}"
                                class="group transition-colors duration-150 hover:bg-sp-primary/[0.025]"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sp-info/10 text-sp-info-foreground transition-colors duration-150 group-hover:bg-sp-primary/10 group-hover:text-sp-primary">
                                            <x-stockpilot.icon
                                                name="products"
                                                class="h-5 w-5"
                                            />
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-sp-text">
                                                {{ $product->name }}
                                            </p>

                                            <p class="mt-0.5 truncate text-xs font-medium tracking-wide text-sp-text-muted">
                                                SKU: {{ $product->sku }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-sp-text">
                                        {{ $product->category?->name ?? '—' }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-sp-brand-dark dark:text-white">
                                        Rs. {{ number_format((float) $product->selling_price, 2) }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex flex-col items-end gap-1.5">
                                        <span class="text-sm font-bold text-sp-text">
                                            {{ number_format((float) $product->quantity, 3) }}
                                        </span>

                                        @if ($product->status !== 'active')
                                            <span class="inline-flex items-center rounded-full bg-sp-surface-muted px-2.5 py-1 text-[11px] font-bold text-sp-text-muted">
                                                {{ __('Inactive') }}
                                            </span>
                                        @elseif ($isOutOfStock)
                                            <span class="inline-flex items-center rounded-full bg-sp-danger/10 px-2.5 py-1 text-[11px] font-bold text-sp-danger">
                                                {{ __('Out of stock') }}
                                            </span>
                                        @elseif ($isLowStock)
                                            <span class="inline-flex items-center rounded-full bg-sp-warning/25 px-2.5 py-1 text-[11px] font-bold text-sp-warning-foreground">
                                                {{ __('Low stock') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-sp-success/10 px-2.5 py-1 text-[11px] font-bold text-sp-success">
                                                {{ __('Normal') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <span class="text-sm font-medium text-sp-text-muted">
                                        {{ number_format((float) $product->reorder_level, 3) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($product->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sp-success/10 px-2.5 py-1 text-[11px] font-bold text-sp-success">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ __('Active') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sp-surface-muted px-2.5 py-1 text-[11px] font-bold text-sp-text-muted">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ __('Inactive') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="mx-auto max-w-lg">
                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-sp-info/15 text-sp-info-foreground">
                                            <x-stockpilot.icon
                                                name="products"
                                                class="h-6 w-6"
                                            />
                                        </div>

                                        <h3 class="mt-4 text-base font-bold text-sp-text">
                                            @if ($this->hasActiveFilters())
                                                {{ __('No matching products') }}
                                            @else
                                                {{ __('No products yet') }}
                                            @endif
                                        </h3>

                                        <p class="mt-1.5 text-sm leading-6 text-sp-text-muted">
                                            @if ($this->hasActiveFilters())
                                                {{ __('Try changing your search or filters to find the products you are looking for.') }}
                                            @else
                                                {{ __('Create your first product to start managing your inventory.') }}
                                            @endif
                                        </p>

                                        <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                                            @if ($this->hasActiveFilters())
                                                <button
                                                    type="button"
                                                    wire:click="clearFilters"
                                                    class="inline-flex items-center gap-2 rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                                                >
                                                    {{ __('Clear filters') }}
                                                </button>
                                            @endif

                                            @if (!$this->hasActiveFilters() && Route::has('admin.products.create'))
                                                <a
                                                    href="{{ route('admin.products.create') }}"
                                                    wire:navigate
                                                    class="inline-flex items-center gap-2 rounded-lg bg-sp-primary px-4 py-2.5 text-sm font-semibold text-sp-primary-foreground shadow-sm transition hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-sp-primary/30"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="h-4 w-4"
                                                        aria-hidden="true"
                                                    >
                                                        <path d="M12 5v14"/>
                                                        <path d="M5 12h14"/>
                                                    </svg>

                                                    {{ __('Add product') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- =====================================================
                MOBILE CARDS
            ====================================================== --}}
            <div class="divide-y divide-sp-border md:hidden">
                @forelse ($products as $product)
                    @php
                        $isOutOfStock = $product->quantity <= 0;
                        $isLowStock = !$isOutOfStock && $product->quantity <= $product->reorder_level;
                    @endphp

                    <article
                        wire:key="mobile-product-{{ $product->id }}"
                        class="p-5 transition-colors duration-150 hover:bg-sp-primary/[0.025]"
                    >
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sp-info/10 text-sp-info-foreground">
                                <x-stockpilot.icon
                                    name="products"
                                    class="h-5 w-5"
                                />
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-sm font-bold text-sp-text">
                                            {{ $product->name }}
                                        </h3>

                                        <p class="mt-0.5 truncate text-xs font-medium tracking-wide text-sp-text-muted">
                                            SKU: {{ $product->sku }}
                                        </p>
                                    </div>

                                    @if ($product->status === 'active')
                                        <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-sp-success/10 px-2.5 py-1 text-[11px] font-bold text-sp-success">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ __('Active') }}
                                        </span>
                                    @else
                                        <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-sp-surface-muted px-2.5 py-1 text-[11px] font-bold text-sp-text-muted">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ __('Inactive') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-x-4 gap-y-4">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wide text-sp-text-muted">
                                            {{ __('Category') }}
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-sp-text">
                                            {{ $product->category?->name ?? '—' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wide text-sp-text-muted">
                                            {{ __('Selling price') }}
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-sp-brand-dark dark:text-white">
                                            Rs. {{ number_format((float) $product->selling_price, 2) }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wide text-sp-text-muted">
                                            {{ __('Current stock') }}
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-sp-text">
                                            {{ number_format((float) $product->quantity, 3) }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wide text-sp-text-muted">
                                            {{ __('Reorder level') }}
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-sp-text">
                                            {{ number_format((float) $product->reorder_level, 3) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    @if ($product->status !== 'active')
                                        <span class="inline-flex items-center rounded-full bg-sp-surface-muted px-2.5 py-1 text-[11px] font-bold text-sp-text-muted">
                                            {{ __('Stock monitoring paused') }}
                                        </span>
                                    @elseif ($isOutOfStock)
                                        <span class="inline-flex items-center rounded-full bg-sp-danger/10 px-2.5 py-1 text-[11px] font-bold text-sp-danger">
                                            {{ __('Out of stock') }}
                                        </span>
                                    @elseif ($isLowStock)
                                        <span class="inline-flex items-center rounded-full bg-sp-warning/25 px-2.5 py-1 text-[11px] font-bold text-sp-warning-foreground">
                                            {{ __('Low stock') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-sp-success/10 px-2.5 py-1 text-[11px] font-bold text-sp-success">
                                            {{ __('Stock normal') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="px-5 py-10 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-sp-info/15 text-sp-info-foreground">
                            <x-stockpilot.icon
                                name="products"
                                class="h-6 w-6"
                            />
                        </div>

                        <h3 class="mt-4 text-base font-bold text-sp-text">
                            @if ($this->hasActiveFilters())
                                {{ __('No matching products') }}
                            @else
                                {{ __('No products yet') }}
                            @endif
                        </h3>

                        <p class="mt-1.5 text-sm leading-6 text-sp-text-muted">
                            @if ($this->hasActiveFilters())
                                {{ __('Try changing your search or filters.') }}
                            @else
                                {{ __('Create your first product to start managing inventory.') }}
                            @endif
                        </p>

                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            @if ($this->hasActiveFilters())
                                <button
                                    type="button"
                                    wire:click="clearFilters"
                                    class="inline-flex items-center rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted"
                                >
                                    {{ __('Clear filters') }}
                                </button>
                            @endif

                            @if (!$this->hasActiveFilters() && Route::has('admin.products.create'))
                                <a
                                    href="{{ route('admin.products.create') }}"
                                    wire:navigate
                                    class="inline-flex items-center gap-2 rounded-lg bg-sp-primary px-4 py-2.5 text-sm font-semibold text-sp-primary-foreground shadow-sm transition hover:brightness-95"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="h-4 w-4"
                                        aria-hidden="true"
                                    >
                                        <path d="M12 5v14"/>
                                        <path d="M5 12h14"/>
                                    </svg>

                                    {{ __('Add product') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- =====================================================
                PAGINATION
            ====================================================== --}}
            @if ($products->hasPages())
                <div class="border-t border-sp-border px-5 py-4 sm:px-6">
                    {{ $products->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
