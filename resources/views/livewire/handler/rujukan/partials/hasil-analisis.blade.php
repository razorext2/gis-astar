{{-- Hasil Analisis Rujukan Table --}}
<div
    class="dark:bg-dark-primary flex flex-col justify-between rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 lg:col-span-7 dark:border-zinc-800">
    <div>
        <div class="mb-3 flex items-center justify-between">
            <h3 class="flex items-center gap-2 text-sm font-bold text-zinc-900 dark:text-white">
                <x-icons.clipboard-list class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                Hasil Analisis Rujukan
            </h3>
        </div>

        <div class="overflow-x-auto rounded-xl border border-zinc-200/80 dark:border-zinc-700/80">
            <table class="w-full text-left text-xs text-zinc-700 dark:text-zinc-300">
                <thead
                    class="border-b border-zinc-200/80 bg-zinc-50/80 text-[11px] font-semibold uppercase tracking-wider text-zinc-500 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-zinc-400">
                    <tr>
                        <th class="w-12 px-3.5 py-3 text-center">No</th>
                        <th class="px-3.5 py-3">Rumah Sakit Rujukan</th>
                        <th class="w-24 px-3.5 py-3 text-center">Jarak (km)</th>
                        <th class="w-28 px-3.5 py-3 text-center">Waktu Tempuh</th>
                        <th class="w-32 px-3.5 py-3 text-center">Estimasi Biaya</th>
                        <th class="w-28 px-3.5 py-3 text-center">Rute</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/80 dark:divide-zinc-700/80">

                    {{-- Rows after A* calculation --}}
                    <template x-if="astarResult && astarResult.all_ranked">
                        <template x-for="(item, idx) in astarResult.all_ranked" :key="idx">
                            <tr
                                class="cursor-pointer transition-colors"
                                :class="idx === selectedIndex
                                    ? 'bg-emerald-500/10 dark:bg-emerald-950/40 font-medium ring-1 ring-inset ring-emerald-400/30'
                                    : 'hover:bg-zinc-50/80 dark:hover:bg-zinc-800/50'"
                                @click="selectCandidate(idx)">
                                <td class="px-3.5 py-3 text-center font-semibold text-zinc-500"
                                    x-text="idx + 1"></td>
                                <td class="px-3.5 py-3 font-bold text-zinc-900 dark:text-white">
                                    <span x-text="item.hospital.nama"></span>
                                    <template x-if="idx === selectedIndex">
                                        <span class="ml-1.5 inline-flex items-center rounded-md bg-emerald-100 px-1.5 py-0.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">
                                            ✓ Dipilih
                                        </span>
                                    </template>
                                </td>
                                <td class="px-3.5 py-3 text-center font-medium"
                                    x-text="item.distance ? item.distance.toFixed(1).replace('.', ',') : '-'">
                                </td>
                                <td class="px-3.5 py-3 text-center font-medium"
                                    x-text="item.estimated_time ? (item.estimated_time + ' menit') : '-'">
                                </td>
                                <td class="px-3.5 py-3 text-center font-semibold text-emerald-600 dark:text-emerald-400"
                                    x-text="item.estimated_cost ? ('Rp ' + parseInt(item.estimated_cost).toLocaleString('id-ID')) : '-'">
                                </td>
                                <td class="px-3.5 py-3 text-center" @click.stop>
                                    <template x-if="idx === 0">
                                        <x-button.success type="button" @click="selectCandidate(idx)"
                                            class="px-2.5 py-1 text-[11px] font-bold">
                                            Rute Terpendek
                                        </x-button.success>
                                    </template>
                                    <template x-if="idx > 0">
                                        <x-button.secondary type="button" @click="selectCandidate(idx)"
                                            class="px-2.5 py-1 text-[11px] font-medium">
                                            Lihat Rute
                                        </x-button.secondary>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </template>

                    {{-- Placeholder rows before A* calculation --}}
                    <template x-if="!astarResult || !astarResult.all_ranked">
                        <template x-for="(rs, idx) in rsList" :key="rs.id_rumah_sakit">
                            <tr
                                class="cursor-pointer transition-colors"
                                :class="idx === selectedIndex
                                    ? 'bg-emerald-500/10 dark:bg-emerald-950/40 font-medium ring-1 ring-inset ring-emerald-400/30'
                                    : 'hover:bg-zinc-50/80 dark:hover:bg-zinc-800/50'"
                                @click="selectCandidate(idx)">
                                <td class="px-3.5 py-3 text-center font-semibold text-zinc-500"
                                    x-text="idx + 1"></td>
                                <td class="px-3.5 py-3 font-bold text-zinc-900 dark:text-white">
                                    <span x-text="rs.nama_rumah_sakit || rs.nama"></span>
                                    <template x-if="idx === selectedIndex">
                                        <span class="ml-1.5 inline-flex items-center rounded-md bg-emerald-100 px-1.5 py-0.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">
                                            ✓ Dipilih
                                        </span>
                                    </template>
                                </td>
                                <td class="px-3.5 py-3 text-center font-medium text-zinc-400"
                                    x-text="idx === 0 ? currentDistance : '-'"></td>
                                <td class="px-3.5 py-3 text-center font-medium text-zinc-400"
                                    x-text="idx === 0 ? (currentDuration + ' min') : '-'"></td>
                                <td class="px-3.5 py-3 text-center font-semibold text-emerald-600 dark:text-emerald-400"
                                    x-text="idx === 0 ? ('Rp ' + currentCost) : '-'"></td>
                                <td class="px-3.5 py-3 text-center" @click.stop>
                                    <template x-if="idx === 0">
                                        <x-button.success type="button" @click="selectCandidate(idx)"
                                            class="px-2.5 py-1 text-[11px] font-bold">
                                            Rute Terpendek
                                        </x-button.success>
                                    </template>
                                    <template x-if="idx > 0">
                                        <x-button.secondary type="button" @click="selectCandidate(idx)"
                                            class="px-2.5 py-1 text-[11px] font-medium">
                                            Lihat Rute
                                        </x-button.secondary>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </template>

                </tbody>
            </table>
        </div>
    </div>

    <p class="mt-2 text-right text-[11px] italic text-zinc-400 dark:text-zinc-500">*Perhitungan berdasarkan
        kondisi lalu lintas normal.</p>
</div>
