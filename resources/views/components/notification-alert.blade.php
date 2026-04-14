@props(['class' => null, 'id' => null, 'type' => 'announcement'])

@php
    $themes = [
        'announcement' => [
            'border' => 'border-red-500/30 dark:border-red-500/20',
            'bg' => 'bg-red-50/50 dark:bg-red-950/10',
            'accent' => 'bg-red-600',
            'iconBg' => 'bg-red-100 dark:bg-red-900/30',
            'iconColor' => 'text-red-600 dark:text-red-400',
            'titleBg' => 'bg-red-600',
            'titleText' => 'text-white',
        ],
        'offline' => [
            'border' => 'border-amber-500/30 dark:border-amber-500/20',
            'bg' => 'bg-amber-50/50 dark:bg-amber-950/10',
            'accent' => 'bg-amber-600',
            'iconBg' => 'bg-amber-100 dark:bg-amber-900/30',
            'iconColor' => 'text-amber-600 dark:text-amber-400',
            'titleBg' => 'bg-amber-600',
            'titleText' => 'text-white',
        ],
    ];

    $theme = $themes[$type] ?? $themes['announcement'];
@endphp

<div
    class="{{ $class }} {{ $theme['bg'] }} {{ $theme['border'] }} relative flex items-start gap-4 overflow-hidden rounded-2xl border p-4 shadow-sm backdrop-blur-sm transition-all duration-300 hover:shadow-md dark:shadow-none sm:p-5"
    id="{{ $id }}" role="alert" {{ $attributes }}>

    {{-- Left Accent Line --}}
    <div class="{{ $theme['accent'] }} absolute left-0 top-0 h-full w-1"></div>

    {{-- Icon container --}}
    <div class="{{ $theme['iconBg'] }} flex h-10 w-10 shrink-0 items-center justify-center rounded-xl sm:h-12 sm:w-12">
        @if ($type === 'offline')
            <svg class="{{ $theme['iconColor'] }} h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
            </svg>
        @else
            <x-icons.bell class="{{ $theme['iconColor'] }} h-6 w-6" />
        @endif
    </div>

    {{-- Content --}}
    <div class="flex-1 pt-0.5">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-black uppercase tracking-wider text-zinc-900 dark:text-white sm:text-base">
                {{ $title }}
            </h3>
        </div>
        <div class="mt-1 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400 sm:text-base">
            {{ $desc }}
        </div>
    </div>
</div>
