{{-- Goal: Stat card carousel item with liquid glass/glassmorphism theme, Livewire: components.card, Alpine: None --}}
@php
    $colorMap = [
        'blue' => [
            'shadow' => 'group-hover:shadow-blue-500/20 dark:group-hover:shadow-blue-500/15',
            'accent' => 'from-blue-400 via-sky-400 to-blue-600',
            'glow' => 'bg-blue-400/20 dark:bg-blue-500/15',
            'glow2' => 'bg-sky-300/10 dark:bg-sky-400/10',
            'icon-ring' => 'ring-blue-300/50 dark:ring-blue-500/30',
            'icon-bg' => 'bg-blue-400/20 dark:bg-blue-500/20',
            'icon-text' => 'text-blue-600 dark:text-blue-300',
            'progress' => 'from-blue-400 to-sky-500',
            'progress-glow' => 'rgba(56,189,248,0.6)',
            'value-from' => 'from-blue-600',
            'value-to' => 'to-sky-500',
            'value-dark-from' => 'dark:from-blue-300',
            'value-dark-to' => 'dark:to-sky-200',
            'label-hover' => 'group-hover:text-blue-600 dark:group-hover:text-blue-400',
        ],
        'red' => [
            'shadow' => 'group-hover:shadow-red-500/20 dark:group-hover:shadow-red-500/15',
            'accent' => 'from-red-400 via-rose-400 to-red-600',
            'glow' => 'bg-red-400/20 dark:bg-red-500/15',
            'glow2' => 'bg-rose-300/10 dark:bg-rose-400/10',
            'icon-ring' => 'ring-red-300/50 dark:ring-red-500/30',
            'icon-bg' => 'bg-red-400/20 dark:bg-red-500/20',
            'icon-text' => 'text-red-600 dark:text-red-300',
            'progress' => 'from-red-400 to-rose-500',
            'progress-glow' => 'rgba(251,113,133,0.6)',
            'value-from' => 'from-red-600',
            'value-to' => 'to-rose-500',
            'value-dark-from' => 'dark:from-red-300',
            'value-dark-to' => 'dark:to-rose-200',
            'label-hover' => 'group-hover:text-red-600 dark:group-hover:text-red-400',
        ],
        'yellow' => [
            'shadow' => 'group-hover:shadow-yellow-500/20 dark:group-hover:shadow-yellow-500/15',
            'accent' => 'from-yellow-400 via-amber-400 to-yellow-600',
            'glow' => 'bg-yellow-400/20 dark:bg-yellow-500/15',
            'glow2' => 'bg-amber-300/10 dark:bg-amber-400/10',
            'icon-ring' => 'ring-yellow-300/50 dark:ring-yellow-500/30',
            'icon-bg' => 'bg-yellow-400/20 dark:bg-yellow-500/20',
            'icon-text' => 'text-yellow-600 dark:text-yellow-300',
            'progress' => 'from-yellow-400 to-amber-500',
            'progress-glow' => 'rgba(251,191,36,0.6)',
            'value-from' => 'from-yellow-600',
            'value-to' => 'to-amber-500',
            'value-dark-from' => 'dark:from-yellow-300',
            'value-dark-to' => 'dark:to-amber-200',
            'label-hover' => 'group-hover:text-yellow-600 dark:group-hover:text-yellow-400',
        ],
        'green' => [
            'shadow' => 'group-hover:shadow-green-500/20 dark:group-hover:shadow-green-500/15',
            'accent' => 'from-green-400 via-emerald-400 to-green-600',
            'glow' => 'bg-green-400/20 dark:bg-green-500/15',
            'glow2' => 'bg-emerald-300/10 dark:bg-emerald-400/10',
            'icon-ring' => 'ring-green-300/50 dark:ring-green-500/30',
            'icon-bg' => 'bg-green-400/20 dark:bg-green-500/20',
            'icon-text' => 'text-green-600 dark:text-green-300',
            'progress' => 'from-green-400 to-emerald-500',
            'progress-glow' => 'rgba(52,211,153,0.6)',
            'value-from' => 'from-green-600',
            'value-to' => 'to-emerald-500',
            'value-dark-from' => 'dark:from-green-300',
            'value-dark-to' => 'dark:to-emerald-200',
            'label-hover' => 'group-hover:text-green-600 dark:group-hover:text-green-400',
        ],
    ];

    $style = $colorMap[$color] ?? $colorMap['red'];
    $visibleCount = $visibleCount ?? 1;

    $itemClasses = 'min-w-[260px] flex-shrink-0 xl:flex-1 xl:min-w-0';
@endphp

<div class="{{ $itemClasses }} group relative snap-start">
    <div class="relative h-full transition-all duration-500 ease-out group-hover:-translate-y-2">

        {{-- Main Liquid Glass Card --}}
        <div
            class="{{ $style['shadow'] }} relative h-full overflow-hidden rounded-2xl border border-white/40 bg-white/50 p-5 shadow-md backdrop-blur-xl transition-all duration-500 group-hover:border-white/60 group-hover:shadow-sm dark:border-zinc-700/50 dark:bg-zinc-900/50 dark:group-hover:border-zinc-600/60">

            {{-- Colored Top Accent Bar --}}
            <div
                class="{{ $style['accent'] }} absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r opacity-90 transition-all duration-500 group-hover:opacity-100">
            </div>

            {{-- Primary Glow Orb (top-right) --}}
            <div
                class="{{ $style['glow'] }} pointer-events-none absolute -right-6 -top-6 h-28 w-28 rounded-full blur-2xl transition-all duration-700 ease-in-out group-hover:scale-[1.6] group-hover:opacity-80">
            </div>

            {{-- Secondary Glow Orb (bottom-left) --}}
            <div
                class="{{ $style['glow2'] }} pointer-events-none absolute -bottom-8 -left-6 h-24 w-24 rounded-full blur-3xl transition-all duration-700 ease-in-out group-hover:scale-150 group-hover:opacity-60">
            </div>

            {{-- Inner Glass Sheen --}}
            <div
                class="pointer-events-none absolute inset-0 rounded-2xl bg-gradient-to-br from-white/10 via-transparent to-transparent dark:from-white/5">
            </div>

            <div class="relative z-10">

                {{-- Header Row --}}
                <div class="mb-4 flex items-start justify-between gap-2">
                    <p
                        class="{{ $style['label-hover'] }} text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-400 transition-colors duration-300 dark:text-zinc-500">
                        {{ $label }}
                    </p>

                    {{-- Liquid Glass Icon Badge --}}
                    <div
                        class="{{ $style['icon-bg'] }} {{ $style['icon-ring'] }} {{ $style['icon-text'] }} relative flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl ring-1 backdrop-blur-sm transition-all duration-500 group-hover:rotate-6 group-hover:scale-110 group-hover:shadow-md">
                        {{-- Icon inner glow --}}
                        <div
                            class="{{ $style['glow'] }} absolute inset-0 rounded-xl opacity-0 blur-sm transition-opacity duration-500 group-hover:opacity-100">
                        </div>
                        <x-dynamic-component :component="$icon" class="relative h-4 w-4 drop-shadow" />
                    </div>
                </div>

                {{-- Main Count Value --}}
                <div class="flex items-end gap-2">
                    <span
                        class="{{ $style['value-from'] }} {{ $style['value-to'] }} {{ $style['value-dark-from'] }} {{ $style['value-dark-to'] }} inline-block origin-left bg-gradient-to-br bg-clip-text text-4xl font-black tracking-tight text-transparent transition-transform duration-300 group-hover:scale-105">
                        {{ number_format($count) }}
                    </span>
                    <span class="mb-1.5 text-[11px] font-semibold text-zinc-400 dark:text-zinc-500">
                        {{ $indicator }}
                    </span>
                </div>

                {{-- Neon Progress Track --}}
                <div class="mt-5 h-1 w-full overflow-hidden rounded-full bg-zinc-200/60 dark:bg-zinc-700/50">
                    <div class="{{ $style['progress'] }} h-full w-1/3 rounded-full bg-gradient-to-r transition-all duration-700 ease-out group-hover:w-full"
                        style="box-shadow: 0 0 8px {{ $style['progress-glow'] }}, 0 0 2px {{ $style['progress-glow'] }};">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
