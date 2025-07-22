<div class="flex w-72 flex-row items-center md:w-full">
	@if ($status == 0 || $status == 3 || $status == 4 || $status == 5)
		<x-dashboard.status :color="'yellow'">
			<span class="absolute inline-flex h-4 w-4 animate-ping rounded-md bg-yellow-400 opacity-75"></span>
			<x-icons.question-circle class="relative inline-flex h-4 w-4" />
		</x-dashboard.status>
	@elseif ($status == 1)
		<x-dashboard.status :color="'green'">
			<x-icons.check class="mx-auto h-4 w-4" />
		</x-dashboard.status>
	@else
		<x-dashboard.status :color="'red'">
			<x-icons.close class="mx-auto h-4 w-4" />
		</x-dashboard.status>
	@endif

	<p class="flex max-w-sm items-center text-wrap text-left">
		@if ($status == 4 && route('driver.index'))
			<x-button.primary id="assign-button" type="button" class="!py-1" wire:click="assign({{ $id }})"
				wire:key="assign-{{ $id }}">
				Assign </x-button.primary>
		@else
			{{ $title }}
		@endif
	</p>

</div>
