<div id="announcement-container" >
	@if ($row)
		<x-notification-alert class="mt-2" :id="'notification-alert'" wire:poll.300s>
			<x-slot name="title">
				{{ $row->title }}
			</x-slot>
			<x-slot name="desc">
				{{ $row->description }}
			</x-slot>
		</x-notification-alert>
	@endif

	<x-notification-alert class="hidden mt-2" :id="'offline-alert'" wire:offline.class.remove="hidden">
		<x-slot name="title">
			Peringatan
		</x-slot>
		<x-slot name="desc">
			Kamu sedang dalam kondisi offline.
		</x-slot>
	</x-notification-alert>
</div>
