<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        sidebarCollapsed: localStorage.getItem('stockpilot-sidebar') === 'collapsed',
        sidebarHovering: false,
        mobileSidebarOpen: false,

        sidebarIsExpanded() {
            return !this.sidebarCollapsed || this.sidebarHovering || this.mobileSidebarOpen;
        },

        collapseSidebar() {
            this.sidebarCollapsed = true;
            this.sidebarHovering = false;
            localStorage.setItem('stockpilot-sidebar', 'collapsed');
        },

        expandSidebar() {
            this.sidebarCollapsed = false;
            localStorage.setItem('stockpilot-sidebar', 'expanded');
        }
    }"
    @keydown.escape.window="mobileSidebarOpen = false"
>
    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-sp-background text-sp-text antialiased">
        <div class="min-h-screen">

            {{-- =====================================================
                MOBILE OVERLAY
            ====================================================== --}}
            <div
                x-cloak
                x-show="mobileSidebarOpen"
                x-transition.opacity.duration.200ms
                class="fixed inset-0 z-40 bg-sp-brand-dark/45 backdrop-blur-[1px] lg:hidden"
                x-on:click="mobileSidebarOpen = false"
                aria-hidden="true"
            ></div>

            {{-- =====================================================
                SIDEBAR
            ====================================================== --}}
            <aside
                class="fixed inset-y-0 start-0 z-50 flex flex-col overflow-visible bg-sp-brand-dark text-white shadow-2xl transition-[width,transform] duration-300 ease-out lg:translate-x-0"
                :class="[
                    sidebarIsExpanded() ? 'lg:w-64' : 'lg:w-20',
                    mobileSidebarOpen
                        ? 'translate-x-0 w-72'
                        : '-translate-x-full lg:translate-x-0'
                ]"
                @mouseenter="sidebarHovering = true"
                @mouseleave="sidebarHovering = false"
                aria-label="{{ __('Main navigation') }}"
            >
                {{-- =================================================
                    BRAND
                ================================================== --}}
                <div class="relative flex h-16 shrink-0 items-center border-b border-white/10 px-3">
                    <a
                        href="{{ route('dashboard') }}"
                        wire:navigate
                        class="flex min-w-0 flex-1 items-center gap-3"
                        aria-label="{{ config('app.name', 'StockPilot') }}"
                    >
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-sp-brand-dark shadow-sm ring-1 ring-white/10">
                            <x-app-logo-icon class="h-7 w-7" />
                        </span>

                        <span
                            x-show="sidebarIsExpanded()"
                            x-transition.opacity.duration.150ms
                            class="min-w-0 truncate text-lg font-bold tracking-tight"
                        >
                            {{ config('app.name', 'StockPilot') }}
                        </span>
                    </a>

                    {{-- Desktop collapse --}}
                    <button
                        type="button"
                        x-on:click="sidebarCollapsed ? expandSidebar() : collapseSidebar()"
                        class="hidden h-9 w-9 shrink-0 items-center justify-center rounded-lg text-white/70 transition hover:bg-white/10 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/50 lg:flex"
                        :aria-label="sidebarCollapsed ? '{{ __('Expand sidebar') }}' : '{{ __('Collapse sidebar') }}'"
                        :title="sidebarCollapsed ? '{{ __('Expand sidebar') }}' : '{{ __('Collapse sidebar') }}'"
                    >
                        <x-stockpilot.icon
                            name="chevron-right"
                            class="h-5 w-5 transition-transform duration-300"
                            x-bind:class="sidebarIsExpanded() ? 'rotate-180' : ''"
                        />
                    </button>

                    {{-- Mobile close --}}
                    <button
                        type="button"
                        x-on:click="mobileSidebarOpen = false"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-white/70 transition hover:bg-white/10 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/50 lg:hidden"
                        aria-label="{{ __('Close navigation') }}"
                    >
                        <x-stockpilot.icon name="x" class="h-5 w-5" />
                    </button>
                </div>

                {{-- =================================================
                    NAVIGATION
                ================================================== --}}
                <nav class="flex-1 overflow-y-auto px-3 py-5">
                    <div
                        x-show="sidebarIsExpanded()"
                        x-transition.opacity.duration.150ms
                        class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[0.16em] text-white/40"
                    >
                        {{ __('Workspace') }}
                    </div>

                    {{-- Dashboard --}}
                    <a
                        href="{{ route('dashboard') }}"
                        wire:navigate
                        x-on:click="mobileSidebarOpen = false"
                        @class([
                            'group mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-150',
                            'bg-sp-primary text-white shadow-sm' => request()->routeIs('dashboard'),
                            'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('dashboard'),
                        ])
                        :title="sidebarIsExpanded() ? null : '{{ __('Dashboard') }}'"
                    >
                        <x-stockpilot.icon
                            name="dashboard"
                            class="h-5 w-5 shrink-0 transition-transform duration-150 group-hover:scale-105"
                        />

                        <span
                            x-show="sidebarIsExpanded()"
                            x-transition.opacity.duration.100ms
                            class="truncate"
                        >
                            {{ __('Dashboard') }}
                        </span>
                    </a>

                    {{-- Products --}}
                    @can('viewAny', App\Models\Product::class)
                        <a
                            href="{{ route('admin.products.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'group mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-150',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.products.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.products.*'),
                            ])
                            :title="sidebarIsExpanded() ? null : '{{ __('Products') }}'"
                        >
                            <x-stockpilot.icon
                                name="products"
                                class="h-5 w-5 shrink-0 transition-transform duration-150 group-hover:scale-105"
                            />

                            <span
                                x-show="sidebarIsExpanded()"
                                x-transition.opacity.duration.100ms
                                class="truncate"
                            >
                                {{ __('Products') }}
                            </span>
                        </a>
                    @endcan

                    {{-- Suppliers --}}
                    @can('viewAny', App\Models\Supplier::class)
                        <a
                            href="{{ route('admin.suppliers.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'group mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-150',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.suppliers.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.suppliers.*'),
                            ])
                            :title="sidebarIsExpanded() ? null : '{{ __('Suppliers') }}'"
                        >
                            <x-stockpilot.icon
                                name="suppliers"
                                class="h-5 w-5 shrink-0 transition-transform duration-150 group-hover:scale-105"
                            />

                            <span
                                x-show="sidebarIsExpanded()"
                                x-transition.opacity.duration.100ms
                                class="truncate"
                            >
                                {{ __('Suppliers') }}
                            </span>
                        </a>
                    @endcan

                    {{-- Customers --}}
                    @can('viewAny', App\Models\Customer::class)
                        <a
                            href="{{ route('admin.customers.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'group mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-150',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.customers.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.customers.*'),
                            ])
                            :title="sidebarIsExpanded() ? null : '{{ __('Customers') }}'"
                        >
                            <x-stockpilot.icon
                                name="customers"
                                class="h-5 w-5 shrink-0 transition-transform duration-150 group-hover:scale-105"
                            />

                            <span
                                x-show="sidebarIsExpanded()"
                                x-transition.opacity.duration.100ms
                                class="truncate"
                            >
                                {{ __('Customers') }}
                            </span>
                        </a>
                    @endcan

                    {{-- Operations --}}
                    @can('viewAny', App\Models\Purchase::class)
                        <div
                            x-show="sidebarIsExpanded()"
                            x-transition.opacity.duration.150ms
                            class="mt-7 px-3 pb-2 pt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-white/40"
                        >
                            {{ __('Operations') }}
                        </div>

                        <a
                            href="{{ route('admin.purchases.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'group mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-150',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.purchases.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.purchases.*'),
                            ])
                            :title="sidebarIsExpanded() ? null : '{{ __('Purchasing') }}'"
                        >
                            <x-stockpilot.icon
                                name="purchasing"
                                class="h-5 w-5 shrink-0 transition-transform duration-150 group-hover:scale-105"
                            />

                            <span
                                x-show="sidebarIsExpanded()"
                                x-transition.opacity.duration.100ms
                                class="truncate"
                            >
                                {{ __('Purchasing') }}
                            </span>
                        </a>
                    @endcan

                    {{-- Administration --}}
                    @can('viewAny', App\Models\User::class)
                        <div
                            x-show="sidebarIsExpanded()"
                            x-transition.opacity.duration.150ms
                            class="mt-7 px-3 pb-2 pt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-white/40"
                        >
                            {{ __('Administration') }}
                        </div>

                        <a
                            href="{{ route('admin.users.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'group mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-150',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.users.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.users.*'),
                            ])
                            :title="sidebarIsExpanded() ? null : '{{ __('Users') }}'"
                        >
                            <x-stockpilot.icon
                                name="users"
                                class="h-5 w-5 shrink-0 transition-transform duration-150 group-hover:scale-105"
                            />

                            <span
                                x-show="sidebarIsExpanded()"
                                x-transition.opacity.duration.100ms
                                class="truncate"
                            >
                                {{ __('Users') }}
                            </span>
                        </a>
                    @endcan
                </nav>

                {{-- =================================================
                    SIDEBAR PROFILE
                ================================================== --}}
                <div class="shrink-0 border-t border-white/10 p-3">
                    <x-desktop-user-menu />
                </div>
            </aside>

            {{-- =====================================================
                MAIN APPLICATION AREA
            ====================================================== --}}
            <div class="min-h-screen lg:pl-20">

                {{-- =================================================
                    HEADER
                ================================================== --}}
                <header class="sticky top-0 z-30 border-b border-sp-border bg-sp-surface shadow-sm">
                    <div class="flex h-16 items-center gap-3 px-4 sm:px-6">

                        {{-- Mobile menu --}}
                        <button
                            type="button"
                            x-on:click="mobileSidebarOpen = true"
                            class="flex h-10 w-10 items-center justify-center rounded-lg text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-primary/30 lg:hidden"
                            aria-label="{{ __('Open navigation') }}"
                        >
                            <x-stockpilot.icon
                                name="menu"
                                class="h-5 w-5"
                            />
                        </button>

                        {{-- Context --}}
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-sp-brand-dark dark:text-white">
                                {{ config('app.name', 'StockPilot') }}
                            </p>

                            <p class="hidden truncate text-xs text-sp-text-muted sm:block">
                                {{ __('Sales, inventory & business management') }}
                            </p>
                        </div>

                        {{-- Appearance --}}
                        <div
                            x-data="{ open: false }"
                            class="relative"
                        >
                            <button
                                type="button"
                                x-on:click="open = !open"
                                x-on:keydown.escape.window="open = false"
                                x-bind:aria-expanded="open"
                                class="flex h-10 w-10 items-center justify-center rounded-lg text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-primary/30"
                                aria-label="{{ __('Appearance') }}"
                                title="{{ __('Appearance') }}"
                            >
                                <template x-if="$store.theme.theme === 'light'">
                                    <x-stockpilot.icon name="sun" class="h-5 w-5" />
                                </template>

                                <template x-if="$store.theme.theme === 'dark'">
                                    <x-stockpilot.icon name="moon" class="h-5 w-5" />
                                </template>

                                <template x-if="$store.theme.theme === 'system'">
                                    <x-stockpilot.icon name="system" class="h-5 w-5" />
                                </template>
                            </button>

                            <div
                                x-cloak
                                x-show="open"
                                x-transition.origin.top.right
                                x-on:click.outside="open = false"
                                class="absolute end-0 top-full z-50 mt-2 w-44 overflow-hidden rounded-xl border border-sp-border bg-sp-surface p-1.5 shadow-xl"
                            >
                                <button
                                    type="button"
                                    x-on:click="$store.theme.set('light'); open = false"
                                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-sp-text transition hover:bg-sp-surface-muted"
                                >
                                    <x-stockpilot.icon name="sun" class="h-4 w-4" />
                                    {{ __('Light') }}
                                </button>

                                <button
                                    type="button"
                                    x-on:click="$store.theme.set('dark'); open = false"
                                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-sp-text transition hover:bg-sp-surface-muted"
                                >
                                    <x-stockpilot.icon name="moon" class="h-4 w-4" />
                                    {{ __('Dark') }}
                                </button>

                                <button
                                    type="button"
                                    x-on:click="$store.theme.set('system'); open = false"
                                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-sp-text transition hover:bg-sp-surface-muted"
                                >
                                    <x-stockpilot.icon name="system" class="h-4 w-4" />
                                    {{ __('System') }}
                                </button>
                            </div>
                        </div>

                        {{-- Notifications --}}
                        <button
                            type="button"
                            class="hidden h-10 w-10 items-center justify-center rounded-lg text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-primary/30 sm:flex"
                            aria-label="{{ __('Notifications') }}"
                            title="{{ __('Notifications') }}"
                        >
                            <x-stockpilot.icon
                                name="bell"
                                class="h-5 w-5"
                            />
                        </button>

                        {{-- =================================================
                            TOP-RIGHT PROFILE
                        ================================================== --}}
                        <x-topbar-user-menu />
                    </div>
                </header>

                {{-- =================================================
                    CONTENT
                ================================================== --}}
                <main class="min-w-0">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
