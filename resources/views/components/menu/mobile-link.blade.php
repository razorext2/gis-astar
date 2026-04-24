<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'group mb-2 flex h-full w-auto flex-col items-center justify-center rounded-xl border border-zinc-200 bg-gray-50 p-2 text-gray-800 transition duration-500 hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-zinc-800 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800']) }}>
    {{ $slot }}
    <p class="mt-1 text-center !text-xs">{{ $label }}</p>
</a>
