<button data-popover-target="{{ $id }}" data-popover-placement="bottom-end" type="button">
    <svg class="h-4 w-4 text-zinc-400 hover:text-zinc-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
            clip-rule="evenodd"></path>
    </svg>
    <span class="sr-only">Show information</span>
</button>

<div class="invisible absolute z-50 inline-block w-72 rounded-xl border border-zinc-200 bg-white text-sm text-zinc-500 opacity-0 shadow-md transition-opacity duration-300 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400 dark:shadow-none"
    id="{{ $id }}" data-popover role="tooltip">
    <div class="space-y-2 p-3">
        <h3 class="font-semibold text-zinc-900 dark:text-white">Perhatian!</h3>
        <p>
            {{ $slot }}
        </p>
    </div>
    <div data-popper-arrow></div>
</div>
