@props([
    'level' => 2,
    'size' => 'md',
])

@php
    $tag = in_array($level, [1, 2, 3, 4, 5, 6], true) ? "h{$level}" : 'h2';

    $sizeClass = match ($size) {
        'xl' => 'text-2xl sm:text-3xl',
        'lg' => 'text-xl sm:text-2xl',
        'sm' => 'text-sm',
        default => 'text-base',
    };
@endphp

<{{ $tag }}
    {{ $attributes->merge([
        'class' => "font-semibold tracking-tight text-sp-text dark:text-white {$sizeClass}",
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
