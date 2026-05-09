{{-- Goal: Tombol primary untuk aksi utama (Blue), Smart Tag (a/button), Livewire: -, Alpine: - --}}
@props(['icon' => null, 'type' => 'button', 'id' => null, 'href' => null])

@php
    $tag = $href ? 'a' : 'button';
    $baseClasses =
        'inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition-all duration-300 hover:bg-blue-700 hover:shadow-blue-600/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:scale-95 disabled:pointer-events-none disabled:opacity-50 dark:shadow-none dark:focus:ring-offset-zinc-900';
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
