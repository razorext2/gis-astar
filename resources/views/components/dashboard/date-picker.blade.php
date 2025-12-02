<label class="sr-only mb-2 text-sm font-medium text-gray-900 dark:text-white"
    for="{{ $id }}">{{ $text }}</label>
<div class="relative">
    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
        <x-icons.date class="h-4 w-4 text-gray-500 dark:text-gray-400" />
    </div>
    <input
        class="block w-full rounded-lg border border-gray-300 bg-white px-2.5 py-4 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        id="{{ $id }}" name="{{ $name }}" type="text" datepicker datepicker-buttons
        datepicker-autoselect-today datepicker-format="yyyy-mm-dd" placeholder="{{ $text }}" autocomplete="off"
        datepicker-autohide>

    <x-button.primary class="absolute bottom-2 end-2" id="search" type="submit">
        <x-slot name="icon">
            <x-icons.search class="h-4 w-4 dark:stroke-white" />
        </x-slot>
        Search
    </x-button.primary>
</div>
