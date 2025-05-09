@props(['form' => null, 'class' => null, 'icon' => null, 'type' => 'button', 'id' => null])

<button
	class="{{ $class }} flex flex-row items-center rounded-lg px-2.5 py-2 ring-1 ring-green-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-green-300 focus:scale-105 dark:bg-green-800 dark:text-white dark:ring-gray-700 dark:hover:bg-green-900"
	id="{{ $id }}" type="{{ $type }}" {{ $form ? 'form=' . $form : '' }} {{ $attributes }}>
	{{ $icon }}
	<span>{{ $slot }}</span>
</button>
