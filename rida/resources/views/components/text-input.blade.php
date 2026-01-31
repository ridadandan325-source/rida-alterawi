@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'form-control bg-glass-lighter border-glass shadow-sm']) !!}
>