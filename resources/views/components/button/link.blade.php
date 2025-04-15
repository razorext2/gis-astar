@props(['href' => null, 'class' => null, 'icon' => null, 'type' => 'button', 'id' => null])

<a id="{{ $id }}" type="{{ $type }}" href="{{ $href }}"
	{{ $attributes->merge(['class' => "$class gap-2 flex flex-row items-center rounded-lg px-2.5 py-2 ring-1  transition-all duration-300 ease-in-out will-change-transform hover:scale-105  focus:scale-105 dark:text-white dark:ring-gray-700 "]) }}
	{{ $attributes }}>
	{{ $icon }}
	<span>{{ $slot }}</span>
</a>
