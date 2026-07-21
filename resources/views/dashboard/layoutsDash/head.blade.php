{{-- Goal: Dashboard head metadata, styles, and dark mode initialization script, Livewire: None, Alpine: None --}}
<script>
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Dashboard System</title>
<meta name="description" content="Dashboard System" />
<meta name="keywords" content="dashboard, system, indodacin" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-id" content="{{ auth()->user()->id }}">
<meta name="vapid-public-key" content="{{ config('webpush.vapid.public_key') }}">

<!-- Favicons -->
<link href="{{ asset('assets/img/logo.ico') }}" rel="icon" />
<link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />
<link href="https://fonts.googleapis.com/css2?family=Bungee&family=Poppins&family=Montserrat&display=swap"
    rel="stylesheet">

@livewireStyles

<!-- Vite Files -->
@vite('resources/css/app.css')
@vite('resources/js/app.js')

{{-- Tom select --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
