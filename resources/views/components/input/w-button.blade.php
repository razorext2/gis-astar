@props(['labels' => true, 'id', 'name', 'textLabel', 'buttonLabel', 'placeholder', 'value' => null])

@if ($labels)
	<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="{{ $id }}">
		{{ $textLabel }}
	</label>
@endif

<div class="relative">
	<div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
		<x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400" />
	</div>

	<x-input.basic class="ps-10" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
		placeholder="{{ $placeholder }}" required :labels="false" />

	<x-button.primary class="absolute bottom-[1px] end-0 focus:outline" id="{{ $id }}_submit">
		{{ $buttonLabel }}
	</x-button.primary>
</div>
