@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6">
		<div
			class="grid gap-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">

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
						{{ __('Ubah Driver') }}
					</h2>

				</header>
				<p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
					{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
				</p>
			</div>

			<div class="w-full">

				<div class="grid gap-4 md:grid-cols-2" id="laporan-content">
					<input id="id" type="hidden" value="{{ $data->id }}" required>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="kode_pegawai" name="kode_pegawai" value="{{ $data->kode_pegawai }}" readonly>
							Kode Pegawai
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full lg:col-span-1">
						<x-input.basic id="employee_name" name="employee_name" value="{{ $data->pegawai->name }}" readonly>
							Nama Pegawai
						</x-input.basic>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="title" name="title" value="{{ $data->title }}" placeholder="Judul laporan" required>
							Judul Laporan
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-title"></div>
					</div>

					<div class="col-span-2 w-full">
						<x-input.basic id="lokasi" name="lokasi" value="{{ $data->lokasi }}" placeholder="Jl. XXX, XXX, XXX" required>
							Lokasi
						</x-input.basic>
						<div class="mt-2 hidden text-sm text-red-500" id="alert-lokasi"></div>
					</div>

					<div class="col-span-2 w-full">
						<p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dokumentasi</p>
						<p class="mb-2 text-xs text-red-500"> *Dokumentasi tidak dapat diubah setelah laporan diinput. </p>

						@if (count($data->photoCollect))

							<div class="relative overflow-auto">
								<div class="flex overflow-x-auto" id="captured-images">

									<!-- Thumbnail gambar yang diambil akan muncul di sini -->
									@if ($data->photoCollect)
										@foreach ($data->photoCollect as $photo)
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

					<div class="col-span-2 w-full">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="keterangan">Keterangan</label>
						<div class="h-32 w-full dark:bg-white" id="editor"></div>
						<input id="keterangan" name="keterangan" type="hidden">
						<div class="mt-2 hidden text-sm text-red-500" id="alert-keterangan"></div>
					</div>

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

@endsection
@push('script')
	<script>
		const data = @json($data->keterangan);
	</script>
	@vite(['resources/js/driver/edit.js'])
@endpush
