{{-- Goal: Filter bar component with collapsible search parameters, Livewire: None, Alpine: open --}}
<div id="filter-bar" x-data="{ open: false }">
    <h2>
        <button
            class="flex w-full items-center justify-between gap-3 rounded-lg border border-zinc-200 p-2.5 font-medium text-zinc-500 hover:bg-zinc-100 dark:border-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-800"
            type="button" @click="open = ! open">
            <span>Filter data...</span>
            <x-icons.chevron-up class="h-3 w-3 shrink-0 transform transition-transform duration-300"
                x-bind:class="{ 'rotate-180': open }" />
        </button>
    </h2>

    {{-- body --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-5" x-transition:enter-end="opacity-100 "
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 "
        x-transition:leave-end="opacity-0 -translate-y-5">
        <div class="grid grid-cols-2 gap-2 pt-2 md:gap-4 md:pt-4">

            {{ $slot }}

            <div class="col-span-2 mx-auto w-full">
                <div class="mx-auto flex w-fit flex-row gap-2">
                    <x-button.primary :id="'cari'" :type="'button'" :text="'Search'">
                        <x-icons.search class="h-4 w-4"></x-icons.search>
                    </x-button.primary>

                    <x-button.danger :id="'clear'" :type="'button'" :text="'Clear'">
                        <x-icons.plus class="h-4 w-4 rotate-45"></x-icons.plus>
                    </x-button.danger>

                </div>
            </div>

        </div>
    </div>
</div>
