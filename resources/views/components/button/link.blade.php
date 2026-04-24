{{-- Goal: Tombol link/anchor dengan navigasi (Maatwebsite/SPA), Livewire: -, Alpine: - --}}
@props(['href' => '#', 'icon' => null, 'id' => null])

<a id="{{ $id }}" href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'inline-flex items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 shadow-sm transition-all duration-300 hover:bg-zinc-50 hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 active:scale-95 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800 dark:hover:text-white dark:focus:ring-offset-zinc-900',
    ]) }}>
    @if ($icon)
        {{ $icon }}
    @endif
    <span>{{ $slot }}</span>
</a>
