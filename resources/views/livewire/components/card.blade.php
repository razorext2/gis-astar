<div class="relative mb-2 w-full overflow-x-auto py-2">

    <div class="flex snap-x snap-mandatory flex-nowrap gap-4" wire:poll.300s>

        @foreach ($data as $row)
            @if ($row['permission'] == 'all' || auth()->user()->hasPermissionTo($row['permission']))
                <x-card.card-carousel-item :label="$row['label']" :count="$row['count']" :indicator="$row['indicator']" :icon="$row['icon']"
                    :color="$row['color']" :visibleCount="$totalData" />
            @endif
        @endforeach

    </div>

</div>
