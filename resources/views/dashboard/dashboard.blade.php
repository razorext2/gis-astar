@extends('dashboard.layoutsDash.app')
@section('content')
	<form id="attend-in" action="{{ route('attendanceIn.index') }}"></form>
	<form id="attend-out" action="{{ route('attendanceOut.index') }}"></form>

	<div class="mb-4 grid grid-cols-1 gap-0 xl:grid-cols-3 xl:gap-4">

		<!-- Chart -->
		<div class="col-span-2 mb-4 flex items-center justify-center xl:mb-0">
			<div class="w-full rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b] md:p-6">
				<div class="mb-5 flex justify-between">
					<div>
						<p class="mb-2 text-3xl font-bold leading-none text-gray-900 dark:text-white">{{ $yearNow }}
						</p>
						<p class="text-base font-normal text-gray-500 dark:text-gray-300">Data 7 hari kebelakang</p>
					</div>
					<div class="flex items-center px-2.5 py-0.5 text-center text-base font-semibold text-green-500 dark:text-white">
						{{ $formattedDateRange }}
					</div>
				</div>
				<div id="tooltip-chart" data-late-counts='[2,3,1]' data-ontime-counts='[0,2,3]' data-outtime-counts="[2,0,2]"
					data-fast-counts='[0,5,0]' data-dates='[1,4,2]'></div>
				<div class="mt-5 grid grid-cols-1 items-center justify-between border-t border-gray-200 dark:border-gray-700">
					<div class="flex items-center justify-between pt-5">

						<x-button.primary form="attend-in" type="submit">
							<x-slot name="icon">
								<x-icons.angle-right class="icon h-6 w-6 text-green-500 dark:text-white" />
							</x-slot>
							Absen masuk
						</x-button.primary>

						<x-button.danger form="attend-out" type="submit">
							<x-slot name="icon">
								<x-icons.angle-left class="icon h-6 w-6 text-green-500 dark:text-white" />
							</x-slot>
							Absen keluar
						</x-button.danger>
					</div>
				</div>
			</div>
		</div>
		<!-- End Chart -->

		<!-- Notification -->
		<div class="grid grid-cols-1">

			<div class="flex flex-col rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b]">

				<p class="font-base text-sm text-gray-500 dark:text-gray-400">
					Absen Masuk
				</p>
				<p class="text-md font-medium text-gray-900 dark:text-white">
					{{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM YYYY') }}
				</p>
				<ul class="h-44 overflow-y-auto text-gray-700" aria-labelledby="dropdownUsersButton">

					@if (!empty($attendance_today))
						@foreach ($attendance_today as $at)
							<li>
								<p
									class="my-2 flex rounded-lg bg-green-500 bg-none p-2 text-xs text-white hover:bg-green-600 dark:bg-green-700 dark:hover:bg-green-800">
									<img class="me-3 h-6 w-6 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
										alt="Jese image">
									<span class="leading-relaxed">
										{{ $at->pegawaiRelasi->full_name ?? 'N/A' }}, melakukan absensi <b
											class="rounded bg-green-800 px-1 py-0.5 text-white">Masuk</b> pada
										pukul
										{{ \Carbon\Carbon::parse($at->jam_masuk)->format('H:i') }}
									</span>
								</p>
							</li>
						@endforeach
					@else
						<li>
							<span class="my-2 flex items-center rounded-xl">
								Belum ada absensi hari ini
							</span>
						</li>
					@endif

				</ul>
			</div>

			<div class="mt-3 flex flex-col rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b]">

				<p class="font-base text-sm text-gray-400">
					Absen Keluar
				</p>
				<p class="text-md font-medium text-gray-900 dark:text-white">
					{{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMMM YYYY') }}
				</p>
				<ul class="h-44 overflow-y-auto text-gray-700" aria-labelledby="dropdownUsersButton">
					@foreach ($attendance_out_today as $at)
						<p
							class="my-2 flex rounded-lg bg-red-500 bg-none p-2 text-xs text-white hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800">
							<img class="me-3 h-6 w-6 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
								alt="Jese image">
							<span class="leading-relaxed">
								{{ $at->pegawaiRelasi->full_name ?? 'N/A' }}, melakukan absensi <b
									class="rounded bg-red-800 px-1 py-0.5 text-white">Keluar</b> pada
								pukul
								{{ \Carbon\Carbon::parse($at->jam_keluar)->format('H:i') }}
							</span>
						</p>
					@endforeach
				</ul>
			</div>
		</div>
		<!-- End Notification -->
	</div>

	<div class="grid grid-cols-1 gap-6">
		<div
			class="flex h-auto items-center justify-center rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-[#18181b]">
			<!-- Table -->
			<div class="relative w-full overflow-x-auto">
				<table class="w-full text-left text-sm" id="filter-table">
					<thead>
						<tr>
							<th class="dark:text-white">
								<span class="flex items-center">
									Waktu
									<x-icons.chevron-sort class="ms-1 h-4 w-4" />
								</span>
							</th>
							<th class="dark:text-white">
								<span class="flex items-center">
									Kode Pegawai
									<x-icons.chevron-sort class="ms-1 h-4 w-4" />
								</span>
							</th>
							<th class="dark:text-white">
								<span class="flex items-center">
									Full Name
									<x-icons.chevron-sort class="ms-1 h-4 w-4" />
								</span>
							</th>
							<th class="dark:text-white">
								<span class="flex items-center">
									Nick Name
									<x-icons.chevron-sort class="ms-1 h-4 w-4" />
								</span>
							</th>
							<th class="dark:text-white">
								<span class="flex items-center">
									No Telepon
									<x-icons.chevron-sort class="ms-1 h-4 w-4" />
								</span>
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($attendance_all as $index => $attendance)
							<tr class="hover:bg-gray-100 hover:text-black dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white">
								<td class="flex flex-col text-center">
									<!-- jam masuk -->
									@if ($attendance['jam_masuk'])
										<span
											class="my-1 w-full rounded-lg py-1 text-black ring-1 ring-green-400 hover:bg-green-300 dark:bg-green-800 dark:text-white dark:ring-1 dark:ring-gray-700 dark:hover:bg-green-900 md:px-1">
											Masuk : {{ \Carbon\Carbon::parse($attendance['jam_masuk'])->format('H:i') }}
										</span>
									@else
										<span
											class="my-1 w-full rounded-lg py-1 text-black ring-1 ring-red-400 hover:bg-red-300 dark:bg-red-800 dark:text-white dark:ring-1 dark:ring-gray-700 dark:hover:bg-red-900 md:px-1">
											Belum Absen
										</span>
									@endif

									<!-- jam keluar -->
									@if ($attendance['latest_jam_keluar'])
										<span
											class="my-1 w-full rounded-lg py-1 text-black ring-1 ring-green-400 hover:bg-green-300 dark:bg-green-800 dark:text-white dark:ring-1 dark:ring-gray-700 dark:hover:bg-green-900 md:px-1">
											Keluar :
											{{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->format('H:i') }}
										</span>
									@else
										<span
											class="my-1 w-full rounded-lg py-1 text-black ring-1 ring-red-400 hover:bg-red-300 dark:bg-red-800 dark:text-white dark:ring-1 dark:ring-gray-700 dark:hover:bg-red-900 md:px-1">
											Belum Absen
										</span>
									@endif

								</td>
								<td>{{ $attendance['kode_pegawai'] ?? 'N/A' }}</td>
								<td>{{ $attendance['full_name'] ?? 'N/A' }}</td>
								<td>{{ $attendance['nick_name'] ?? 'N/A' }}</td>
								<td>{{ $attendance['no_telp'] ?? 'N/A' }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<!-- End Table -->
		</div>

	</div>

@endsection
