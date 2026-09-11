<div
    x-data="{ open: false }"
    class="relative"
>
    <button
        type="button"
        x-on:click="open = !open"
        x-on:keydown.escape.window="open = false"
        x-bind:aria-expanded="open"
        aria-haspopup="menu"
        class="flex items-center rounded-xl p-1 transition hover:bg-sp-surface-muted focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-primary/30"
        aria-label="{{ __('Open profile menu') }}"
        title="{{ __('Profile') }}"
    >
        @if (auth()->user()->profilePhotoUrl())
            <span class="h-9 w-9 overflow-hidden rounded-full bg-sp-info/10 shadow-sm ring-2 ring-sp-primary/10">
                <img
                    src="{{ auth()->user()->profilePhotoUrl() }}"
                    alt="{{ __('Profile photo') }}"
                    class="h-full w-full object-cover"
                >
            </span>
        @else
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-sp-primary text-xs font-bold text-white shadow-sm ring-2 ring-sp-primary/10">
                {{ auth()->user()->initials() }}
            </span>
        @endif

        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="ms-1 hidden h-4 w-4 text-sp-text-muted transition-transform duration-150 sm:block"
            x-bind:class="{ 'rotate-180': open }"
            aria-hidden="true"
        >
            <path d="m6 9 6 6 6-6"/>
        </svg>
    </button>

    <div
        x-cloak
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
        x-on:click.outside="open = false"
        role="menu"
        class="absolute end-0 top-full z-50 mt-2 w-72 overflow-hidden rounded-xl border border-sp-border bg-sp-surface shadow-2xl"
    >
        <div class="border-b border-sp-border bg-sp-info/[0.045] px-4 py-4">
            <div class="flex items-center gap-3">
                @if (auth()->user()->profilePhotoUrl())
                    <span class="h-12 w-12 shrink-0 overflow-hidden rounded-full bg-sp-info/10 shadow-sm">
                        <img
                            src="{{ auth()->user()->profilePhotoUrl() }}"
                            alt="{{ __('Profile photo') }}"
                            class="h-full w-full object-cover"
                        >
                    </span>
                @else
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-sp-primary text-sm font-bold text-white shadow-sm">
                        {{ auth()->user()->initials() }}
                    </span>
                @endif

                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-sp-text">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="mt-0.5 truncate text-xs text-sp-text-muted">
                        {{ auth()->user()->email }}
                    </p>

                    <p class="mt-1 inline-flex rounded-full bg-sp-primary/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-sp-primary">
                        {{ auth()->user()->roleEnum()?->label() ?? __('User') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="p-1.5">
            <a
                href="{{ route('profile.edit') }}"
                wire:navigate
                role="menuitem"
                x-on:click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-sp-text transition hover:bg-sp-surface-muted focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-primary"
            >
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sp-info/10 text-sp-info-foreground">
                    <x-stockpilot.icon
                        name="user"
                        class="h-4 w-4"
                    />
                </span>

                <span class="min-w-0">
                    <span class="block">
                        {{ __('My Profile') }}
                    </span>

                    <span class="mt-0.5 block text-xs font-normal text-sp-text-muted">
                        {{ __('Manage your account information') }}
                    </span>
                </span>
            </a>

            <div class="my-1 border-t border-sp-border"></div>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    role="menuitem"
                    data-test="topbar-logout-button"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-sp-danger transition hover:bg-sp-danger/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sp-danger"
                >
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sp-danger/10 text-sp-danger">
                        <x-stockpilot.icon
                            name="logout"
                            class="h-4 w-4"
                        />
                    </span>

                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>
</div>
