{{-- Goal: Summary Metrics (Distance, Duration, ETA, Condition), Streets List, and Export PDF Action --}}
<div
    class="dark:bg-dark-primary flex flex-col justify-between space-y-4 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800 print:hidden">
    <div>
        {{-- Card Header --}}
        <div class="mb-4 flex items-center justify-between">
            <h3 class="flex items-center gap-2 text-sm font-bold text-zinc-900 dark:text-zinc-100">
                <x-icons.clipboard-list class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                Hasil Rute Terpendek
            </h3>
        </div>

        {{-- Stat List --}}
        <div class="space-y-2">

            {{-- Jarak Total --}}
            <div class="flex items-center gap-3.5">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:border dark:border-emerald-800/40 dark:bg-emerald-950/50">
                    <x-icons.globe class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-medium text-zinc-400 dark:text-zinc-400">Jarak Total</p>
                    <p class="text-base font-extrabold text-zinc-900 dark:text-white" x-text="currentDistance"></p>
                </div>
            </div>

            {{-- Waktu Tempuh --}}
            <div class="flex items-center gap-3.5">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 dark:border dark:border-blue-800/40 dark:bg-blue-950/50">
                    <x-icons.clock class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-medium text-zinc-400 dark:text-zinc-400">Waktu Tempuh</p>
                    <p class="text-base font-extrabold text-zinc-900 dark:text-white" x-text="currentDuration"></p>
                </div>
            </div>

            {{-- Estimasi Tiba --}}
            <div class="flex items-center gap-3.5">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 dark:border dark:border-amber-800/40 dark:bg-amber-950/50">
                    <x-icons.clock class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-medium text-zinc-400 dark:text-zinc-400">Estimasi Tiba</p>
                    <p class="text-base font-extrabold text-zinc-900 dark:text-white" x-text="estimasiTiba"></p>
                </div>
            </div>

            {{-- Kondisi Rute --}}
            <div class="flex items-center gap-3.5">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:border dark:border-emerald-800/40 dark:bg-emerald-950/50">
                    <x-icons.truck class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-medium text-zinc-400 dark:text-zinc-400">Kondisi Rute</p>
                    <span
                        class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-800 dark:border dark:border-emerald-800/40 dark:bg-emerald-950/50 dark:text-emerald-300"
                        x-text="kondisi"></span>
                </div>
            </div>
        </div>

        {{-- Rute Melalui --}}
        <div class="mt-5 space-y-2.5">
            <div class="flex items-center justify-between">
                <span class="flex items-center gap-1.5 text-xs font-bold text-zinc-800 dark:text-zinc-200">
                    <x-icons.map-pin class="h-3.5 w-3.5 text-emerald-500 dark:text-emerald-400" />
                    <span>Rute Jalan Melalui</span>
                </span>
            </div>

            <div class="flex flex-wrap gap-1.5">
                <template x-for="(street, idx) in ruteMelalui" :key="idx">
                    <span
                        class="inline-flex items-center gap-1.5 rounded-lg bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                        <span class="font-mono text-[10px] font-bold text-emerald-600 dark:text-emerald-400"
                            x-text="(idx + 1) + '.'"></span>
                        <span x-text="street"></span>
                    </span>
                </template>

                <template x-if="ruteMelalui.length === 0">
                    <div
                        class="flex w-full items-center gap-2 rounded-xl border border-dashed border-zinc-200 bg-zinc-50 px-3 py-2.5 text-xs text-zinc-500 dark:border-zinc-800 dark:bg-zinc-800 dark:text-zinc-400">
                        <x-icons.info-circle class="h-3.5 w-3.5 text-zinc-400 dark:text-zinc-400" />
                        <span class="italic">Tarik data rute untuk melihat daftar jalan</span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- Single Print Button --}}
    <div class="pt-2">
        <x-button.secondary type="button" x-bind:disabled="!hasRouteLoaded"
            class="h-9 w-full justify-center text-xs font-semibold" onclick="window.print()">
            <x-slot name="icon"><x-icons.paper-clip class="h-3.5 w-3.5" /></x-slot>
            <span>Export PDF / Cetak Rute</span>
        </x-button.secondary>
    </div>
</div>
