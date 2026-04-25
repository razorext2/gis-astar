{{-- Goal: Tombol secondary dengan skema warna netral (Zinc), Smart Tag (a/button), Livewire: -, Alpine: - --}}
@props(['icon' => null, 'type' => 'button', 'id' => null, 'href' => null])

@php
    $tag = $href ? 'a' : 'button';
    $baseClasses =
        'inline-flex items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 shadow-sm transition-all duration-300 hover:bg-zinc-50 hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 active:scale-95 disabled:pointer-events-none disabled:opacity-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white dark:focus:ring-offset-zinc-900';
@endphp

<{{ $tag }} id="{{ $id }}" {{ $href ? "href=$href" : "type=$type" }}
    {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if ($icon)
        {{ $icon }}
    @endif
    @if ($slot->isNotEmpty())
        <span>{{ $slot }}</span>
    @endif
    </{{ $tag }}>
