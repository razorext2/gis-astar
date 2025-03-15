@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-6 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">
			<div class="w-full">
				<header class="flex flex-row">

					<form id="index-dayoff" action="{{ route('dayoff.index') }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" id="back-button" form="index-dayoff" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="font-base mt-2 text-lg text-gray-900 dark:text-gray-300">
						Detail: <span class="font-bold text-white">Permohonan {{ $data->dayoff_for ?? 'N/A' }}
							{{ $data->pegawaiRelasi->full_name ?? 'N/A' }} </span>
					</h2>
				</header>
			</div>

			<div class="w-full">
				<div class="grid gap-2 md:grid-cols-2">

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Nama Pegawai</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->pegawaiRelasi->full_name ?? 'N/A' }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Kode Pegawai</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->kode_pegawai ?? 'N/A' }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Jenis Permohonan</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->dayoff_for ?? 'N/A' }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Waktu Mulai</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->tgl_dari ?? 'N/A' }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Waktu Selesai</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->tgl_hingga ?? 'N/A' }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Keterangan</p>
						<div class="text-navy-700 w-full text-wrap text-base dark:text-white">
							{!! $data->keterangan !!}
						</div>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Status</p>
						<p class="text-navy-700 pt-1.5 text-base font-medium dark:text-white">
							@php
								$status = $data->status;

								if ($status == 1) {
								    echo '<span class="rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-800 ring-1 ring-gray-300 dark:bg-green-900 dark:text-green-300 dark:ring-gray-700"> Diterima </span>';
								} elseif ($status == 0) {
								    echo '<span class="rounded-full bg-yellow-100 px-4 py-1 text-sm font-medium text-yellow-800 ring-1 ring-gray-300 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-gray-700"> Diajukan </span>';
								} elseif ($status == 2) {
								    echo '<span class="rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-800 ring-1 ring-gray-300 dark:bg-red-900 dark:text-red-300 dark:ring-gray-700"> Ditolak </span>';
								} else {
								    echo '<span class="rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-800 ring-1 ring-gray-300 dark:bg-red-900 dark:text-red-300 dark:ring-gray-700"> Dibatalkan </span>';
								}
							@endphp
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Divalidasi oleh</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->validate_by == 0 ? 'Administrator' : $data->validate_by }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Catatan</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->notes ?? 'N/A' }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Lampiran</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->url ?? 'N/A' }}
						</p>
					</div>

					@can('dayoff-confirm')
						@if (!$data->status)
							<div class="col-span-2 mt-2 flex flex-col justify-end" id="action">
								<div class="text-right">

									<x-button.success class="confirm-btn float-right" id="confirm-btn" data-id="{{ $data->id }}" type="button">
										<x-slot name="icon">
											<x-icons.angle-right class="h-5 w-5" />
										</x-slot>
										Konfirmasi
									</x-button.success>

								</div>
							</div>
						@endif
					@endcan
				</div>
			</div>
		</div>
	</div>
@endsection
@push('script')
	@vite('resources/js/pages/dayoff/detail.js')
@endpush
