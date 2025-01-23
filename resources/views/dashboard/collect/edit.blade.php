@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-6 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">

			<div class="w-full">
				<header class="flex flex-row">

					<form id="index-collector" action="{{ route('collect.show', $data->id) }}"></form>
					<x-button.danger class="my-auto me-4 max-h-10" form="index-collector" type="submit">
						<x-slot name="icon">
							<x-icons.angle-left class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Kembali
					</x-button.danger>

					<h2 class="font-base mt-2 text-lg text-gray-900 dark:text-gray-300">
						Ubah: <span class="font-bold lowercase text-white">{{ $data->title ?? 'N/A' }}</span>
					</h2>
				</header>
			</div>

			<div class="w-full">

				<div class="grid gap-4 md:grid-cols-2" id="laporan-content">
					<input id="id" name="id" type="hidden" value="{{ $data->id ?? 'N/A' }}">

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic class="cursor-not-allowed" id="no_sr" name="no_sr" value="{{ $data->no_sr ?? 'N/A' }}"
							readonly>
							No. SR
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic class="cursor-not-allowed" id="title" name="title"
							value="{{ $data->collectTaskRelasi->customer_name ?? 'N/A' }}" readonly>
							Nama Customer
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic class="cursor-not-allowed" id="location" name="location" value="{{ $data->location ?? 'N/A' }}"
							readonly>
							Alamat Customer
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic class="cursor-not-allowed" id="total_bill" name="total_bill"
							value="{{ Number::currency($data->collectTaskRelasi->total_bill ?? 0, 'IDR', 'id') }}" readonly>
							Total Tagihan
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic class="cursor-not-allowed" id="remaining_bill" name="remaining_bill"
							value="{{ Number::currency($data->collectTaskRelasi->remaining_bill ?? 0, 'IDR', 'id') }}" readonly>
							Sisa Tagihan
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full">
						<p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dokumentasi</p>
						<p class="mb-2 text-xs text-red-500"> *Dokumentasi tidak dapat diubah setelah laporan diinput. </p>

						@if (count($data->photoCollectRelasi) == 0)
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
						@else
							<div class="relative overflow-auto">
								<div class="flex overflow-x-auto" id="captured-images">

									<!-- Thumbnail gambar yang diambil akan muncul di sini -->
									@if ($data->photoCollectRelasi)
										@foreach ($data->photoCollectRelasi as $photo)
											<div class="relative me-2 flex-none items-center gap-4 rounded-xl p-2">
												<img
													class="h-36 w-36 rounded-xl object-cover blur-sm transition duration-300 ease-in-out hover:scale-105 hover:blur-0"
													id="documentations" data-url="{{ asset($photo->photourl) }}" src="{{ asset($photo->photourl) }}"
													alt="" onclick="javascript:void(0)" loading="lazy">
											</div>
										@endforeach
									@endif

								</div>
							</div>

						@endif

						<div class="mt-2 hidden text-sm text-red-500" id="alert-images"></div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1" id="have_paid_container">
						<x-input.select id="have_paid" name="have_paid" :options="[
						    '3' => 'Tanda Terima',
						    '0' => 'Belum bayar',
						    '1' => 'Cicil',
						    '2' => 'Lunas',
						]" default-option="Pilih status">
							<x-slot name="textLabel">
								Status Pembayaran
							</x-slot>
						</x-input.select>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-have_paid"></div>
					</div>

					<div class="col-span-2 w-full lg:col-span-1" id="payment_type_container">
						<x-input.select id="payment_type" name="payment_type" :options="[
						    '0' => 'Tidak ada',
						    '1' => 'Cash',
						    '2' => 'Transfer',
						    '3' => 'Giro',
						]" default-option="Pilih status">
							<x-slot name="textLabel">
								Metode Pembayaran
							</x-slot>
						</x-input.select>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-payment_type"></div>
					</div>

					<div class="col-span-2 w-full" id="payment_amount_container">
						<x-input.currency id="payment_amount" name="payment_amount" :values="$data->payment_amount" required>
							Total Bayar
						</x-input.currency>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-payment_amount"></div>
					</div>

					<div class="col-span-2 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="keterangan">Keterangan</label>
						</p>
						<div class="h-32 w-full dark:bg-white" id="editor"></div>
						<input id="keterangan" name="keterangan" type="hidden">
						<div class="mt-2 hidden text-sm text-red-500" id="alert-keterangan"></div>
					</div>

					<input class="hidden w-full rounded-lg border border-gray-300 bg-gray-400 p-2.5 text-sm text-gray-900"
						id="longitude" name="longitude" type="hidden" readonly>

					<input class="hidden w-full rounded-lg border border-gray-300 bg-gray-400 p-2.5 text-sm text-gray-900"
						id="latitude" name="latitude" type="hidden" readonly>

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
		const data = @json($data->keterangan);
	</script>
	@vite(['resources/js/collect/edit.js'])
@endpush
