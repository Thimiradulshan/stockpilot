@php
    $user = auth()->user();
@endphp

<div
    x-data="{ open: false }"
    class="relative w-full"
>
    {{-- Profile trigger --}}
    <button
        type="button"
        x-on:click.stop="open = !open"
        x-on:keydown.escape.window="open = false"
        x-bind:aria-expanded="open"
        aria-haspopup="menu"
        aria-label="{{ __('Open account menu') }}"
        data-test="sidebar-menu-button"
        class="group flex w-full items-center gap-3 rounded-xl p-2 text-left transition
               hover:bg-white/10
               focus-visible:outline-none
               focus-visible:ring-2
               focus-visible:ring-white/40"
    >
        {{-- Avatar --}}
        <span
            class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full
                   bg-sp-primary text-sm font-bold text-white ring-2 ring-white/10"
        >
            @if ($user->profilePhotoUrl())
                <img
                    src="{{ $user->profilePhotoUrl() }}"
                    alt="{{ $user->name }}"
                    class="h-full w-full object-cover"
                >
            @else
                {{ $user->initials() }}
            @endif
        </span>

        {{-- User information --}}
        <span
            x-show="sidebarIsExpanded()"
            x-transition.opacity.duration.100ms
            class="min-w-0 flex-1"
        >
            <span class="block truncate text-sm font-semibold text-white">
                {{ $user->name }}
            </span>

            <span class="mt-0.5 block truncate text-xs text-white/55">
                {{ $user->roleEnum()->value }}
            </span>
        </span>

        {{-- Chevron --}}
        <span
            x-show="sidebarIsExpanded()"
            x-transition.opacity.duration.100ms
            class="shrink-0 text-white/45 transition-transform duration-200"
            x-bind:class="{ 'rotate-180': open }"
        >
            <x-stockpilot.icon
                name="chevron-down"
                class="h-4 w-4"
            />
        </span>
    </button>

    {{-- Account menu --}}
    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-1 scale-95"
        x-on:click.outside="open = false"
        class="absolute bottom-full start-0 z-[9999] mb-3 w-64 overflow-hidden rounded-xl
               border border-sp-border bg-sp-surface shadow-2xl
               ring-1 ring-black/5"
        role="menu"
        aria-label="{{ __('Account menu') }}"
    >
        {{-- Account information --}}
        <div class="border-b border-sp-border px-4 py-3">
            <div class="flex items-center gap-3">
                <span
                    class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full
                           bg-sp-primary text-sm font-bold text-white"
                >
                    @if ($user->profilePhotoUrl())
                        <img
                            src="{{ $user->profilePhotoUrl() }}"
                            alt="{{ $user->name }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        {{ $user->initials() }}
                    @endif
                </span>

                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-sp-text">
                        {{ $user->name }}
                    </p>

                    <p class="truncate text-xs text-sp-text-muted">
                        {{ $user->email }}
                    </p>

                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wide text-sp-primary">
                        {{ $user->roleEnum()->value }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Menu actions --}}
        <div class="p-1.5">
            {{-- My Profile --}}
            <a
                href="{{ route('profile.edit') }}"
                wire:navigate
                x-on:click="open = false"
                role="menuitem"
                data-test="sidebar-profile-link"
                class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                       text-sp-text transition
                       hover:bg-sp-surface-muted
                       focus-visible:bg-sp-surface-muted
                       focus-visible:outline-none"
            >
                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                           bg-sp-surface-muted text-sp-primary"
                >
                    <x-stockpilot.icon
                        name="user"
                        class="h-4 w-4"
                    />
                </span>

                <span>
                    {{ __('My Profile') }}
                </span>
            </a>

            {{-- Logout --}}
            <form
                method="POST"
                action="{{ route('logout') }}"
                class="mt-1 w-full"
                x-on:submit="open = false"
            >
                @csrf

                <button
                    type="submit"
                    role="menuitem"
                    data-test="sidebar-logout-button"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                           text-sp-danger transition
                           hover:bg-sp-danger/10
                           focus-visible:bg-sp-danger/10
                           focus-visible:outline-none"
                >
                    <span
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg
                               bg-sp-danger/10 text-sp-danger"
                    >
                        <x-stockpilot.icon
                            name="logout"
                            class="h-4 w-4"
                        />
                    </span>

                    <span>
                        {{ __('Log out') }}
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
