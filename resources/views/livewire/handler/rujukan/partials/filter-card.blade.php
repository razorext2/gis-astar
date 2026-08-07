{{-- Top Filter Card --}}
<div
    class="dark:bg-dark-primary space-y-4 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm transition-all sm:p-5 dark:border-zinc-800">

    <p class="max-w-3xl text-xs leading-relaxed text-zinc-600 sm:text-sm dark:text-zinc-400">
        Pilih pasien untuk menganalisis rujukan ke rumah sakit tujuan. Sistem akan menghitung rute terpendek
        menggunakan algoritma A*.
    </p>

    {{-- 4 Filter Select Inputs --}}
    <div class="grid grid-cols-1 items-start gap-3.5 sm:gap-4 md:grid-cols-4">

        {{-- 1. Pilih Pasien --}}
        <div class="space-y-1.5">
            <label class="flex items-center gap-1 text-xs font-semibold text-zinc-800 dark:text-zinc-200">
                <span>Pilih Pasien</span>
                <span class="text-emerald-500">*</span>
            </label>
            <div class="relative">
                <x-input.select wire:model.live="pasienId" id="pasien-select" name="pasienId" :labels="false"
                    class="shadow-xs h-10 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 pl-9 pr-8 text-xs font-medium text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 sm:h-9 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                    @foreach ($pasienList as $p)
                        <option value="{{ $p->id_pasien }}">{{ $p->nama }}</option>
                    @endforeach
                </x-input.select>
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                    <x-icons.user class="h-4 w-4" />
                </div>
            </div>
        </div>

        {{-- 2. Pilih Tujuan (Rumah Sakit) --}}
        <div class="space-y-1.5">
            <label class="block text-xs font-semibold text-zinc-800 dark:text-zinc-200">Pilih Tujuan (Rumah
                Sakit)</label>
            <x-input.select wire:model="rumahSakitTarget" id="rs-target-select" name="rumahSakitTarget"
                :labels="false"
                class="shadow-xs h-10 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs font-medium text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 sm:h-9 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                <option value="semua">Semua Rumah Sakit</option>
                @foreach ($rumahSakitList as $rs)
                    <option value="{{ $rs->id_rumah_sakit }}">{{ $rs->nama_rumah_sakit }}</option>
                @endforeach
            </x-input.select>
        </div>

        {{-- 3. Metode --}}
        <div class="space-y-1.5">
            <label class="block text-xs font-semibold text-zinc-800 dark:text-zinc-200">Metode</label>
            <x-input.select wire:model="metode" id="metode-select" name="metode" :labels="false"
                class="shadow-xs h-10 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs font-medium text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 sm:h-9 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                <option value="astar">Algoritma A* (A Star)</option>
            </x-input.select>
        </div>

        {{-- 4. Prioritas Rute --}}
        <div class="space-y-1.5">
            <label class="block text-xs font-semibold text-zinc-800 dark:text-zinc-200">Prioritas Rute</label>
            <x-input.select wire:model="prioritasRute" id="prioritas-select" name="prioritasRute" :labels="false"
                class="shadow-xs h-10 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs font-medium text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 sm:h-9 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                <option value="jarak">Jarak Terpendek</option>
                <option value="waktu">Waktu Tercepat</option>
            </x-input.select>
        </div>

    </div>

    {{-- Bottom Bar: Alamat Pasien Preview + Tombol Proses Analisis --}}
    <div
        class="flex flex-col gap-3 border-t border-zinc-200/60 pt-3 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-800/80">

        {{-- Alamat & Koordinat Pasien --}}
        <div class="flex flex-wrap items-center gap-2 text-[11px] text-zinc-500" x-data="{
            get currentPasien() { return pasienList.find(p => p.id_pasien == pasienId); }
        }">
            <div
                class="inline-flex items-center gap-1.5 rounded-xl border border-zinc-200/70 bg-zinc-50 px-3 py-1.5 dark:border-zinc-800/70 dark:bg-zinc-800/50">
                <x-icons.map-pin class="h-3.5 w-3.5 shrink-0 text-emerald-500" />
                <span class="font-medium text-zinc-700 dark:text-zinc-300" x-text="currentPasien?.alamat || '-'"></span>
                <span class="text-zinc-300 dark:text-zinc-600">•</span>
                <span class="font-mono text-[10px] text-emerald-600 dark:text-emerald-400"
                    x-text="currentPasien?.latitude ? (currentPasien.latitude.toFixed(4) + ', ' + currentPasien.longitude.toFixed(4)) : '-'"></span>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center w-full sm:w-auto">
            {{-- Tombol Reset --}}
            <x-button.secondary x-show="hasSearched" x-transition type="button" @click="astarResult = null"
                class="h-10 w-full px-5 text-xs font-semibold sm:h-9 sm:w-auto text-zinc-700 hover:text-red-600 dark:text-zinc-300 dark:hover:text-red-400">
                <x-slot name="icon">
                    <x-icons.refresh class="h-4 w-4" />
                </x-slot>
                <span>Reset</span>
            </x-button.secondary>

            {{-- Tombol Simpan Riwayat Rujukan --}}
            <x-button.primary x-show="hasSearched" x-transition type="button"
                @click="
                    let rsId = null;
                    if (astarResult && astarResult.all_ranked && astarResult.all_ranked[selectedIndex]) {
                        rsId = astarResult.all_ranked[selectedIndex].hospital.id_rumah_sakit;
                    } else if (rsList && rsList[selectedIndex]) {
                        rsId = rsList[selectedIndex].id_rumah_sakit;
                    }
                    if (rsId) { $wire.simpanRiwayat(rsId); }
                "
                wire:loading.attr="disabled"
                class="h-10 w-full px-5 text-xs font-semibold sm:h-9 sm:w-auto">
                <x-slot name="icon">
                    <x-icons.clipboard-check wire:loading.remove wire:target="simpanRiwayat" class="h-4 w-4" />
                    <x-icons.loading wire:loading wire:target="simpanRiwayat" class="h-4 w-4 animate-spin" />
                </x-slot>
                <span wire:loading.remove wire:target="simpanRiwayat">Simpan Riwayat</span>
                <span wire:loading wire:target="simpanRiwayat">Menyimpan...</span>
            </x-button.primary>

            {{-- Tombol Proses Analisis --}}
            <x-button.success wire:click="searchReferral" wire:loading.attr="disabled" type="button"
                class="h-10 w-full px-6 text-xs font-semibold sm:h-9 sm:w-auto">
                <x-slot name="icon">
                    <x-icons.search wire:loading.remove wire:target="searchReferral" class="h-4 w-4" />
                    <x-icons.loading wire:loading wire:target="searchReferral" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="searchReferral" class="inline-flex items-center gap-2">
                    Proses Analisis
                </span>
                <span wire:loading wire:target="searchReferral" class="inline-flex items-center gap-2">
                    Memproses...
                </span>
            </x-button.success>
        </div>
    </div>
</div>

