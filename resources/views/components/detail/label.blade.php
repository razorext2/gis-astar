@props(['label', 'id'])

<div
    {{ $attributes->merge(['class' => 'col-span-2 flex flex-col items-start rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1']) }}>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $label }}</p>
    <p class="text-navy-700 text-base font-medium dark:text-white" id="{{ $id }}">
        {{ $slot }}
    </p>
</div>
