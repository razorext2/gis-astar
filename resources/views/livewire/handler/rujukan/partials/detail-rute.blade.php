{{-- Detail Rute Terpendek --}}
<div
    class="dark:bg-dark-primary flex flex-col justify-between rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 lg:col-span-7 dark:border-zinc-800">
    <div>
        <h3 class="mb-3 flex items-center gap-2 text-sm font-bold text-zinc-900 dark:text-white">
            <x-icons.arrow-right class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
            Detail Rute Terpendek
        </h3>

        {{-- Turn-by-Turn Steps --}}
        <div class="max-h-56 space-y-2 overflow-y-auto pr-1">

            <template x-if="steps && steps.length > 0">
                <template x-for="(st, idx) in steps" :key="idx">
                    <div
                        class="flex items-center justify-between rounded-lg border-b border-zinc-100 p-1.5 pb-2 text-xs transition-colors hover:bg-zinc-50/50 dark:border-zinc-800/60 dark:hover:bg-zinc-800/30">
                        <div class="flex min-w-0 flex-1 items-center gap-2.5">
                            <span
                                class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-xs font-semibold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300"
                                x-text="st.icon"></span>
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-zinc-800 dark:text-zinc-200" x-text="st.title">
                                </p>
                                <p class="truncate text-[11px] text-zinc-400" x-show="st.address" x-text="st.address">
                                </p>
                            </div>
                        </div>
                        <span
                            class="ml-3 shrink-0 rounded-md bg-zinc-100/80 px-2 py-0.5 font-mono text-xs font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300"
                            x-text="st.distance"></span>
                    </div>
                </template>
            </template>

            {{-- Fallback placeholder steps --}}
            <template x-if="!steps || steps.length === 0">
                <div class="space-y-2">
                    <div
                        class="flex items-center justify-between rounded-lg border-b border-zinc-100 p-1.5 pb-2 text-xs dark:border-zinc-800/60">
                        <div class="flex items-center gap-2.5">
                            <span
                                class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-xs text-blue-600 dark:bg-blue-950/50">📍</span>
                            <div>
                                <p class="font-semibold text-zinc-800 dark:text-zinc-200"
                                    x-text="'Lokasi Pasien [' + (pasienList.find(p => p.id_pasien == pasienId)?.nama || '-') + ']'">
                                </p>
                                <p class="text-[11px] text-zinc-400"
                                    x-text="pasienList.find(p => p.id_pasien == pasienId)?.alamat || '-'">
                                </p>
                            </div>
                        </div>
                        <span
                            class="rounded-md bg-zinc-100 px-2 py-0.5 font-mono font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">0
                            km</span>
                    </div>
                    <div
                        class="flex items-center justify-between rounded-lg border-b border-zinc-100 p-1.5 pb-2 text-xs dark:border-zinc-800/60">
                        <div class="flex items-center gap-2.5">
                            <span
                                class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-red-50 text-xs text-red-600 dark:bg-red-950/50">📍</span>
                            <div>
                                <p class="font-semibold text-zinc-800 dark:text-zinc-200"
                                    x-text="'Tujuan: ' + (rsList[selectedIndex]?.nama_rumah_sakit || rsList[0]?.nama_rumah_sakit || '-')">
                                </p>
                                <p class="text-[11px] text-zinc-400"
                                    x-text="rsList[selectedIndex]?.alamat || rsList[0]?.alamat || '-'"></p>
                            </div>
                        </div>
                        <span
                            class="rounded-md bg-zinc-100 px-2 py-0.5 font-mono font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300"
                            x-text="currentDistance !== '-' ? ('Total ' + currentDistance + ' km (' + currentDuration + ' min)') : '-'"></span>
                    </div>
                </div>
            </template>

        </div>
    </div>
</div>
