<div
	class="{{ $total > 2 ? 'min-w-60' : '' }} group relative w-full overflow-hidden rounded-xl border border-t-4 border-gray-200 border-t-red-600 bg-white p-4 shadow-md transition-transform duration-500 ease-in-out hover:translate-y-2 dark:border-gray-700 dark:border-t-red-800 dark:bg-dark-primary dark:shadow-none lg:min-w-full lg:px-6 xl:px-8">
	<div class="flex h-full w-full items-center justify-between gap-x-2 overflow-hidden">
		<div>
			<h5 class="pb-2 text-3xl font-bold leading-none text-gray-900 dark:text-white">{{ $count }} <sup
					class="text-xs !font-thin">{{ $indicator }}</sup>
			</h5>
			<p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $label }}</p>
		</div>
	</div>
	<div
		class="absolute -right-5 top-1/2 -translate-y-1/2 items-center rounded-full bg-red-200 p-5 transition-transform duration-500 group-hover:scale-150 dark:bg-red-800">
	</div>
</div>
