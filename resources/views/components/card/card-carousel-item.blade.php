@php
    $colorMap = [
        'blue' => [
            'shadow' => 'group-hover:shadow-blue-500/10 dark:group-hover:shadow-blue-900/20',
            'accent' => 'from-blue-400 via-blue-500 to-blue-700',
            'radial' => 'from-blue-100 to-blue-50/50 dark:from-blue-900/20 dark:to-blue-800/10',
            'icon' => 'bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400',
            'progress' => 'from-blue-500 to-blue-700 dark:from-blue-500 dark:to-blue-400',
            'progress-shadow' => 'rgba(59,130,246,0.5)',
        ],
        'red' => [
            'shadow' => 'group-hover:shadow-red-500/10 dark:group-hover:shadow-red-900/20',
            'accent' => 'from-red-400 via-red-500 to-red-700',
            'radial' => 'from-red-100 to-red-50/50 dark:from-red-900/20 dark:to-red-800/10',
            'icon' => 'bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400',
            'progress' => 'from-red-500 to-red-700 dark:from-red-500 dark:to-red-400',
            'progress-shadow' => 'rgba(239,68,68,0.5)',
        ],
        'yellow' => [
            'shadow' => 'group-hover:shadow-yellow-500/10 dark:group-hover:shadow-yellow-900/20',
            'accent' => 'from-yellow-400 via-yellow-500 to-yellow-700',
            'radial' => 'from-yellow-100 to-yellow-50/50 dark:from-yellow-900/20 dark:to-yellow-800/10',
            'icon' => 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400',
            'progress' => 'from-yellow-500 to-yellow-700 dark:from-yellow-500 dark:to-yellow-400',
            'progress-shadow' => 'rgba(234,179,8,0.5)',
        ],
        'green' => [
            'shadow' => 'group-hover:shadow-green-500/10 dark:group-hover:shadow-green-900/20',
            'accent' => 'from-green-400 via-green-500 to-green-700',
            'radial' => 'from-green-100 to-green-50/50 dark:from-green-900/20 dark:to-green-800/10',
            'icon' => 'bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400',
            'progress' => 'from-green-500 to-green-700 dark:from-green-500 dark:to-green-400',
            'progress-shadow' => 'rgba(34,197,94,0.5)',
        ],
    ];

    $style = $colorMap[$color] ?? $colorMap['red'];
@endphp

<div class="group relative min-w-[240px] max-w-[320px] flex-1 flex-shrink-0 snap-start">
    <div class="relative h-full transition-transform duration-300 ease-out group-hover:-translate-y-1.5">

        {{-- Main Card --}}
        <div
            class="{{ $style['shadow'] }} relative h-full overflow-hidden rounded-2xl bg-white p-4 shadow-sm ring-1 ring-zinc-200 transition-all duration-300 group-hover:shadow-lg dark:bg-dark-primary dark:ring-zinc-800">

            {{-- Accent Top Line --}}
            <div
                class="{{ $style['accent'] }} absolute inset-x-0 top-0 h-1 bg-gradient-to-r opacity-80">
            </div>

            {{-- Subtle Background Radial Effect --}}
            <div
                class="{{ $style['radial'] }} absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br blur-2xl transition-transform duration-700 ease-in-out group-hover:scale-150">
            </div>

            <div class="relative z-10">
                {{-- Header --}}
                <div class="mb-4 flex items-center justify-between">
                    <h3
                        class="text-xs font-bold uppercase tracking-widest text-zinc-500 transition-colors duration-300 group-hover:text-zinc-700 dark:text-zinc-400 dark:group-hover:text-zinc-300">
                        {{ $label }}
                    </h3>

                    {{-- Icon Box --}}
                    <div
                        class="{{ $style['icon'] }} relative flex h-8 w-8 items-center justify-center rounded-lg transition-transform duration-500 group-hover:rotate-6 group-hover:scale-110">
                        <x-dynamic-component :component="$icon" class="h-4 w-4 drop-shadow-sm" />
                    </div>
                </div>

                {{-- Main Value --}}
                <div class="flex items-end gap-2">
                    <span
                        class="bg-gradient-to-br from-zinc-800 to-zinc-600 bg-clip-text text-4xl font-black tracking-tight text-transparent dark:from-white dark:to-zinc-300">
                        {{ number_format($count) }}
                    </span>
                    <span class="mb-1.5 text-xs font-semibold text-zinc-500 dark:text-zinc-400">
                        {{ $indicator }}
                    </span>
                </div>

                {{-- Progress/Decorative Bar --}}
                <div
                    class="mt-5 flex h-1.5 w-full items-center overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800/80">
                    <div
                        class="{{ $style['progress'] }} h-full w-1/3 rounded-full bg-gradient-to-r transition-all duration-1000 ease-out group-hover:w-full"
                        style="box-shadow: 0 0 10px {{ $style['progress-shadow'] }};">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
