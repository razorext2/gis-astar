@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="flex flex-col">
		<div class="mb-4 flex flex-col lg:grid lg:grid-cols-3 lg:gap-x-4">

			<form id="attend-in" action="{{ route('attendanceIn.index') }}"></form>
			<form id="attend-out" action="{{ route('attendanceOut.index') }}"></form>

			<!-- Chart -->
			<div
				class="col-span-2 mb-4 flex h-full flex-col rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b] md:p-6 lg:mb-0">
				<div class="mb-5 flex justify-between">
					<div>
						<p class="mb-2 text-3xl font-bold leading-none text-gray-900 dark:text-white">
							{{ $yearNow }}
						</p>
						<p class="text-base font-normal text-gray-500 dark:text-gray-300">
							Data 7 hari kebelakang
						</p>
					</div>
					<div class="flex items-center px-2.5 py-0.5 text-center text-base font-semibold text-green-500 dark:text-white">
						{{ $formattedDateRange }}
					</div>
				</div>

				{{-- chart here --}}
				<livewire:chart.line />

				<div class="justify-between border-t border-gray-200 dark:border-gray-700">
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
			<!-- End Chart -->

			<!-- Notification -->
			<div class="grid grid-cols-1 gap-y-4">

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
											alt="Jese image" loading="lazy">
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

				<div class="flex flex-col rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b]">

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
									alt="Jese image" loading="lazy">
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

	</div>
@endsection
