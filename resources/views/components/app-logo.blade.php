@props([
    'sidebar' => false,
])

<a
    href="{{ route('home') }}"
    wire:navigate
    {{ $attributes->merge([
        'class' => 'inline-flex items-center gap-3 shrink-0',
    ]) }}
    aria-label="{{ config('app.name', 'StockPilot') }}"
>
    <span
        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-sp-brand-dark text-white shadow-sm"
    >
        <x-app-logo-icon class="h-6 w-6" />
    </span>

    <span
        @class([
            'font-bold tracking-tight text-sp-brand-dark dark:text-white',
            'hidden' => $sidebar,
        ])
    >
        {{ config('app.name', 'StockPilot') }}
    </span>
</a>
