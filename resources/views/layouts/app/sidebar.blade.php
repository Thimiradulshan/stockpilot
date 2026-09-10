<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ sidebarCollapsed: localStorage.getItem('stockpilot-sidebar') === 'collapsed', mobileSidebarOpen: false }"
>
    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-sp-background text-sp-text antialiased">
        <div class="min-h-screen">

            {{-- Mobile overlay --}}
            <div
                x-cloak
                x-show="mobileSidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-40 bg-black/40 lg:hidden"
                x-on:click="mobileSidebarOpen = false"
                aria-hidden="true"
            ></div>

            {{-- Sidebar --}}
            <aside
                class="fixed inset-y-0 start-0 z-50 flex flex-col bg-sp-brand-dark text-white shadow-xl transition-[width,transform] duration-200 lg:translate-x-0"
                :class="[
                    sidebarCollapsed ? 'lg:w-20' : 'lg:w-64',
                    mobileSidebarOpen ? 'translate-x-0 w-72' : '-translate-x-full lg:translate-x-0'
                ]"
                aria-label="{{ __('Main navigation') }}"
            >
                {{-- Brand --}}
                <div class="flex h-16 shrink-0 items-center border-b border-white/10 px-3">
                    <a
                        href="{{ route('dashboard') }}"
                        wire:navigate
                        class="flex min-w-0 flex-1 items-center gap-3"
                        aria-label="{{ config('app.name', 'StockPilot') }}"
                    >
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-sp-brand-dark shadow-sm">
                            <x-app-logo-icon class="h-6 w-6" />
                        </span>

                        <span
                            x-show="!sidebarCollapsed"
                            x-transition.opacity
                            class="truncate text-lg font-bold tracking-tight"
                        >
                            {{ config('app.name', 'StockPilot') }}
                        </span>
                    </a>

                    <button
                        type="button"
                        x-on:click="
                            sidebarCollapsed = !sidebarCollapsed;
                            localStorage.setItem('stockpilot-sidebar', sidebarCollapsed ? 'collapsed' : 'expanded');
                        "
                        class="hidden h-9 w-9 shrink-0 items-center justify-center rounded-lg text-white/70 transition hover:bg-white/10 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/50 lg:flex"
                        :aria-label="sidebarCollapsed ? '{{ __('Expand sidebar') }}' : '{{ __('Collapse sidebar') }}'"
                    >
                        <x-stockpilot.icon
                            name="chevron-right"
                            class="h-5 w-5 transition-transform"
                            x-bind:class="{ 'rotate-180': !sidebarCollapsed }"
                        />
                    </button>

                    <button
                        type="button"
                        x-on:click="mobileSidebarOpen = false"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-white/70 transition hover:bg-white/10 hover:text-white lg:hidden"
                        aria-label="{{ __('Close navigation') }}"
                    >
                        <x-stockpilot.icon name="x" class="h-5 w-5" />
                    </button>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 overflow-y-auto px-3 py-5">
                    <div
                        x-show="!sidebarCollapsed"
                        class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-white/40"
                    >
                        {{ __('Workspace') }}
                    </div>

                    {{-- Dashboard --}}
                    <a
                        href="{{ route('dashboard') }}"
                        wire:navigate
                        x-on:click="mobileSidebarOpen = false"
                        @class([
                            'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                            'bg-sp-primary text-white shadow-sm' => request()->routeIs('dashboard'),
                            'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('dashboard'),
                        ])
                        :title="sidebarCollapsed ? '{{ __('Dashboard') }}' : null"
                    >
                        <x-stockpilot.icon name="dashboard" class="h-5 w-5 shrink-0" />
                        <span x-show="!sidebarCollapsed" class="truncate">{{ __('Dashboard') }}</span>
                    </a>

                    {{-- Products --}}
                    @can('viewAny', App\Models\Product::class)
                        <a
                            href="{{ route('admin.products.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'mt-1 group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.products.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.products.*'),
                            ])
                            :title="sidebarCollapsed ? '{{ __('Products') }}' : null"
                        >
                            <x-stockpilot.icon name="products" class="h-5 w-5 shrink-0" />
                            <span x-show="!sidebarCollapsed" class="truncate">{{ __('Products') }}</span>
                        </a>
                    @endcan

                    {{-- Suppliers --}}
                    @can('viewAny', App\Models\Supplier::class)
                        <a
                            href="{{ route('admin.suppliers.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'mt-1 group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.suppliers.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.suppliers.*'),
                            ])
                            :title="sidebarCollapsed ? '{{ __('Suppliers') }}' : null"
                        >
                            <x-stockpilot.icon name="suppliers" class="h-5 w-5 shrink-0" />
                            <span x-show="!sidebarCollapsed" class="truncate">{{ __('Suppliers') }}</span>
                        </a>
                    @endcan

                    {{-- Customers --}}
                    @can('viewAny', App\Models\Customer::class)
                        <a
                            href="{{ route('admin.customers.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'mt-1 group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.customers.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.customers.*'),
                            ])
                            :title="sidebarCollapsed ? '{{ __('Customers') }}' : null"
                        >
                            <x-stockpilot.icon name="customers" class="h-5 w-5 shrink-0" />
                            <span x-show="!sidebarCollapsed" class="truncate">{{ __('Customers') }}</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\Purchase::class)
                        <div
                            x-show="!sidebarCollapsed"
                            class="mt-7 px-3 pb-2 pt-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-white/40"
                        >
                            {{ __('Operations') }}
                        </div>

                        <a
                            href="{{ route('admin.purchases.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'mt-1 group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.purchases.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.purchases.*'),
                            ])
                            :title="sidebarCollapsed ? '{{ __('Purchasing') }}' : null"
                        >
                            <x-stockpilot.icon name="purchasing" class="h-5 w-5 shrink-0" />
                            <span x-show="!sidebarCollapsed" class="truncate">{{ __('Purchasing') }}</span>
                        </a>
                    @endcan

                    @can('viewAny', App\Models\User::class)
                        <div
                            x-show="!sidebarCollapsed"
                            class="mt-7 px-3 pb-2 pt-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-white/40"
                        >
                            {{ __('Administration') }}
                        </div>

                        <a
                            href="{{ route('admin.users.index') }}"
                            wire:navigate
                            x-on:click="mobileSidebarOpen = false"
                            @class([
                                'mt-1 group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                                'bg-sp-primary text-white shadow-sm' => request()->routeIs('admin.users.*'),
                                'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('admin.users.*'),
                            ])
                            :title="sidebarCollapsed ? '{{ __('Users') }}' : null"
                        >
                            <x-stockpilot.icon name="users" class="h-5 w-5 shrink-0" />
                            <span x-show="!sidebarCollapsed" class="truncate">{{ __('Users') }}</span>
                        </a>
                    @endcan
                </nav>

                {{-- Footer --}}
                <div class="shrink-0 border-t border-white/10 p-3">
                    <a
                        href="{{ route('profile.edit') }}"
                        wire:navigate
                        x-on:click="mobileSidebarOpen = false"
                        @class([
                            'mb-2 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                            'bg-sp-primary text-white shadow-sm' => request()->routeIs('profile.*'),
                            'text-white/75 hover:bg-white/10 hover:text-white' => ! request()->routeIs('profile.*'),
                        ])
                        :title="sidebarCollapsed ? '{{ __('Settings') }}' : null"
                    >
                        <x-stockpilot.icon name="settings" class="h-5 w-5 shrink-0" />
                        <span x-show="!sidebarCollapsed" class="truncate">{{ __('Settings') }}</span>
                    </a>

                    <div class="border-t border-white/10 pt-3">
                        <x-desktop-user-menu />
                    </div>
                </div>
            </aside>

            {{-- Main application area --}}
            <div
                class="min-h-screen transition-[padding-left] duration-200"
                :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'"
            >
                {{-- Header --}}
                <header class="sticky top-0 z-30 border-b border-sp-border bg-sp-surface/95 backdrop-blur">
                    <div class="flex h-16 items-center gap-3 px-4 sm:px-6">
                        <button
                            type="button"
                            x-on:click="mobileSidebarOpen = true"
                            class="flex h-10 w-10 items-center justify-center rounded-lg text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text lg:hidden"
                            aria-label="{{ __('Open navigation') }}"
                        >
                            <x-stockpilot.icon name="menu" class="h-5 w-5" />
                        </button>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-sp-brand-dark dark:text-white">
                                {{ config('app.name', 'StockPilot') }}
                            </p>
                            <p class="hidden truncate text-xs text-sp-text-muted sm:block">
                                {{ __('Sales, inventory & business management') }}
                            </p>
                        </div>

                        {{-- Theme --}}
                        <div
                            x-data="{ open: false }"
                            class="relative"
                        >
                            <button
                                type="button"
                                x-on:click="open = !open"
                                x-on:keydown.escape.window="open = false"
                                x-bind:aria-expanded="open"
                                class="flex h-10 w-10 items-center justify-center rounded-lg text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text"
                                aria-label="{{ __('Appearance') }}"
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

                        {{-- Notifications placeholder --}}
                        <button
                            type="button"
                            class="hidden h-10 w-10 items-center justify-center rounded-lg text-sp-text-muted transition hover:bg-sp-surface-muted hover:text-sp-text sm:flex"
                            aria-label="{{ __('Notifications') }}"
                            title="{{ __('Notifications') }}"
                        >
                            <x-stockpilot.icon name="bell" class="h-5 w-5" />
                        </button>

                        <div class="hidden items-center gap-3 border-s border-sp-border ps-3 sm:flex">
                            <span class="text-xs text-sp-text-muted">
                                {{ auth()->user()->name }}
                            </span>
                        </div>
                    </div>
                </header>

                {{-- Content --}}
                <main class="min-w-0">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
