@props([
    'sidebar' => false,
    'href' => null,
])

@php
    $logoHref = $href ?? route('dashboard');
@endphp

<a
    href="{{ $logoHref }}"
    wire:navigate
    {{ $attributes->merge([
        'class' => 'inline-flex min-w-0 items-center gap-3 shrink-0',
    ]) }}
    aria-label="{{ config('app.name', 'StockPilot') }}"
>
    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-sp-brand-dark text-white shadow-sm">
        <x-app-logo-icon class="h-6 w-6" />
    </span>

    @unless ($sidebar)
        <span class="truncate text-lg font-bold tracking-tight text-sp-brand-dark dark:text-white">
            {{ config('app.name', 'StockPilot') }}
        </span>
    @endunless
</a>
