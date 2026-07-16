{{-- Goal: Render dynamic stacked column chart, Livewire: AttendanceChart, Alpine: None --}}
<!-- Chart Section -->
<div class="col-span-2 mb-4 flex h-full flex-col rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none md:p-6 lg:mb-0"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
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
                    <select wire:model.live="days"
                        class="rounded-lg border border-zinc-200 bg-white px-2 py-1 text-xs font-semibold text-zinc-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300">
                        <option value="7">7 Hari Terakhir</option>
                        <option value="30">30 Hari Terakhir</option>
                        <option value="90">90 Hari Terakhir</option>
                    </select>
                </div>
            </div>
            <div
                class="flex items-center rounded-lg bg-red-50 px-3 py-1 text-center text-sm font-bold text-red-700 dark:bg-red-700/10 dark:text-red-500">
                {{ $formattedDateRange }}
            </div>
        </div>

        {{-- Livewire Column Chart --}}
        <div class="relative h-[320px] w-full overflow-hidden px-1 py-4 lg:h-full lg:flex-1">
            <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel" />
        </div>
    </div>

    <div class="mt-4 border-t border-zinc-200 pt-5 dark:border-zinc-800">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <x-button.primary href="{{ route('attendanceIn.index') }}">
                <x-slot name="icon">
                    <x-icons.angle-right class="icon h-5 w-5" />
                </x-slot>
                Absen Masuk
            </x-button.primary>

            <x-button.danger href="{{ route('attendanceOut.index') }}">
                <x-slot name="icon">
                    <x-icons.angle-left class="icon h-5 w-5" />
                </x-slot>
                Absen Keluar
            </x-button.danger>
        </div>
    </div>
</div>
