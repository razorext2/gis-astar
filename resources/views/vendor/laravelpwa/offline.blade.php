<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Offline • Jaringan Tidak Tersedia</title>
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
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
				gap: 48px;
				align-items: center
			}

			@media (max-width: 900px) {
				.wrapper {
					grid-template-columns: 1fr;
					gap: 28px;
					padding: 28px 0
				}
			}

			/* Card desk scene */
			.scene {
				position: relative;
				height: min(56vh, 520px);
				min-height: 380px;
				border-radius: 28px;
				background: linear-gradient(160deg, #0f1b2c, #0c1726);
				box-shadow: var(--shadow);
				overflow: hidden
			}

			.glow {
				position: absolute;
				inset: -30%;
				background: radial-gradient(560px 420px at 30% 35%, rgba(76, 141, 255, .18), transparent 60%), radial-gradient(660px 520px at 90% 110%, rgba(126, 167, 255, .16), transparent 60%)
			}

			.floor {
				position: absolute;
				left: 0;
				right: 0;
				bottom: 0;
				height: 42%;
				background: linear-gradient(#0e1624, #0b1220)
			}

			.desk {
				position: absolute;
				left: 9%;
				right: 34%;
				bottom: 18%;
				height: 18px;
				background: #cdb899;
				border-radius: 12px;
				box-shadow: 0 16px 0 6px #b79e7b, 0 42px 24px rgba(0, 0, 0, .35)
			}

			.leg {
				position: absolute;
				width: 20px;
				height: 110px;
				background: #b79e7b;
				bottom: -126px;
				left: 14%;
				border-radius: 8px
			}

			.leg:nth-child(2) {
				left: 40%
			}

			/* Character */
			.char {
				position: absolute;
				left: 42%;
				bottom: 22%;
				width: 230px;
				height: 230px
			}

			.bubble {
				position: absolute;
				left: 58%;
				bottom: 56%;
				width: 110px;
				height: 78px;
				background: #0e1a2c;
				border: 2px solid #22324d;
				border-radius: 14px;
				display: grid;
				place-items: center;
				box-shadow: 0 10px 30px rgba(0, 0, 0, .35)
			}

			.bubble::after {
				content: "";
				position: absolute;
				left: 14px;
				bottom: -10px;
				width: 16px;
				height: 16px;
				background: #0e1a2c;
				border-left: 2px solid #22324d;
				border-bottom: 2px solid #22324d;
				transform: rotate(45deg)
			}

			.no-signal {
				display: flex;
				gap: 6px;
				align-items: end
			}

			.no-signal i {
				display: inline-block;
				width: 6px;
				background: #294068;
				height: 10px;
				border-radius: 2px
			}

			.no-signal i:nth-child(2) {
				height: 18px
			}

			.no-signal i:nth-child(3) {
				height: 26px;
				background: #22324d
			}

			.no-signal i:nth-child(4) {
				height: 34px;
				background: #22324d
			}

			.blink {
				animation: blink 1.2s infinite
			}

			@keyframes blink {
				50% {
					opacity: .35
				}
			}

			/* Minimal laptop */
			.laptop {
				position: absolute;
				left: 21%;
				bottom: 27%;
				width: 125px;
				height: 78px;
				border-radius: 10px;
				background: #0b1422;
				outline: 2px solid #23334f;
				box-shadow: 0 10px 24px rgba(0, 0, 0, .4) inset
			}

			.screen {
				position: absolute;
				inset: 6px 6px 28px;
				border-radius: 8px;
				background: linear-gradient(180deg, #122641, #0b1628)
			}

			.screen:before {
				content: "";
				position: absolute;
				inset: 0;
				border-radius: 8px;
				background: radial-gradient(120px 80px at 70% 30%, rgba(76, 141, 255, .3), transparent 60%)
			}

			.face {
				position: absolute;
				inset: auto auto 10px 14px;
				width: 38px;
				height: 28px;
				border-radius: 6px;
				background: #0d1e36;
				display: grid;
				place-items: center;
				color: #7ea7ff;
				font-size: 12px;
				font-weight: 700
			}

			.base {
				position: absolute;
				left: -6px;
				right: -6px;
				bottom: 8px;
				height: 10px;
				background: #101b2a;
				border-radius: 12px
			}

			/* Cactus */
			.cactus {
				position: absolute;
				left: 12%;
				bottom: 24%;
				width: 60px;
				height: 60px
			}

			.pot {
				position: absolute;
				width: 56px;
				height: 18px;
				bottom: 0;
				left: 2px;
				background: #aa8260;
				border-radius: 8px 8px 10px 10px
			}

			.arm,
			.arm:before {
				position: absolute;
				background: #1a864a
			}

			.arm {
				width: 20px;
				height: 36px;
				left: 18px;
				bottom: 18px;
				border-radius: 14px
			}

			.arm:before {
				content: "";
				width: 14px;
				height: 22px;
				left: -12px;
				bottom: 12px;
				border-radius: 14px
			}

			.thorn {
				position: absolute;
				width: 3px;
				height: 3px;
				background: #0d5e33;
				border-radius: 50%
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
				margin-bottom: 18px
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
				margin: 0 0 26px
			}

			.actions {
				display: flex;
				gap: 14px;
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
			<div class="scene" aria-hidden="true">
				<div class="glow"></div>
				<div class="floor"></div>
				<div class="desk">
					<div class="leg"></div>
					<div class="leg"></div>
				</div>

				<!-- Minimal laptop -->
				<div class="laptop">
					<div class="screen"></div>
					<div class="face">:(</div>
					<div class="base"></div>
				</div>

				<!-- Cactus -->
				<div class="cactus">
					<div class="pot"></div>
					<div class="arm">
						<span class="thorn" style="left:4px; top:6px"></span>
						<span class="thorn" style="left:9px; top:16px"></span>
						<span class="thorn" style="left:14px; top:8px"></span>
					</div>
				</div>

				<!-- Character silhouette (simple shapes) -->
				<svg class="char" viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg">
					<defs>
						<linearGradient id="pants" x1="0" x2="1" y1="0" y2="1">
							<stop offset="0" stop-color="#2b9be5" />
							<stop offset="1" stop-color="#2d71d9" />
						</linearGradient>
					</defs>
					<!-- chair -->
					<ellipse cx="155" cy="190" rx="46" ry="10" fill="#0a1322" opacity="0.35" />
					<path d="M150 112c24 0 31 23 22 66h-18c10-32 6-49-4-49s-20 17-12 49h-18c-10-43 8-66 30-66z" fill="#b9a2a8" />
					<!-- hoodie -->
					<path d="M105 60c30 0 46 22 46 46 0 30-16 44-44 44s-50-10-56-17c-5-6 4-15 15-19-2-20 12-54 39-54z"
						fill="#e6ecf7" />
					<!-- head -->
					<circle cx="99" cy="63" r="16" fill="#0c1422" />
					<!-- arms -->
					<rect x="35" y="108" rx="12" ry="12" width="64" height="22" fill="#e6ecf7" />
					<rect x="90" y="108" rx="12" ry="12" width="44" height="22" fill="#e6ecf7" />
					<!-- pants -->
					<path d="M75 134c26 0 58 24 60 50-22 6-70 6-98 0 2-26 18-50 38-50z" fill="url(#pants)" />
				</svg>

				<!-- Bubble: No signal bars -->
				<div class="bubble">
					<div class="no-signal" aria-label="No signal icon">
						<i class="blink"></i><i class="blink" style="animation-delay:.2s"></i><i></i><i></i>
					</div>
				</div>
			</div>

			<!-- Right: Content -->
			<div class="content">
				<div class="badge"><span class="dot"></span> Mode Offline</div>
				<h1>Ups, koneksi hilang.</h1>
				<p>Sepertinya perangkatmu tidak terhubung ke internet atau server kami sedang tidak dapat dijangkau. Periksa
					jaringanmu lalu coba lagi.</p>
				<div class="actions">
					<button class="btn primary" id="tryBtn">Coba Lagi</button>
					<a class="btn ghost" href="/">Ke Beranda</a>
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
