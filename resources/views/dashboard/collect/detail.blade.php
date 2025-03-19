@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-6">
			<div class="w-full">
				<header class="flex flex-row">

					<form id="index-collector" action="{{ route('collect.index') }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" id="back-button" form="index-collector" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="font-base mt-2 text-lg text-gray-900 dark:text-gray-300">
						Detail: <span class="font-bold text-white">{{ $data->title ?? 'N/A' }}</span>
					</h2>
				</header>
			</div>

			<div class="flex w-full justify-between">
				<p class="text-sm text-gray-600 dark:text-gray-300">Mohon periksa terlebih dahulu laporan berikut sebelum memutuskan
					untuk disetujui.</p>
				@can('collect-approve')
					@if ($data->status != 1 && $data->total_revision == 1)
						<a class="text-blue-500 hover:text-blue-600 hover:underline" href="{{ route('collect.edit', $data->id) }}"> Edit
						</a>
					@endif
				@endcan
			</div>

			<div class="w-full">

				<div class="grid gap-2 md:grid-cols-2">
					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">No. Tagihan</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->no_sr ?? 'N/A' }}
							(
							{{ match ($data->bill_type) {
							    'idcnonppn' => 'IDC Non PPN',
							    'idcppn' => $data->collectTaskPpnRelasi->sales_invoice,
							    'idyppn' => $data->collectIdyPpnRelasi->sales_invoice,
							    default => '-',
							} }}
							)
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Nama Customer</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ match ($data->bill_type) {
							    'idcnonppn' => $data->collectTaskRelasi->customer_name,
							    'idcppn' => $data->collectTaskPpnRelasi->customer_name,
							    'idyppn' => $data->collectIdyPpnRelasi->customer_name,
							    default => 'N/A',
							} }}
							/
							{{ match ($data->bill_type) {
							    'idcnonppn' => $data->collectTaskRelasi->sr_type,
							    'idcppn' => $data->collectTaskPpnRelasi->sr_type,
							    'idyppn' => $data->collectIdyPpnRelasi->sr_type,
							    default => 'N/A',
							} }}
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
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Nama Pegawai</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->pegawaiRelasi->full_name ?? 'N/A' }}
						</p>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Waktu Dibuat</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->created_at->locale('id')->isoFormat('D MMM YYYY HH:mm:s') ?? 'N/A' }}
						</p>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Waktu Diupdate</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->updated_at->locale('id')->isoFormat('D MMM YYYY HH:mm:s') ?? 'N/A' }}
						</p>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Total Tagihan</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ Number::currency(
							    match ($data->bill_type) {
							        'idcnonppn' => $data->collectTaskRelasi->total_bill,
							        'idcppn' => $data->collectTaskPpnRelasi->total_bill,
							        'idyppn' => $data->collectIdyPpnRelasi->total_bill,
							        default => 0,
							    },
							    'IDR',
							    'id',
							) }}
						</p>
					</div>

					<div
						class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Sisa Tagihan</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ Number::currency(
							    match ($data->bill_type) {
							        'idcnonppn' => $data->collectTaskRelasi->remaining_bill,
							        'idcppn' => $data->collectTaskPpnRelasi->remaining_bill,
							        'idyppn' => $data->collectIdyPpnRelasi->remaining_bill,
							        default => 0,
							    },
							    'IDR',
							    'id',
							) }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Lokasi checkpoint</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->location ?? 'N/A' }}
						</p>

						<span class="text-navy-700 text-xs font-medium text-gray-400 dark:text-white">
							<a class="inline-flex underline"
								href="https://www.google.com/maps/{{ '@' . $data->latitude }},{{ $data->longitude }},20m/" target="_blank">
								{{ $data->latitude }}, {{ $data->longitude }}
								<x-icons.arrow-up class="h-4 w-4 rotate-45" />
							</a>
						</span>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="mb-2 text-sm text-gray-600 dark:text-gray-300">Dokumentasi</p>
						<div class="relative overflow-auto">
							<div class="flex overflow-x-auto" id="captured-images">
								<!-- Thumbnail gambar yang diambil akan muncul di sini -->
								@if ($data->photoCollectRelasi)
									@foreach ($data->photoCollectRelasi as $photo)
										<div class="relative me-2 flex-none items-center gap-4 rounded-xl p-2">
											<img
												class="h-36 w-36 rounded-xl object-cover blur-sm transition duration-300 ease-in-out hover:scale-105 hover:blur-0"
												id="documentations" onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
												data-url="{{ asset($photo->photourl) }}" src="{{ asset($photo->photourl) }}" alt=""
												onclick="javascript:void(0)" loading="lazy">
										</div>
									@endforeach
								@endif
							</div>
						</div>
					</div>

					<div
						class="col-span-2 items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Keterangan</p>
						<div class="text-navy-700 quill-content !mt-1 w-full text-wrap !border-none !p-0 !text-base dark:text-white"
							id="editor">
							{!! $data->keterangan !!}
						</div>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Status</p>
						<p class="text-navy-700 pt-1.5 text-base font-medium dark:text-white">
							@php
								$status = $data->status;
							@endphp

							@if ($status == 0)
								<span
									class="rounded-lg bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800 ring-1 ring-gray-300 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-gray-700">
									Belum dilengkapi.
								</span>
							@elseif ($status == 1)
								<span
									class="rounded-lg bg-green-100 px-4 py-2 text-sm font-medium text-green-800 ring-1 ring-gray-300 dark:bg-green-900 dark:text-green-300 dark:ring-gray-700">
									Disetujui. (divalidasi oleh: {{ $user->name ?? 'N/A' }})
								</span>
							@elseif ($status == 2)
								<span
									class="rounded-lg bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800 ring-1 ring-gray-300 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-gray-700">
									Sedang diajukan.{{ $data->total_revision > 0 ? ' (direvisi: ' . $data->total_revision . 'x)' : '' }}
								</span>
							@elseif ($status == 4)
								<div class="grid gap-y-2">
									<span
										class="rounded-lg bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800 ring-1 ring-gray-300 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-gray-700">
										Perlu direvisi! (divalidasi oleh: {{ $user->name ?? 'N/A' }})
									</span>

									<x-button.link class="max-h-10 max-w-max ring-red-700 hover:bg-red-300 dark:bg-red-800 dark:hover:bg-red-900"
										id="revisi" href="{{ route('collect.edit', $data->id) }}">
										Klik untuk revisi.
									</x-button.link>
								</div>
							@else
								<span
									class="rounded-xl bg-red-100 px-4 py-2 text-sm font-medium text-red-800 ring-1 ring-gray-300 dark:bg-red-900 dark:text-red-300 dark:ring-gray-700">
									Laporan di Tolak! (divalidasi oleh: {{ $user->name ?? 'N/A' }})
								</span>
							@endif

						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Catatan</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->notes ? $data->notes : 'Tidak ada catatan' }}
						</p>
					</div>

					@php

						if (is_null($data->have_paid)) {
						    $status = 'Belum ada update pembayaran';
						} else {
						    if ($data->have_paid == 0) {
						        $status = 'Belum bayar';
						    } elseif ($data->have_paid == 1) {
						        $status = 'Cicilan';
						    } elseif ($data->have_paid == 2) {
						        $status = 'Lunas';
						    } elseif ($data->have_paid == 3) {
						        $status = 'Tanda Terima';
						    } elseif ($data->have_paid == 4) {
						        $status = 'Belum sempat';
						    } elseif ($data->have_paid == 5) {
						        $status = 'Antar bon lunas';
						    } else {
						        $status = 'Tidak ditemukan';
						    }
						}

					@endphp

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Status Pembayaran</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $status }}
						</p>
					</div>

					@php

						if (is_null($data->payment_type)) {
						    $type = 'Belum pilih tipe pembayaran.';
						} else {
						    if ($data->payment_type == 0) {
						        $type = 'Tidak ada';
						    } elseif ($data->payment_type == 1) {
						        $type = 'Cash';
						    } elseif ($data->payment_type == 2) {
						        $type = 'Transfer';
						    } elseif ($data->payment_type == 3) {
						        $type = "Giro ( $data->no_giro )";
						    }
						}

					@endphp

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
						<p class="text-sm text-gray-600 dark:text-gray-300">Tipe Pembayaran</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $type }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Jumlah Pembayaran</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ Number::currency($data->payment_amount ?? 0, 'IDR', 'id') }}
						</p>
					</div>

					@can('collect-approve')
						@if ($data->status == 2)
							<div class="col-span-2 mt-2 flex flex-col justify-end" id="action">
								<div class="text-right">

									<x-button.success class="confirm-btn float-right" id="confirm-btn" data-id="{{ $data->id }}"
										data-validateby="{{ Crypt::encryptString(auth()->user()->id) }}" type="button">
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
	@vite('resources/js/pages/collect/detail.js')
@endpush
