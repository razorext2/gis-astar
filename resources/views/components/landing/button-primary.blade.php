<button id="{{ $id }}" type="{{ $type }}"
    {{ $attributes->merge(['class' => 'dark:bg-blue-800 dark:hover:bg-blue-900 dark:text-white dark:border-zinc-800 rounded-lg bg-blue-400 p-2 font-bold text-white border border-zinc-200 hover:bg-blue-700']) }}>
    {{ $slot }}
</button>
