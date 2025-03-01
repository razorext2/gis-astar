<div
	class="{{ $total > 2 ? 'min-w-60' : 'null' }} group w-full rounded-xl border border-t-4 border-gray-200 border-t-red-300 bg-white p-4 shadow-sm transition-transform duration-500 ease-in-out hover:translate-y-2 dark:border-gray-700 dark:border-t-red-800 dark:bg-[#18181b] lg:min-w-full lg:px-6 xl:px-8">
	<div class="flex h-full w-full items-center justify-between gap-x-2">
		<div>
			<h5 class="pb-2 text-3xl font-bold leading-none text-gray-900 dark:text-white">{{ $count }} <sup
					class="text-xs !font-thin">{{ $indicator }}</sup>
			</h5>
			<p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $label }}</p>
		</div>
		<div class="flex items-center px-2.5 py-0.5 text-center text-base font-semibold text-green-500 dark:text-green-500">
			12%
			<svg class="ms-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M5 13V1m0 0L1 5m4-4 4 4" />
			</svg>
		</div>
	</div>
</div>
