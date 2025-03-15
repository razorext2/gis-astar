@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full">
		<form class="mt-4" action="{{ route('placement.update', $placement) }}" method="POST">
			@csrf
			@method('put')
			<div class="grid gap-6 lg:grid-cols-2">
				<div class="w-full space-y-6">
					<div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">
						<div class="max-w-xl">
							<header class="flex flex-row items-center gap-x-3">
								<div class="max-w-xs">
									<x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
										href="{{ route('placement.index') }}">
										<x-slot name="icon">
											<x-icons.angle-right class="h-6 w-6 text-red-500 dark:text-white" />
										</x-slot>
										Kembali
									</x-button.link>
								</div>
								<h2 class="text-lg font-medium text-gray-900 dark:text-white">
									{{ __('Edit Data Penempatan') }}
								</h2>

							</header>
							<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
								{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
							</p>

							<div class="mb-4 grid gap-6 sm:mb-5 sm:gap-6">
								<div class="w-full">
									<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="kode_penempatan">Kode
										Penempatan</label>
									<input
										class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900"
										id="kode_penempatan" name="kode_penempatan" type="text" value="{{ $placement->kode_penempatan }}"
										placeholder="Kode Penempatan" required="">
								</div>
								<div class="w-full">
									<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="penempatan">Nama
										Penempatan</label>
									<input
										class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
										id="penempatan" name="penempatan" type="text" value="{{ old('penempatan', $placement->penempatan ?? '') }}"
										placeholder="Penempatan" required="">
								</div>

								<div class="w-full">
									<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="restrict_app">Pembatasan
										Akses</label>
									<select
										class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
										id="restrict_app" name="restrict_app">
										<option value="" selected>Pilih</option>
										<option value="y" @if ($placement->restrict_app == 'y') selected @endif> Ya
										</option>
										<option value="t" @if ($placement->restrict_app == 't') selected @endif> Tidak
										</option>
									</select>
								</div>

								<div class="w-full">
									<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="alamat">Alamat</label>
									<textarea
									 class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
									 id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap penempatan" required>{{ old('alamat', $placement->alamat) }}</textarea>
								</div>

								<div class="mb-4 w-full">
									<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="radius">Radius
										(Meter)</label>
									<div class="mb-4 flex">
										<div class="relative w-full">
											<input
												class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
												id="radius" name="radius" type="number" value="{{ old('radius', $placement->radius ?? 0) }}"
												placeholder="Enter amount" required />
										</div>
									</div>
									<div class="relative">
										<input class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-white" id="radius-input"
											type="range" value="{{ old('radius', $placement->radius ?? 35) }}" min="10" max="150">
										<span class="absolute -bottom-6 start-0 text-sm text-gray-500 dark:text-gray-400">Min
											10M</span>
										<span
											class="absolute -bottom-6 start-1/3 -translate-x-1/2 text-sm text-gray-500 dark:text-gray-400 rtl:translate-x-1/2">55M</span>
										<span
											class="absolute -bottom-6 start-2/3 -translate-x-1/2 text-sm text-gray-500 dark:text-gray-400 rtl:translate-x-1/2">105M</span>
										<span class="absolute -bottom-6 end-0 text-sm text-gray-500 dark:text-gray-400">Max
											150M</span>
									</div>
								</div>

								<div class="mb-6 grid gap-6 md:grid-cols-2">
									<div>
										<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="longitude">Longitude</label>
										<input
											class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
											id="longitude" name="longitude" type="text" value="{{ old('radius', $placement->longitude) }}" required />
									</div>
									<div>
										<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="latitude">Latitude</label>
										<input
											class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
											id="latitude" name="latitude" type="text" value="{{ old('radius', default: $placement->latitude) }}"
											required />
									</div>
								</div>

							</div>
							<div class="flex items-center">
								<button
									class="inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 hover:bg-blue-800 hover:text-white focus:text-white focus:ring-4 focus:ring-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
									type="submit">
									Submit
									<svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 14 10">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M1 5h12m0 0L9 1m4 4L9 9" />
									</svg>
								</button>
							</div>

						</div>
					</div>
				</div>

				<div class="w-full">
					<div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">
						<div class="max-w-xl">
							<header class="flex flex-row">
								<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
									{{ __('Tentukan titik lokasi') }}
								</h2>

							</header>
							<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
								{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
							</p>

							<div class="my-4 rounded-lg" id="map" style="height: 500px;"></div>

						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection
@push('script')
	<script>
		var icon = "{{ asset('assets/img/marker.png') }}";
		var shadow = "{{ asset('assets/img/marker-shadow.png') }}";
		var lng = "{{ $placement->longitude }}";
		var lat = "{{ $placement->latitude }}"
	</script>
	@vite(['resources/js/pages/placement/edit.js'])
@endpush
