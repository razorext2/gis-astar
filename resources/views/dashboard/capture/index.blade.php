@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="relative rounded-xl bg-white/70 p-0 ring-1 ring-gray-200 dark:bg-[#18181b]/70 dark:shadow-none dark:ring-gray-700 lg:max-w-screen-lg lg:p-4"
		id="Scan" data-aos="zoom-in-up" data-aos-delay="50">
		<div class="grid h-auto w-full grid-cols-1 lg:grid-cols-3 lg:gap-4">

			<div class="video-container h-auto p-3 text-center lg:col-span-2 lg:p-0" data-aos="zoom-in" data-aos-delay="100">
				<div class="relative h-[30rem] w-full">
					<video class="flex h-full w-full rounded-lg object-cover p-0 ring-1 ring-gray-200 dark:ring-gray-700" id="video"
						data-aos="zoom-in" data-aos-delay="100"
						style="background: url('{{ asset('assets/img/noCamera.webp') }}') center center / cover no-repeat;" autoplay>
					</video>
					<canvas class="absolute left-0 top-0 flex h-full w-full rounded-xl object-cover p-0" id="overlay"></canvas>
				</div>
				<div class="mt-3 inline-flex w-full lg:px-0">
					<button
						class="w-full rounded-lg bg-blue-400 p-2 font-bold text-white ring-1 ring-gray-200 hover:bg-blue-700 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
						id="startButton">Start</button>
				</div>
				<div class="mt-3 h-auto w-full rounded-lg dark:bg-[#18181b] lg:px-0">
					<div class="-h-10 h-auto rounded-lg p-3 text-left ring-1 ring-gray-200 dark:ring-gray-700">
						<p class="text-sm font-bold text-black dark:text-white">Log</p>
						<hr class="my-2 bg-black dark:bg-[#18181b]">
						<pre class="max-h-32 overflow-y-auto scroll-smooth dark:text-white" id="consoleOutput"></pre>
					</div>
				</div>
			</div>

			<!-- #region -->
			<div class="col-span-1 px-3 pb-3 md:px-3 md:pb-3 lg:col-span-1 lg:p-0" data-aos="zoom-in" data-aos-delay="100">
				<div class="mb-4 rounded-lg p-2 text-center ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700"
					data-aos="fade-left" data-aos-delay="100">
					<p class="text-xl font-bold text-black dark:text-white">INFORMASI</p>
				</div>

				<div class="grid grid-cols-1 gap-6 md:grid-cols-1">

					<div class="relative flex w-full flex-col gap-6 rounded-lg md:flex-row lg:flex-col lg:gap-0" data-aos="fade-right"
						data-aos-delay="100">
						<div class="h-full w-full rounded-lg md:rounded-lg lg:w-full lg:object-fill">
							<img
								class="h-60 w-full rounded-lg object-cover ring-1 ring-gray-200 dark:ring-gray-700 md:h-auto lg:h-full lg:object-fill"
								id="canvLogo" src="{{ asset('assets/img/noImage.webp') }}" alt="" loading="lazy">
							<canvas
								class="absolute left-0 top-0 h-60 w-full rounded-lg object-cover ring-1 ring-gray-200 dark:ring-gray-700 md:h-full lg:h-full"
								id="canvAttend"></canvas>
						</div>
					</div>

					<div
						class="relative flex h-auto w-full flex-col rounded-lg p-4 leading-normal ring-1 ring-gray-200 dark:ring-gray-700 lg:justify-between"
						data-aos="fade-left" data-aos-delay="100">
						<div id="pegawaiInfo"></div>
						<div id="pegawaiKosong">
							<ul class="space-y-4 text-left text-gray-500 dark:text-white">
								<li class="flex items-center space-x-3 rtl:space-x-reverse">
									<svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 16 12">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M1 5.917 5.724 10.5 15 1.5" />
									</svg>
									<span>Lokasi: <span id="lokasi"></span></span>
								</li>
								<li class="flex items-center space-x-3 rtl:space-x-reverse">
									<svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 16 12">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M1 5.917 5.724 10.5 15 1.5" />
									</svg>
									<span>Kode Pegawai: {{ Auth::user()->kode_pegawai }}<input id="kode_pegawai" name="kode_pegawai" type="hidden"
											value="{{ Auth::user()->kode_pegawai }}"> </span>
								</li>
								<li class="flex items-center space-x-3 rtl:space-x-reverse">
									<svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 16 12">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M1 5.917 5.724 10.5 15 1.5" />
									</svg>
									<span>NIK: {{ $data->nik_pegawai ?? 'N/A' }}</span>
								</li>
								<li class="flex items-center space-x-3 rtl:space-x-reverse">
									<svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 16 12">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M1 5.917 5.724 10.5 15 1.5" />
									</svg>
									<span>Nama: {{ $data->full_name ?? 'N/A' }}</span>
								</li>
							</ul>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>

	@push('script')
		<script>
			let lastLat, lastLng, lat, lng;
			const redirectUrl = "{{ route('capture.index') }}";
			const specifiedLat = parseFloat("{{ $data->latitude ?? 'N/A' }}"); // Latitude of the specified point
			const specifiedLng = parseFloat("{{ $data->longitude ?? 'N/A' }}"); // Longitude of the specified point
			const radius = parseFloat("{{ $data->radius ?? 'N/A' }}"); // Radius in meters
			const movementThreshold = 50; // Minimum distance to move (in meters)
			const kodePegawai = "{{ $data->kode_pegawai }}"
		</script>

		<script defer src="{{ asset('face-api.min.js') }}"></script>
		@vite('resources/js/capture/selfDetect.js')
		@vite(['resources/js/capture/index.js'])
	@endpush
@endsection
