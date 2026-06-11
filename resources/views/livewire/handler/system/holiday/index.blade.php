{{-- Goal: Management interface for national holidays with API integration. Livewire: Handler\System\Holiday\Index, Alpine: Modal handling --}}

<div class="flex flex-col gap-6">
    {{-- Header --}}
    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Libur Nasional</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola daftar hari libur nasional untuk perhitungan cuti.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <x-button.primary wire:click="$set('showCreateModal', true)" class="group !py-3 px-6">
                <x-slot name="icon">
                    <x-icons.plus class="h-5 w-5" />
                </x-slot>
                Tambah Hari Libur
            </x-button.primary>
        </div>
    </div>

    {{-- Main Table Section --}}
    <div
        class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60">
        <livewire:powergrid-tables.holiday-table />
    </div>

    {{-- Fetch API Modal --}}
    <x-modal.base-modal maxWidth="lg" show="showCreateModal" title="Fetch Hari Libur dari API">
        <div class="p-6">
            <div
                class="mb-6 flex items-end gap-3 rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-white/5">
                <div class="flex-1">
                    <label class="mb-1 block text-sm font-bold uppercase tracking-wider text-zinc-500">Tahun</label>
                    <input type="number" wire:model="year"
                        class="w-full rounded-lg border-zinc-200 bg-white text-sm focus:ring-red-500/50 dark:border-zinc-800 dark:bg-zinc-900"
                        placeholder="Contoh: 2026">
                </div>
                <x-button.secondary wire:click="fetchHolidays" class="!py-2.5" wire:loading.attr="disabled"
                    wire:target="fetchHolidays">
                    <x-slot name="icon">
                        <x-icons.cloud-upload class="h-4 w-4" wire:loading.remove wire:target="fetchHolidays" />
                        <x-icons.loading wire:loading wire:target="fetchHolidays" class="h-4 w-4 animate-spin" />
                    </x-slot>

                    <span wire:loading.remove wire:target="fetchHolidays">Cek Data</span>
                    <span wire:loading wire:target="fetchHolidays">Memproses...</span>
                </x-button.secondary>
            </div>

            @if (!empty($holidayOptions))
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            Ditemukan {{ count($holidayOptions) }} hari libur. Pilih yang ingin disimpan:
                        </p>
                        <div class="flex gap-2">
                            <button type="button"
                                @click="$wire.set('selectedHolidays', $wire.holidayOptions.filter(h => !$wire.existingHolidays.includes(h.date)).map(h => h.date))"
                                class="text-xs font-bold text-red-600 hover:underline">Pilih Yang Belum Ada</button>
                            <span class="text-zinc-300">|</span>
                            <button type="button" @click="$wire.set('selectedHolidays', [])"
                                class="text-xs font-bold text-zinc-500 hover:underline">Hapus Semua</button>
                        </div>
                    </div>

                    <div
                        class="grid max-h-[300px] grid-cols-1 overflow-y-auto rounded-xl border border-zinc-200 dark:border-zinc-800">
                        @foreach ($holidayOptions as $holiday)
                            @php $isExists = in_array($holiday['date'], $existingHolidays); @endphp
                            <label
                                class="{{ $isExists ? 'bg-zinc-50/50 dark:bg-white/5' : '' }} flex cursor-pointer items-center justify-between border-b border-zinc-100 px-4 py-3 last:border-0 hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-white/5">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" wire:model="selectedHolidays" value="{{ $holiday['date'] }}"
                                        class="h-5 w-5 rounded border-zinc-300 text-red-600 focus:ring-red-500/50 dark:border-zinc-700 dark:bg-zinc-800">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="{{ $isExists ? 'text-zinc-500' : 'text-zinc-900 dark:text-white' }} text-sm font-bold">{{ $holiday['name'] }}</span>
                                            @if ($isExists)
                                                <span
                                                    class="rounded bg-green-100 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-tighter text-green-700 dark:bg-green-900/30 dark:text-green-400">Tersimpan</span>
                                            @endif
                                        </div>
                                        <span
                                            class="text-[10px] uppercase tracking-wider text-zinc-500">{{ \Carbon\Carbon::parse($holiday['date'])->locale('id')->isoFormat('DD MMMM YYYY') }}</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-4 flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                        <x-button.secondary @click="$wire.set('showCreateModal', false)">Batal</x-button.secondary>
                        <x-button.primary wire:click="saveHolidays" wire:loading.attr="disabled"
                            wire:target="saveHolidays">
                            <x-slot name="icon">
                                <x-icons.check-circle class="h-4 w-4" wire:loading.remove wire:target="saveHolidays" />
                                <x-icons.loading wire:loading wire:target="saveHolidays" class="h-4 w-4 animate-spin" />
                            </x-slot>

                            <span wire:loading.remove wire:target="saveHolidays">Simpan Terpilih</span>
                            <span wire:loading wire:target="saveHolidays">Memproses...</span>
                        </x-button.primary>
                    </div>
                </div>
            @elseif($year && empty($holidayOptions))
                <div class="py-12 text-center">
                    <x-icons.info-circle class="mx-auto mb-3 h-12 w-12 text-zinc-300" />
                    <p class="text-sm text-zinc-500">Klik "Cek Data" untuk mengambil data hari libur nasional dari
                        API.</p>
                </div>
            @endif
        </div>
    </x-modal.base-modal>
</div>
