{{-- Goal: Modal checklist bulk approve laporan produksi, Livewire: Handler\ProductionHistories\BulkApproveHistories, Alpine: false --}}
<div>
    <x-modal.base-modal show="showModal" title="Approve Laporan Produksi" subtitle="Pilih laporan yang akan disetujui"
        iconContainerClass="bg-green-600 shadow-green-500/20" maxWidth="2xl">
        <x-slot name="icon">
            <x-icons.check-circle class="h-5 w-5" />
        </x-slot>

        @if ($this->histories->isEmpty())
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="rounded-full bg-zinc-100 p-4 dark:bg-zinc-800">
                    <x-icons.clipboard class="h-8 w-8 text-zinc-400" />
                </div>
                <h3 class="mt-4 text-sm font-semibold text-zinc-900 dark:text-white">
                    Tidak ada laporan pending
                </h3>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                    Semua laporan produksi sudah disetujui atau belum ada laporan yang diajukan.
                </p>
            </div>
        @else
            {{-- Summary Info --}}
            <div class="dark: mb-4 flex items-center justify-between rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <div class="flex items-center gap-2">
                    <x-icons.info-circle class="h-4 w-4 shrink-0 text-zinc-400" />
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        <span class="font-semibold text-zinc-900 dark:text-white">{{ $this->histories->count() }}</span>
                        laporan pending menunggu persetujuan
                    </p>
                </div>
                @if (count($selectedIds) > 0)
                    <span
                        class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-bold text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        {{ count($selectedIds) }} dipilih
                    </span>
                @endif
            </div>

            {{-- Checklist Table --}}
            <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                {{-- Select All Header --}}
                <div
                    class="flex items-center gap-3 border-b border-zinc-200 bg-zinc-50 px-4 py-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                    <input type="checkbox" id="select-all-histories" wire:click="toggleSelectAll"
                        @checked(count($selectedIds) === $this->histories->count() && $this->histories->count() > 0)
                        class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:ring-offset-zinc-800">
                    <label for="select-all-histories"
                        class="cursor-pointer text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Pilih Semua ({{ $this->histories->count() }} laporan)
                    </label>
                </div>

                {{-- History Items --}}
                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach ($this->histories as $history)
                        @php
                            $statusLabel = ucfirst($history->status_produksi_description['label'] ?? '-');
                            $isSelected = in_array((string) $history->id, $selectedIds);
                        @endphp
                        <label for="history-{{ $history->id }}" wire:key="bulk-history-{{ $history->id }}"
                            class="{{ $isSelected ? 'bg-green-50/50 dark:bg-green-900/10' : '' }} flex cursor-pointer items-start gap-3 px-4 py-3.5 transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                            <input type="checkbox" id="history-{{ $history->id }}" wire:model.live="selectedIds"
                                value="{{ $history->id }}"
                                class="mt-0.5 h-4 w-4 shrink-0 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:ring-offset-zinc-800">
                            <div class="flex min-w-0 flex-1 flex-col gap-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="truncate text-sm font-semibold text-zinc-900 dark:text-white">
                                        {{ $history->judul }}
                                    </span>
                                    <span
                                        class="rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-600 ring-1 ring-blue-600/10 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                                <p class="line-clamp-2 text-xs leading-relaxed text-zinc-500 dark:text-zinc-400">
                                    {{ $history->keterangan }}
                                </p>
                                <div class="flex items-center gap-3 text-[10px] italic text-zinc-400">
                                    <span>Oleh: <span
                                            class="font-medium not-italic text-zinc-600 dark:text-zinc-400">{{ $history->addedBy?->name ?? 'Sistem' }}</span></span>
                                    <span>·</span>
                                    <span>{{ \Carbon\Carbon::parse($history->created_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <x-slot name="footer">
            <x-button.secondary @click="open = false">
                Batal
            </x-button.secondary>

            @if (!$this->histories->isEmpty())
                <x-button.primary id="btn-bulk-approve" wire:click="approveSelected" wire:loading.attr="disabled"
                    wire:target="approveSelected" :disabled="count($selectedIds) === 0">
                    <x-slot name="icon">
                        <x-icons.check-circle class="h-4 w-4" wire:loading.remove wire:target="approveSelected" />
                        <x-icons.loading wire:loading wire:target="approveSelected" class="h-4 w-4 animate-spin" />
                    </x-slot>
                    <span wire:loading.remove wire:target="approveSelected">
                        Setujui {{ count($selectedIds) > 0 ? '(' . count($selectedIds) . ')' : '' }}
                    </span>
                    <span wire:loading wire:target="approveSelected">Memproses...</span>
                </x-button.primary>
            @endif
        </x-slot>
    </x-modal.base-modal>
</div>
