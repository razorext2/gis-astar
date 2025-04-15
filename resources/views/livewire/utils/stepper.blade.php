<ol class="flex w-full items-center text-center text-sm font-medium text-gray-500 dark:text-gray-400 sm:text-base">
	<li
		class="after:border-1 {{ $step == 2 || $step == 3 ? 'after:border-blue-600 dark:after:border-blue-500' : 'dark:after:border-gray-700' }} flex items-center text-blue-600 after:mx-6 after:hidden after:h-1 after:w-full after:border-b dark:text-blue-500 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
		<span
			class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] dark:after:text-gray-500 sm:after:hidden">
			<x-icons.checklist-stepper class="me-2.5 h-3.5 w-3.5 sm:h-4 sm:w-4" />
			Akumulasi <span class="hidden sm:ms-2 sm:inline-flex">Poin </span>
		</span>
	</li>

	<li
		class="after:border-1 {{ $step == 2 || $step == 3 ? 'text-blue-600 dark:text-blue-500' : '' }} {{ $step == 3 ? 'after:border-blue-600 dark:after:border-blue-500' : 'dark:after:border-gray-700' }} flex items-center after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 after:content-[''] sm:after:inline-block md:w-full xl:after:mx-10">
		<span
			class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] dark:after:text-gray-500 sm:after:hidden">

			@if ($step == 2 || $step == 3)
				<x-icons.checklist-stepper class="me-2.5 h-3.5 w-3.5 sm:h-4 sm:w-4" />
			@else
				<span class="me-2">2</span>
			@endif

			Validasi <span class="hidden sm:ms-2 sm:inline-flex">Poin</span>
		</span>
	</li>

	<li class="{{ $step == 3 ? 'text-blue-600 dark:text-blue-500' : '' }} flex items-center">
		<span class="me-2">3</span>
		Konfirmasi
	</li>
</ol>
