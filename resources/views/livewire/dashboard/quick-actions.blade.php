<div class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
    @can('spk-create')
        <a href="{{ route('spk.create') }}"
            class="group flex flex-col items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white/60 p-4 text-center shadow-sm backdrop-blur-md transition-all hover:-translate-y-1 hover:border-red-200 hover:bg-red-50/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:hover:border-red-900/30 dark:hover:bg-red-900/10">
            <div
                class="rounded-lg bg-red-100 p-2.5 text-red-600 transition-colors group-hover:bg-red-600 group-hover:text-white dark:bg-red-900/30 dark:text-red-500">
                <x-icons.plus class="h-5 w-5" />
            </div>
            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">Buat SPK Baru</span>
        </a>
    @endcan

    @can('invoice-list')
        <a href="{{ route('invoice.all.index') }}"
            class="group flex flex-col items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white/60 p-4 text-center shadow-sm backdrop-blur-md transition-all hover:-translate-y-1 hover:border-blue-200 hover:bg-blue-50/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:hover:border-blue-900/30 dark:hover:bg-blue-900/10">
            <div
                class="rounded-lg bg-blue-100 p-2.5 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-900/30 dark:text-blue-500">
                <x-icons.file-invoice class="h-5 w-5" />
            </div>
            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">Daftar Tagihan</span>
        </a>
    @endcan

    @can('spk-approve')
        <a href="{{ route('spk.index') }}"
            class="group flex flex-col items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white/60 p-4 text-center shadow-sm backdrop-blur-md transition-all hover:-translate-y-1 hover:border-emerald-200 hover:bg-emerald-50/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:hover:border-emerald-900/30 dark:hover:bg-emerald-900/10">
            <div
                class="rounded-lg bg-emerald-100 p-2.5 text-emerald-600 transition-colors group-hover:bg-emerald-600 group-hover:text-white dark:bg-emerald-900/30 dark:text-emerald-500">
                <x-icons.clipboard-check class="h-5 w-5" />
            </div>
            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">Validasi SPK</span>
        </a>
    @endcan

    @can('point-redeem')
        <a href="{{ route('points.index') }}"
            class="group flex flex-col items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white/60 p-4 text-center shadow-sm backdrop-blur-md transition-all hover:-translate-y-1 hover:border-amber-200 hover:bg-amber-50/50 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:hover:border-amber-900/30 dark:hover:bg-amber-900/10">
            <div
                class="rounded-lg bg-amber-100 p-2.5 text-amber-600 transition-colors group-hover:bg-amber-600 group-hover:text-white dark:bg-amber-900/30 dark:text-amber-500">
                <x-icons.star class="h-5 w-5" />
            </div>
            <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">Poin Teknisi</span>
        </a>
    @endcan
</div>
