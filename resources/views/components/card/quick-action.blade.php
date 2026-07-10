{{-- Goal: Reusable quick action card supporting light/dark responsive themes and elastic jelly-tap animation, Livewire: None, Alpine: jelly-tap --}}
@props(['href', 'label', 'icon', 'color' => 'red'])

@php
    $colorMap = [
        'red' => [
            'hover_border' => 'hover:border-white/30 dark:hover:border-red-500/30',
            'hover_bg' => 'hover:bg-red-500/90 dark:hover:bg-red-500/20',
            'hover_text' => 'group-hover:text-white dark:group-hover:text-red-200',
            'hover_shadow' => 'hover:shadow-lg hover:shadow-red-500/30 dark:hover:shadow-red-500/15',
            'icon_bg' => 'bg-red-100 dark:bg-red-900/30 group-hover:bg-white/20 dark:group-hover:bg-red-500/20',
            'icon_text' => 'text-red-600 dark:text-red-500 group-hover:text-white dark:group-hover:text-red-200',
        ],
        'blue' => [
            'hover_border' => 'hover:border-white/30 dark:hover:border-blue-500/30',
            'hover_bg' => 'hover:bg-blue-500/90 dark:hover:bg-blue-500/20',
            'hover_text' => 'group-hover:text-white dark:group-hover:text-blue-200',
            'hover_shadow' => 'hover:shadow-lg hover:shadow-blue-500/30 dark:hover:shadow-blue-500/15',
            'icon_bg' => 'bg-blue-100 dark:bg-blue-900/30 group-hover:bg-white/20 dark:group-hover:bg-blue-500/20',
            'icon_text' => 'text-blue-600 dark:text-blue-500 group-hover:text-white dark:group-hover:text-blue-200',
        ],
        'emerald' => [
            'hover_border' => 'hover:border-white/30 dark:hover:border-emerald-500/30',
            'hover_bg' => 'hover:bg-emerald-500/90 dark:hover:bg-emerald-500/20',
            'hover_text' => 'group-hover:text-white dark:group-hover:text-emerald-200',
            'hover_shadow' => 'hover:shadow-lg hover:shadow-emerald-500/30 dark:hover:shadow-emerald-500/15',
            'icon_bg' =>
                'bg-emerald-100 dark:bg-emerald-900/30 group-hover:bg-white/20 dark:group-hover:bg-emerald-500/20',
            'icon_text' =>
                'text-emerald-600 dark:text-emerald-500 group-hover:text-white dark:group-hover:text-emerald-200',
        ],
        'amber' => [
            'hover_border' => 'hover:border-white/30 dark:hover:border-amber-500/30',
            'hover_bg' => 'hover:bg-amber-500/90 dark:hover:bg-amber-500/20',
            'hover_text' => 'group-hover:text-white dark:group-hover:text-amber-200',
            'hover_shadow' => 'hover:shadow-lg hover:shadow-amber-500/30 dark:hover:shadow-amber-500/15',
            'icon_bg' => 'bg-amber-100 dark:bg-amber-900/30 group-hover:bg-white/20 dark:group-hover:bg-amber-500/20',
            'icon_text' => 'text-amber-600 dark:text-amber-500 group-hover:text-white dark:group-hover:text-amber-200',
        ],
    ];
    $c = $colorMap[$color] ?? $colorMap['red'];
@endphp

<a href="{{ $href }}" x-data="{ tapping: false }" x-on:mousedown="tapping = true" x-on:touchstart="tapping = true"
    x-on:animationend="tapping = false" x-on:animationcancel="tapping = false" :class="{ 'is-tapping': tapping }"
    {{ $attributes->merge([
        'class' => "liquid-btn relative overflow-hidden group flex flex-col items-center justify-center gap-2 rounded-xl border border-zinc-200 p-4 text-center  bg-glass-light shadow-sm backdrop-blur-md transition-all duration-300 ease-out hover:-translate-y-1 {$c['hover_border']} {$c['hover_bg']} {$c['hover_shadow']} dark:border-zinc-800 dark:bg-glass-dark",
    ]) }}
    wire:navigate>

    <div class="{{ $c['icon_bg'] }} {{ $c['icon_text'] }} rounded-lg p-2.5 transition-all duration-300">
        <x-dynamic-component :component="'icons.' . $icon" class="h-5 w-5" />
    </div>
    <span
        class="{{ $c['hover_text'] }} text-xs font-bold text-zinc-700 transition-colors duration-300 dark:text-zinc-300">{{ $label }}</span>
</a>
