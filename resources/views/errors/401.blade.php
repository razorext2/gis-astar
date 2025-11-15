<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>401: Unauthorized</title>

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

<body class="bg-white antialiased dark:bg-gray-900">
    <div class="container mx-auto px-8">
        <div class="grid h-screen md:grid-cols-2">
            <!-- Left section (Image) -->
            <div class="flex items-center justify-center">
                <img class="w-64 md:w-full" src="{{ asset('assets/img/403.png') }}" alt="403 Image" loading="lazy">
            </div>

            <!-- Right section (Text) -->
            <div class="flex items-center justify-center">
                <div class="mx-auto max-w-screen-xl lg:px-6 lg:py-16">
                    <div class="mx-auto max-w-screen-sm">
                        <span class="mb-4 text-8xl font-bold text-blue-500">401</span>
                        <p
                            class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white md:text-4xl">
                            Unauthorized.
                        </p>
                        <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">
                            You need authorized account to do this!
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
