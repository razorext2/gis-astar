<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>FaceID Attendance System</title>
<meta name="description" content="Is a web-based attendance application for Indodacin using face recognition" />
<meta name="keywords" content="face, attendance, face-attendance, face attendance, indodacin" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

<!-- Favicons -->
<link href="{{ asset('assets/img/logo.ico') }}" rel="icon" />
<link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />
<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect" />
<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
<link
	href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
	rel="stylesheet" />
<!-- Vendor CSS Files -->
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/global/simpleTables.js', 'resources/js/global/alpine.js', 'resources/js/global/chart.js'])
@if (Route::is('dashboard'))
	{{-- @vite(['resources/js/chart.js']) --}}
@elseif (Route::is('pegawai.timeline') ||
		Route::is('placement.create') ||
		Route::is('placement.edit') ||
		Route::is('pegawai.collectors'))
	@vite(['resources/js/global/leaflet.js'])
@endif

<link href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css" rel="stylesheet">
<link href="https://cdn.datatables.net/datetime/1.5.4/css/dataTables.dateTime.min.css" rel="stylesheet">
{{-- datatables button --}}
<link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css" rel="stylesheet">
{{-- quill --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
{{-- sweetalert --}}
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
{{-- jquery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
	if (
		localStorage.getItem("color-theme") === "dark" ||
		(!("color-theme" in localStorage) &&
			window.matchMedia("(prefers-color-scheme: dark)").matches)
	) {
		document.documentElement.classList.add("dark");
	} else {
		document.documentElement.classList.remove("dark");
	}

	const APP_URL = "{{ env('APP_URL') }}";
</script>
