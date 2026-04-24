@props(['class' => '', 'id', 'name', 'labels' => true, 'type' => 'text', 'default' => null])

@if ($labels)
    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
        for="{{ $id }}">{{ $slot }}</label>
@endif

<input
    class="{{ $class }} block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
    id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" default="{{ $default }}"
    {{ $attributes }} />
