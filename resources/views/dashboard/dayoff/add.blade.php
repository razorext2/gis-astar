@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">
			<div class="w-full">
				<header class="flex flex-row">

					<form id="index-dayoff" action="{{ route('dayoff.index') }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" form="index-dayoff" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
						{{ __('Tambah Pengajuan Off') }}
					</h2>

				</header>
				<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
					{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
				</p>

				<form class="mt-4" method="POST">
					@csrf
					<div class="mb-4 grid grid-cols-2 gap-4 sm:mb-5">

						<div class="w-full">
							<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="name">Nama
								Pegawai</label>
							@if (Auth::user()->hasPermissionTo('dayoff-confirm'))
								<input class="block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900" id="name"
									name="name" type="text" placeholder="Cari nama karyawan.." required>
								<div class="autocomplete-results" id="autocomplete-results"></div>
							@else
								<input class="block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900" id="name"
									name="name" type="text" value="{{ $data->full_name }}" required readonly>
							@endif
						</div>

						<div class="w-full">
							<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="kode_pegawai">Kode
								Pegawai</label>
							@if (Auth::user()->hasPermissionTo('dayoff-confirm'))
								<input
									class="block w-full cursor-not-allowed rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
									id="kode_pegawai" name="kode_pegawai" type="text" placeholder="Kode pegawai" required readonly>
							@else
								<input
									class="block w-full cursor-not-allowed rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
									id="kode_pegawai" name="kode_pegawai" type="text" value="{{ $data->kode_pegawai }}" required readonly>
							@endif
							<div class="mt-2 text-sm text-red-500" id="alert-kode_pegawai"></div>
						</div>

						<div class="col-span-2 w-full">
							<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="dayoff_for">Peruntukan</label>
							<select
								class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
								id="dayoff_for" name="dayoff_for">
								<option value="" selected>Pilih</option>
								<option value="Izin"> Izin </option>
								<option value="Sakit"> Sakit </option>
								<option value="Absen"> Absen </option>
								<option value="PC"> Pulang Cepat </option>
							</select>
							<div class="mt-2 text-sm text-red-500" id="alert-dayoff_for"></div>
						</div>

						<div class="w-full">
							<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="start-time">Start time:</label>
							<input
								class="block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white dark:text-gray-800 dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
								id="start-time" name="start_time" type="datetime-local" required />
							<div class="mt-2 text-sm text-red-500" id="alert-tgl_dari"></div>
						</div>

						<div class="w-full">
							<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="end-time">End
								time:</label>
							<input
								class="block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-white dark:text-gray-800 dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
								id="end-time" name="end_time" type="datetime-local" required />
							<div class="mt-2 text-sm text-red-500" id="alert-tgl_hingga"></div>
						</div>
					</div>

					<div class="mb-4 w-full">
						<p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Lampiran</p>
						<p class="mb-2 text-xs text-red-500"> *Lampiran tidak dapat diubah setelah pengajuan diajukan. Lampiran dapat
							berisi surat sakit, surat izin, surat absen, atau surat pulang cepat. </p>

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

					<div class="relative mb-4 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
							Keterangan
						</label>
						<div class="h-32 w-full dark:bg-white" id="editor"></div>
						<input id="keterangan" name="keterangan" type="hidden">
						<div class="mt-2 text-sm text-red-500" id="alert-keterangan"></div>
						<div class="mt-2 text-sm text-red-500" id="alert-image"></div>
					</div>

					<div class="relative w-full">

						<x-button.primary id="store" type="button">
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
	@livewire('utils.camera-stream-modal')
@endsection
@push('script')
	@vite(['resources/js/pages/dayoff/add.js'])
@endpush
