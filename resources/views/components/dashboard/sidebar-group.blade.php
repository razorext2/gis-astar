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
        class="{{ $isActive ? 'bg-zinc-100/80 dark:bg-white/5 text-red-600 dark:text-red-400 font-bold border-l-4 border-red-600' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }} group relative flex w-full items-center rounded-r-2xl px-4 py-3 transition-all duration-200"
        type="button" @click="{{ $varName }} = !{{ $varName }}" :aria-expanded="{{ $varName }}">

        <div class="flex flex-1 items-center gap-3.5 overflow-hidden">
            <x-dynamic-component :component="'icons.' . $icon"
                class="{{ $isActive ? 'text-red-600' : 'text-zinc-400 group-hover:text-red-600' }} h-5 w-5 flex-shrink-0 transition-colors duration-200" />

            <span class="whitespace-normal break-words text-left text-sm tracking-wide transition-colors duration-200">
                {{ $label }}
            </span>
        </div>

        <x-icons.carred-down
            class="{{ $isActive ? 'text-red-600' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-red-600' }} ml-1 h-4 w-4 flex-shrink-0 transform transition-transform duration-300"
            x-bind:class="{ 'rotate-180': {{ $varName }} }" />
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
