<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Kamu tidak terhubung...</title>
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<style>
			:root {
				--bg: #0c1420;
				--muted: #8aa0bd;
				--text: #e9f0ff;
				--accent: #4c8dff;
				--accent-2: #7ea7ff;
				--card: #101b2a;
				--shadow: 0 40px 80px rgba(2, 10, 30, .35), 0 8px 24px rgba(2, 10, 30, .4);
			}

			* {
				box-sizing: border-box
			}

			html,
			body {
				height: 100%
			}

			body {
				margin: 0;
				font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
				background: radial-gradient(1200px 800px at 70% -10%, #16243a 0%, #0f1a2a 35%, var(--bg) 70%);
				color: var(--text);
				display: grid;
				place-items: center;
				overflow: hidden;
			}

			.wrapper {
				width: min(1100px, 92vw);
				display: grid;
				grid-template-columns: 1.1fr .9fr;
				gap: 36px;
				align-items: center
			}

			@media (max-width: 900px) {
				.wrapper {
					grid-template-columns: 1fr;
					gap: 16px;
					padding: 14px 0
				}
			}

			.scene {
				position: relative;
				height: min(56vh, 520px);
				min-height: 380px;
				border-radius: 28px;
				background: linear-gradient(160deg, #0f1b2c, #0c1726);
				box-shadow: var(--shadow);
				overflow: hidden;
				display: flex;
				align-items: center;
				justify-content: center
			}

			/* Big title side */
			.content h1 {
				font-size: clamp(44px, 5vw, 72px);
				line-height: 1;
				margin: 0 0 16px;
				letter-spacing: .5px
			}

			.badge {
				display: inline-flex;
				align-items: center;
				gap: 10px;
				padding: 10px 14px;
				border-radius: 999px;
				background: #0f1b2c;
				border: 1px solid #20304b;
				color: #b4c5e3;
				font-weight: 600;
				font-size: 14px;
				margin-bottom: 12px
			}

			.dot {
				width: 8px;
				height: 8px;
				border-radius: 999px;
				background: #ffb84d;
				box-shadow: 0 0 16px #ffb84d
			}

			.content p {
				color: var(--muted);
				font-size: clamp(16px, 1.5vw, 18px);
				margin: 0 0 16px
			}

			.actions {
				display: flex;
				flex-wrap: wrap
			}

			.btn {
				appearance: none;
				border: 0;
				padding: 14px 18px;
				border-radius: 14px;
				font-weight: 700;
				font-size: 16px;
				cursor: pointer;
				transition: transform .08s ease, box-shadow .2s ease;
			}

			.primary {
				background: linear-gradient(180deg, var(--accent), var(--accent-2));
				color: white;
				box-shadow: 0 12px 28px rgba(76, 141, 255, .35)
			}

			.primary:active {
				transform: translateY(1px)
			}

			.ghost {
				background: #0e1b2d;
				color: #bcd0f2;
				border: 1px solid #243555
			}

			.hint {
				margin-top: 16px;
				font-size: 13px;
				color: #89a0bf
			}

			.hint code {
				background: #0e1b2d;
				border: 1px solid #243555;
				padding: 3px 6px;
				border-radius: 6px;
				color: #cfe0ff
			}
		</style>
	</head>

	<body>
		<div class="wrapper">
			<!-- Left: Scene Illustration (pure CSS) -->
			<div class="scene" aria-hidden="true" style="align-items: center;">
				<img style="min-width: 200px; max-width: 400px;" src="{{ asset('assets/img/500.svg') }}" alt="">
			</div>

			<!-- Right: Content -->
			<div class="content" style="margin-bottom: 20px;">
				<div class="badge"><span class="dot"></span> Mode Offline</div>
				<h1>Ups, koneksi hilang.</h1>
				<p>Sepertinya perangkatmu tidak terhubung ke internet atau server kami sedang tidak dapat dijangkau. Periksa
					jaringanmu lalu coba lagi.</p>
				<div class="actions">
					<button class="btn primary" id="tryBtn">Coba Lagi</button>
				</div>
				<div class="hint" id="statusHint"></div>
			</div>
		</div>

		<script>
			const hint = document.getElementById('statusHint');

			function renderStatus() {
				const online = navigator.onLine;
				hint.textContent = online ? 'Jaringan terdeteksi. Kamu bisa memuat ulang halaman.' :
					'Tidak ada jaringan. Aktifkan data/Wi‑Fi untuk melanjutkan.';
			}
			window.addEventListener('online', renderStatus);
			window.addEventListener('offline', renderStatus);
			renderStatus();

			// Try again button: if online -> reload; if offline -> ping a bit then show message
			document.getElementById('tryBtn').addEventListener('click', async () => {
				if (navigator.onLine) {
					location.reload();
					return;
				}
				hint.textContent = 'Mengecek koneksi…';
				// small retry window to detect connectivity changes
				const started = Date.now();
				const check = () => {
					if (navigator.onLine) {
						location.reload();
						return;
					}
					if (Date.now() - started < 3000) requestAnimationFrame(check);
					else hint.textContent = 'Masih offline. Coba lagi nanti.';
				}
				check();
			});
		</script>
	</body>

</html>
