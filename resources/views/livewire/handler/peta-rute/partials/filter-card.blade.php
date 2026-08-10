{{-- Goal: Filter Form Rujukan Pasien & Rumah Sakit --}}
<div class="dark:bg-dark-primary space-y-4 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800 print:hidden">

    <form wire:submit.prevent="search" class="space-y-4">
        <div class="grid grid-cols-1 items-start gap-3.5 sm:gap-4 md:grid-cols-2">

            {{-- 1. Pilih Pasien (Riwayat Rujukan) --}}
            <div class="space-y-1.5">
                <label class="flex items-center gap-1 text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                    <span>Pilih Pasien</span>
                    <span class="text-emerald-500">*</span>
                </label>
                <div class="relative">
                    <select wire:model.live="rujukanId"
                        class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs font-medium text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:border-emerald-500 dark:focus:bg-zinc-900 [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                        <option value="">-- Pilih Pasien Rujukan --</option>
                        @foreach($rujukanList as $r)
                            <option value="{{ $r->id_rujukan }}">{{ $r->pasien?->nama ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- 2. Tujuan Rujukan (Read-only Display matching Select style) --}}
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300">Tujuan Rujukan</label>
                <div class="flex h-9 w-full items-center justify-between rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs font-medium text-zinc-800 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white">
                    <span class="truncate">{{ $rujukan?->rumahSakit?->nama_rumah_sakit ?? 'Otomatis Terisi' }}</span>
                    <x-icons.office-building class="h-3.5 w-3.5 shrink-0 text-zinc-400 dark:text-zinc-400" />
                </div>
            </div>

        </div>

        {{-- Bottom Action Row --}}
        <div class="flex flex-col gap-3 border-t border-zinc-200/60 pt-3 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800/80">

            {{-- Alamat Preview --}}
            <div class="flex flex-wrap items-center gap-2 text-[11px] text-zinc-500">
                @if($selectedPasien)
                    <div class="inline-flex items-center gap-1.5 rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 py-1.5 text-xs font-medium text-zinc-800 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white">
                        <x-icons.map-pin class="h-3.5 w-3.5 shrink-0 text-emerald-500 dark:text-emerald-400" />
                        <span class="font-medium text-zinc-700 dark:text-zinc-200">{{ $selectedPasien->alamat ?? '-' }}</span>
                        <span class="text-zinc-300 dark:text-zinc-600">•</span>
                        <span class="font-mono text-[10px] text-emerald-600 dark:text-emerald-400">Lat: {{ number_format($selectedPasien->latitude, 4) }}, Lng: {{ number_format($selectedPasien->longitude, 4) }}</span>
                    </div>
                @else
                    <span class="text-zinc-400 dark:text-zinc-400 italic">Pilih data pasien untuk melihat detail lokasi</span>
                @endif
            </div>

            {{-- Submit Button --}}
            <div class="flex w-full sm:w-auto">
                <x-button.success type="submit" wire:loading.attr="disabled" wire:target="search" class="h-9 w-full sm:w-auto px-6 text-xs font-semibold">
                    <x-slot name="icon">
                        <x-icons.search wire:loading.remove wire:target="search" class="h-4 w-4" />
                        <x-icons.loading wire:loading wire:target="search" class="h-4 w-4 animate-spin" />
                    </x-slot>
                    <span wire:loading.remove wire:target="search">Tarik Data Rute</span>
                    <span wire:loading wire:target="search">Memproses...</span>
                </x-button.success>
            </div>
        </div>
    </form>
</div>
