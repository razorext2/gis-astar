@props(['label', 'id'])

<div
	{{ $attributes->merge(['class' => 'col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1']) }}>
	<p class="text-sm text-gray-600 dark:text-gray-300">{{ $label }}</p>
	<p class="text-navy-700 text-base font-medium dark:text-white" id="{{ $id }}"></p>

	<x-skeleton />
</div>
