<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		@include('dashboard.layoutsDash.head')
	</head>

	<body class="bg-gray-50 dark:bg-[#09090b]">

		@if (session('status'))
			<div
				class="fixed right-0 top-[4.5rem] z-50 flex w-full max-w-sm scale-90 transform items-center divide-x transition duration-300"
				id="toast-top-right" role="alert" x-data="{ showToast: true }" x-init="setTimeout(() => showToast = false, 3000)" x-show="showToast"
				x-transition:enter="transition ease-in duration-300" x-transition:enter-start="transform scale-90 opacity-0"
				x-transition:enter-end="transform scale-100 opacity-100" x-transition:leave="transition ease-out duration-300"
				x-transition:leave-start="transform scale-100 opacity-100" x-transition:leave-end="transform scale-90 opacity-0">
				<div
					class="mb-4 flex w-full max-w-sm items-center rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#09090b] dark:ring-gray-500"
					id="toast-success" role="alert">
					<div
						class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-500 dark:bg-green-950">
						<svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
							viewBox="0 0 20 20">
							<path
								d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
						</svg>
						<span class="sr-only">Check icon</span>
					</div>
					<div class="ms-3 mt-0.5 text-sm font-normal text-black dark:text-white">
						<x-auth.auth-session-status :status="session('status')" />
					</div>
					<button
						class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-green-950 dark:text-green-400"
						type="button" aria-label="Close" @click="showToast = false">
						<span class="sr-only">Close</span>
						<svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
						</svg>
					</button>
				</div>
			</div>
		@endif

		@include('dashboard.layoutsDash.navbar')

		@include('dashboard.layoutsDash.sidebar')

		<div class="mb-20 max-w-screen-xl p-2 sm:ml-72 sm:mt-0 sm:p-4 xl:ml-[420px]">

			<div class="mt-10 rounded-lg p-2 sm:p-4 md:mt-6">

				<!-- carousel for cards -->
				<div class="grid grid-cols-1">
					@include('dashboard.layoutsDash.title')
				</div>

				<x-card.card-carousel />

				@yield('content')
			</div>
		</div>

		{{-- bikin navigasi ala android --}}
		<x-dashboard.mobile-drawer></x-dashboard.mobile-drawer>
		<div class="fixed inset-0 z-50 bg-white dark:bg-[#09090b] md:z-[9999]" id="preloader">
		</div>

		<!-- js -->
		@include('dashboard.layoutsDash.js')
	</body>

</html>
