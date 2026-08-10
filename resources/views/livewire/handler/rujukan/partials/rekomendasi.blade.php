{{-- Rekomendasi Rujukan --}}
<div
    class="dark:bg-dark-primary flex flex-col justify-between rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 lg:col-span-5 dark:border-zinc-800">
    <div>
        <h3 class="mb-3 flex items-center gap-2 text-sm font-bold text-zinc-900 dark:text-white">
            <x-icons.award class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
            Rekomendasi Rujukan
        </h3>

        {{-- Top Award Section --}}
        <div
            class="mb-4 flex items-start gap-3.5 rounded-xl border border-emerald-500/20 bg-gradient-to-r from-emerald-500/10 via-emerald-500/5 to-transparent p-3">
            <div
                class="shadow-xs flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white sm:h-12 sm:w-12 dark:bg-emerald-600">
                <x-icons.award class="h-6 w-6 text-white" />
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs leading-snug text-zinc-600 dark:text-zinc-400">
                    Berdasarkan hasil analisis dengan algoritma A*, rumah sakit rujukan yang paling optimal
                    adalah:
                </p>
                <h4 class="mt-1 truncate text-sm font-extrabold text-zinc-900 sm:text-base dark:text-white"
                    x-text="astarResult && astarResult.best_hospital ? astarResult.best_hospital.nama_rumah_sakit : (rsList && rsList.length > 0 ? (rsList[0].nama_rumah_sakit || rsList[0].nama) : '-')">
                </h4>
            </div>
        </div>

        {{-- 3 Metric Badges --}}
        <div class="my-4 grid grid-cols-3 gap-2 sm:gap-2.5">

            {{-- Jarak --}}
            <div
                class="flex flex-col items-center gap-1.5 rounded-xl border border-zinc-200/70 bg-zinc-50/60 p-2 text-center sm:flex-row sm:items-center sm:gap-2.5 sm:p-2.5 sm:text-left dark:border-zinc-800 dark:bg-zinc-900/50">
                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
                    <x-icons.truck class="h-4 w-4" />
                </div>
                <div class="min-w-0">
                    <span class="block text-[10px] font-medium text-zinc-400">Jarak</span>
                    <span class="block truncate text-xs font-bold text-zinc-900 sm:text-xs dark:text-white"
                        x-text="currentDistance !== '-' ? (currentDistance + ' km') : '-'">-</span>
                </div>
            </div>

            {{-- Waktu Tempuh --}}
            <div
                class="flex flex-col items-center gap-1.5 rounded-xl border border-zinc-200/70 bg-zinc-50/60 p-2 text-center sm:flex-row sm:items-center sm:gap-2.5 sm:p-2.5 sm:text-left dark:border-zinc-800 dark:bg-zinc-900/50">
                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-950/50 dark:text-amber-400">
                    <x-icons.clock class="h-4 w-4" />
                </div>
                <div class="min-w-0">
                    <span class="block text-[10px] font-medium text-zinc-400">Waktu</span>
                    <span class="block truncate text-xs font-bold text-zinc-900 sm:text-xs dark:text-white"
                        x-text="currentDuration !== '-' ? (currentDuration + ' min') : '-'">-</span>
                </div>
            </div>

            {{-- Estimasi Biaya --}}
            <div
                class="flex flex-col items-center gap-1.5 rounded-xl border border-zinc-200/70 bg-zinc-50/60 p-2 text-center sm:flex-row sm:items-center sm:gap-2.5 sm:p-2.5 sm:text-left dark:border-zinc-800 dark:bg-zinc-900/50">
                <div
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                    <x-icons.cash class="h-4 w-4" />
                </div>
                <div class="min-w-0">
                    <span class="block text-[10px] font-medium text-zinc-400">Biaya</span>
                    <span class="block truncate text-xs font-bold text-zinc-900 sm:text-xs dark:text-white"
                        x-text="currentCost !== '-' ? ('Rp ' + currentCost) : '-'">-</span>
                </div>
            </div>

        </div>
    </div>

    {{-- Green Callout Box --}}
    <div
        class="mt-2 flex items-start gap-2 rounded-xl border border-emerald-200/90 bg-emerald-50/80 p-3 text-xs text-emerald-900 dark:border-emerald-800/60 dark:bg-emerald-950/40 dark:text-emerald-200">
        <x-icons.info-circle class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600 dark:text-emerald-400" />
        <span>Rute ini merupakan pilihan terbaik dengan jarak terpendek dan waktu tempuh paling cepat.</span>
    </div>
</div>
