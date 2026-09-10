<div
    x-data="{ open: false }"
    class="relative"
>
    <button
        type="button"
        x-on:click="open = !open"
        x-bind:aria-expanded="open"
        aria-haspopup="menu"
        data-test="sidebar-menu-button"
        class="flex w-full items-center gap-3 rounded-xl p-2 text-start transition hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/50"
    >
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sp-primary text-sm font-bold text-white">
            {{ auth()->user()->initials() }}
        </span>

        <span class="min-w-0 flex-1">
            <span class="block truncate text-sm font-semibold text-white">
                {{ auth()->user()->name }}
            </span>

            <span class="block truncate text-xs text-white/60">
                {{ auth()->user()->roleEnum()?->label() ?? __('User') }}
            </span>
        </span>

        <x-stockpilot.icon
            name="chevron-right"
            class="h-4 w-4 shrink-0 text-white/50 transition-transform"
            x-bind:class="{ 'rotate-90': open }"
        />
    </button>

    <div
        x-cloak
        x-show="open"
        x-transition.origin.bottom.left
        x-on:click.outside="open = false"
        x-on:keydown.escape.window="open = false"
        role="menu"
        class="absolute bottom-full start-0 z-50 mb-2 w-64 overflow-hidden rounded-xl border border-sp-border bg-sp-surface shadow-xl dark:border-sp-border dark:bg-sp-surface"
    >
        <div class="border-b border-sp-border px-4 py-3">
            <p class="truncate text-sm font-semibold text-sp-text">
                {{ auth()->user()->name }}
            </p>

            <p class="truncate text-xs text-sp-text-muted">
                {{ auth()->user()->email }}
            </p>

            <p class="mt-1 text-xs font-medium text-sp-primary">
                {{ auth()->user()->roleEnum()?->label() ?? __('User') }}
            </p>
        </div>

        <div class="p-1.5">
            <a
                href="{{ route('profile.edit') }}"
                wire:navigate
                role="menuitem"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-sp-text transition hover:bg-sp-surface-muted focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-primary"
            >
                <x-stockpilot.icon
                    name="settings"
                    class="h-4 w-4 text-sp-text-muted"
                />

                {{ __('Settings') }}
            </a>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    role="menuitem"
                    data-test="logout-button"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-sp-danger transition hover:bg-sp-danger/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-danger"
                >
                    <x-stockpilot.icon
                        name="logout"
                        class="h-4 w-4"
                    />

                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>
</div>
