<div
	class="w-full rounded-lg border border-gray-200 bg-white p-4 text-right transition-transform duration-500 hover:z-10 hover:scale-105 dark:border-gray-700 dark:bg-[#18181b] lg:hover:scale-110">
	<h2 class="text-md font-medium text-gray-900 dark:text-white md:text-lg">
		{{ $label }}
	</h2>
	<div>
		<p class="text-2xl font-medium text-gray-900 dark:text-white lg:text-4xl">
			{{ Number::format($percentage, 1) }}% <sup class="text-xs font-normal md:text-sm">
				{{ $approved }} dari
				{{ $total }}
				laporan</sup>
		</p>
	</div>
</div>
