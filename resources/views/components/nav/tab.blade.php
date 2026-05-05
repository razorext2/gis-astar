{{-- Goal: Tombol Tab untuk navigasi panel (Flowbite compatible), Livewire: -, Alpine: - --}}
@props(['active' => false, 'icon' => null, 'id' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-t-lg border-b-2 p-4 text-sm font-medium transition-all duration-300 focus:outline-none';
    
    // Default Flowbite Tab Styles
    $activeClasses = 'border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500';
    $inactiveClasses = 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-600 dark:text-zinc-400 dark:hover:text-zinc-300';
    
    $classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

<button id="{{ $id }}" type="button" role="tab" aria-selected="{{ $active ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <span class="inline-flex items-center">{{ $icon }}</span>
    @endif

    @if ($slot->isNotEmpty())
        <span>{{ $slot }}</span>
    @endif
</button>
