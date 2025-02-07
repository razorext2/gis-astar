@props(['values' => '', 'id', 'name', 'labels' => true])

@if ($labels)
	<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
		for="{{ $id }}">{{ $slot }}</label>
@endif

<div class="flex items-center">
	<div
		class="z-10 inline-flex flex-shrink-0 items-center rounded-s-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
		Rp.
	</div>

	<div class="relative w-full">
		<x-input.basic class="z-20 rounded-s-none border-s-0" id="{{ $id }}" name="{{ $name }}" type="number"
			value="{{ $values }}" placeholder="9999999" :labels="false" {{ $attributes }} />
	</div>
</div>
