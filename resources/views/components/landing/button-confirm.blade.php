<button id="{{ $id }}" type="{{ $type }}"
    {{ $attributes->merge(['class' => 'dark:bg-green-800 dark:hover:bg-green-900 dark:text-white dark:border-zinc-800 rounded-lg bg-green-400 p-2 font-bold text-white border border-zinc-200 hover:bg-green-700']) }}>
    {{ $slot }}
</button>
