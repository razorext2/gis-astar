<div {{ $attributes }} class="fixed bottom-0 left-1/2 z-[51] w-full max-w-lg -translate-x-1/2 md:hidden">
	<div class="h-16 w-full rounded-t-2xl border-t border-gray-200 bg-white dark:border-gray-700 dark:bg-dark-primary">
		<div class="mx-auto grid h-full max-w-lg grid-cols-5">
			{{ $slot }}
		</div>
	</div>
</div>
