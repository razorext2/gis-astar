@props([
    'delete' => false,
    'detail' => false,
    'confirm' => false,
    'reschedule' => false,
    'changeCollector' => false,
])

<div class="flex gap-2">
    <div class="inline-flex max-w-10" x-data="{ open: false }">
        <x-button.primary class="h-9 w-9" type="button" @click="open = !open" x-transition="">
            <x-icons.three-dots class="h-4 w-4 rotate-90" />
        </x-button.primary>

        <!-- Dropdown menu -->
        <div class="relative" x-show="open" @click.outside="open = false"
            x-transition:enter="transition ease-in duration-200"
            x-transition:enter-start="transform opacity-0 -translate-x-2"
            x-transition:enter-end="transform opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="transform opacity-100 translate-x-0"
            x-transition:leave-end="transform opacity-0 -translate-x-2">
            <ul
                class="absolute -top-10 left-2 z-50 flex w-auto flex-col rounded-xl bg-white text-sm text-zinc-700 shadow-md ring-1 ring-blue-500 dark:bg-zinc-800 dark:text-zinc-200 dark:ring-0 md:flex-row">
                @foreach ($datas as $item)
                    <li>
                        <a class="{{ $item['id'] == 'delete-btn' ? 'text-red-500 hover:bg-red-500 hover:text-white' : 'hover:bg-zinc-100 dark:hover:bg-zinc-700 dark:text-white' }} block rounded-md px-4 py-2.5 transition-colors duration-300 ease-in-out"
                            id="{{ $item['id'] }}" data-id="{{ $id }}" href="{{ $item['action'] }}"
                            data-userid="{{ Crypt::encryptString(auth()->user()->id) }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach

                @if ($detail)
                    <li>
                        <button
                            class="block rounded-md px-4 py-2.5 transition-colors duration-300 ease-in-out hover:bg-zinc-100 hover:text-white dark:text-white dark:hover:bg-zinc-700"
                            id="detail-btn" wire:click="$dispatch('detail', {id: {{ $id }}})"
                            data-userid="{{ Crypt::encryptString(auth()->user()->id) }}"
                            wire:key="detail-btn-{{ $id }}">
                            Confirm
                        </button>
                    </li>
                @endif


                @if ($reschedule)
                    <li>
                        <button
                            class="flex w-full items-center gap-2 rounded-md px-4 py-2.5 text-amber-600 transition-colors duration-300 ease-in-out hover:bg-amber-500 hover:text-white dark:text-amber-400 dark:hover:bg-amber-600 dark:hover:text-white"
                            id="reschedule-btn-{{ $id }}"
                            onclick="Livewire.dispatch('reschedule', {id: {{ $id }}})">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Reschedule
                        </button>
                    </li>
                @endif

                @if ($changeCollector)
                    <li>
                        <button
                            class="flex w-full items-center gap-2 rounded-md px-4 py-2.5 text-blue-600 transition-colors duration-300 ease-in-out hover:bg-blue-500 hover:text-white dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white"
                            id="change-collector-btn-{{ $id }}"
                            onclick="Livewire.dispatch('changeCollector', {id: {{ $id }}})">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Ganti Kolektor
                        </button>
                    </li>
                @endif

                @if ($delete)
                    <li>
                        <button
                            class="block rounded-md px-4 py-2.5 text-red-500 transition-colors duration-300 ease-in-out hover:bg-red-500 hover:text-white"
                            id="delete-btn" wire:click="$dispatch('delete', {id: {{ $id }}})"
                            wire:key="delete-btn-{{ $id }}">
                            Hapus
                        </button>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    @if ($confirm)
        <livewire:handler.sales.validate-sales id="{{ $id }}" wire:key="salesid-{{ $id }}"
            :showDetail="true" />
    @endif
</div>
