@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="grid gap-6 xl:grid-cols-4">
		<div class="w-full space-y-6 xl:col-span-3">
			<form id="photoForm" action="{{ route('pegawai.update', $pegawai) }}" method="POST" enctype="multipart/form-data">
				<div
					class="dark:bg-[#18181b] dark:ring-gray-700 grid gap-6 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 sm:p-6 lg:grid-cols-2">
					<div class="max-w-xl">
						<header class="flex flex-row">
							<a
								class="dark:bg-red-800 dark:hover:bg-red-900 dark:text-white dark:ring-gray-700 mb-4 mr-3 flex flex-row rounded-lg px-2.5 py-2.5 align-middle ring-1 ring-red-700 hover:bg-red-300 md:px-4"
								href="{{ route('pegawai.index') }}">
								<svg class="dark:fill-white" class="icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
									viewBox="0 0 1024 1024" fill="#000000" version="1.1">
									<path
										d="M669.6 849.6c8.8 8 22.4 7.2 30.4-1.6s7.2-22.4-1.6-30.4l-309.6-280c-8-7.2-8-17.6 0-24.8l309.6-270.4c8.8-8 9.6-21.6 2.4-30.4-8-8.8-21.6-9.6-30.4-2.4L360.8 480.8c-27.2 24-28 64-0.8 88.8l309.6 280z"
										fill="" />
								</svg>
								Kembali
							</a>
							<h2 class="dark:text-white mt-2 text-lg font-medium text-gray-900">
								{{ __('Edit Data Pegawai') }}
							</h2>

						</header>
						<p class="dark:text-gray-300 mt-1 text-sm text-gray-600">
							{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
						</p>

						@csrf
						@method('put')
						<div class="mb-4 grid gap-6 sm:mb-5 sm:grid-cols-2 sm:gap-6">
							<div class="sm:col-span-2">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="kode_pegawai">Kode
									Pegawai</label>
								<input
									class="focus:ring-primary-600 focus:border-primary-600 block w-full cursor-not-allowed rounded-lg border border-gray-300 bg-gray-200 p-2.5 text-sm text-gray-900"
									id="kode_pegawai" type="text" value="{{ $pegawai->kode_pegawai }}" placeholder="Nama lengkap" required=""
									disabled>
								<input name="kode_pegawai" type="hidden" value="{{ $pegawai->kode_pegawai }}">
							</div>
							<div class="sm:col-span-2">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="nik_pegawai">NIK</label>
								<input
									class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900"
									id="nik_pegawai" name="nik_pegawai" type="text" value="{{ old('nik_pegawai', $pegawai->nik_pegawai) }}"
									placeholder="NIK" required="" pattern="[0-9]{1,17}">
							</div>
							<div class="w-full">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="nama_lengkap">Nama
									Lengkap</label>
								<input
									class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
									id="nama_lengkap" name="nama_lengkap" type="text" value="{{ old('full_name', $pegawai->full_name ?? '') }}"
									placeholder="Nama lengkap" required="">
							</div>
							<div class="w-full">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="nick_name">Nama
									Panggilan</label>
								<input
									class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
									id="nick_name" name="nick_name" type="text" value="{{ old('nick_name', $pegawai->nick_name ?? '') }}"
									placeholder="Nama panggilan" required="">
							</div>
							<div class="w-full">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="jabatan">Posisi</label>
								<select
									class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
									id="jabatan" name="jabatan">
									<option selected>Pilih</option>
									@foreach ($jabatan as $jb)
										<option value="{{ $jb->id }}" @if ($pegawai->jabatan == $jb->id) selected @endif>
											{{ $jb->nama_jabatan }}
										</option>
									@endforeach

								</select>
							</div>
							<div class="w-full">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="golongan">Posisi</label>
								<select
									class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
									id="golongan" name="golongan">
									<option selected>Pilih</option>
									@foreach ($golongan as $gol)
										<option value="{{ $gol->id }}" @if ($pegawai->golongan == $gol->id) selected @endif>
											{{ $gol->nama_golongan }}
										</option>
									@endforeach

								</select>
							</div>
							<div class="w-full">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="no_telp">Nomor Telepon</label>
								<input
									class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
									id="no_telp" name="no_telp" type="tel" value="{{ old('no_telp', $pegawai->no_telp ?? '') }}"
									title="Nomor telepon harus terdiri dari 10 hingga 13 digit" placeholder="Masukkan nomor telepon" required
									pattern="[0-9]{10,13}">
							</div>

							<div class="relative max-w-sm">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="tgl_lahir">Tanggal Lahir</label>
								<div class="pointer-events-none absolute inset-y-0 start-0 top-7 flex items-center ps-3">
									<svg class="dark:text-gray-400 h-4 w-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="currentColor" viewBox="0 0 20 20">
										<path
											d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
									</svg>
								</div>
								<input
									class="block w-full rounded-lg border border-gray-300 bg-white p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
									id="tgl_lahir" name="tgl_lahir" type="text" value="{{ old('tgl_lahir', $pegawai->tgl_lahir ?? '') }}"
									datepicker datepicker-format="yyyy-mm-dd" placeholder="Select date">
							</div>

							<div class="sm:col-span-2">
								<label class="dark:text-white mb-2 block text-sm font-medium text-gray-900" for="alamat">Alamat</label>
								<textarea
								 class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
								 id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap" required>{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
							</div>

						</div>
						<div class="flex items-center">
							<button
								class="dark:bg-blue-800 dark:hover:bg-blue-900 dark:text-white dark:ring-gray-700 inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 hover:bg-blue-800 hover:text-white focus:text-white focus:ring-4 focus:ring-blue-300"
								type="submit">
								Update
								<svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
									fill="none" viewBox="0 0 14 10">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M1 5h12m0 0L9 1m4 4L9 9" />
								</svg>
							</button>
						</div>

					</div>

					<div class="w-full">
						@csrf
						@php
							$path = 'assets/img/noCamera.webp';
						@endphp
						<div class="col-span-1 grid h-auto gap-6 text-center lg:col-span-2" data-aos="zoom-in" data-aos-delay="100">
							<div class="relative h-auto w-full">
								<video class="flex h-96 w-full rounded-lg border border-gray-200 object-cover p-0 ring-1 ring-gray-50"
									id="video" data-aos="zoom-in" data-aos-delay="100"
									style="background: url('{{ asset($path) }}') center center / cover no-repeat;" autoplay>
								</video>

								<canvas class="absolute left-0 top-0 h-auto w-full rounded-lg object-cover p-0" id="overlay"></canvas>

								<div class="absolute bottom-2 right-2 z-50" data-aos="fade-right" data-aos-delay="150">
									<button
										class="focus:text-gray-90 dark:bg-blue-800 dark:hover:bg-blue-900 dark:text-white dark:ring-gray-700 w-full items-center rounded-lg bg-white px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 hover:bg-blue-800 hover:text-white focus:bg-white focus:ring-2 focus:ring-blue-300 focus:hover:text-gray-900"
										id="capturePhoto" type="button">Start Kamera</button>
									<input id="photo1Data" name="photo1" type="hidden">
									<input id="photo2Data" name="photo2" type="hidden">
								</div>
							</div>

							<div class="grid gap-6 lg:grid-cols-2">
								<div class="relative flex w-full flex-col rounded-lg md:flex-row lg:flex-col lg:gap-0" data-aos="fade-right"
									data-aos-delay="100">
									<div class="h-auto w-full rounded-lg md:rounded-lg lg:w-full">
										<img class="h-[184px] w-full rounded-lg object-cover ring-1 ring-gray-200" id="canvLogo"
											src="{{ asset('assets/img/noImage.webp') }}" alt="">
										<canvas class="absolute left-0 top-0 h-full w-full rounded-lg object-cover" id="canvRegist"></canvas>
									</div>
								</div>

								<div class="relative flex w-full flex-col rounded-lg md:flex-row lg:flex-col lg:gap-0" data-aos="fade-left"
									data-aos-delay="100">
									<div class="h-auto w-full rounded-lg md:rounded-lg lg:w-full">
										<img class="h-[184px] w-full rounded-lg object-cover ring-1 ring-gray-200" id="canvLogo"
											src="{{ asset('assets/img/noImage.webp') }}" alt="">
										<canvas class="absolute left-0 top-0 h-full w-full rounded-lg object-cover" id="canvRegistt"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="w-full space-y-4">
			<header
				class="dark:bg-[#18181b] dark:ring-gray-700 flex flex-row rounded-xl bg-white p-4 ring-1 ring-gray-200 sm:p-6">
				<h2 class="dark:text-white text-lg font-medium text-gray-900">
					{{ __('Foto Terdaftar') }}
				</h2>
			</header>
			<div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-1">

				@foreach ($images as $image)
					@if (!is_null($image))
						<div class="dark:bg-[#18181b] dark:ring-gray-700 rounded-xl bg-white p-1 ring-1 ring-gray-200">
							<img class="border h-56 w-full rounded-xl border-gray-500 object-cover blur-sm hover:blur-none"
								src="{{ asset('storage/' . $pegawai->storage . $image) }}" alt="">
						</div>
					@endif
				@endforeach

			</div>
		</div>
	</div>

	<script>
		const video = document.getElementById('video');
		const canvas = document.getElementById('canvRegist');
		const canvass = document.getElementById('canvRegistt');
		const photo1Data = document.getElementById('photo1Data');
		const photo2Data = document.getElementById('photo2Data');
		const captureButton = document.getElementById('capturePhoto');
		const overlay = document.getElementById('overlay');

		const originalConsoleLog = console.log;

		let stream = null;

		function startCamera() {
			navigator.mediaDevices.getUserMedia({
					video: true
				})
				.then(userStream => {
					stream = userStream;
					video.srcObject = stream;
					video.play();
					console.log("Camera started");
				})
				.catch(err => console.error('Error accessing camera: ', err));
		}

		function capturePhoto(targetCanvas, targetWidth, targetHeight) {
			const context = targetCanvas.getContext('2d');
			targetCanvas.width = targetWidth;
			targetCanvas.height = targetHeight;
			context.drawImage(video, 0, 0, targetWidth, targetHeight);
			return targetCanvas.toDataURL('image/jpeg');
		}

		function displayTimer(seconds, callback) {
			let remainingTime = seconds;
			overlay.textContent = remainingTime; // Menampilkan waktu awal
			console.log(`Foto diambil dalam: ${remainingTime} detik`);

			// Menampilkan timer di consoleOutput

			const timerInterval = setInterval(() => {
				remainingTime--;
				overlay.textContent = remainingTime;
				console.log(`${remainingTime} `);

				// Menampilkan waktu tersisa di consoleOutput
				if (remainingTime <= 0) {
					clearInterval(timerInterval);
					overlay.textContent = ''; // Hapus teks overlay
					console.log('Captured.');
					if (callback) callback();
				}
			}, 1000);
		}

		function captureTwoPhotos() {
			// Menyusun kamera jika belum dimulai
			if (!stream) {
				startCamera();
				setTimeout(() => {
					displayTimer(3, () => {
						const photo1 = capturePhoto(canvas, video.videoWidth, video.videoHeight);
						photo1Data.value = photo1;

						// Menunggu 3 detik sebelum menangkap foto kedua
						setTimeout(() => {
							displayTimer(3, () => {
								const photo2 = capturePhoto(canvass, video.videoWidth, video
									.videoHeight);
								photo2Data.value = photo2;
							});
						}, 3000); // Jeda sebelum menangkap foto kedua
					});
				}, 3000); // Jeda sebelum menangkap foto pertama

			}
		}

		// Event listener untuk tombol capture
		captureButton.addEventListener('click', () => {
			captureTwoPhotos();
		});
	</script>
@endsection
