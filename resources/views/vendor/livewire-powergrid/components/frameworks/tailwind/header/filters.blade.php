<div class="mt-2 flex gap-3 sm:mt-0" id="toggle-filters" wire:key="toggle-filters-{{ $tableName }}')">
    <button
        class="focus:ring-primary-600 focus-within:focus:ring-primary-600 focus-within:ring-primary-600 dark:focus-within:ring-primary-600 flex w-auto rounded-md rounded-md border-0 bg-transparent bg-white px-3 py-2 text-gray-600 ring-0 ring-1 ring-zinc-200 transition placeholder:text-gray-400 focus-within:ring-2 focus:outline-none dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:placeholder-pg-primary-400 dark:ring-pg-primary-600 sm:text-sm sm:leading-6"
        type="button" wire:click="toggleFilters">
        <x-livewire-powergrid::icons.filter class="h-4 w-4 text-pg-primary-500 dark:text-pg-primary-300" />
    </button>
</div>
