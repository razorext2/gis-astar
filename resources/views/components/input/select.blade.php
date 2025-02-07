@props(['id', 'name', 'options', 'defaultOption', 'textLabel', 'class', 'value' => '', 'labels' => true])

@if ($labels)
	<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
		for="{{ $id }}">{{ $textLabel ?? null }}
	</label>
@endif

<select
	class="{{ $class ?? null }} block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
	id="{{ $id }}" name="{{ $name }}">
	<option value="">{{ $defaultOption }}</option>
	@foreach ($options as $item => $label)
		<option value="{{ $item }}" {{ $item == $value ? 'selected' : '' }}>
			{{ $label }}
		</option>
	@endforeach
</select>
