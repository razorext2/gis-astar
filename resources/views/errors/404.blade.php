<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>Not Found</title>

		<!-- Fonts -->
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

	<body class="dark:bg-gray-900 bg-white antialiased">
		<div class="container mx-auto px-8">
			<div class="grid md:grid-cols-2">
				<div class="flex flex-col justify-evenly md:h-screen md:flex-row">
					<img class="w-64 md:w-full" src="{{ asset('assets/img/404.svg') }}" alt="" loading="lazy">
				</div>

				<div class="flex flex-col justify-evenly md:h-screen md:flex-row md:items-center">
					<div class="mx-auto max-w-screen-xl lg:px-6 lg:py-16">
						<div class="mx-auto max-w-screen-sm">
							<span class="mb-4 text-8xl font-bold text-blue-500">404</span>
							<p class="dark:text-white mb-4 text-3xl font-extrabold tracking-tight text-gray-900 md:text-4xl">Whoops! That
								page doesn’t exist.</p>
							<p class="dark:text-gray-400 mb-4 text-lg font-light text-gray-500">The page that you're looking for is nowhere.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</body>

</html>
