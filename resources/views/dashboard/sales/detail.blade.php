@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-6 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-6">
			<div class="w-full">
				<header class="flex flex-row">

					<form id="actionForm" action="{{ route('sales.index') }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" id="back-button" form="actionForm" type="submit">
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

			<div class="w-full">

				<div class="grid gap-2 md:grid-cols-2">

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
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Judul laporan</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->title }}
						</p>
					</div>

					@php
						$telp = $data->customer_telp;

						if (Str::startsWith($telp, '08')) {
						    $telp = Str::replaceFirst('08', '628', $telp);
						}
					@endphp

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Customer</p>
						<p class="text-navy-700 text-base font-medium dark:text-white">
							{{ $data->customer_name ?? 'N/A' }} ({{ $telp }})
						</p>
						<a class="text-navy-700 inline-flex text-base font-medium underline dark:text-white"
							href="https://api.whatsapp.com/send?phone={{ $telp }}&text=Halo, %2A{{ ucwords(strtolower($data->title)) }}%2A. %0A%0ASaya %2A{{ auth()->user()->name }}%2A, marketing dari %2APT. Indodacin Presisi Utama%2A. Saya ingin menghubungi Anda terkait pesanan atau layanan yang mungkin Anda butuhkan.%0A%0AJika ada pertanyaan atau ingin berdiskusi lebih lanjut, silakan balas pesan ini.%0A%0ATerima kasih!%F0%9F%98%8A"
							target="_blank">
							Chat di Whatsapp
							<x-icons.arrow-up class="h-4 w-4 rotate-45" />
						</a>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Lokasi checkpoint</p>

						<span class="text-navy-700 text-base font-medium dark:text-white">{{ $data->lokasi }}</span>

						<span class="text-navy-700 text-xs font-medium text-gray-400 dark:text-white">
							<a class="inline-flex underline"
								href="https://www.google.com/maps/search/?api=1&query={{ $data->latitude }},{{ $data->longitude }}"
								target="_blank">
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
								@if ($data->photoCollectRelasi->count() > 0)
									@foreach ($data->photoCollectRelasi as $photo)
										<div class="relative me-2 flex-none items-center gap-4 rounded-xl p-2">
											<img
												class="h-36 w-36 rounded-xl object-cover blur-sm transition duration-300 ease-in-out hover:scale-105 hover:blur-0"
												id="documentations" onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
												data-url="{{ asset($photo->photourl) }}" src="{{ asset($photo->photourl) }}" alt=""
												onclick="javascript:void(0)" loading="lazy">
										</div>
									@endforeach
								@else
									<p class="font-semibold text-gray-800 dark:text-white"> Tidak ada dokumentasi</p>
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
								<span class="text-sm font-semibold text-yellow-400">
									Sedang diajukan.
								</span>
							@elseif ($status == 1)
								<span class="text-sm font-semibold text-green-400">
									Disetujui. (divalidasi oleh: {{ $data->validateBy->name ?? 'N/A' }})
								</span>
							@else
								<span class="text-sm font-semibold text-red-400">
									Laporan di Tolak! (divalidasi oleh: {{ $data->validateBy->name ?? 'N/A' }})
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

					@if ($data->order_notes && Auth::user()->can('sales-approve'))
						<div
							class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
							<p class="text-sm text-gray-600 dark:text-gray-300">Customer Melakukan Order?</p>
							<p class="text-navy-700 text-base font-medium dark:text-white">
								{{ $data->customer_make_order == 1 ? 'Ya' : 'Tidak' }}
							</p>
						</div>
						<div
							class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700 lg:col-span-1">
							<p class="text-sm text-gray-600 dark:text-gray-300">Note</p>
							<p class="text-xs text-gray-400 dark:text-gray-400">Produk yg di order customer/alasan customer tdk order.</p>
							<p class="text-navy-700 text-base font-medium dark:text-white">
								{{ $data->order_notes ?? 'Tidak ada catatan' }}
							</p>
						</div>
						<div
							class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
							<p class="text-sm text-gray-600 dark:text-gray-300">Bukti followup</p>

							<img class="h-36 w-36 rounded-xl object-cover transition duration-300 ease-in-out hover:scale-105"
								onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
								src="{{ asset('storage/sales/proof/' . $data->proof_picture) }}" alt="" onclick="javascript:void(0)"
								loading="lazy" id="documentations" data-url="{{ asset('storage/sales/proof/' . $data->proof_picture) }}">
						</div>
					@endif

					@can('sales-approve')
						@if ($data->status == 0)
							<div class="col-span-2 mt-2 flex flex-col justify-end" id="action">
								<livewire:handler.sales.validate-sales :label="'Konfirmasi'" :id="$data->id" />
							</div>
						@endif
					@endcan
				</div>

			</div>
		</div>
	</div>

	@push('script')
		@vite('resources/js/pages/sales/detail.js')
	@endpush
@endsection
