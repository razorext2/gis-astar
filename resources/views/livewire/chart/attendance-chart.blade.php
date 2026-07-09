{{-- Goal: Render dynamic stacked column chart, Livewire: AttendanceChart, Alpine: None --}}
<div class="flex h-full flex-col lg:flex-1">
    <div class="mb-5 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="mb-1 text-3xl font-black tracking-tight text-zinc-900 dark:text-white">
                {{ $year }}
            </p>
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                    Menampilkan data
                </span>
                <select wire:model.live="days" class="rounded-lg border border-zinc-200 bg-white px-2 py-1 text-xs font-semibold text-zinc-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300">
                    <option value="7">7 Hari Terakhir</option>
                    <option value="30">30 Hari Terakhir</option>
                    <option value="90">90 Hari Terakhir</option>
                </select>
            </div>
        </div>
        <div class="flex items-center rounded-lg bg-red-50 px-3 py-1 text-center text-sm font-bold text-red-700 dark:bg-red-700/10 dark:text-red-500">
            {{ $formattedDateRange }}
        </div>
    </div>

    {{-- Livewire Column Chart --}}
    <div class="relative h-[320px] lg:h-full lg:flex-1 w-full overflow-hidden px-1 py-4">
        <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel" />
    </div>
</div>
