<div id="announcement-container">
	@if ($row)
		<x-notification-alert class="mb-4" :id="'notification-alert'" wire:poll.300s>
			<x-slot name="title">
				{{ $row->title }}
			</x-slot>
			<x-slot name="desc">
				{{ $row->description }}
			</x-slot>
		</x-notification-alert>
	@endif
</div>
