@props([
    'name',
])

@error($name)
    <p
        {{ $attributes->merge([
            'class' => 'text-sm leading-5 text-sp-danger',
        ]) }}
        role="alert"
    >
        {{ $message }}
    </p>
@enderror
