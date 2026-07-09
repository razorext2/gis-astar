@props(['class' => null, 'id' => null, 'type' => 'announcement'])

@php
    $themes = [
        'announcement' => [
            'border' => 'border-red-500/30 dark:border-red-500/20',
            'bg' => 'bg-red-50/50 dark:bg-red-950/10',
            'accent' => 'bg-red-600',
            'iconBg' => 'bg-red-100 dark:bg-red-900/30',
            'iconColor' => 'text-red-600 dark:text-red-400',
            'titleText' => 'text-red-900 dark:text-red-300',
            'descText' => 'text-red-700 dark:text-red-400',
        ],
        'offline' => [
            'border' => 'border-amber-500/30 dark:border-amber-500/20',
            'bg' => 'bg-amber-500/10 dark:bg-amber-500/5',
            'accent' => null,
            'iconBg' => 'bg-amber-100 dark:bg-amber-900/30',
            'iconColor' => 'text-amber-600 dark:text-amber-400',
            'titleText' => 'text-amber-900 dark:text-amber-300',
            'descText' => 'text-amber-700 dark:text-amber-400',
        ],
    ];

    $theme = $themes[$type] ?? $themes['announcement'];
@endphp

<div
    class="{{ $class }} {{ $theme['bg'] }} {{ $theme['border'] }} relative flex items-start gap-4 overflow-hidden rounded-xl border p-4 shadow-sm backdrop-blur-md transition-all duration-300 dark:shadow-none md:p-6"
    id="{{ $id }}" role="alert" {{ $attributes }}>

    @if ($theme['accent'])
        {{-- Left Accent Line (announcement only) --}}
        <div class="{{ $theme['accent'] }} absolute left-0 top-0 h-full w-1"></div>
    @endif

    {{-- Icon container --}}
    <div class="{{ $theme['iconBg'] }} flex h-10 w-10 shrink-0 items-center justify-center rounded-full p-2">
        @if ($type === 'offline')
            <svg class="{{ $theme['iconColor'] }} h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
            </svg>
        @else
            <x-icons.bell class="{{ $theme['iconColor'] }} h-6 w-6" />
        @endif
    </div>

    {{-- Content --}}
    <div class="flex flex-1 flex-col pt-0.5">
        <h3 class="{{ $theme['titleText'] }} text-sm font-bold">
            {{ $title }}
        </h3>
        <div class="{{ $theme['descText'] }} mt-1 text-sm leading-relaxed">
            {{ $desc }}
        </div>
    </div>
</div>
