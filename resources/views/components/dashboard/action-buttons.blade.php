{{-- Goal: Render a dropdown of actions (such as detail, assign, delete, reschedule) for data table rows, Livewire: None, Alpine: x-data="{ open: false, dropdownStyle: '', dropUp: false }" --}}
@props([
    'delete' => false,
    'detail' => false,
    'confirm' => false,
    'reschedule' => false,
    'changeCollector' => false,
    'navigate' => false,
])

<div class="flex gap-2">
    <div class="relative inline-flex" x-data="{
        open: false,
        dropdownStyle: '',
        dropUp: false,
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    const btn = document.getElementById('action-btn-{{ $id }}');
                    if (!btn) return;
                    const rect = btn.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - rect.bottom;
                    if (spaceBelow < 220) {
                        this.dropdownStyle = 'top: auto; bottom: ' + (window.innerHeight - rect.top + 6) + 'px; left: ' + rect.left + 'px; position: fixed;';
                        this.dropUp = true;
                    } else {
                        this.dropdownStyle = 'top: ' + (rect.bottom + 6) + 'px; bottom: auto; left: ' + rect.left + 'px; position: fixed;';
                        this.dropUp = false;
                    }
                });
            }
        }
    }" @scroll.window.capture="open = false">
        <button type="button" id="action-btn-{{ $id }}" @click="toggle()"
            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-zinc-200 text-zinc-500 shadow-sm transition-all duration-200 hover:bg-zinc-50 hover:text-zinc-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'"
            :class="open ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : ''">
            <x-icons.three-dots class="h-4 w-4 rotate-90" />
        </button>

        <!-- Dropdown menu -->
        <template x-teleport="body">
            <div x-show="open"
                @click.outside="if (!$event.target.closest('#action-btn-{{ $id }}')) open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="z-50 w-48 rounded-xl border border-zinc-200 p-1 dark:border-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'"
                :class="dropUp ? 'origin-bottom-left' : 'origin-top-left'" :style="dropdownStyle"
                style="display: none;">
                <ul class="flex flex-col gap-0.5">
                    @foreach ($datas as $item)
                        @php
                            $isDelete = $item['id'] == 'delete-btn' || str_contains($item['id'], 'delete');
                            $isEdit = $item['id'] == 'edit-btn' || str_contains($item['id'], 'edit');
                            $isShow =
                                $item['id'] == 'show-btn' ||
                                str_contains($item['id'], 'show') ||
                                str_contains($item['id'], 'detail');
                        @endphp
                        <li>
                            <a class="{{ $isDelete ? 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }} flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200"
                                id="{{ $item['id'] }}" data-id="{{ $id }}" href="{{ $item['action'] }}"
                                {{ $item['navigate'] ?? $navigate ? 'wire:navigate' : '' }}
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
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-blue-600 transition-all duration-200 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/30"
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
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-amber-600 transition-all duration-200 hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-950/30"
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
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-blue-600 transition-all duration-200 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/30"
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
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition-all duration-200 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30"
                                id="delete-btn" wire:click="$dispatch('delete', {id: {{ $id }}})"
                                wire:key="delete-btn-{{ $id }}">
                                <x-icons.trash class="h-4 w-4 flex-shrink-0" />
                                Hapus
                            </button>
                        </li>
                    @endif
                </ul>
            </div>
        </template>
    </div>

    @if ($confirm)
        <livewire:handler.sales.validate-sales id="{{ $id }}" wire:key="salesid-{{ $id }}"
            :showDetail="true" />
    @endif
</div>
