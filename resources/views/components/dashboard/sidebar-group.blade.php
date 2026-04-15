@props([
    'label',
    'icon',
    'routes' => [],
])

@php
    $isActive = collect($routes)->contains(fn($r) => Route::is($r));
    $varName  = 'grp_' . Str::slug($label, '_');
@endphp

<li x-data="{ {{ $varName }}: {{ $isActive ? 'true' : 'false' }} }">
    <button
        class="{{ $isActive ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base transition duration-200"
        type="button"
        @click="{{ $varName }} = !{{ $varName }}"
        :aria-expanded="{{ $varName }}">

        <x-dynamic-component
            :component="'icons.' . $icon"
            class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

        <span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">{{ $label }}</span>

        <x-icons.carred-down
            class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
            x-bind:class="{ 'rotate-180 duration-200': {{ $varName }} }" />
    </button>

    <ul class="space-y-4 py-4"
        x-show="{{ $varName }}"
        x-transition:enter="transition ease-in duration-200"
        x-transition:enter-start="transform opacity-0 -translate-y-5"
        x-transition:leave="transition ease-out duration-200"
        x-transition:leave-end="transform opacity-0 -translate-y-5">
        {{ $slot }}
    </ul>
</li>
