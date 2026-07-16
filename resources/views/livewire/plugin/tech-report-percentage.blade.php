<div class="flex w-full flex-col gap-6 rounded-xl border border-white/40 p-4 dark:border-zinc-800/50 lg:p-6"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

    {{-- Header with Month Selector --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/10 text-red-600 dark:bg-red-500/20 dark:text-red-400">
                <x-icons.file-pen class="h-6 w-6" />
            </div>
            <div>
                <h2 class="text-lg font-bold tracking-tight text-zinc-800 dark:text-white">Laporan Kunjungan</h2>
                <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Ringkasan pengisian teknisi</p>
            </div>
        </div>

        <div class="group relative">
            <select wire:model.live="selectedMonth"
                class="w-full cursor-pointer appearance-none rounded-2xl border-none bg-zinc-100/50 py-2.5 pl-4 pr-10 text-sm font-semibold text-zinc-700 transition-all hover:bg-zinc-100 focus:ring-2 focus:ring-red-500/20 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700/80">
                @foreach ($availableMonths as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400">
                <x-icons.carred-down class="h-4 w-4" />
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Left: Current Overview Cards --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2 px-1">
                <div class="h-1 w-4 rounded-full bg-red-500"></div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Status Laporan
                </h3>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                @php
                    $statusCards = [
                        [
                            'label' => 'Draft',
                            'value' => $draft,
                            'icon' => 'file-pen',
                            'color' => 'bg-indigo-500',
                            'text' => 'text-indigo-600 dark:text-indigo-400',
                        ],
                        [
                            'label' => 'Diajukan',
                            'value' => $requested,
                            'icon' => 'cloud-upload',
                            'color' => 'bg-blue-500',
                            'text' => 'text-blue-600 dark:text-blue-400',
                        ],
                        [
                            'label' => 'Revisi',
                            'value' => $revised,
                            'icon' => 'exclamation-circle',
                            'color' => 'bg-amber-500',
                            'text' => 'text-amber-600 dark:text-amber-400',
                        ],
                        [
                            'label' => 'Diterima',
                            'value' => $accepted,
                            'icon' => 'badge-check',
                            'color' => 'bg-emerald-500',
                            'text' => 'text-emerald-600 dark:text-emerald-400',
                        ],
                        [
                            'label' => 'Ditolak',
                            'value' => $rejected,
                            'icon' => 'minus-circle',
                            'color' => 'bg-rose-500',
                            'text' => 'text-rose-600 dark:text-rose-400',
                        ],
                    ];
                @endphp

                @foreach ($statusCards as $card)
                    <div class="flex flex-col gap-2 rounded-2xl border border-zinc-200 bg-zinc-50/50 p-4 transition-all hover:scale-[1.02] hover:bg-white dark:border-zinc-800 dark:hover:bg-zinc-800/60"
                        x-bind:class="dynamicBg ?
                            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        <div class="flex items-center justify-between">
                            <div
                                class="{{ str_replace('bg-', 'bg-opacity-10 ', $card['color']) }} {{ $card['text'] }} flex h-8 w-8 items-center justify-center rounded-lg">
                                @php $iconComponent = "icons." . $card['icon']; @endphp
                                <x-dynamic-component :component="$iconComponent" class="h-5 w-5" />
                            </div>
                            <span
                                class="text-lg font-black tabular-nums tracking-tight text-zinc-800 dark:text-white">{{ $card['value'] }}</span>
                        </div>
                        <span class="text-xs font-bold text-zinc-500 dark:text-zinc-500">{{ $card['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Right: Historical Progress --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2 px-1">
                <div class="h-1 w-4 rounded-full bg-red-500"></div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Persentase
                    Bulanan (API)</h3>
            </div>

            <div class="space-y-4 rounded-2xl border border-zinc-200 bg-zinc-50/50 p-5 dark:border-zinc-800"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                @foreach ($historicalData as $item)
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span
                                class="uppercase tracking-tighter text-zinc-600 dark:text-zinc-400">{{ $item['month_label'] }}</span>
                            <span class="{{ str_replace('bg-', 'text-', $item['color']) }}">{{ $item['label'] }}
                                ({{ round($item['percentage']) }}%)
                            </span>
                        </div>
                        <div class="relative h-3 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                            {{-- Progress Bar with Gradient and Glow --}}
                            <div class="{{ $item['color'] }} absolute left-0 top-0 h-full rounded-full shadow-[0_0_10px_rgba(0,0,0,0.1)] transition-all duration-1000 ease-out"
                                style="width: {{ $item['percentage'] }}%">
                                <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
