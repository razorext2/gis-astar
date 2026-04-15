@props([
    'href',
    'icon',
    'check'    => [],
    'navigate' => true,
])

@php
    $checks   = is_array($check) ? $check : [$check];
    $isActive = collect($checks)->contains(fn($r) => Route::is($r));
@endphp

<li>
    <a class="{{ $isActive ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
        href="{{ $href }}"
        {{ $navigate ? 'wire:navigate' : '' }}>

        <x-dynamic-component
            :component="'icons.' . $icon"
            class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

        <span class="ms-3 inline-flex text-sm group-hover:text-red-600">{{ $slot }}</span>
    </a>
</li>
