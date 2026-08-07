<div
    wire:ignore
    class="dark:bg-dark-primary flex flex-col justify-between rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 lg:col-span-5 dark:border-zinc-800">
    <div>
        <div class="mb-3 flex items-center justify-between">
            <h3 class="flex items-center gap-2 text-sm font-bold text-zinc-900 dark:text-white">
                <x-icons.map class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                Peta Rute Terpendek
            </h3>
        </div>

        <div id="analisis-map"
            class="h-64 w-full overflow-hidden rounded-xl border border-zinc-200/80 shadow-inner sm:h-80 lg:h-[340px] dark:border-zinc-700/80"
            style="z-index: 10;"></div>
    </div>

    {{-- Map Legend --}}
    <div
        class="mt-3 flex flex-wrap items-center justify-between gap-2 px-1 text-[11px] font-medium text-zinc-600 dark:text-zinc-400">
        <span
            class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200/60 bg-blue-50/50 px-2 py-1 dark:border-blue-900/40 dark:bg-blue-950/30">
            <span class="inline-block h-2.5 w-2.5 rounded-full bg-blue-500 ring-2 ring-blue-500/20"></span>
            Lokasi Pasien
        </span>
        <span
            class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200/60 bg-emerald-50/50 px-2 py-1 dark:border-emerald-900/40 dark:bg-emerald-950/30">
            <span class="inline-block h-1.5 w-4 rounded-full bg-emerald-500"></span>
            Rute Terpendek
        </span>
        <span
            class="inline-flex items-center gap-1.5 rounded-lg border border-red-200/60 bg-red-50/50 px-2 py-1 dark:border-red-900/40 dark:bg-red-950/30">
            <span class="inline-block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-red-500/20"></span>
            RS Rujukan
        </span>
    </div>
</div>
