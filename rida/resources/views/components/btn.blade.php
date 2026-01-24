@props(['variant' => 'secondary'])

@php
  $base = "inline-flex items-center justify-center rounded-2xl px-4 py-2.5 text-sm font-semibold transition shadow-sm focus:outline-none focus:ring-2 focus:ring-black/10 dark:focus:ring-white/10";
  $variants = [
    'primary' => "bg-black text-white hover:opacity-90 dark:bg-white dark:text-black",
    'secondary' => "bg-white border border-gray-200 hover:bg-gray-50 dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10",
    'danger' => "bg-red-600 text-white hover:opacity-90",
    'blue' => "bg-blue-600 text-white hover:opacity-90",
    'ghost' => "bg-transparent hover:bg-gray-50 dark:hover:bg-white/10 border border-transparent dark:text-white",
  ];
@endphp

<a {{ $attributes->merge(['class' => $base.' '.($variants[$variant] ?? $variants['secondary'])]) }}>
  {{ $slot }}
</a>
