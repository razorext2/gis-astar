<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>FaceID Attendance System</title>
<meta name="description" content="Is a web-based attendance application for Indodacin using face recognition" />
<meta name="keywords" content="face, attendance, face-attendance, face attendance, indodacin" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user-id" content="{{ auth()->user()->id }}">

<!-- Favicons -->
<link href="{{ asset('assets/img/logo.ico') }}" rel="icon" />
<link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

@livewireStyles

<!-- Vite Files -->
@vite('resources/css/app.css')
@vite('resources/js/app.js')

@if (Route::is('pegawai.timeline') ||
		Route::is('placement.create') ||
		Route::is('placement.edit') ||
		Route::is('pegawai.collectors') ||
		Route::is('pegawai.sales'))
	@vite('resources/js/global/leaflet.js')
@endif

<!-- Datatables Tailwind -->
<link href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css" rel="stylesheet">
<!-- Datatables Button -->
<link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css" rel="stylesheet">
{{-- Tom select --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">

<!-- Theme -->
<script>
	if (localStorage.getItem("color-theme") === "dark" || (!("color-theme" in localStorage) && window.matchMedia(
			"(prefers-color-scheme: dark)").matches)) {
		document.documentElement.classList.add("dark");
	} else {
		document.documentElement.classList.remove("dark");
	}
	const APP_URL = "{{ env('APP_URL') }}";
</script>
