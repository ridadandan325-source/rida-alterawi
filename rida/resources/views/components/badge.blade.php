@props(['type' => 'sale'])

@php
  $map = [
    'sale' => "bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-200 dark:border-emerald-500/20",
    'sold' => "bg-gray-100 text-gray-800 border border-gray-200 dark:bg-white/10 dark:text-gray-200 dark:border-white/10",
  ];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ".$map[$type]]) }}>
  {{ $slot }}
</span>
