{{-- Goal: Tombol danger untuk aksi destruktif/error (Rose), Smart Tag (a/button), Livewire: -, Alpine: - --}}
@props(['icon' => null, 'type' => 'button', 'id' => null, 'href' => null])

@php
    $tag = $href ? 'a' : 'button';
    $baseClasses =
        'inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-red-600/20 transition-all duration-300 hover:bg-red-700 hover:shadow-red-600/40 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:scale-95 disabled:pointer-events-none disabled:opacity-50 dark:shadow-none dark:focus:ring-offset-zinc-900';
@endphp

<{{ $tag }} id="{{ $id }}" {{ $href ? "href=$href" : "type=$type" }}
    {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if ($icon)
        {{ $icon }}
    @endif
    <span>{{ $slot }}</span>
    </{{ $tag }}>
