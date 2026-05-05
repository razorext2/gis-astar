@props([
    'show' => null,
    'id' => 'modal-' . uniqid(),
    'title' => 'Modal Title',
    'subtitle' => null,
    'maxWidth' => 'md',
    'iconContainerClass' => 'bg-blue-600 shadow-blue-500/20',
    'isAlpine' => false,
])

@php
    $maxWidthClass =
        [
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
            '4xl' => 'max-w-4xl',
            '5xl' => 'max-w-5xl',
            '6xl' => 'max-w-6xl',
            '7xl' => 'max-w-7xl',
            'full' => 'max-w-full',
        ][$maxWidth] ?? 'max-w-md';
@endphp

<template x-teleport="body">
    <div x-data="{ open: @if($isAlpine) {{ $show }} @else @entangle($show) @endif }"
        @if($isAlpine) x-init="$watch('open', val => {{ $show }} = val); $watch('{{ $show }}', val => open = val)" @endif
        x-show="open" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-900/60 p-4 backdrop-blur-md"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.self="open = false">

        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="relative flex w-full {{ $maxWidthClass }} max-h-[calc(100vh-2rem)] flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-zinc-900">

            {{-- Header --}}
            <div class="shrink-0 flex items-center justify-between border-b border-zinc-200 p-5 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    @isset($icon)
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl text-white shadow-lg {{ $iconContainerClass }}">
                            {{ $icon }}
                        </div>
                    @endisset
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">
                            {{ $title }}
                        </h2>
                        @if ($subtitle)
                            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                                {{ $subtitle }}
                            </p>
                        @endif
                    </div>
                </div>
                <x-button.secondary @click="open = false"
                    class="!rounded-full !border-none !bg-transparent !p-2 !shadow-none !ring-0">
                    <x-slot name="icon">
                        <x-icons.close class="h-5 w-5" />
                    </x-slot>
                </x-button.secondary>
            </div>

            {{-- Body --}}
            <div class="min-h-0 flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @isset($footer)
                <div
                    class="shrink-0 flex justify-end gap-3 border-t border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</template>
