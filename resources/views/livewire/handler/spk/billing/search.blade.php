{{-- Goal: Form untuk mencari tagihan BSI, Livewire: Search, Alpine: minimal --}}
<div class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    <div class="mb-6 flex items-center gap-2 border-l-4 border-blue-500 pl-3">
        <h3 class="text-base font-bold text-zinc-900 dark:text-white">Cari Tagihan</h3>
        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30">
            Sinkronisasi BSI
        </span>
    </div>

    <form class="flex w-full flex-col gap-6" wire:submit.prevent="search">
        <div class="space-y-4">
            <div>
                <x-input.select id="tipe_tagihan" name="tipe_tagihan" :labels="true" :textLabel="'Tipe Tagihan'"
                    :defaultOption="'Pilih tipe tagihan...'" :options="collect(config('spk-config.spk_tipe_tagihan'))
                        ->mapWithKeys(fn($row, $key) => [$key => $row['label']])
                        ->toArray()" wire:model.live="form.tipe_tagihan" disabled />

                @error('form.tipe_tagihan')
                    <span class="mt-2 text-xs font-bold text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-input.basic id="nomor_tagihan" name="nomor_tagihan" wire:model="form.nomor_tagihan"
                    type="text" placeholder="Masukkan nomor SR spk..." :labels="true">
                    Nomor SR
                </x-input.basic>

                @error('form.nomor_tagihan')
                    <span class="mt-2 text-xs font-bold text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror

                <div class="mt-2.5 rounded-lg border border-zinc-200 bg-zinc-50 p-3 text-xs text-zinc-500 dark:border-zinc-700 dark:bg-zinc-800/30">
                    <span class="mb-1 block font-bold text-zinc-700 dark:text-zinc-300">Catatan:</span>
                    <ul class="list-inside list-disc space-y-0.5">
                        <li>Gunakan <span class="font-semibold text-zinc-700 dark:text-zinc-300">SR Internal</span> untuk tagihan Non PPN</li>
                        <li>Gunakan <span class="font-semibold text-zinc-700 dark:text-zinc-300">SR PPN</span> untuk tagihan PPN</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-zinc-100 pt-6 dark:border-zinc-800">
            @if ($form->nomor_tagihan)
                <x-button.secondary type="button" id="clear-search"
                    wire:click="clearSearch" wire:loading.attr="disabled" wire:target="clearSearch">
                    <x-slot name="icon">
                        <x-icons.close class="icon h-4 w-4" />
                    </x-slot>
                    Batal
                </x-button.secondary>
            @endif

            <x-button.primary type="submit" id="search" class="!px-6" wire:loading.attr="disabled"
                wire:target="search">
                <x-slot name="icon">
                    <x-icons.angle-right wire:loading.remove wire:target="search" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="search" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="search">Cari Tagihan</span>
                <span wire:loading wire:target="search">Memproses...</span>
            </x-button.primary>
        </div>
    </form>
</div>
