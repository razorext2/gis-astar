{{-- Goal: Universal refresh button for PowerGrid tables, dispatches pg:eventRefresh via JS --}}
<div class="mt-2 flex gap-3 sm:mt-0" id="toggle-refresh" wire:key="toggle-refresh-{{ $tableName }}">
    <button type="button" title="Refresh data"
        class="focus:ring-primary-600 focus-within:focus:ring-primary-600 focus-within:ring-primary-600 dark:focus-within:ring-primary-600 flex w-auto rounded-md border-0 bg-transparent bg-white px-3 py-2 text-gray-600 ring-0 ring-1 ring-zinc-200 transition placeholder:text-gray-400 focus-within:ring-2 focus:outline-none dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:placeholder-pg-primary-400 dark:ring-pg-primary-600 sm:text-sm sm:leading-6"
        onclick="
            var icon = document.getElementById('pg-refresh-icon-{{ $tableName }}');
            if (icon) { icon.classList.add('animate-spin'); setTimeout(function(){ icon.classList.remove('animate-spin'); }, 1500); }
            window.dispatchEvent(new CustomEvent('pg:eventRefresh-{{ $tableName }}'));
        ">
        <x-icons.clockwise id="pg-refresh-icon-{{ $tableName }}"
            class="h-5 w-5 text-pg-primary-500 transition-transform duration-300 dark:text-pg-primary-300" />
    </button>
</div>
