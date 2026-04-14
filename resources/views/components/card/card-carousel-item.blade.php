<div class="group relative min-w-[240px] max-w-[320px] flex-1 flex-shrink-0 snap-start">

    <div class="relative h-full transition-transform duration-300 ease-out group-hover:-translate-y-1.5">

        {{-- Main Card --}}
        <div
            class="relative h-full overflow-hidden rounded-2xl bg-white p-4 shadow-sm ring-1 ring-zinc-200 transition-all duration-300 group-hover:shadow-lg group-hover:shadow-red-500/10 dark:bg-dark-primary dark:ring-zinc-800 dark:group-hover:shadow-red-900/20">

            {{-- Accent Top Line --}}
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-red-400 via-red-500 to-red-700 opacity-80">
            </div>

            {{-- Subtle Background Radial Effect --}}
            <div
                class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-red-100 to-red-50/50 blur-2xl transition-transform duration-700 ease-in-out group-hover:scale-150 dark:from-red-900/20 dark:to-red-800/10">
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
                        class="relative flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 transition-transform duration-500 group-hover:rotate-6 group-hover:scale-110 dark:bg-red-500/10 dark:text-red-400">
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
                        class="h-full w-1/3 rounded-full bg-gradient-to-r from-red-500 to-red-700 shadow-[0_0_10px_rgba(239,68,68,0.5)] transition-all duration-1000 ease-out group-hover:w-full dark:from-red-500 dark:to-red-400">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
