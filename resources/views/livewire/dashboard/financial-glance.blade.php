<div>
    @can('invoice-list')
        <div
            class="flex flex-col rounded-xl border border-zinc-200 p-5 shadow-sm dark:border-zinc-800 md:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="mb-4 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <div
                        class="flex h-6 w-6 items-center justify-center rounded-md bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-500">
                        <x-icons.file-invoice class="h-3.5 w-3.5" />
                    </div>
                    <h3 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Financial Glance</h3>
                </div>
            </div>

            <div class="flex flex-col">
                <div class="mb-1 text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Invoice Bulan Ini</div>
                <div class="text-3xl font-black tracking-tight text-zinc-900 dark:text-white">
                    {{ number_format($totalInvoiceThisMonth, 0, ',', '.') }} <span
                        class="text-lg font-bold text-zinc-400">Dokumen</span>
                </div>
            </div>
        </div>
    @endcan
</div>
