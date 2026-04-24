@props(['labels' => true, 'id', 'name'])

@if ($labels)
    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="{{ $id }}">
        {{ $slot }}
    </label>
@endif

<div class="flex items-center">
    <div
        class="z-10 items-center rounded-s-lg border border-zinc-200 bg-gray-100 px-4 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 focus:outline-none dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-zinc-800">
        +62
    </div>

    <div class="relative w-full">
        <x-input.basic class="z-20 rounded-s-none border-s-0" id="{{ $id }}" name="{{ $name }}"
            placeholder="08123XXXXXX" :labels="false" required />
    </div>
</div>
