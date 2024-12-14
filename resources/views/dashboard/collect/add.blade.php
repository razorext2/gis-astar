@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="grid w-full grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-6">
		{{-- form add --}}
		<div
			class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6 lg:col-span-2">
			<div class="w-full">
				<header class="flex flex-row">

					<form id="index-collector" action="{{ route('collect.index') }}"></form>
					<x-button.danger class="me-4" form="index-collector" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
						{{ __('Tambah Laporan') }}
					</h2>

				</header>
				<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
					{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
				</p>

				<form class="mt-4" method="POST">
					@csrf

					<input id="kode_pegawai" name="kode_pegawai" type="hidden"
						value="{{ auth()->user()->kode_pegawai ?? '28101999' }}">

					<div class="relative mb-4 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="title">Judul laporan</label>
						<input class="block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900" id="title"
							name="title" type="text" placeholder="Judul laporan.." required>
						<div class="mt-2 text-sm text-red-500" id="alert-title"></div>
					</div>

					<div class="relative mb-4 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="location">Lokasi </label>
						<input class="block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900" id="location"
							name="location" type="text" placeholder="Isikan lokasi checkpoint.." required>
						<div class="mt-2 text-sm text-red-500" id="alert-location"></div>
					</div>

					<!-- Tombol Ambil Gambar -->
					<div class="relative mb-4 w-full">
						<label class="block text-sm font-medium text-gray-900 dark:text-white" for="capture-button">Dokumentasi
						</label>
						<p class="mb-2 text-xs text-red-500"> *Dokumentasi tidak dapat diubah setelah laporan diinput. </p>

						<x-button.primary id="capture-button" type="button">
							<x-slot name="icon">
								<x-icons.plus class="icon h-5 w-5 text-blue-500 dark:text-white" />
							</x-slot>
							Ambil Foto
						</x-button.primary>
					</div>

					<div class="relative overflow-auto">
						<div class="flex overflow-x-auto" id="captured-images">
							<!-- Thumbnail gambar yang diambil akan muncul di sini -->
						</div>
					</div>

					<div class="mb-2 text-sm text-red-500" id="alert-images"></div>

					<div class="relative mb-4 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
							Keterangan
						</label>
						<div class="h-32 w-full dark:bg-white" id="editor"></div>
						<input id="keterangan" name="keterangan" type="hidden">
						<div class="mt-2 text-sm text-red-500" id="alert-keterangan"></div>
					</div>

					<input class="block w-full rounded-lg border border-gray-300 bg-gray-400 p-2.5 text-sm text-gray-900" id="longitude"
						name="longitude" type="hidden" readonly>

					<input class="block w-full rounded-lg border border-gray-300 bg-gray-400 p-2.5 text-sm text-gray-900" id="latitude"
						name="latitude" type="hidden" readonly>

					<div class="mb-4 text-sm text-red-500" id="alert-coordinate"></div>

					<div class="relative w-full">
						<x-button.primary id="store" data-url="{{ route('collectors.store') }}" type="button">
							<x-slot name="icon">
								<x-icons.angle-right class="h-5 w-5 text-blue-500 dark:text-white" />
							</x-slot>
							Submit
						</x-button.primary>
					</div>
				</form>
			</div>

		</div>
	</div>

	<div
		class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
		id="camera-modal">
		<div class="relative max-h-full w-full max-w-2xl p-4">
			<div class="relative rounded-xl bg-white shadow dark:bg-gray-700">
				<div class="space-y-4 p-1">
					<div class="relative">
						<!-- Video -->
						<video class="rounded-lg" id="video" width="100%" height="auto" autoplay></video>

						<!-- Button -->
						<button
							class="absolute bottom-4 left-1/2 h-14 w-14 -translate-x-1/2 transform rounded-full bg-white/60 shadow-lg ring-2 ring-white hover:bg-white/80 focus:outline-none md:bottom-6 md:h-16 md:w-16"
							id="capture-image">
							<x-icons.camera class="mx-auto h-8 w-8 text-white md:h-10 md:w-10" />
						</button>

						{{-- close button --}}
						<button class="absolute right-2 top-2 h-auto w-auto transform focus:outline-none md:top-2" id="close-button"
							data-modal-hide="camera-modal" type="button">
							<x-icons.close class="h-8 w-8 text-red-600 hover:text-red-800" />
						</button>

					</div>
				</div>

			</div>
		</div>
	</div>
@endsection
@push('script')
	<script>
		// kirim kebawah
		const indexUrl = "{{ route('collect.index') }}";
		const storeUrl = "{{ route('collectors.store') }}";
	</script>
	@vite(['resources/js/collect/add.js'])
@endpush
