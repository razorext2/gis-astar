@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="grid grid-cols-1 gap-6">
		<div
			class="flex items-center justify-center rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700">

			<table id="filter-table">
				<thead>
					<tr>
						<th>
							<span class="flex items-center text-gray-800 dark:text-white">
								Foto
								<svg class="ms-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									fill="none" viewBox="0 0 24 24">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="m8 15 4 4 4-4m0-6-4-4-4 4" />
								</svg>
							</span>
						</th>
						<th>
							<span class="flex items-center text-gray-800 dark:text-white">
								Kode Pegawai
								<svg class="ms-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									fill="none" viewBox="0 0 24 24">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="m8 15 4 4 4-4m0-6-4-4-4 4" />
								</svg>
							</span>
						</th>
						<th>
							<span class="flex items-center text-gray-800 dark:text-white">
								Full Name
								<svg class="ms-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									fill="none" viewBox="0 0 24 24">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="m8 15 4 4 4-4m0-6-4-4-4 4" />
								</svg>
							</span>
						</th>
						<th>
							<span class="flex items-center text-gray-800 dark:text-white">
								Absen Masuk
								<svg class="ms-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
									fill="none" viewBox="0 0 24 24">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="m8 15 4 4 4-4m0-6-4-4-4 4" />
								</svg>
							</span>
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($datas as $index => $data)
						<tr class="hover:bg-gray-100 hover:text-black dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white">
							<td>
								@php
									$photoURL = sha1('libs');
									$url = $data->photoURL;
									$path = asset($photoURL . '/' . $url);
									$defaultImage = asset('assets/img/noImage.webp'); // Ganti dengan path gambar default Anda
								@endphp

								@if (file_exists(public_path(
											'storage/labels/' . $data->pegawaiRelasi->kode_pegawai . '/capturedImg/' . $data->photoURL . '.png')))
									<img class="w-32 rounded-lg blur-sm transition-all duration-300 hover:blur-none" src="{{ $path . '.png' }}"
										loading="lazy">
								@else
									<img class="w-32 rounded-lg blur-sm transition-all duration-300 hover:blur-none" src="{{ $defaultImage }}"
										loading="lazy">
								@endif
							</td>
							<td>{{ $data->pegawaiRelasi->kode_pegawai ?? 'N/A' }}</td>
							<td>{{ $data->pegawaiRelasi->full_name ?? 'N/A' }}</td>
							<td>
								{{ $data->jam_masuk ?? 'N/A' }}
								@if (
									\Carbon\Carbon::parse($data->jam_masuk)->gt(
										\Carbon\Carbon::parse(\Carbon\Carbon::parse($data->jam_masuk)->toDateString() . '08:00:00')))
									<span
										class="ml-2 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 shadow-sm ring-1 ring-gray-300 dark:bg-red-900 dark:text-white dark:ring-gray-700">Terlambat</span>
								@else
									<span
										class="ml-2 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 shadow-sm ring-1 ring-gray-300 dark:bg-green-800 dark:text-white dark:ring-gray-700">Tepat
										Waktu</span>
								@endif
							</td>
						</tr>
					@endforeach

				</tbody>
			</table>
		</div>
	</div>
@endsection
