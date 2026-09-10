@props([
    'label' => null,
])

<div class="relative py-2">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-sp-border"></div>
    </div>

    @if ($label)
        <div class="relative flex justify-center">
            <span class="bg-sp-surface px-3 text-xs text-sp-text-subtle">
                {{ $label }}
            </span>
        </div>
    @endif
</div>
