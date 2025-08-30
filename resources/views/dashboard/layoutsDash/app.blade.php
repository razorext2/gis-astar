<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		@include('dashboard.layoutsDash.head')
	</head>

	<body class="relative bg-gray-100 dark:bg-[#09090b]" x-data="{ openSidebar: true }">
		@if (session('status'))
			<x-notification-popup>
				{{ session('status') }}
			</x-notification-popup>
		@endif

		@persist('navbar')
			@include('dashboard.layoutsDash.navbar')
		@endpersist

		@include('dashboard.layoutsDash.sidebar')

		<div
			:class="openSidebar ? 'max-w-screen-xl sm:ml-72 xl:ml-96' : 'sm:ml-24 md:ml-28 lg:ml-36 xl:mx-36 mx-auto max-w-screen-2xl'"
			class="mb-20 mt-32 px-4 transition-all duration-300 ease-in-out sm:mt-24 md:mb-4">

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
