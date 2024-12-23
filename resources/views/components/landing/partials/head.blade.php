<!-- Meta Tags -->
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Is a web-based attendance application for Indodacin using face recognition" />
<meta name="keywords" content="face, attendance, face-attendance, face attendance, indodacin" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Title -->
<title>{{ $title }}: Attendance System</title>

<!-- Favicons -->
<link href="{{ asset('assets/img/logo.ico') }}" rel="icon" />
<link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect" />
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
<link
	href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
	rel="stylesheet" />

<!-- Vendor CSS -->
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/global/alpine.js'])
<link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet" />
<link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />

<!-- JavaScript -->
<script defer>
	if (localStorage.getItem('color-theme') === 'dark' ||
		(!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
		document.documentElement.classList.add('dark');
	} else {
		document.documentElement.classList.remove('dark');
	}
	const APP_URL = "{{ env('APP_URL') }}"
</script>
<script defer src="{{ asset('keymap.js') }}"></script>
