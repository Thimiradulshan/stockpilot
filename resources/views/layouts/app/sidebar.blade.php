<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-sp-background text-sp-text antialiased">
        <flux:sidebar
            sticky
            collapsible
            class="border-e border-white/10 bg-sp-brand-dark text-white"
        >
            {{-- Brand --}}
            <flux:sidebar.header class="border-b border-white/10 px-3">
                <x-app-logo
                    :sidebar="true"
                    href="{{ route('dashboard') }}"
                    wire:navigate
                />

                <flux:sidebar.collapse
                    class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2 text-white/75 hover:bg-white/10 hover:text-white"
                />
            </flux:sidebar.header>

            {{-- Navigation --}}
            <flux:sidebar.nav class="px-2 py-4">
                {{-- Workspace label --}}
                <div class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white/50 in-data-flux-sidebar-collapsed-desktop:hidden">
                    {{ __('Workspace') }}
                </div>

                {{-- Dashboard --}}
                <flux:sidebar.item
                    icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate
                    tooltip="{{ __('Dashboard') }}"
                    class="!text-white/80 hover:!bg-white/10 hover:!text-white data-current:!bg-sp-primary data-current:!text-white"
                >
                    {{ __('Dashboard') }}
                </flux:sidebar.item>

                {{-- Products --}}
                @can('viewAny', App\Models\Product::class)
                    <flux:sidebar.item
                        icon="cube"
                        :href="route('admin.products.index')"
                        :current="request()->routeIs('admin.products.*')"
                        wire:navigate
                        tooltip="{{ __('Products') }}"
                        class="!text-white/80 hover:!bg-white/10 hover:!text-white data-current:!bg-sp-primary data-current:!text-white"
                    >
                        {{ __('Products') }}
                    </flux:sidebar.item>
                @endcan

                {{-- Suppliers --}}
                @can('viewAny', App\Models\Supplier::class)
                    <flux:sidebar.item
                        icon="truck"
                        :href="route('admin.suppliers.index')"
                        :current="request()->routeIs('admin.suppliers.*')"
                        wire:navigate
                        tooltip="{{ __('Suppliers') }}"
                        class="!text-white/80 hover:!bg-white/10 hover:!text-white data-current:!bg-sp-primary data-current:!text-white"
                    >
                        {{ __('Suppliers') }}
                    </flux:sidebar.item>
                @endcan

                {{-- Customers --}}
                @can('viewAny', App\Models\Customer::class)
                    <flux:sidebar.item
                        icon="users"
                        :href="route('admin.customers.index')"
                        :current="request()->routeIs('admin.customers.*')"
                        wire:navigate
                        tooltip="{{ __('Customers') }}"
                        class="!text-white/80 hover:!bg-white/10 hover:!text-white data-current:!bg-sp-primary data-current:!text-white"
                    >
                        {{ __('Customers') }}
                    </flux:sidebar.item>
                @endcan

                {{-- Operations label --}}
                @can('viewAny', App\Models\Purchase::class)
                    <div class="mt-6 px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white/50 in-data-flux-sidebar-collapsed-desktop:hidden">
                        {{ __('Operations') }}
                    </div>

                    <flux:sidebar.item
                        icon="shopping-cart"
                        :href="route('admin.purchases.index')"
                        :current="request()->routeIs('admin.purchases.*')"
                        wire:navigate
                        tooltip="{{ __('Purchasing') }}"
                        class="!text-white/80 hover:!bg-white/10 hover:!text-white data-current:!bg-sp-primary data-current:!text-white"
                    >
                        {{ __('Purchasing') }}
                    </flux:sidebar.item>
                @endcan

                {{-- Administration label --}}
                @can('viewAny', App\Models\User::class)
                    <div class="mt-6 px-3 py-2 text-xs font-semibold uppercase tracking-wider text-white/50 in-data-flux-sidebar-collapsed-desktop:hidden">
                        {{ __('Administration') }}
                    </div>

                    <flux:sidebar.item
                        icon="user-group"
                        :href="route('admin.users.index')"
                        :current="request()->routeIs('admin.users.*')"
                        wire:navigate
                        tooltip="{{ __('Users') }}"
                        class="!text-white/80 hover:!bg-white/10 hover:!text-white data-current:!bg-sp-primary data-current:!text-white"
                    >
                        {{ __('Users') }}
                    </flux:sidebar.item>
                @endcan
            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            {{-- Footer navigation --}}
            <flux:sidebar.nav class="border-t border-white/10 px-2 py-3">
                <flux:sidebar.item
                    icon="cog-6-tooth"
                    :href="route('profile.edit')"
                    :current="request()->routeIs('profile.*')"
                    wire:navigate
                    tooltip="{{ __('Settings') }}"
                    class="!text-white/80 hover:!bg-white/10 hover:!text-white data-current:!bg-sp-primary data-current:!text-white"
                >
                    {{ __('Settings') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            {{-- User area --}}
            <div class="border-t border-white/10 p-2">
                <x-desktop-user-menu class="hidden lg:block" />
            </div>
        </flux:sidebar>

        {{-- Desktop header --}}
        <flux:header
            class="hidden border-b border-sp-border bg-sp-surface lg:flex"
        >
            <div class="flex min-w-0 flex-1 items-center">
                <div class="min-w-0">
                    <div class="truncate text-sm font-semibold text-sp-text">
                        {{ config('app.name', 'StockPilot') }}
                    </div>

                    <div class="truncate text-xs text-sp-text-muted">
                        Sales, inventory & business management
                    </div>
                </div>
            </div>

            <flux:spacer />

            <div class="flex items-center gap-1">
                <flux:tooltip
                    :content="__('Appearance')"
                    position="bottom"
                >
                    <flux:dropdown
                        x-data
                        align="end"
                    >
                        <flux:button
                            variant="subtle"
                            square
                            aria-label="{{ __('Appearance') }}"
                        >
                            <flux:icon.sun
                                x-show="$flux.appearance === 'light'"
                                variant="mini"
                            />

                            <flux:icon.moon
                                x-show="$flux.appearance === 'dark'"
                                variant="mini"
                            />

                            <flux:icon.moon
                                x-show="$flux.appearance === 'system' && $flux.dark"
                                variant="mini"
                            />

                            <flux:icon.sun
                                x-show="$flux.appearance === 'system' && ! $flux.dark"
                                variant="mini"
                            />
                        </flux:button>

                        <flux:menu>
                            <flux:menu.item
                                icon="sun"
                                x-on:click="$flux.appearance = 'light'"
                            >
                                {{ __('Light') }}
                            </flux:menu.item>

                            <flux:menu.item
                                icon="moon"
                                x-on:click="$flux.appearance = 'dark'"
                            >
                                {{ __('Dark') }}
                            </flux:menu.item>

                            <flux:menu.item
                                icon="computer-desktop"
                                x-on:click="$flux.appearance = 'system'"
                            >
                                {{ __('System') }}
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </flux:tooltip>

                <flux:tooltip
                    :content="__('Notifications')"
                    position="bottom"
                >
                    <flux:button
                        variant="subtle"
                        square
                        icon="bell"
                        aria-label="{{ __('Notifications') }}"
                    />
                </flux:tooltip>

                <flux:tooltip
                    :content="__('Settings')"
                    position="bottom"
                >
                    <flux:button
                        variant="subtle"
                        square
                        icon="cog-6-tooth"
                        :href="route('profile.edit')"
                        wire:navigate
                        aria-label="{{ __('Settings') }}"
                    />
                </flux:tooltip>
            </div>

            <div class="ms-3 border-s border-sp-border ps-3">
                <x-desktop-user-menu />
            </div>
        </flux:header>

        {{-- Mobile header --}}
        <flux:header
            class="border-b border-sp-border bg-sp-surface lg:hidden"
        >
            <flux:sidebar.toggle
                icon="bars-2"
                inset="left"
            />

            <x-app-logo
                href="{{ route('dashboard') }}"
                wire:navigate
            />

            <flux:spacer />

            <flux:dropdown
                x-data
                align="end"
            >
                <flux:button
                    variant="subtle"
                    square
                    aria-label="{{ __('Appearance') }}"
                >
                    <flux:icon.sun
                        x-show="$flux.appearance === 'light'"
                        variant="mini"
                    />

                    <flux:icon.moon
                        x-show="$flux.appearance === 'dark'"
                        variant="mini"
                    />

                    <flux:icon.moon
                        x-show="$flux.appearance === 'system' && $flux.dark"
                        variant="mini"
                    />

                    <flux:icon.sun
                        x-show="$flux.appearance === 'system' && ! $flux.dark"
                        variant="mini"
                    />
                </flux:button>

                <flux:menu>
                    <flux:menu.item
                        icon="sun"
                        x-on:click="$flux.appearance = 'light'"
                    >
                        {{ __('Light') }}
                    </flux:menu.item>

                    <flux:menu.item
                        icon="moon"
                        x-on:click="$flux.appearance = 'dark'"
                    >
                        {{ __('Dark') }}
                    </flux:menu.item>

                    <flux:menu.item
                        icon="computer-desktop"
                        x-on:click="$flux.appearance = 'system'"
                    >
                        {{ __('System') }}
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <flux:dropdown align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                />

                <flux:menu>
                    <div class="px-3 py-2">
                        <div class="text-sm font-medium text-sp-text">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="max-w-48 truncate text-xs text-sp-text-muted">
                            {{ auth()->user()->email }}
                        </div>
                    </div>

                    <flux:menu.separator />

                    <flux:menu.item
                        :href="route('profile.edit')"
                        icon="cog-6-tooth"
                        wire:navigate
                    >
                        {{ __('Settings') }}
                    </flux:menu.item>

                    <flux:menu.separator />

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="w-full"
                    >
                        @csrf

                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{-- Application content --}}
        <flux:main class="min-w-0 bg-sp-background">
            {{ $slot }}
        </flux:main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
