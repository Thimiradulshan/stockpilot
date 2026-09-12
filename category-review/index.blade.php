<div class="sp-page">
    <div
        x-data="{
            createOpen: false,
            editOpen: false,
            editingCategory: null,

            openCreate() {
                this.editingCategory = null;
                this.editOpen = false;
                this.createOpen = true;
            },

            openEdit(category) {
                this.createOpen = false;
                this.editingCategory = category;
                this.editOpen = true;
            },

            closeModals() {
                this.createOpen = false;
                this.editOpen = false;
                this.editingCategory = null;
            }
        }"
        @keydown.escape.window="closeModals()"
        class="relative space-y-6"
    >
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

                            <span class="text-sp-text-subtle">
                                /
                            </span>

                            <span class="text-sp-primary">
                                {{ __('Categories') }}
                            </span>
                        </div>

                        <h1 class="text-2xl font-bold tracking-tight text-sp-brand-dark dark:text-white sm:text-3xl">
                            {{ __('Categories') }}
                        </h1>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-sp-text-muted sm:text-base">
                            {{ __('Organize your product catalog with clear category structure and availability control.') }}
                        </p>
                    </div>

                    <div class="shrink-0">
                        @can('create', \App\Models\Category::class)
                            <button
                                type="button"
                                @click="openCreate()"
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

                                {{ __('Add category') }}
                            </button>
                        @endcan
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
                        class="inline-flex shrink-0 items-center gap-2 px-4 py-3 text-sm font-semibold text-sp-text-muted transition hover:text-sp-text"
                    >
                        <x-stockpilot.icon
                            name="products"
                            class="h-4 w-4"
                        />

                        {{ __('Products') }}
                    </a>

                    <a
                        href="{{ route('admin.categories.index') }}"
                        wire:navigate
                        aria-current="page"
                        class="relative inline-flex shrink-0 items-center gap-2 px-4 py-3 text-sm font-semibold text-sp-primary"
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
                            <rect x="4" y="4" width="16" height="16" rx="2"/>
                            <path d="M8 8h8"/>
                            <path d="M8 12h8"/>
                            <path d="M8 16h5"/>
                        </svg>

                        {{ __('Categories') }}

                        <span
                            class="absolute inset-x-2 bottom-0 h-0.5 rounded-full bg-sp-primary"
                            aria-hidden="true"
                        ></span>
                    </a>
                </div>
            </div>
        </section>

        {{-- =========================================================
            FLASH MESSAGE
        ========================================================== --}}
        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition.opacity
                class="flex items-start gap-3 rounded-xl border border-sp-success/25 bg-sp-success/10 px-4 py-3 shadow-sm"
            >
                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-sp-success/15 text-sp-success">
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
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-sp-text">
                        {{ session('success') }}
                    </p>
                </div>

                <button
                    type="button"
                    @click="show = false"
                    class="rounded-md p-1 text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text"
                    aria-label="{{ __('Dismiss notification') }}"
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
                        <path d="M6 6l12 12"/>
                        <path d="M18 6 6 18"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- =========================================================
            VALIDATION ERRORS
        ========================================================== --}}
        @if ($errors->any())
            <div class="rounded-xl border border-sp-danger/25 bg-sp-danger/10 px-4 py-3 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-sp-danger/10 text-sp-danger">
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
                            <path d="M12 9v4"/>
                            <path d="M12 17h.01"/>
                            <path d="m10.3 3.7-7.7 13.3a2 2 0 0 0 1.7 3h15.4a2 2 0 0 0 1.7-3L13.7 3.7a2 2 0 0 0-3.4 0Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-sp-text">
                            {{ __('Please correct the following errors.') }}
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-sp-text-muted">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- =========================================================
            KPI CARDS
        ========================================================== --}}
        <section aria-label="{{ __('Category summary') }}">
            <div class="grid gap-4 sm:grid-cols-3">

                {{-- Total --}}
                <article class="relative overflow-hidden rounded-xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-1 bg-sp-brand-dark"></div>

                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-sp-text-muted">
                                {{ __('Total categories') }}
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
                                {{ number_format($totalCategories) }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-sp-text-muted">
                                {{ __('Entire category catalog') }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sp-brand-dark/10 text-sp-brand-dark dark:bg-white/10 dark:text-white">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-6 w-6"
                                aria-hidden="true"
                            >
                                <rect x="3" y="4" width="7" height="7" rx="1"/>
                                <rect x="14" y="4" width="7" height="7" rx="1"/>
                                <rect x="3" y="13" width="7" height="7" rx="1"/>
                                <rect x="14" y="13" width="7" height="7" rx="1"/>
                            </svg>
                        </div>
                    </div>
                </article>

                {{-- Active --}}
                <article class="relative overflow-hidden rounded-xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-1 bg-sp-success"></div>

                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-sp-text-muted">
                                {{ __('Active categories') }}
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
                                {{ number_format($activeCategories) }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-sp-text-muted">
                                {{ __('Available for new products') }}
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

                {{-- Inactive --}}
                <article class="relative overflow-hidden rounded-xl border border-sp-border bg-sp-surface p-5 shadow-sm">
                    <div class="absolute inset-x-0 top-0 h-1 bg-sp-warning"></div>

                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-sp-text-muted">
                                {{ __('Inactive categories') }}
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-sp-brand-dark dark:text-white">
                                {{ number_format($inactiveCategories) }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-sp-text-muted">
                                {{ __('Retained for historical assignments') }}
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sp-warning/20 text-sp-warning-foreground">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-6 w-6"
                                aria-hidden="true"
                            >
                                <path d="M12 3v11"/>
                                <path d="M12 18h.01"/>
                                <path d="M5.5 20h13a1.5 1.5 0 0 0 1.3-2.25l-6.5-13a1.5 1.5 0 0 0-2.6 0l-6.5 13A1.5 1.5 0 0 0 5.5 20Z"/>
                            </svg>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- =========================================================
            CATEGORY MANAGEMENT
        ========================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-sp-border bg-sp-surface shadow-sm">

            {{-- Section header --}}
            <div class="border-b border-sp-border bg-sp-info/[0.035] px-5 py-5 sm:px-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex min-w-0 items-start gap-3">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sp-info/15 text-sp-info-foreground">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-6 w-6"
                                aria-hidden="true"
                            >
                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                <path d="M8 8h8"/>
                                <path d="M8 12h8"/>
                                <path d="M8 16h5"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-sp-brand-dark dark:text-white">
                                {{ __('Category catalog') }}
                            </h2>

                            <p class="mt-1 text-sm text-sp-text-muted">
                                {{ __('Search, review, and maintain your product categories.') }}
                            </p>
                        </div>
                    </div>

                    <div class="inline-flex shrink-0 items-center gap-2 rounded-full bg-sp-info/10 px-3 py-1.5 text-xs font-bold text-sp-info-foreground">
                        <span class="h-1.5 w-1.5 rounded-full bg-sp-primary"></span>
                        {{ __('All statuses') }}
                    </div>
                </div>

                {{-- Filters --}}
                <div class="mt-5 rounded-xl border border-sp-info/20 bg-sp-surface p-4 shadow-sm">
                    <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_200px_auto]">

                        {{-- Search --}}
                        <div>
                            <label
                                for="category-search"
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
                                    id="category-search"
                                    type="search"
                                    wire:model.live.debounce.300ms="search"
                                    placeholder="{{ __('Search by category name or description...') }}"
                                    autocomplete="off"
                                    class="block w-full rounded-lg border border-sp-border bg-sp-surface py-2.5 pe-4 ps-11 text-sm text-sp-text shadow-sm outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                >
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label
                                for="category-status"
                                class="mb-2 block text-[11px] font-bold uppercase tracking-[0.1em] text-sp-text-muted"
                            >
                                {{ __('Status') }}
                            </label>

                            <select
                                id="category-status"
                                wire:model.live="status"
                                class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                            >
                                <option value="">
                                    {{ __('All statuses') }}
                                </option>

                                <option value="active">
                                    {{ __('Active') }}
                                </option>

                                <option value="inactive">
                                    {{ __('Inactive') }}
                                </option>
                            </select>
                        </div>

                        {{-- Clear --}}
                        <div class="flex items-end">
                            @if ($this->hasActiveFilters())
                                <button
                                    type="button"
                                    wire:click="clearFilters"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted focus:outline-none focus:ring-2 focus:ring-sp-primary/20 md:w-auto"
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
                                {{ __('Category') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Description') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-right text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Products') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Status') }}
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3.5 text-right text-[11px] font-bold uppercase tracking-[0.12em] text-sp-text-muted"
                            >
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-sp-border">
                        @forelse ($categories as $category)
                            <tr
                                wire:key="category-row-{{ $category->id }}"
                                class="group transition-colors duration-150 hover:bg-sp-primary/[0.025]"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sp-info/10 text-sp-info-foreground transition-colors duration-150 group-hover:bg-sp-primary/10 group-hover:text-sp-primary">
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
                                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                                <path d="M8 8h8"/>
                                                <path d="M8 12h8"/>
                                                <path d="M8 16h5"/>
                                            </svg>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-sp-text">
                                                {{ $category->name }}
                                            </p>

                                            <p class="mt-0.5 truncate text-xs font-medium tracking-wide text-sp-text-muted">
                                                ID: #{{ $category->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="max-w-lg px-6 py-4">
                                    <p class="truncate text-sm font-medium text-sp-text">
                                        {{ $category->description ?: __('No description provided') }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-sp-brand-dark dark:text-white">
                                        {{ number_format($category->products_count) }}
                                    </span>

                                    <p class="mt-0.5 text-xs text-sp-text-muted">
                                        {{ __('assigned') }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($category->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sp-success/10 px-2.5 py-1 text-[11px] font-bold text-sp-success">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ __('Active') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sp-warning/20 px-2.5 py-1 text-[11px] font-bold text-sp-warning-foreground">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ __('Inactive') }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right">
                                    @can('update', $category)
                                        <button
                                            type="button"
                                            @click="openEdit(@js(['id' => $category->id, 'name' => $category->name, 'description' => $category->description, 'status' => $category->status]))"
                                            class="inline-flex items-center gap-2 rounded-lg border border-sp-border bg-sp-surface px-3 py-2 text-sm font-semibold text-sp-text transition hover:border-sp-primary/30 hover:bg-sp-primary/[0.05] hover:text-sp-primary focus:outline-none focus:ring-2 focus:ring-sp-primary/20"
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
                                                <path d="M12 20h9"/>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                                            </svg>

                                            {{ __('Edit') }}
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-14 text-center">
                                    <div class="mx-auto max-w-lg">
                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-sp-info/15 text-sp-info-foreground">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="h-6 w-6"
                                                aria-hidden="true"
                                            >
                                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                                <path d="M8 8h8"/>
                                                <path d="M8 12h8"/>
                                                <path d="M8 16h5"/>
                                            </svg>
                                        </div>

                                        <h3 class="mt-4 text-base font-bold text-sp-text">
                                            @if ($this->hasActiveFilters())
                                                {{ __('No matching categories') }}
                                            @else
                                                {{ __('No categories yet') }}
                                            @endif
                                        </h3>

                                        <p class="mt-1.5 text-sm leading-6 text-sp-text-muted">
                                            @if ($this->hasActiveFilters())
                                                {{ __('Try changing your search or status filter.') }}
                                            @else
                                                {{ __('Create your first category to organize the product catalog.') }}
                                            @endif
                                        </p>

                                        <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                                            @if ($this->hasActiveFilters())
                                                <button
                                                    type="button"
                                                    wire:click="clearFilters"
                                                    class="inline-flex items-center gap-2 rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted"
                                                >
                                                    {{ __('Clear filters') }}
                                                </button>
                                            @endif

                                            @can('create', \App\Models\Category::class)
                                                <button
                                                    type="button"
                                                    @click="openCreate()"
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

                                                    {{ __('Add category') }}
                                                </button>
                                            @endcan
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
                @forelse ($categories as $category)
                    <article
                        wire:key="mobile-category-{{ $category->id }}"
                        class="p-5 transition-colors duration-150 hover:bg-sp-primary/[0.025]"
                    >
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sp-info/10 text-sp-info-foreground">
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
                                    <rect x="4" y="4" width="16" height="16" rx="2"/>
                                    <path d="M8 8h8"/>
                                    <path d="M8 12h8"/>
                                    <path d="M8 16h5"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-sm font-bold text-sp-text">
                                            {{ $category->name }}
                                        </h3>

                                        <p class="mt-0.5 text-xs font-medium tracking-wide text-sp-text-muted">
                                            ID: #{{ $category->id }}
                                        </p>
                                    </div>

                                    @if ($category->status === 'active')
                                        <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-sp-success/10 px-2.5 py-1 text-[11px] font-bold text-sp-success">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ __('Active') }}
                                        </span>
                                    @else
                                        <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-sp-warning/20 px-2.5 py-1 text-[11px] font-bold text-sp-warning-foreground">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ __('Inactive') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <p class="text-[11px] font-bold uppercase tracking-wide text-sp-text-muted">
                                        {{ __('Description') }}
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-sp-text">
                                        {{ $category->description ?: __('No description provided') }}
                                    </p>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wide text-sp-text-muted">
                                            {{ __('Products') }}
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-sp-text">
                                            {{ number_format($category->products_count) }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-[11px] font-bold uppercase tracking-wide text-sp-text-muted">
                                            {{ __('Status') }}
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-sp-text">
                                            {{ $category->status === 'active' ? __('Available') : __('Inactive') }}
                                        </p>
                                    </div>
                                </div>

                                @can('update', $category)
                                    <div class="mt-4">
                                        <button
                                            type="button"
                                            @click="openEdit(@js(['id' => $category->id, 'name' => $category->name, 'description' => $category->description, 'status' => $category->status]))"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:border-sp-primary/30 hover:bg-sp-primary/[0.05] hover:text-sp-primary"
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
                                                <path d="M12 20h9"/>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                                            </svg>

                                            {{ __('Edit category') }}
                                        </button>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="px-5 py-12 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-sp-info/15 text-sp-info-foreground">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="h-6 w-6"
                                aria-hidden="true"
                            >
                                <rect x="4" y="4" width="16" height="16" rx="2"/>
                                <path d="M8 8h8"/>
                                <path d="M8 12h8"/>
                                <path d="M8 16h5"/>
                            </svg>
                        </div>

                        <h3 class="mt-4 text-base font-bold text-sp-text">
                            @if ($this->hasActiveFilters())
                                {{ __('No matching categories') }}
                            @else
                                {{ __('No categories yet') }}
                            @endif
                        </h3>

                        <p class="mt-1.5 text-sm leading-6 text-sp-text-muted">
                            @if ($this->hasActiveFilters())
                                {{ __('Try changing your search or status filter.') }}
                            @else
                                {{ __('Create your first category to organize the product catalog.') }}
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

                            @can('create', \App\Models\Category::class)
                                <button
                                    type="button"
                                    @click="openCreate()"
                                    class="inline-flex items-center gap-2 rounded-lg bg-sp-primary px-4 py-2.5 text-sm font-semibold text-sp-primary-foreground shadow-sm transition hover:brightness-95"
                                >
                                    {{ __('Add category') }}
                                </button>
                            @endcan
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- =====================================================
                PAGINATION
            ====================================================== --}}
            @if ($categories->hasPages())
                <div class="border-t border-sp-border px-5 py-4 sm:px-6">
                    {{ $categories->links() }}
                </div>
            @endif
        </section>

        {{-- =========================================================
            CREATE CATEGORY MODAL
        ========================================================== --}}
        @can('create', \App\Models\Category::class)
            <div
                x-cloak
                x-show="createOpen"
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 p-4"
            >
                <div
                    x-show="createOpen"
                    x-transition
                    @click.outside="closeModals()"
                    class="w-full max-w-lg rounded-2xl border border-sp-border bg-sp-surface shadow-2xl"
                >
                    <div class="flex items-start justify-between gap-4 border-b border-sp-border px-6 py-5">
                        <div>
                            <h2 class="text-lg font-bold text-sp-text">
                                {{ __('Add category') }}
                            </h2>

                            <p class="mt-1 text-sm text-sp-text-muted">
                                {{ __('Create a category for your product catalog.') }}
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="closeModals()"
                            class="rounded-lg p-2 text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text"
                            aria-label="{{ __('Close') }}"
                        >
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
                                <path d="M6 6l12 12"/>
                                <path d="M18 6 6 18"/>
                            </svg>
                        </button>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('admin.categories.store') }}"
                        class="space-y-5 px-6 py-6"
                    >
                        @csrf

                        <div>
                            <label
                                for="create_category_name"
                                class="mb-2 block text-sm font-semibold text-sp-text"
                            >
                                {{ __('Category name') }}
                            </label>

                            <input
                                id="create_category_name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                maxlength="100"
                                required
                                autocomplete="off"
                                class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                placeholder="{{ __('e.g. Electronics') }}"
                            >

                            @error('name')
                                <p class="mt-1.5 text-xs font-medium text-sp-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="create_category_description"
                                class="mb-2 block text-sm font-semibold text-sp-text"
                            >
                                {{ __('Description') }}
                            </label>

                            <textarea
                                id="create_category_description"
                                name="description"
                                rows="4"
                                maxlength="5000"
                                class="block w-full resize-y rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                                placeholder="{{ __('Optional description for this category...') }}"
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <p class="mt-1.5 text-xs font-medium text-sp-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label
                                for="create_category_status"
                                class="mb-2 block text-sm font-semibold text-sp-text"
                            >
                                {{ __('Status') }}
                            </label>

                            <select
                                id="create_category_status"
                                name="status"
                                required
                                class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                            >
                                <option value="active" @selected(old('status', 'active') === 'active')>
                                    {{ __('Active') }}
                                </option>

                                <option value="inactive" @selected(old('status') === 'inactive')>
                                    {{ __('Inactive') }}
                                </option>
                            </select>

                            @error('status')
                                <p class="mt-1.5 text-xs font-medium text-sp-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="rounded-xl border border-sp-info/20 bg-sp-info/[0.05] px-4 py-3">
                            <p class="text-xs leading-5 text-sp-text-muted">
                                {{ __('Active categories can be assigned to new products. Inactive categories remain available for historical product assignments.') }}
                            </p>
                        </div>

                        <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                            <button
                                type="button"
                                @click="closeModals()"
                                class="inline-flex items-center justify-center rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted"
                            >
                                {{ __('Cancel') }}
                            </button>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-sp-primary px-4 py-2.5 text-sm font-semibold text-sp-primary-foreground shadow-sm transition hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-sp-primary/30"
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

                                {{ __('Create category') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endcan

        {{-- =========================================================
            EDIT CATEGORY MODAL
        ========================================================== --}}
        <div
            x-cloak
            x-show="editOpen && editingCategory"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 p-4"
        >
            <div
                x-show="editOpen && editingCategory"
                x-transition
                @click.outside="closeModals()"
                class="w-full max-w-lg rounded-2xl border border-sp-border bg-sp-surface shadow-2xl"
            >
                <div class="flex items-start justify-between gap-4 border-b border-sp-border px-6 py-5">
                    <div>
                        <h2 class="text-lg font-bold text-sp-text">
                            {{ __('Edit category') }}
                        </h2>

                        <p class="mt-1 text-sm text-sp-text-muted">
                            {{ __('Update category details and availability.') }}
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="closeModals()"
                        class="rounded-lg p-2 text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text"
                        aria-label="{{ __('Close') }}"
                    >
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
                            <path d="M6 6l12 12"/>
                            <path d="M18 6 6 18"/>
                        </svg>
                    </button>
                </div>

                <form
                    method="POST"
                    class="space-y-5 px-6 py-6"
                    x-bind:action="editingCategory ? `{{ url('/admin/categories') }}/${editingCategory.id}` : '#'"
                >
                    @csrf
                    @method('PATCH')

                    <div>
                        <label
                            for="edit_category_name"
                            class="mb-2 block text-sm font-semibold text-sp-text"
                        >
                            {{ __('Category name') }}
                        </label>

                        <input
                            id="edit_category_name"
                            name="name"
                            type="text"
                            x-model="editingCategory.name"
                            maxlength="100"
                            required
                            autocomplete="off"
                            class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                        >
                    </div>

                    <div>
                        <label
                            for="edit_category_description"
                            class="mb-2 block text-sm font-semibold text-sp-text"
                        >
                            {{ __('Description') }}
                        </label>

                        <textarea
                            id="edit_category_description"
                            name="description"
                            rows="4"
                            maxlength="5000"
                            x-model="editingCategory.description"
                            class="block w-full resize-y rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition placeholder:text-sp-text-subtle focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                        ></textarea>
                    </div>

                    <div>
                        <label
                            for="edit_category_status"
                            class="mb-2 block text-sm font-semibold text-sp-text"
                        >
                            {{ __('Status') }}
                        </label>

                        <select
                            id="edit_category_status"
                            name="status"
                            x-model="editingCategory.status"
                            required
                            class="block w-full rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm text-sp-text shadow-sm outline-none transition focus:border-sp-primary focus:ring-2 focus:ring-sp-primary/20"
                        >
                            <option value="active">
                                {{ __('Active') }}
                            </option>

                            <option value="inactive">
                                {{ __('Inactive') }}
                            </option>
                        </select>
                    </div>

                    <div class="rounded-xl border border-sp-info/20 bg-sp-info/[0.05] px-4 py-3">
                        <p class="text-xs leading-5 text-sp-text-muted">
                            {{ __('Deactivating a category does not remove it from existing products. It only prevents the category from being selected for new product assignments.') }}
                        </p>
                    </div>

                    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                        <button
                            type="button"
                            @click="closeModals()"
                            class="inline-flex items-center justify-center rounded-lg border border-sp-border bg-sp-surface px-4 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted"
                        >
                            {{ __('Cancel') }}
                        </button>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-sp-primary px-4 py-2.5 text-sm font-semibold text-sp-primary-foreground shadow-sm transition hover:brightness-95 focus:outline-none focus:ring-2 focus:ring-sp-primary/30"
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
                                <path d="M5 12h14"/>
                                <path d="m12 5 7 7-7 7"/>
                            </svg>

                            {{ __('Save changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
