@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-6">

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
						<x-input.basic id="title" name="title" placeholder="Kunjungan ke toko xxx" required>
							Judul Laporan
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-title"></div>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="customer_name" name="customer_name" placeholder="Bp. Samsudin" required>
							Nama Calon Customer
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-customer_name"></div>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="customer_telp" name="customer_telp" placeholder="62812xxxxxxx" required>
							No. Telp / Contact Person
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-customer_telp"></div>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="lokasi" name="lokasi" placeholder="Jl. ABC, No 123" required>
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
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="keterangan">Keterangan</label>
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
	@livewire('utils.camera-stream-modal')
@endsection
@push('script')
	@vite(['resources/js/pages/sales/add.js'])
@endpush
