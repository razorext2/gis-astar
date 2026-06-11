{{-- Goal: Powergrid table header export actions, Livewire: N/A, Alpine: N/A --}}
<div x-data="{ open: false, countChecked: @entangle('checkboxValues').live }" x-on:keydown.esc="open = false" x-on:click.outside="open = false;">
    <button @click.prevent="open = true"
        class="focus:ring-primary-600 focus-within:focus:ring-primary-600 focus-within:ring-primary-600 dark:focus-within:ring-primary-600 flex w-auto rounded-md rounded-md border-0 bg-transparent bg-white px-3 py-2 text-gray-600 ring-0 ring-1 ring-zinc-200 transition placeholder:text-gray-400 focus-within:ring-2 focus:outline-none dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:placeholder-pg-primary-400 dark:ring-pg-primary-600 sm:text-sm sm:leading-6">
        <div class="flex">
            <x-livewire-powergrid::icons.download class="h-5 w-5 text-pg-primary-500 dark:text-pg-primary-300" />
        </div>
    </button>

    <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-10 mt-2 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-pg-primary-700"
        tabindex="-1" @keydown.tab="open = false" @keydown.enter.prevent="open = false;"
        @keyup.space.prevent="open = false;">
        @if (in_array('xlsx', data_get($setUp, 'exportable.type')))
            <div
                class="flex items-center border-b border-pg-primary-100 px-4 py-1 text-pg-primary-400 dark:border-pg-primary-600 dark:text-pg-primary-300">
                <span class="w-12">@lang('XLSX')</span>
                <button wire:click.prevent="exportToXLS" x-on:click="open = false" href="#"
                    class="hover:text-black-300 block rounded px-2 py-1 text-pg-primary-800 hover:bg-pg-primary-100 dark:text-pg-primary-200 dark:hover:bg-pg-primary-800">
                    <span class="export-count text-xs">({{ $this->total }})</span>
                    @if (count($enabledFilters) === 0)
                        @lang('livewire-powergrid::datatable.labels.all')
                    @else
                        @lang('livewire-powergrid::datatable.labels.filtered')
                    @endif

                </button>
                @if ($checkbox)
                    <button wire:click.prevent="exportToXLS(true)" x-on:click="open = false"
                        x-bind:disabled="countChecked.length === 0"
                        :class="{ 'cursor-not-allowed': countChecked.length === 0 }"
                        class="hover:text-black-300 block rounded px-2 py-1 text-pg-primary-800 hover:bg-pg-primary-100 dark:text-pg-primary-200 dark:hover:bg-pg-primary-800">
                        <span class="export-count text-xs" x-text="`(${countChecked.length})`"></span> @lang('livewire-powergrid::datatable.labels.selected')
                    </button>
                @endif
            </div>
        @endif
        @if (in_array('csv', data_get($setUp, 'exportable.type')))
            <div class="flex items-center px-4 py-1 text-pg-primary-400 dark:text-pg-primary-300">
                <span class="w-12">@lang('Csv')</span>
                <button wire:click.prevent="exportToCsv" x-on:click="open = false"
                    class="hover:text-black-300 block rounded px-2 py-1 text-pg-primary-800 hover:bg-pg-primary-100 dark:text-pg-primary-200 dark:hover:bg-pg-primary-800">
                    <span class="export-count text-xs">({{ $this->total }})</span>
                    @if (count($enabledFilters) === 0)
                        @lang('livewire-powergrid::datatable.labels.all')
                    @else
                        @lang('livewire-powergrid::datatable.labels.filtered')
                    @endif
                </button>
                @if ($checkbox)
                    <button wire:click.prevent="exportToCsv(true)" x-on:click="open = false"
                        :class="{ 'cursor-not-allowed': countChecked.length === 0 }"
                        class="hover:text-black-300 block rounded px-2 py-1 text-pg-primary-800 hover:bg-pg-primary-100 dark:text-pg-primary-200 dark:hover:bg-pg-primary-800">
                        <span class="export-count text-xs" x-text="`(${countChecked.length})`"></span> @lang('livewire-powergrid::datatable.labels.selected')
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>
