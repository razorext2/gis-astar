<div
	class="fixed left-1/2 top-20 z-[60] flex w-full -translate-x-1/2 items-center divide-x px-4 transition-all duration-300 md:left-auto md:right-4 md:top-20 md:w-fit md:max-w-96 md:translate-x-0 md:px-0"
	id="toast-top-right" role="alert" x-data="{ showToast: true }" x-init="setTimeout(() => showToast = false, 3000)" x-show="showToast"
	x-transition:enter="transition ease-in duration-300" x-transition:enter-start="transform scale-90 opacity-0"
	x-transition:enter-end="transform scale-100 opacity-100" x-transition:leave="transition ease-out duration-300"
	x-transition:leave-start="transform scale-100 opacity-100" x-transition:leave-end="transform scale-90 opacity-0">

	<div
		class="relative flex w-full items-center gap-x-2 rounded-xl border border-t-4 border-gray-200 border-t-red-600 bg-white p-4 shadow-md dark:border-gray-700 dark:border-t-red-800 dark:bg-dark-primary md:gap-x-4"
		id="toast-success" role="alert">
		<div class="text-justify text-sm font-normal text-black dark:text-white">
			{{ $slot }}
		</div>

		<x-button.danger class="absolute -bottom-3 right-1/2 ms-auto translate-x-1/2 !rounded-full !p-2"
			@click="showToast = false">
			<span class="sr-only">Close</span>
			<x-icons.close class="h-3 w-3" />
		</x-button.danger>

	</div>

</div>
