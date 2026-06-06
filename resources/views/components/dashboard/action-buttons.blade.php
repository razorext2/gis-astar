{{-- Goal: Render a dropdown of actions (such as detail, assign, delete, reschedule) for data table rows, Livewire: None, Alpine: x-data="{ open: false }" --}}
@props([
    'delete' => false,
    'detail' => false,
    'confirm' => false,
    'reschedule' => false,
    'changeCollector' => false,
    'navigate' => false,
])

<div class="flex gap-2">
    <div class="relative inline-flex" x-data="{ open: false }">
        <button type="button" @click="open = !open"
            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 bg-white/60 text-zinc-500 shadow-sm backdrop-blur-md transition-all duration-200 hover:bg-zinc-50 hover:text-zinc-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-800 dark:bg-zinc-900/60 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
            :class="open ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : ''">
            <x-icons.three-dots class="h-4 w-4 rotate-90" />
        </button>

        <!-- Dropdown menu -->
        <div x-show="open" @click.outside="open = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute left-0 top-full z-50 mt-1.5 w-48 origin-top-left rounded-xl border border-zinc-200 bg-white/95 p-1 shadow-lg backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/95"
            style="display: none;">
            <ul class="flex flex-col gap-0.5">
                @foreach ($datas as $item)
                    @php
                        $isDelete = $item['id'] == 'delete-btn' || str_contains($item['id'], 'delete');
                        $isEdit = $item['id'] == 'edit-btn' || str_contains($item['id'], 'edit');
                        $isShow = $item['id'] == 'show-btn' || str_contains($item['id'], 'show') || str_contains($item['id'], 'detail');
                    @endphp
                    <li>
                        <a class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 {{ $isDelete ? 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}"
                            id="{{ $item['id'] }}" data-id="{{ $id }}" href="{{ $item['action'] }}"
                            {{ ($item['navigate'] ?? $navigate) ? 'wire:navigate' : '' }}
                            data-userid="{{ Crypt::encryptString(auth()->user()->id) }}">
                            @if ($isShow)
                                <x-icons.eye class="h-4 w-4 flex-shrink-0" />
                            @elseif ($isEdit)
                                <x-icons.pen class="h-4 w-4 flex-shrink-0" />
                            @elseif ($isDelete)
                                <x-icons.trash class="h-4 w-4 flex-shrink-0" />
                            @endif
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach

                @if ($detail)
                    <li>
                        <button
                            class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/30 transition-all duration-200"
                            id="detail-btn" wire:click="$dispatch('detail', {id: {{ $id }}})"
                            data-userid="{{ Crypt::encryptString(auth()->user()->id) }}"
                            wire:key="detail-btn-{{ $id }}">
                            <x-icons.check-circle class="h-4 w-4 flex-shrink-0" />
                            Confirm
                        </button>
                    </li>
                @endif

                @if ($reschedule)
                    <li>
                        <button
                            class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-amber-600 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-950/30 transition-all duration-200"
                            id="reschedule-btn-{{ $id }}"
                            onclick="Livewire.dispatch('reschedule', {id: {{ $id }}})">
                            <x-icons.calendar class="h-4 w-4 flex-shrink-0" />
                            Reschedule
                        </button>
                    </li>
                @endif

                @if ($changeCollector)
                    <li>
                        <button
                            class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/30 transition-all duration-200"
                            id="change-collector-btn-{{ $id }}"
                            onclick="Livewire.dispatch('changeCollector', {id: {{ $id }}})">
                            <x-icons.user class="h-4 w-4 flex-shrink-0" />
                            Ganti Kolektor
                        </button>
                    </li>
                @endif

                @if ($delete)
                    <li>
                        <button
                            class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30 transition-all duration-200"
                            id="delete-btn" wire:click="$dispatch('delete', {id: {{ $id }}})"
                            wire:key="delete-btn-{{ $id }}">
                            <x-icons.trash class="h-4 w-4 flex-shrink-0" />
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

