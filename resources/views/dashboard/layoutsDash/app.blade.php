<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		@include('dashboard.layoutsDash.head')
	</head>

	<body class="bg-gray-100 dark:bg-[#09090b]">
		@if (session('status'))
			<x-notification-popup>
				{{ session('status') }}
			</x-notification-popup>
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
