@props(['form' => null, 'class' => null, 'icon' => null, 'type' => 'button', 'id' => null])

<button
	class="{{ $class }} {{ $slot ? 'gap-2' : '' }} flex flex-row items-center rounded-lg px-2.5 py-2 ring-1 ring-red-700 transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-red-300 focus:scale-105 dark:bg-red-800 dark:text-white dark:ring-gray-700 dark:hover:bg-red-900"
	id="{{ $id }}" type="{{ $type }}" {{ $form ? 'form=' . $form : '' }} {{ $attributes }}>
	{{ $icon }}
	<span>{{ $slot }}</span>
</button>
