@props(['location' => null, 'lat' => null, 'long' => null])

<div class="flex flex-col">
	<span class="font-medium">{{ $location }}</span>
	<span class="text-xs text-gray-400">
		<a class="inline-flex underline"
			href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $long }}" target="_blank">
			{{ $lat }}, {{ $long }}
			<x-icons.arrow-up class="h-4 w-4 rotate-45" />
		</a>
	</span>
</div>
