<div class="relative w-full" id="notifications-bell">
	<x-icons.bell class="h-6 w-6 text-gray-800 dark:text-white" />

	@if ($notification)
		<div class="absolute -left-0.5 bottom-0 block h-2 w-2" id="notificationDot" aria-live="polite">
			<span class="absolute mx-auto inline-flex h-full w-full animate-ping rounded-full bg-yellow-400 opacity-75"></span>
			<span class="absolute h-2 w-2 rounded-full bg-red-500"></span>
		</div>
	@endif

	<div class="absolute -left-0.5 bottom-0 hidden h-2 w-2" id="notificationDot" aria-live="polite">
		<span class="absolute mx-auto inline-flex h-full w-full animate-ping rounded-full bg-yellow-400 opacity-75"></span>
		<span class="absolute h-2 w-2 rounded-full bg-red-500"></span>
	</div>

</div>
