<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ config('app.name', 'Laravel') }}</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

		@livewireStyles()
		@laravelPWA

		<!-- Fonts -->
		<link href="{{ asset('assets/img/logo.ico') }}" rel="icon" />
		<link href="https://fonts.bunny.net" rel="preconnect">
		<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

		<!-- Scripts -->
		@vite(['resources/css/app.css', 'resources/js/app.js'])

		<script>
			// On page load or when changing themes, best to add inline in `head` to avoid FOUC
			if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
					'(prefers-color-scheme: dark)').matches)) {
				document.documentElement.classList.add('dark');
			} else {
				document.documentElement.classList.remove('dark')
			}
		</script>
	</head>

	<body class="bg-gradient-to-t from-red-500 to-white antialiased dark:from-gray-800 dark:to-red-500">
		@if (session('status'))
			<div
				class="fixed bottom-5 right-5 z-50 flex w-full max-w-xs scale-90 transform items-center divide-x rounded-lg transition duration-300"
				id="toast-bottom-right" role="alert" x-data="{ showToast: true }" x-init="setTimeout(() => showToast = false, 3000)" x-show="showToast"
				x-transition:enter="transition ease-in duration-300" x-transition:enter-start="transform scale-90 opacity-0"
				x-transition:enter-end="transform scale-100 opacity-100" x-transition:leave="transition ease-out duration-300"
				x-transition:leave-start="transform scale-100 opacity-100" x-transition:leave-end="transform scale-90 opacity-0">
				<div
					class="mb-4 flex w-full max-w-xs items-center rounded-lg bg-white p-4 text-gray-500 shadow ring-1 ring-gray-200 dark:bg-dark-primary dark:text-white dark:ring-gray-700"
					id="toast-success" role="alert">
					<div
						class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-500 dark:text-white">
						<svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
							viewBox="0 0 20 20">
							<path
								d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
						</svg>
						<span class="sr-only">Check icon</span>
					</div>
					<div class="ms-3 mt-0.5 text-sm font-normal text-black"><x-auth.auth-session-status class="mb-4"
							:status="session('status')" />
					</div>
					<button
						class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-500 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-300"
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

		<div class="container mx-auto px-6">
			<div class="flex h-screen flex-col justify-evenly gap-4 md:flex-row md:items-center md:text-left">
				<div class="flex w-full flex-col text-center md:text-left">
					<div class="hidden md:block">
						<svg class="fill-stroke mx-auto h-20 w-20 text-gray-800 dark:text-white md:float-left" fill="none"
							stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
							</path>
						</svg>
					</div>
					<h1 class="text-5xl font-bold text-gray-800 dark:text-white">Indodacin Presisi Utama</h1>
					<p class="mx-auto mt-5 w-full text-gray-500 dark:text-white md:mx-0 md:mt-3">
						Jl. Glugur No.18-D, Petisah Tengah, Kota Medan
					</p>
				</div>
				{{ $slot }}
			</div>
		</div>

		@livewireScripts()
	</body>

</html>
