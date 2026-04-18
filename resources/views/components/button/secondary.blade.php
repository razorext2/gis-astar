@props(['form' => null, 'class' => null, 'icon' => null, 'type' => 'button', 'id' => null])

<button
    class="{{ $class }} flex flex-row items-center gap-2 rounded-lg px-2.5 py-2 ring-1 ring-gray-200 transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-gray-100 focus:scale-105 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:hover:bg-zinc-900 shadow-sm"
    id="{{ $id }}" type="{{ $type }}" {{ $form ? 'form=' . $form : '' }} {{ $attributes }}>
    {{ $icon }}
    <span>{{ $slot }}</span>
</button>
