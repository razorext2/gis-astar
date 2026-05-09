@props(['active', 'navigate' => false])

<a class="{{ $active ? 'text-red-600 font-bold bg-zinc-100 dark:bg-dark-primary' : 'text-zinc-900 dark:text-zinc-300' }} group flex flex-row items-center rounded-xl p-2 hover:text-red-600"
    {{ $attributes }} {{ $navigate ? 'wire:navigate' : '' }}>

    {{ $icon }}
    <span class="ms-3 inline-flex text-sm group-hover:text-red-600">{{ $slot }}</span>
</a>
