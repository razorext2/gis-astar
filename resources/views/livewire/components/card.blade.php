<div class="{{ $totalData > 2 ? 'pb-4 mb-4 lg:mb-0' : 'mb-2 pb-2' }} relative w-full overflow-x-auto">
	<div
		class="{{ $totalData > 2 && $totalData ? 'flex flex-row lg:grid lg:grid-cols-' . $totalData : 'grid grid-cols-' . $totalData }} gap-4"
		wire:poll.300s>

		@foreach ($data as $row)
			@if ($row['permission'] == 'all' || auth()->user()->hasPermissionTo($row['permission']))
				<x-card.card-carousel-item :total="$totalData" :label="$row['label']" :count="$row['count']" :indicator="$row['indicator']" />
			@endif
		@endforeach

	</div>
</div>
