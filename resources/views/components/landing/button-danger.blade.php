<button id="{{ $id }}" type="{{ $type }}"
	{{ $attributes->merge(['class' => 'dark:bg-red-800 dark:hover:bg-red-900 dark:text-white dark:border-gray-700 rounded-lg bg-red-400 p-2 font-bold text-white border border-gray-200 hover:bg-red-700']) }}>
	{{ $slot }}
</button>
