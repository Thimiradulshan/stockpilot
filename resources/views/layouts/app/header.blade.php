<header
    class="sticky top-0 z-30 border-b border-sp-border bg-sp-surface/95 backdrop-blur"
>
    <div class="flex min-h-16 items-center justify-between gap-4 px-4 sm:px-6">
        <div class="flex min-w-0 items-center gap-3">
            <button
                type="button"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-sp-border text-sp-text transition hover:bg-sp-surface-muted lg:hidden"
                x-on:click="mobileSidebarOpen = true"
                aria-label="Open navigation"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-sp-text">
                    {{ $title ?? 'StockPilot' }}
                </p>

                <p class="hidden truncate text-xs text-sp-text-muted sm:block">
                    Sales, Inventory & Business Management
                </p>
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-2">
            <div x-data="{ open: false }" class="relative">
                <button
                    type="button"
                    class="inline-flex h-10 items-center gap-2 rounded-lg border border-sp-border bg-sp-surface px-3 text-sm font-medium text-sp-text transition hover:bg-sp-surface-muted"
                    x-on:click="open = !open"
                    :aria-expanded="open"
                >
                    <span
                        class="flex h-7 w-7 items-center justify-center rounded-md bg-sp-surface-muted"
                        aria-hidden="true"
                    >
                        <template x-if="$store.theme.theme === 'light'">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="4" />
                                <path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.65 17.65l1.42 1.42M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.65 6.35l1.42-1.42" />
                            </svg>
                        </template>

                        <template x-if="$store.theme.theme === 'dark'">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                            </svg>
                        </template>

                        <template x-if="$store.theme.theme === 'system'">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="14" rx="2" />
                                <path stroke-linecap="round" d="M8 20h8M12 18v2" />
                            </svg>
                        </template>
                    </span>

                    <span class="hidden sm:inline">Theme</span>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition.origin.top.right
                    x-on:click.outside="open = false"
                    class="absolute right-0 top-12 z-50 w-44 rounded-xl border border-sp-border bg-sp-surface p-1.5 shadow-xl"
                >
                    <button
                        type="button"
                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-sp-text hover:bg-sp-surface-muted"
                        x-on:click="$store.theme.set('light'); open = false"
                    >
                        <span>Light</span>
                        <span x-show="$store.theme.theme === 'light'" class="text-sp-primary">✓</span>
                    </button>

                    <button
                        type="button"
                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-sp-text hover:bg-sp-surface-muted"
                        x-on:click="$store.theme.set('dark'); open = false"
                    >
                        <span>Dark</span>
                        <span x-show="$store.theme.theme === 'dark'" class="text-sp-primary">✓</span>
                    </button>

                    <button
                        type="button"
                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm text-sp-text hover:bg-sp-surface-muted"
                        x-on:click="$store.theme.set('system'); open = false"
                    >
                        <span>System</span>
                        <span x-show="$store.theme.theme === 'system'" class="text-sp-primary">✓</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
