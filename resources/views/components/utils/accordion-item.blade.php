{{-- Goal: Enhanced Reusable Accordion Item, Caller: Any Dashboard, Deps: Alpine.js x-collapse --}}
@props(['id', 'title' => '', 'description' => null, 'iconColor' => 'blue', 'expanded' => false])

<div x-data="{ open: @js($expanded) }"
    {{ $attributes->merge(['class' => 'overflow-hidden shadow-md rounded-xl border border-zinc-200 bg-white/60 backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60']) }}>

    <h2 id="{{ $id }}-heading" class="m-0">
        <button type="button"
            class="flex w-full items-center justify-between gap-3 p-5 text-left transition-all duration-300 hover:bg-white/50 focus:outline-none dark:hover:bg-white/5"
            @click="open = !open" :aria-expanded="open" aria-controls="{{ $id }}-body">

            <div class="flex min-w-0 flex-1 items-center gap-4">
                @if (isset($icon))
                    <div @class([
                        'flex h-10 w-10 shrink-0 items-center justify-center rounded-xl transition-all duration-300',
                        'bg-blue-600 text-white shadow-lg shadow-blue-500/20' =>
                            $iconColor === 'primary' || $iconColor === 'blue',
                        'bg-green-600 text-white shadow-lg shadow-green-500/20' =>
                            $iconColor === 'green',
                        'bg-red-600 text-white shadow-lg shadow-red-500/20' => $iconColor === 'red',
                        'bg-amber-500 text-white shadow-lg shadow-amber-500/20' =>
                            $iconColor === 'amber',
                        'bg-zinc-600 text-white shadow-lg shadow-zinc-500/20' =>
                            $iconColor === 'zinc',
                    ])>
                        {{ $icon }}
                    </div>
                @endif

                <div class="min-w-0 flex-1">
                    <h3 class="m-0 truncate text-base font-bold tracking-tight text-gray-800 dark:text-white">
                        {{ $title }}
                    </h3>
                    @if ($description)
                        <p class="m-0 mt-0.5 truncate text-xs font-medium text-zinc-500 dark:text-zinc-400">
                            {{ $description }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 transition-all duration-300 dark:bg-zinc-800"
                :class="open ? 'rotate-180 bg-blue-50 dark:bg-blue-950/30' : ''">
                <svg class="h-4 w-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7.119 8h9.762a1 1 0 0 1 .772 1.636l-4.881 5.927a1 1 0 0 1-1.544 0l-4.88-5.927A1 1 0 0 1 7.118 8Z" />
                </svg>
            </div>
        </button>
    </h2>

    <div id="{{ $id }}-body" x-show="open" x-collapse aria-labelledby="{{ $id }}-heading" x-cloak>
        <div class="border-t border-zinc-200 p-4 transition-all duration-500 dark:border-zinc-800 lg:p-6">
            {{ $slot }}
        </div>
    </div>
</div>
