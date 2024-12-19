@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-6 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">
			@can('collect-create')
				<div class="w-full">
					<header class="flex flex-row">

						<form id="index-collector" action="{{ route('collect.index') }}"></form>
						<x-button.danger class="me-4 flex" form="index-collector" type="submit">
							<x-slot name="icon">
								<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
							</x-slot>
							Kembali
						</x-button.danger>

						<h2 class="font-base mt-2 text-lg text-gray-900 dark:text-gray-300">
							Ubah: <span class="font-bold text-white">{{ $data->title ?? 'N/A' }}</span>
						</h2>
					</header>
				</div>
			@endcan

			<div class="w-full">

				<div class="grid gap-2 md:grid-cols-2" id="laporan-content">
					<input id="id" name="id" type="hidden" value="{{ $data->id ?? 'N/A' }}">

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Kode Pegawai</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->kode_pegawai ?? 'N/A' }}
						</p>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Nama Pegawai</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->pegawaiRelasi->full_name ?? 'N/A' }}
						</p>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Waktu Laporan Dibuat</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->created_at->locale('id')->isoFormat('D MMMM YYYY HH:mm:ss') ?? 'N/A' }}
						</p>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Waktu Laporan Diupdate</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->updated_at->locale('id')->isoFormat('D MMMM YYYY HH:mm:ss') ?? 'N/A' }}
						</p>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 md:col-span-2">
						<p class="mb-2 text-sm text-gray-600 dark:text-gray-300">Judul Laporan <span class="text-sm text-red-500">*</span>
						</p>
						<input class="block w-full rounded-lg bg-gray-300 p-2.5 text-sm text-gray-900" id="title" name="title"
							type="text" value="{{ $data->title ?? 'N/A' }}" placeholder="Judul laporan.." required>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-title"></div>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 md:col-span-2">
						<p class="mb-2 text-sm text-gray-600 dark:text-gray-300">Lokasi <span class="text-sm text-red-500">*</span>
						</p>
						<input class="block w-full rounded-lg bg-gray-300 p-2.5 text-sm text-gray-900" id="location" name="location"
							type="text" value="{{ $data->location ?? 'N/A' }}" placeholder="Judul laporan.." required>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-location"></div>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 md:col-span-2">
						<p class="mb-2 text-sm text-gray-600 dark:text-gray-300">Dokumentasi</p>
						<div class="relative overflow-auto">
							<div class="flex overflow-x-auto" id="captured-images">
								<!-- Thumbnail gambar yang diambil akan muncul di sini -->
								@if ($data->photoCollectRelasi)
									@foreach ($data->photoCollectRelasi as $photo)
										<div class="relative me-2 flex-none items-center gap-4 rounded-xl p-2">
											<img
												class="h-36 w-36 rounded-xl object-cover blur-sm transition duration-300 ease-in-out hover:scale-105 hover:blur-0"
												id="documentations" data-url="{{ asset($photo->photourl) }}" src="{{ asset($photo->photourl) }}"
												alt="" onclick="javascript:void(0)">
										</div>
									@endforeach
								@endif
							</div>
						</div>
					</div>

					<div class="relative col-span-2 mb-4">
						<p class="mb-2 text-sm text-gray-600 dark:text-gray-300">Keterangan <span class="text-sm text-red-500">*</span>
						</p>
						<div class="h-32 w-full dark:bg-white" id="editor"></div>
						<input id="keterangan" name="keterangan" type="hidden">
						<div class="mt-2 hidden text-sm text-red-500" id="alert-keterangan"></div>
					</div>

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
@endsection
@push('script')
	<script>
		const data = @json($data->keterangan);
	</script>
	@vite(['resources/js/collect/edit.js'])
@endpush
