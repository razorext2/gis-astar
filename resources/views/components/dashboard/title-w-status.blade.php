<div class="flex w-72 flex-row md:w-full">
	@if ($status == 0)
		<x-dashboard.status :color="'yellow'">
			<span class="absolute mx-auto inline-flex h-full w-full animate-ping rounded-md bg-yellow-400 opacity-75"></span>
			<x-icons.bell-ring class="relative mx-auto inline-flex h-4 w-4" />
		</x-dashboard.status>
	@elseif ($status == 1)
		<x-dashboard.status :color="'green'">
			<x-icons.check class="mx-auto h-4 w-4" />
		</x-dashboard.status>
	@elseif($status == 2 || $status == 4)
		<x-dashboard.status :color="'yellow'">
			<span class="absolute mx-auto inline-flex h-full w-full animate-ping rounded-md bg-yellow-400 opacity-75"></span>
			<x-icons.question-circle class="relative mx-auto inline-flex h-4 w-4" />
		</x-dashboard.status>
	@else
		<x-dashboard.status :color="'red'">
			<x-icons.close class="mx-auto h-4 w-4" />
		</x-dashboard.status>
	@endif

	<div class="max-w-sm text-wrap text-left">
		<p>{{ $title }}</p>
		<p class="text-xs text-gray-400">{{ $item3 ?? '' }}</p>
	</div>

</div>
