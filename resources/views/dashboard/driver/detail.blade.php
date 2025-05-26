@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-6 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-6">
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
							{{ $data->pegawai->full_name ?? 'N/A' }}
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
							{{ $data->title ?? 'N/A' }}
						</p>
					</div>

					<div
						class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-700">
						<p class="text-sm text-gray-600 dark:text-gray-300">Lokasi checkpoint</p>

						<span class="text-navy-700 text-base font-medium dark:text-white">{{ $data->lokasi ?? 'N/A' }}</span>

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
								@if ($data->photoCollect)
									@foreach ($data->photoCollect as $photo)
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
									class="rounded-xl bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800 ring-1 ring-gray-300 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-gray-700">
									Sedang diajukan.
								</span>
							@elseif ($status == 1)
								<span
									class="rounded-xl bg-green-100 px-4 py-2 text-sm font-medium text-green-800 ring-1 ring-gray-300 dark:bg-green-900 dark:text-green-300 dark:ring-gray-700">
									Disetujui. (divalidasi oleh: {{ $data->validateBy->name ?? 'N/A' }})
								</span>
							@elseif ($status == 3)
								<div class="flex flex-col gap-y-2">
									<span
										class="rounded-xl bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800 ring-1 ring-gray-300 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-gray-700">
										Perlu diperbaiki! (divalidasi oleh: {{ $data->validateBy->name ?? 'N/A' }})
									</span>

									@if ($data->total_revision <= 2)
										<x-button.link class="w-fit rounded-xl ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
											href="{{ route('driver.edit', $data->id) }}">
											<x-slot name="icon">
												<x-icons.angle-right class="h-6 w-6 text-red-500 dark:text-white" />
											</x-slot>
											Klik untuk revisi
										</x-button.link>
									@endif
								</div>
							@else
								<span
									class="rounded-xl bg-red-100 px-4 py-2 text-sm font-medium text-red-800 ring-1 ring-gray-300 dark:bg-red-900 dark:text-red-300 dark:ring-gray-700">
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

					@can('driver-approve')
						@if ($data->status == 0)
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
	@vite('resources/js/pages/driver/detail.js')
@endpush
