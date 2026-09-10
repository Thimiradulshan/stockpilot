<div class="sp-page">
    <div class="space-y-6">
        {{-- Page header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-sm font-medium text-sp-text-muted">
                    <span>Workspace</span>
                    <span class="text-sp-text-subtle">/</span>
                    <span>Products</span>
                </div>

                <h1 class="text-2xl font-semibold tracking-tight text-sp-text sm:text-3xl">
                    Products
                </h1>

                <p class="mt-1 max-w-2xl text-sm text-sp-text-muted sm:text-base">
                    Manage products, pricing, stock levels, and availability.
                </p>
            </div>
        </div>

        {{-- Summary cards --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="sp-surface p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-sp-text-muted">
                            Total products
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-sp-text">
                            {{ number_format($totalProducts) }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-sp-brand-dark/10 px-3 py-2 text-sm font-semibold text-sp-brand-dark dark:bg-white/10 dark:text-white">
                        All
                    </div>
                </div>
            </div>

            <div class="sp-surface p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-sp-text-muted">
                            Active
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-sp-text">
                            {{ number_format($activeProducts) }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-sp-success/10 px-3 py-2 text-sm font-semibold text-sp-success">
                        Active
                    </div>
                </div>
            </div>

            <div class="sp-surface p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-sp-text-muted">
                            Low stock
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-sp-text">
                            {{ number_format($lowStockProducts) }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-sp-warning/20 px-3 py-2 text-sm font-semibold text-sp-warning-foreground">
                        Attention
                    </div>
                </div>
            </div>

            <div class="sp-surface p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-sp-text-muted">
                            Out of stock
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight text-sp-text">
                            {{ number_format($outOfStockProducts) }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-sp-danger/10 px-3 py-2 text-sm font-semibold text-sp-danger">
                        Critical
                    </div>
                </div>
            </div>
        </div>

        {{-- Product management panel --}}
        <section class="sp-surface overflow-hidden">
            <div class="border-b border-sp-border px-5 py-5 sm:px-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-sp-text">
                            Product catalog
                        </h2>

                        <p class="mt-1 text-sm text-sp-text-muted">
                            Search and filter your product inventory.
                        </p>
                    </div>

                    <div
                        wire:loading
                        wire:target="search,category,status"
                        class="text-sm font-medium text-sp-primary"
                    >
                        Updating results...
                    </div>
                </div>

                {{-- Filters --}}
                <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-[minmax(0,1.6fr)_minmax(180px,0.8fr)_minmax(160px,0.7fr)_auto]">
                    <div>
                        <label
                            for="product-search"
                            class="mb-2 block text-sm font-medium text-sp-text"
                        >
                            Search
                        </label>

                        <div class="relative">
                            <input
                                id="product-search"
                                type="search"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search by product name or SKU..."
                                class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                            >
                        </div>
                    </div>

                    <div>
                        <label
                            for="product-category"
                            class="mb-2 block text-sm font-medium text-sp-text"
                        >
                            Category
                        </label>

                        <select
                            id="product-category"
                            wire:model.live="category"
                            class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                        >
                            <option value="">All categories</option>

                            @foreach ($categories as $categoryOption)
                                <option value="{{ $categoryOption->id }}">
                                    {{ $categoryOption->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            for="product-status"
                            class="mb-2 block text-sm font-medium text-sp-text"
                        >
                            Status
                        </label>

                        <select
                            id="product-status"
                            wire:model.live="status"
                            class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="">All statuses</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        @if ($this->hasActiveFilters())
                            <button
                                type="button"
                                wire:click="clearFilters"
                                class="w-full rounded-lg border border-sp-border px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
                            >
                                Clear filters
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Desktop table --}}
            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-full divide-y divide-sp-border">
                    <thead class="bg-sp-surface-muted/60">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-sp-text-muted"
                            >
                                Product
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-sp-text-muted"
                            >
                                Category
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-sp-text-muted"
                            >
                                Selling price
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-sp-text-muted"
                            >
                                Stock
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-sp-text-muted"
                            >
                                Reorder level
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-sp-text-muted"
                            >
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-sp-border">
                        @forelse ($products as $product)
                            @php
                                $isOutOfStock = $product->quantity <= 0;
                                $isLowStock = !$isOutOfStock && $product->quantity <= $product->reorder_level;
                            @endphp

                            <tr class="transition hover:bg-sp-surface-muted/30">
                                <td class="px-6 py-4">
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-sp-text">
                                            {{ $product->name }}
                                        </p>

                                        <p class="mt-1 text-xs font-medium tracking-wide text-sp-text-muted">
                                            {{ $product->sku }}
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-sp-text-muted">
                                    {{ $product->category?->name ?? '—' }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-sp-text">
                                    Rs. {{ number_format((float) $product->selling_price, 2) }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="flex flex-col items-end gap-1">
                                        <span class="font-semibold text-sp-text">
                                            {{ number_format((float) $product->quantity, 3) }}
                                        </span>

                                        @if ($product->status !== 'active')
                                            <span class="text-xs font-medium text-sp-text-muted">
                                                Inactive
                                            </span>
                                        @elseif ($isOutOfStock)
                                            <span class="rounded-full bg-sp-danger/10 px-2.5 py-1 text-xs font-semibold text-sp-danger">
                                                Out of stock
                                            </span>
                                        @elseif ($isLowStock)
                                            <span class="rounded-full bg-sp-warning/20 px-2.5 py-1 text-xs font-semibold text-sp-warning-foreground">
                                                Low stock
                                            </span>
                                        @else
                                            <span class="rounded-full bg-sp-success/10 px-2.5 py-1 text-xs font-semibold text-sp-success">
                                                Normal
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-sp-text-muted">
                                    {{ number_format((float) $product->reorder_level, 3) }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($product->status === 'active')
                                        <span class="rounded-full bg-sp-success/10 px-2.5 py-1 text-xs font-semibold text-sp-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="rounded-full bg-sp-surface-muted px-2.5 py-1 text-xs font-semibold text-sp-text-muted">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-md">
                                        <h3 class="text-base font-semibold text-sp-text">
                                            No products found
                                        </h3>

                                        <p class="mt-2 text-sm leading-6 text-sp-text-muted">
                                            Try changing your search or filters to find the products you are looking for.
                                        </p>

                                        @if ($this->hasActiveFilters())
                                            <button
                                                type="button"
                                                wire:click="clearFilters"
                                                class="mt-4 rounded-lg bg-sp-primary px-4 py-2.5 text-sm font-semibold text-sp-primary-foreground shadow-sm transition hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-sp-primary/30"
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

            {{-- Mobile cards --}}
            <div class="divide-y divide-sp-border md:hidden">
                @forelse ($products as $product)
                    @php
                        $isOutOfStock = $product->quantity <= 0;
                        $isLowStock = !$isOutOfStock && $product->quantity <= $product->reorder_level;
                    @endphp

                    <article class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h3 class="truncate font-semibold text-sp-text">
                                    {{ $product->name }}
                                </h3>

                                <p class="mt-1 text-xs font-medium tracking-wide text-sp-text-muted">
                                    {{ $product->sku }}
                                </p>
                            </div>

                            @if ($product->status === 'active')
                                <span class="shrink-0 rounded-full bg-sp-success/10 px-2.5 py-1 text-xs font-semibold text-sp-success">
                                    Active
                                </span>
                            @else
                                <span class="shrink-0 rounded-full bg-sp-surface-muted px-2.5 py-1 text-xs font-semibold text-sp-text-muted">
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs font-medium text-sp-text-muted">
                                    Category
                                </p>

                                <p class="mt-1 font-medium text-sp-text">
                                    {{ $product->category?->name ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-sp-text-muted">
                                    Selling price
                                </p>

                                <p class="mt-1 font-semibold text-sp-text">
                                    Rs. {{ number_format((float) $product->selling_price, 2) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-sp-text-muted">
                                    Current stock
                                </p>

                                <p class="mt-1 font-semibold text-sp-text">
                                    {{ number_format((float) $product->quantity, 3) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-sp-text-muted">
                                    Reorder level
                                </p>

                                <p class="mt-1 font-medium text-sp-text">
                                    {{ number_format((float) $product->reorder_level, 3) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4">
                            @if ($product->status !== 'active')
                                <span class="rounded-full bg-sp-surface-muted px-2.5 py-1 text-xs font-semibold text-sp-text-muted">
                                    Stock monitoring paused
                                </span>
                            @elseif ($isOutOfStock)
                                <span class="rounded-full bg-sp-danger/10 px-2.5 py-1 text-xs font-semibold text-sp-danger">
                                    Out of stock
                                </span>
                            @elseif ($isLowStock)
                                <span class="rounded-full bg-sp-warning/20 px-2.5 py-1 text-xs font-semibold text-sp-warning-foreground">
                                    Low stock
                                </span>
                            @else
                                <span class="rounded-full bg-sp-success/10 px-2.5 py-1 text-xs font-semibold text-sp-success">
                                    Stock normal
                                </span>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="px-5 py-16 text-center">
                        <h3 class="text-base font-semibold text-sp-text">
                            No products found
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-sp-text-muted">
                            Try changing your search or filters.
                        </p>

                        @if ($this->hasActiveFilters())
                            <button
                                type="button"
                                wire:click="clearFilters"
                                class="mt-4 rounded-lg bg-sp-primary px-4 py-2.5 text-sm font-semibold text-sp-primary-foreground shadow-sm transition hover:brightness-95"
                            >
                                Clear filters
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="border-t border-sp-border px-5 py-4 sm:px-6">
                    {{ $products->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
