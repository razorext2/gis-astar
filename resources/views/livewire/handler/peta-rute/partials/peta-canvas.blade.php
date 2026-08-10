{{-- Goal: Leaflet Map Canvas, Layer Controls, and Map Legend --}}
<div class="dark:bg-dark-primary flex flex-col gap-3 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800 print:w-full print:border-none print:p-0">

    {{-- Card Header --}}
    <div class="flex items-center justify-between print:hidden">
        <h3 class="flex items-center gap-2 text-sm font-bold text-zinc-900 dark:text-zinc-100">
            <x-icons.map class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
            Peta Rute Terpendek
        </h3>
    </div>

    {{-- Map Canvas --}}
    <div class="relative h-72 sm:h-[340px] lg:h-[460px] w-full overflow-hidden rounded-xl border border-zinc-200/80 dark:border-zinc-800 print:h-[420px]" wire:ignore>
        <div id="peta-rute-canvas" class="h-full w-full"></div>

        {{-- Layer Toggle --}}
        <div class="absolute left-3 top-3 z-[999] flex gap-1 rounded-xl border border-zinc-200/70 bg-white/90 p-1 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-800/90 print:hidden">
            <button type="button" @click="toggleLayer('peta')"
                :class="currentLayerType === 'peta'
                    ? 'bg-emerald-600 text-white font-bold shadow-sm'
                    : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 dark:hover:text-zinc-200 font-medium'"
                class="rounded-lg px-3 py-1.5 text-[11px] transition-all duration-150">
                Peta
            </button>
            <button type="button" @click="toggleLayer('satelit')"
                :class="currentLayerType === 'satelit'
                    ? 'bg-emerald-600 text-white font-bold shadow-sm'
                    : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 dark:hover:text-zinc-200 font-medium'"
                class="rounded-lg px-3 py-1.5 text-[11px] transition-all duration-150">
                Satelit
            </button>
        </div>

        {{-- Initial Info Overlay --}}
        <div x-show="!hasRouteLoaded"
            class="pointer-events-none absolute inset-x-0 bottom-4 z-[999] flex justify-center px-4 print:hidden">
            <div class="inline-flex items-center gap-2 rounded-xl border border-zinc-200/80 bg-white/95 px-4 py-2 text-xs font-semibold text-zinc-700 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-800/95 dark:text-zinc-200">
                <x-icons.info-circle class="h-4 w-4 text-emerald-500 dark:text-emerald-400" />
                <span>Pilih data rujukan dan klik <b>Tarik Data Rute</b> untuk menampilkan peta rute</span>
            </div>
        </div>
    </div>

    {{-- Map Legend --}}
    <div class="flex flex-wrap items-center gap-2 px-1 text-[11px] font-medium text-zinc-600 dark:text-zinc-400 print:bg-white print:text-zinc-900">
        <span class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200/60 bg-blue-50/60 px-2.5 py-1 dark:border-blue-900/40 dark:bg-blue-950/40 dark:text-blue-300">
            <span class="h-2.5 w-2.5 rounded-full bg-blue-600 inline-block"></span>
            Lokasi Pasien
        </span>
        <span class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200/60 bg-emerald-50/60 px-2.5 py-1 dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-300">
            <span class="h-1.5 w-5 rounded-full bg-emerald-500 inline-block"></span>
            Rute Terpendek
        </span>
        <span class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200/60 bg-emerald-50/60 px-2.5 py-1 dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-300">
            <span class="h-2.5 w-2.5 rounded-full bg-emerald-600 inline-block"></span>
            RS Rujukan
        </span>
    </div>
</div>
