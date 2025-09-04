<!-- Meta Tags -->
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Is a web-based attendance application for Indodacin using face recognition" />
<meta name="keywords" content="face, attendance, face-attendance, face attendance, indodacin" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ $title }}: Attendance System</title>

@laravelPWA
@livewireStyles

<!-- Favicons -->
<link href="{{ asset('assets/img/logo.ico') }}" rel="icon" />
<link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect" />
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />

<!-- Vendor CSS -->
@vite('resources/css/app.css')
@vite('resources/js/app.js')

<link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
