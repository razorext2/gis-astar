<div class="{{ $class }} group relative flex flex-col overflow-hidden rounded-xl bg-gradient-to-br from-red-600 to-red-800 p-5 ring-1 ring-red-500/50 dark:from-dark-secondary/70 dark:to-dark-primary/70 dark:ring-zinc-800 sm:p-6"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

    {{-- Decorative Background Pattern --}}
    <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-150 dark:bg-red-900/10"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    </div>

    <div class="relative z-10 flex flex-col">
        <div class="mb-1 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-red-100 dark:text-zinc-400 lg:text-base">
                    {{ $greet }}
                </span>
                @if ($isOnLeave)
                    <span
                        class="inline-flex items-center rounded-lg bg-amber-400/20 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-200 ring-1 ring-amber-400/50"
                        x-bind:class="dynamicBg ?
                            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' :
                            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        Sedang Cuti
                    </span>
                @endif
            </div>
            @if ($isOnLeave)
                <x-icons.clock class="h-4 w-4 text-red-200/50" />
            @endif
        </div>

        <span
            class="font-gaming text-xl tracking-wide text-white drop-shadow-sm lg:text-2xl">{{ auth()->user()->name }}</span>

        <div
            class="mt-4 border-l-2 border-red-400/50 pl-3 transition-colors duration-300 group-hover:border-red-300 dark:border-zinc-700 dark:group-hover:border-zinc-500">

            <livewire:inspire-component />
        </div>
    </div>
</div>
