@props(['labels' => true, 'id' => 'datepicker-actions', 'name' => 'date', 'placeholder' => null, 'value' => null])

@if ($labels)
	<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
		for="{{ $id }}">{{ $slot }}</label>
@endif

<div class="relative">

	<div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
		<x-icons.date class="h-4 w-4 text-gray-500 dark:text-gray-400" />
	</div>

	<input id="{{ $id }}" name="{{ $name }}" datepicker-format="yyyy-mm-dd" value="{{ $value }}"
		datepicker datepicker-buttons datepicker-autoselect-today type="text"
		class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
		placeholder="Select date" {{ $attributes }}>
</div>
