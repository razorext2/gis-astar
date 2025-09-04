<!-- Web Application Manifest -->
<link rel="manifest" crossorigin="use-credentials" href="{{ route('laravelpwa.manifest') }}">

<!-- THEME-COLOR: satu meta global, akan diubah via JS -->
<meta name="theme-color" content="#ffffff"><!-- default light; JS akan override -->

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="{{ $config['display'] == 'standalone' ? 'yes' : 'no' }}">
<meta name="application-name" content="{{ $config['short_name'] }}">
<link rel="icon" sizes="{{ data_get(end($config['icons']), 'sizes') }}"
	href="{{ data_get(end($config['icons']), 'src') }}">

<!-- iOS: status bar menyatu; warna ikut meta theme-color -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ $config['short_name'] }}">
<link rel="apple-touch-icon" href="{{ data_get(end($config['icons']), 'src') }}">

{{-- Splash iOS (opsional, biarkan jika dipakai) --}}
<link href="{{ $config['splash']['640x1136'] }}"
	media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['750x1334'] }}"
	media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1242x2208'] }}"
	media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1125x2436'] }}"
	media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['828x1792'] }}"
	media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1242x2688'] }}"
	media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1536x2048'] }}"
	media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1668x2224'] }}"
	media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1668x2388'] }}"
	media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
	rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['2048x2732'] }}"
	media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
	rel="apple-touch-startup-image" />

<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="{{ $config['background_color'] }}">
<meta name="msapplication-TileImage" content="{{ data_get(end($config['icons']), 'src') }}">

<script>
	// Service Worker (tetap)
	if ('serviceWorker' in navigator) {
		navigator.serviceWorker.register('/serviceworker.js', {
				scope: '.'
			})
			.then(r => console.log('PWA SW registered:', r.scope))
			.catch(e => console.log('PWA SW failed:', e));
	}

	// ==== THEME-COLOR SYNC (light/dark) ====
	const THEME_COLORS = {
		light: '#ffffff', // warna status bar untuk light
		dark: '#18181b' // warna status bar untuk dark
	};

	function setThemeColorMeta(color) {
		let meta = document.querySelector('meta[name="theme-color"]');
		if (!meta) {
			meta = document.createElement('meta');
			meta.name = 'theme-color';
			document.head.appendChild(meta);
		}
		meta.setAttribute('content', color);
	}

	function applyThemeColor() {
		const isDark = document.documentElement.classList.contains('dark');
		setThemeColorMeta(isDark ? THEME_COLORS.dark : THEME_COLORS.light);
	}

	// Jalankan saat load
	document.addEventListener('livewire:navigated', applyThemeColor);

	// Simpan global supaya bisa dipanggil
	window.updateThemeColor = applyThemeColor;

	function toggleTheme(dark) {
		if (dark) {
			document.documentElement.classList.add('dark');
		} else {
			document.documentElement.classList.remove('dark');
		}
		// setelah toggle, update meta theme-color
		updateThemeColor();
	}

	const isDarkMode =
		localStorage.getItem('color-theme') === 'dark' ||
		(!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

	toggleTheme(isDarkMode);

	document.addEventListener('livewire:navigated', () => {
		// ==== SWITCH THEME ====
		const themeToggleDarkBtn = document.getElementById('theme-toggle-dark');
		const themeToggleLightBtn = document.getElementById('theme-toggle-light');

		themeToggleDarkBtn.addEventListener('click', () => toggleTheme(true));
		themeToggleLightBtn.addEventListener('click', () => toggleTheme(false));
	})
</script>
