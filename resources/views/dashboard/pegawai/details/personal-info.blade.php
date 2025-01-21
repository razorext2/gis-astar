@extends('dashboard.pegawai.detail')
@section('menus')
	<div
		class="mb-8 grid gap-6 rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-[#18181b] xl:grid-cols-2">
		<div class="w-full">
			<div class="grid rounded-xl">
				<div class="relative w-full">
					<header class="flex flex-row">
						<h2 class="font-base text-sm text-gray-400">
							Personal Info
						</h2>
					</header>
					<h2 class="text-xl font-medium text-gray-900 dark:text-white">
						{{ $pegawai->full_name }}
					</h2>

					@if (auth()->user()->can('pegawai-edit'))
						<a class="absolute bottom-0 right-0 p-1 text-sm text-blue-500 hover:underline"
							href="{{ route('pegawai.edit', $pegawai->id) }}">
							Edit
						</a>
					@endif
				</div>

				<div class="w-full">
					<div class="grid gap-2 md:grid-cols-2">
						@foreach ($images as $image)
							@if (!is_null($image))
								<div class="mt-4 rounded-xl">
									<img class="h-56 w-full rounded-xl border border-gray-500 object-cover blur-sm hover:blur-none"
										src="{{ asset('storage/' . $pegawai->storage . $image) }}" alt="" loading="lazy">
								</div>
							@endif
						@endforeach
					</div>

					<div class="mt-4">

						<div class="grid gap-2 md:grid-cols-2">

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700 md:col-span-2">
								<p class="text-sm text-gray-600 dark:text-gray-300">Kode Pegawai</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->kode_pegawai ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Nama Lengkap</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->full_name ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Panggilan</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->nick_name ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">No Telepon</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->no_telp ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Tanggal Lahir</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->tgl_lahir ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700 md:col-span-2">
								<p class="text-sm text-gray-600 dark:text-gray-300">Alamat</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->alamat ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Jabatan</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->jabatanRelasi->nama_jabatan ?? 'N/A' }}
								</p>
							</div>

							<div
								class="flex flex-col items-start justify-center rounded-xl border border-gray-200 bg-gray-100 p-3 dark:border-gray-700 dark:bg-gray-700">
								<p class="text-sm text-gray-600 dark:text-gray-300">Storage</p>
								<p class="text-navy-700 text-base font-medium dark:text-white">
									{{ $pegawai->storage ?? 'N/A' }}
								</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="w-full grow space-y-6">
			<div class="w-full space-y-6 xl:col-span-2">
				<div class="rounded-xl py-2.5">

					<div class="mb-4 w-full">
						<header class="-mt-2.5 flex flex-col">
							<h2 class="text-xl font-medium text-gray-900 dark:text-white">
								<span class="!text-md text-gray-700 dark:text-gray-300">Periode: </span>

								<span id="choosenPeriod">
									{{ Request::query('period') ? \Carbon\Carbon::parse(Request::query('period'))->locale('id')->isoFormat('MMMM YYYY') : \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}
								</span>

							</h2>
							<p class="text-sm text-gray-700 dark:text-gray-300">
								Informasi absensi pegawai untuk periode yang dipilih. Data ini mencakup waktu masuk dan keluar harian.
							</p>

						</header>
					</div>

					<div
						class="grid grid-cols-7 gap-2 rounded-xl border border-gray-200 p-4 text-center dark:border-gray-700 dark:bg-[#242427]">
						<!-- Nama-nama hari -->
						<div class="font-medium text-gray-900 dark:text-white">Min</div>
						<div class="font-medium text-gray-900 dark:text-white">Sen</div>
						<div class="font-medium text-gray-900 dark:text-white">Sel</div>
						<div class="font-medium text-gray-900 dark:text-white">Rab</div>
						<div class="font-medium text-gray-900 dark:text-white">Kam</div>
						<div class="font-medium text-gray-900 dark:text-white">Jum</div>
						<div class="font-medium text-gray-900 dark:text-white">Sab</div>

						<!-- Looping untuk menampilkan tanggal -->
						@foreach ($dd as $date)
							@if ($date)
								@php

									$hasData = $attendanceData->contains(function ($attendance) use ($date) {
									    return \Carbon\Carbon::parse($attendance->jam_masuk)->isSameDay($date);
									});
								@endphp
								<div>
									<button
										class="{{ $hasData
										    ? 'bg-green-500 hover:bg-green-600 text-white dark:bg-green-800 dark:hover:bg-green-900 dark:text-white'
										    : 'bg-gray-200 text-gray-400 hover:bg-gray-300 dark:bg-transparent dark:text-gray-300' }} h-full w-full cursor-pointer rounded-lg border border-gray-200 p-2 dark:border-gray-700"
										data-date="{{ $date }}" data-popover-placement="left"
										data-popover-target="popover-click-{{ $date }}" data-popover-trigger="click" type="button">
										{{ \Carbon\Carbon::parse($date)->isoFormat('D') }}
									</button>
								</div>

								<div
									class="invisible absolute z-10 inline-block rounded-lg border border-gray-200 bg-white p-2 text-sm text-gray-500 opacity-0 transition-opacity duration-300 dark:border-gray-500 dark:bg-[#18181b] dark:text-gray-400"
									id="popover-click-{{ $date }}" data-popover role="tooltip">

									<div class="popover-content max-h-[250px] overflow-y-auto">
										<p>Tunggu sebentar, data sedang dimuat...</p>
									</div>

									<div data-popper-arrow></div>

								</div>
							@else
								<div></div>
							@endif
						@endforeach
					</div>

					<div class="mt-4 w-full">

						<x-button.primary class="max-h-10 !px-4" id="getAttendancePeriod" type="button">
							<x-slot name="icon">
								<x-icons.date class="icon h-3.5 w-3.5 text-red-500 dark:text-white" />
							</x-slot>
							Pilih periode lain
						</x-button.primary>

					</div>
				</div>
			</div>

		</div>
	</div>
@endsection
@push('script')
	<script>
		const libs = "{{ sha1('libs') }}";
		const id = "{{ $pegawai->kode_pegawai }}";
		const ids = "{{ $pegawai->id }}";
	</script>
	@vite('resources/js/pegawai/personalInfo.js')
@endpush
