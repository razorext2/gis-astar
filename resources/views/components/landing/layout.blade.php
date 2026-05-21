{{-- Goal: Landing page layout wrapper, Livewire: None, Alpine: Yes --}}
@props(['title' => ''])

<!DOCTYPE html>
<html class="scroll-smooth {{ (isset($_COOKIE['color-theme']) && $_COOKIE['color-theme'] === 'dark') ? 'dark' : '' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		@include('components.landing.partials.head', ['title' => $title])
	</head>

	<body>
		<x-landing.navbar />

		{{ $slot }}

		@if (session('success'))
			<x-alert></x-alert>
		@endif

		<x-landing.footer />
		<x-landing.mobile-drawer />

		<div class="fixed inset-0 z-50 bg-white dark:bg-zinc-800 md:z-[100]" id="preloader">
		</div>

		@include('components.landing.partials.script')
	</body>

</html>
