<div class="flex flex-col gap-0.5">
	<div class="flex w-full flex-col items-start gap-0.5 lg:flex-row lg:items-center lg:gap-2">
		@if ($data->no_sr)
			<span class="rounded-md bg-blue-400 px-1.5 py-0.5 text-xs dark:bg-blue-800">{{ $data->no_sr }}</span>
		@endif
		<span class="w-full text-wrap">{{ $data->title }} </span>
	</div>
	<span class="w-full text-wrap text-xs">{{ $data->lokasi }}</span>
	<span class="w-full text-xs text-gray-400">
		<a class="inline-flex underline"
			href="https://www.google.com/maps/search/?api=1&query={{ $data->latitude }},{{ $data->longitude }}" target="_blank">
			{{ $data->latitude }}, {{ $data->longitude }}
			<x-icons.arrow-up class="h-4 w-4 rotate-45" />
		</a>
	</span>
</div>
