{{-- Goal: Render attendance coordinates, visual position status, and optional notes, Livewire: -, Alpine: - --}}
<div class="flex flex-col gap-1.5 w-full min-w-[150px] text-left">
    <!-- Google Maps Coordinate Link -->
    @if ($data->latitude && $data->longitude)
        <a class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-600 dark:text-blue-400 hover:underline transition-all"
           href="https://www.google.com/maps/search/?api=1&query={{ $data->latitude }},{{ $data->longitude }}"
           target="_blank">
            <x-icons.map-pin class="h-3.5 w-3.5 text-blue-500 flex-shrink-0" />
            <span>{{ round($data->latitude, 5) }}, {{ round($data->longitude, 5) }}</span>
        </a>
    @else
        <span class="inline-flex items-center gap-1 text-[11px] text-zinc-400 dark:text-zinc-500">
            <x-icons.map-pin class="h-3.5 w-3.5 text-zinc-300 dark:text-zinc-600 flex-shrink-0" />
            <span>Tanpa Lokasi</span>
        </span>
    @endif

    <!-- Position Status Badge -->
    @php $positionStatus = \App\Enums\PositionStatus::tryFrom((int) $data->position_status); @endphp
    @if ($positionStatus)
        <span class="inline-flex items-center gap-1 w-fit px-2.5 py-0.5 rounded-full text-[11px] font-medium {{ $positionStatus->colorClasses() }}">
            <x-dynamic-component :component="$positionStatus->iconComponent()" class="h-3.5 w-3.5 flex-shrink-0" />
            {{ $positionStatus->label() }}
        </span>
    @else
        <span class="inline-flex items-center gap-1 w-fit px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-zinc-50 dark:bg-zinc-950/40 text-zinc-600 dark:text-zinc-400 border border-zinc-200/60 dark:border-zinc-800/40">
            <x-icons.question-circle class="h-3.5 w-3.5 text-zinc-500 flex-shrink-0" />
            Unknown
        </span>
    @endif

    <!-- Notes / Description -->
    @if ($data->keterangan)
        <p class="text-[11px] text-zinc-500 dark:text-zinc-400 leading-normal max-w-[180px] break-words text-wrap mt-0.5 border-l-2 border-zinc-200 dark:border-zinc-700 pl-1.5 italic">
            "{{ $data->keterangan }}"
        </p>
    @endif
</div>
