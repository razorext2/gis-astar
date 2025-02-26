@props(['active'])

<a
	class="{{ $active ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 dark:text-gray-300' }} group flex flex-row items-center rounded-xl p-2 hover:text-red-600"
	{{ $attributes }}>

	{{ $icon }}
	<span class="ms-3 inline-flex text-sm group-hover:text-red-600">{{ $slot }}</span>
</a>
