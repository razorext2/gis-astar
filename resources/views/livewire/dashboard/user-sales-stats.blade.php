<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 lg:p-6">
    <div class="mb-4 flex items-center gap-2 border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
        <h3 class="text-base font-bold tracking-wide text-zinc-800 dark:text-white">
            Persentase Laporan Diterima
        </h3>
    </div>
    <div class="grid gap-3 lg:grid-cols-3">
        <x-dashboard.plugin.percentage :label="'Laporan Sales Harian'" :total="$sales_total_daily" :approved="$sales_approved_daily" :percentage="$sales_approved_percentage_daily" />

        <x-dashboard.plugin.percentage :label="'Laporan Sales Bulanan'" :total="$sales_total_monthly" :approved="$sales_approved_monthly" :percentage="$sales_approved_percentage_monthly" />

        <x-dashboard.plugin.percentage :label="'Laporan Sales Total'" :total="$sales_total" :approved="$sales_approved" :percentage="$sales_approved_percentage" />
    </div>
</div>
