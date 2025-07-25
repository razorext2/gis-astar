@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-4 rounded-xl bg-white p-4 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 sm:p-6">

			<div class="w-full">
				<header class="flex flex-row gap-x-4">

					<div class="max-w-xs">
						<x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" href="{{ route('driver.index') }}"
							wire:navigate>
							<x-slot name="icon">
								<x-icons.angle-right class="h-6 w-6 text-red-500 dark:text-white" />
							</x-slot>
							Kembali
						</x-button.link>
					</div>

					<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
						Update Laporan {{ $data->no_sr }}
					</h2>

				</header>
				<p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
					Silahkan sesuaikan data dibawah ini dengan data yang benar.
				</p>
			</div>

			<div class="grid gap-4 md:grid-cols-2" id="laporan-content">
				<input type="hidden" id="id" name="id" value="{{ $data->id }}">

				<div class="col-span-2 w-full lg:col-span-1">
					<x-input.basic id="kode_pegawai" name="kode_pegawai" value="{{ $data->kode_pegawai }}" readonly>
						Kode Pegawai
					</x-input.basic>
				</div>

				<div class="col-span-2 w-full lg:col-span-1">
					<x-input.basic id="employee_name" name="employee_name" value="{{ $data->pegawai->full_name }}" readonly>
						Nama Pegawai
					</x-input.basic>
				</div>

				<div class="col-span-2 w-full">
					<x-input.basic readonly id="no_sr" name="no_sr" placeholder="Kunjungan ke toko xxx"
						value="{{ $data->no_sr }}" required>
						No. SR
					</x-input.basic>
					<div class="mt-2 hidden text-sm text-red-500" id="alert-title"></div>
				</div>

				<div class="col-span-2 w-full">
					<x-input.basic readonly id="title" name="title" placeholder="Kunjungan ke toko xxx"
						value="{{ $data->title }}" required>
						Nama Perusahaan
					</x-input.basic>
					<div class="mt-2 hidden text-sm text-red-500" id="alert-title"></div>
				</div>

				<div class="col-span-2 w-full">
					<x-input.basic id="lokasi" readonly value="{{ $data->lokasi }}" name="lokasi" placeholder="Jl. XXXX" required>
						Alamat Perusahaan
					</x-input.basic>
					<div class="mt-2 hidden text-sm text-red-500" id="alert-lokasi"></div>
				</div>

				<div class="col-span-2 w-full">
					<x-input.select id="status_pengantaran" required name="status_pengantaran" :defaultOption="'Pilih Status Pengantaran'" :options="[
					    1 => 'Belum Diterima',
					    2 => 'Sudah Diterima',
					]"
						:labels="true" :textLabel="'Status Pengantaran'" />
					<div class="mt-2 hidden text-sm text-red-500" id="alert-status_pengantaran"></div>
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
						<div class="mt-2 flex overflow-x-auto" id="captured-images">
							<!-- Thumbnail gambar yang diambil akan muncul di sini -->
						</div>
					</div>

					<div class="hidden text-sm text-red-500" id="alert-images"></div>
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

	@livewire('utils.camera-stream-modal')
@endsection
@push('script')
	@vite(['resources/js/pages/driver/update.js'])
@endpush
