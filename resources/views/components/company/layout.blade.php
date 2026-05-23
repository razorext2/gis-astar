{{-- Goal: Company profile standalone layout, Livewire: None, Alpine: Yes --}}
@props(['title' => 'PT. Indodacin Presisi Utama'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="PT. Indodacin Presisi Utama — Pionir manufaktur timbangan presisi Indonesia sejak 1950. Solusi penimbangan industri terpercaya." />
    <meta name="keywords"
        content="timbangan, weighbridge, timbangan jembatan, timbangan industri, indodacin, presisi, Indonesia" />
    <meta name="robots" content="index, follow" />

    <title>{{ $title }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo.ico') }}" rel="icon" />
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    @vite(['resources/css/company.css', 'resources/js/company.js'])
</head>

<body class="cp-body">
    {{ $slot }}
</body>

</html>
