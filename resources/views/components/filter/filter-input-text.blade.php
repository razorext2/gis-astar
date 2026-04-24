@props(['name', 'text', 'icon', 'id', 'type' => 'text'])

<div class="relative w-full">
    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
        {{ $slot }}
    </div>

    <input
        class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
        placeholder="Filter by {{ $text }}..." {{ $attributes }} />
</div>
