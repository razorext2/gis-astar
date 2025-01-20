@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">

			<div class="w-full">
				<header class="flex flex-row">

					<form id="back-form" action="{{ route('sales.index') }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" form="back-form" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
						{{ __('Tambah Laporan Sales') }}
					</h2>

				</header>
				<p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
					{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
				</p>
			</div>

			<div class="w-full">

				<div class="grid gap-4 md:grid-cols-2" id="laporan-content">
					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="kode_pegawai" name="kode_pegawai" value="{{ Auth::user()->kode_pegawai ?? '28101999' }}"
							readonly>
							Kode Pegawai
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="employee_name" name="employee_name" value="{{ Auth::user()->name ?? 'Superadmin' }}" readonly>
							Nama Pegawai
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="title" name="title" placeholder="Judul laporan" required>
							Judul Laporan
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-title"></div>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="lokasi" name="lokasi" placeholder="Jl. XXX, XXX, XXX" required>
							Alamat Customer
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-lokasi"></div>
					</div>

					<div class="col-span-2 w-full">
						<p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dokumentasi</p>
						<p class="mb-2 text-xs text-red-500"> *Dokumentasi tidak dapat diubah setelah laporan diinput. </p>

						<x-button.primary id="capture-button" type="button">
							<x-slot name="icon">
								<x-icons.plus class="icon h-5 w-5 text-blue-500 dark:text-white" />
							</x-slot>
							Ambil Foto
						</x-button.primary>

						<div class="relative overflow-auto">
							<div class="flex overflow-x-auto" id="captured-images">
								<!-- Thumbnail gambar yang diambil akan muncul di sini -->
							</div>
						</div>

						<div class="mt-2 hidden text-sm text-red-500" id="alert-images"></div>
					</div>

					<div class="col-span-2 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="keterangan}">Keterangan</label>
						</p>
						<div class="h-32 w-full dark:bg-white" id="editor"></div>
						<input id="keterangan" name="keterangan" type="hidden">
						<div class="mt-2 hidden text-sm text-red-500" id="alert-keterangan"></div>
					</div>

					<input class="w-full rounded-lg border border-gray-300 bg-gray-400 p-2.5 text-sm text-gray-900" id="longitude"
						name="longitude" type="hidden" readonly>

					<input class="w-full rounded-lg border border-gray-300 bg-gray-400 p-2.5 text-sm text-gray-900" id="latitude"
						name="latitude" type="hidden" readonly>

					<div class="mb-4 hidden text-sm text-red-500" id="alert-coordinate"></div>

					<div class="relative col-span-2 w-full">
						<x-button.primary class="float-right" id="store" type="button">
							<x-slot name="icon">
								<x-icons.angle-right class="icon h-5 w-5" />
							</x-slot>
							Update laporan
						</x-button.primary>
					</div>

				</div>
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
		const storeUrl = "{{ route('sales-api.store') }}"
	</script>
	@vite(['resources/js/sales/add.js'])
@endpush
