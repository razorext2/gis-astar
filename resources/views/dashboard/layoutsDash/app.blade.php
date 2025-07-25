<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		@include('dashboard.layoutsDash.head')
	</head>

	<body class="bg-gray-100 dark:bg-[#09090b]">
		@if (session('status'))
			<div
				class="fixed left-1/2 top-20 z-50 flex w-full -translate-x-1/2 transform items-center divide-x px-4 transition duration-300 md:left-auto md:right-4 md:top-20 md:w-fit md:translate-x-0 md:px-0"
				id="toast-top-right" role="alert" x-data="{ showToast: true }" x-init="setTimeout(() => showToast = false, 3000)" x-show="showToast"
				x-transition:enter="transition ease-in duration-300" x-transition:enter-start="transform scale-90 opacity-0"
				x-transition:enter-end="transform scale-100 opacity-100" x-transition:leave="transition ease-out duration-300"
				x-transition:leave-start="transform scale-100 opacity-100" x-transition:leave-end="transform scale-90 opacity-0">
				<div
					class="flex w-full items-center gap-x-4 rounded-xl border border-t-4 border-gray-200 border-t-red-600 bg-white p-4 shadow-md dark:border-gray-700 dark:border-t-red-800 dark:bg-dark-primary"
					id="toast-success" role="alert">
					<div class="text-sm font-normal text-black dark:text-white">
						<x-auth.auth-session-status :status="session('status')" />
					</div>

					<x-button.danger class="ms-auto" @click="showToast = false">
						<span class="sr-only">Close</span>
						<x-icons.close class="h-5 w-5" />
					</x-button.danger>

				</div>
			</div>
		@endif

		@persist('navbar')
			@include('dashboard.layoutsDash.navbar')
		@endpersist

		@include('dashboard.layoutsDash.sidebar')

		<div class="mb-20 mt-32 max-w-screen-xl px-4 sm:ml-72 sm:mt-24 md:mb-4 xl:ml-96">

			{{-- breadcrumb --}}
			@livewire('utils.breadcrumb')

			{{-- title --}}
			<div class="grid grid-cols-1">
				@include('dashboard.layoutsDash.title')
			</div>

			{{-- carousel for cards --}}
			@persist('card-carousel')
				@livewire('components.card')
			@endpersist

			{{-- announcement --}}
			@livewire('utils.announcement-container')

			{{-- main content --}}
			@yield('content')

		</div>

		{{-- bikin navigasi ala android --}}
		@persist('mobile-drawer')
			<x-mobile-drawer></x-mobile-drawer>
		@endpersist

		{{-- preload --}}
		{{-- <div class="fixed inset-0 z-50 bg-white dark:bg-[#09090b] md:z-[9999]" id="preloader">
		</div> --}}

		<!-- js -->
		@include('dashboard.layoutsDash.js')
	</body>

</html>
