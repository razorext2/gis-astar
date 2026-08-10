{{-- Goal: Turn-by-Turn Navigation Steps Table --}}
<div x-show="steps.length > 0" x-cloak x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    class="dark:bg-dark-primary space-y-4 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800 print:mt-6 print:border-none print:p-0 print:shadow-none">

    <div class="flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800/60 print:pb-1">
        <h3 class="flex items-center gap-2 text-sm font-bold text-zinc-900 dark:text-zinc-100">
            <x-icons.checklist-stepper class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
            <span>Detail Navigasi</span>
        </h3>
    </div>

    {{-- Table Navigation Steps --}}
    <div class="overflow-x-auto rounded-xl border border-zinc-200/80 dark:border-zinc-800">
        <table class="w-full border-collapse text-left text-xs">
            <thead
                class="border-b border-zinc-200/60 bg-zinc-50/80 text-[11px] font-semibold uppercase tracking-wider text-zinc-500 dark:border-zinc-800/60 dark:bg-zinc-800/60 dark:text-zinc-400">
                <tr>
                    <th class="w-12 py-3 text-center">Arah</th>
                    <th class="px-3.5 py-3">Instruksi Rute Jalan</th>
                    <th class="w-28 py-3 pr-4 text-right">Jarak</th>
                </tr>
            </thead>
            <tbody class="divide-y-0">
                <template x-for="(st, idx) in steps" :key="idx">
                    <tr class="border-b border-zinc-200/80 transition-colors hover:bg-zinc-50/80 dark:border-zinc-800/60 dark:hover:bg-zinc-800/60 last:border-b-0"
                        :class="st.isEndpoint ?
                            'bg-emerald-50/40 dark:bg-emerald-950/30 dark:border-l-2 dark:border-l-emerald-500' : ''">
                        <td class="py-3 text-center">
                            <span
                                class="inline-flex h-7 w-7 items-center justify-center rounded-lg font-mono text-sm font-bold"
                                :class="st.isEndpoint ?
                                    'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border dark:border-emerald-800/40' :
                                    'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:border dark:border-zinc-800'"
                                x-text="st.icon"></span>
                        </td>
                        <td class="px-3.5 py-3">
                            <div class="font-semibold text-zinc-900 dark:text-zinc-100" x-text="st.title"></div>
                            <div class="mt-0.5 text-[10px] text-zinc-400 dark:text-zinc-400" x-show="st.address"
                                x-text="st.address"></div>
                        </td>
                        <td class="py-3 pr-4 text-right font-mono font-bold text-zinc-600 dark:text-zinc-400"
                            x-text="st.distance"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

</div>
