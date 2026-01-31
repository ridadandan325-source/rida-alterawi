@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active fw-bold text-primary bg-light border-start border-primary border-4 ps-3'
            : 'nav-link text-secondary ps-3';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>