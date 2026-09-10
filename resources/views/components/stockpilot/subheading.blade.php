@props([])

<p
    {{ $attributes->merge([
        'class' => 'text-sm leading-6 text-sp-text-muted',
    ]) }}
>
    {{ $slot }}
</p>
