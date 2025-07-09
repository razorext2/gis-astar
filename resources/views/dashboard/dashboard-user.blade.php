@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="mb-4">
		@livewire('utils.greetings')
	</div>
	<div class="mb-4 grid grid-cols-1 gap-4 xl:gap-6">

		<div
			class="grid max-h-36 w-full grid-cols-3 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-dark-primary xl:p-6">
			<div class="col-span-2">
				<div>
					<div class="flex flex-row">
						<h2 class="font-base text-sm text-gray-400">
							Jadwal Kamu
						</h2>
					</div>
					<h2 class="text-md font-medium text-gray-900 dark:text-white md:text-lg">
						{{ $getDay }}, 12 November 2024
					</h2>
				</div>
				<div>
					<p class="text-2xl font-medium text-gray-900 dark:text-white lg:text-4xl">
						@if ($getJadwal)
							{{ $getJadwal->jam_masuk }} - {{ $getJadwal->jam_keluar }}
						@else
							No data.
						@endif
					</p>
				</div>
			</div>
		</div>

		@can('sales-create')
			<div
				class="grid w-full rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-dark-primary xl:p-6">

				<div>
					<h2 class="font-base text-sm text-gray-400">
						Persentase Laporan diterima
					</h2>
				</div>

				<div class="mt-2 grid gap-2 lg:grid-cols-3">
					<x-dashboard.plugin.percentage :label="'Laporan Sales Harian'" :total="$sales_total_daily" :approved="$sales_approved_daily" :percentage="$sales_approved_percentage_daily" />

					<x-dashboard.plugin.percentage :label="'Laporan Sales Bulanan'" :total="$sales_total_monthly" :approved="$sales_approved_monthly" :percentage="$sales_approved_percentage_monthly" />

					<x-dashboard.plugin.percentage :label="'Laporan Sales Total'" :total="$sales_total" :approved="$sales_approved" :percentage="$sales_approved_percentage" />
				</div>
			</div>
		@endcan

		@hasrole('Teknisi')
			<livewire:plugin.tech-report-percentage />
		@endhasrole

		<div
			class="hidden w-full rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-dark-primary lg:block xl:p-6">
			<div>
				<div class="flex flex-row">
					<h2 class="font-base text-sm text-gray-400">
						History
					</h2>
				</div>
				<h2 class="text-lg font-medium text-gray-900 dark:text-white">
					Absensi Kamu
				</h2>
			</div>
			<div class="pl-4 pt-4">

				<ol class="relative border-s border-gray-200 dark:border-gray-700">
					@foreach ($attendance_all as $index => $attendance)
						@if ($attendance['jam_masuk'])
							<li class="mb-5 ms-6">
								<span
									class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900">
									<img class="rounded-full shadow-lg" src="{{ asset('assets/img/profile-picture-5.jpg') }}" alt="Bonnie image"
										loading="lazy" />
								</span>
								<div
									class="items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">
									<div class="text-sm font-normal text-gray-500 dark:text-gray-300">
										Kamu melakukan
										<a class="font-semibold text-green-600 hover:underline dark:text-green-500" href="#">
											Clock-in
										</a>
										pada tanggal
										<span
											class="rounded bg-gray-100 px-0.5 py-1 text-xs font-normal text-gray-800 dark:bg-gray-600 dark:text-gray-300">
											{{ \Carbon\Carbon::parse($attendance['jam_masuk'])->locale('id')->isoFormat('DD MMMM YYYY') }}
										</span>, jam
										<span
											class="rounded bg-gray-100 px-0.5 py-1 text-xs font-normal text-gray-800 dark:bg-gray-600 dark:text-gray-300">
											{{ \Carbon\Carbon::parse($attendance['jam_masuk'])->format('H:i:s') }}
										</span>
									</div>

									<div class="flex flex-col items-end">
										@php
											$status = $attendance['status_in'];
											$map = [
											    0 => [
											        'color' => 'yellow',
											        'text' => 'Diajukan',
											    ],
											    1 => [
											        'color' => 'green',
											        'text' => 'Diterima',
											    ],
											    2 => [
											        'color' => 'red',
											        'text' => 'Ditolak',
											    ],
											];
											$color = $map[$status]['color'] ?? 'blue';
											$text = $map[$status]['text'] ?? 'Dibatalkan';
										@endphp

										<span
											class="bg-{{ $color }}-300 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300 rounded-lg px-2 py-0.5 text-xs font-normal">
											{{ $text }}
										</span>

										<time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
											{{ \Carbon\Carbon::parse($attendance['jam_masuk'])->locale('id')->diffForHumans() }}
										</time>
									</div>
								</div>
							</li>
						@else
							<span class="ml-2 text-gray-900 dark:text-white"> Data tidak ditemukan </span>
						@endif
						@if ($attendance['latest_jam_keluar'])
							<li class="mb-5 ms-6">
								<span
									class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900">
									<img class="rounded-full shadow-lg" src="{{ asset('assets/img/profile-picture-5.jpg') }}" alt="Bonnie image"
										loading="lazy" />
								</span>
								<div
									class="items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">
									<div class="text-sm font-normal text-gray-500 dark:text-gray-300">
										Kamu melakukan
										<a class="font-semibold text-red-600 hover:underline dark:text-red-500" href="#">
											Clock-out
										</a>
										pada tanggal
										<span
											class="rounded bg-gray-100 px-0.5 py-0.5 text-xs font-normal text-gray-800 dark:bg-gray-600 dark:text-gray-300">
											{{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->locale('id')->isoFormat('DD MMMM YYYY') }}
										</span>, jam
										<span
											class="rounded bg-gray-100 px-0.5 py-0.5 text-xs font-normal text-gray-800 dark:bg-gray-600 dark:text-gray-300">
											{{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->format('H:i:s') }}
										</span>
									</div>

									<div class="flex flex-col items-end">
										@php
											$status = $attendance['status_out'];
											$map = [
											    0 => [
											        'color' => 'yellow',
											        'text' => 'Diajukan',
											    ],
											    1 => [
											        'color' => 'green',
											        'text' => 'Diterima',
											    ],
											    2 => [
											        'color' => 'red',
											        'text' => 'Ditolak',
											    ],
											];
											$color = $map[$status]['color'] ?? 'blue';
											$text = $map[$status]['text'] ?? 'Dibatalkan';
										@endphp

										<span
											class="bg-{{ $color }}-300 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300 rounded-lg px-2 py-0.5 text-xs font-normal">
											{{ $text }}
										</span>

										<time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
											{{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->locale('id')->diffForHumans() }}
										</time>
									</div>
								</div>
							</li>
						@endif
					@endforeach

				</ol>

			</div>
		</div>

		{{-- all menu --}}
		<div
			class="w-full rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-dark-primary md:hidden lg:col-span-2 xl:col-span-3 xl:p-6">
			<div>
				<div class="flex flex-row">
					<h2 class="font-base text-sm text-gray-400">
						All
					</h2>
				</div>
				<h2 class="text-lg font-medium text-gray-900 dark:text-white">
					Menu
				</h2>
			</div>
			<div class="pt-2">
				<x-dashboard.user-menu />
			</div>
		</div>
		{{-- end all menu --}}

		{{-- attendance sub menu --}}
		<div
			class="w-full rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-dark-primary lg:hidden xl:p-6">
			<div>
				<div class="flex flex-row">
					<h2 class="font-base text-sm text-gray-400">
						History
					</h2>
				</div>
				<h2 class="text-lg font-medium text-gray-900 dark:text-white">
					Absensi Kamu
				</h2>
			</div>

			<div class="pl-4 pt-4">

				<ol class="relative border-s border-gray-200 dark:border-gray-700">
					@foreach ($attendance_all as $index => $attendance)
						@if ($attendance['jam_masuk'])
							<li class="mb-5 ms-6">
								<span
									class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900">
									<img class="rounded-full shadow-lg" src="{{ asset('assets/img/profile-picture-5.jpg') }}" alt="Bonnie image"
										loading="lazy" />
								</span>
								<div
									class="items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">

									<div class="flex flex-row items-center gap-x-1">
										@php
											$status = $attendance['status_in'];
											$map = [
											    0 => [
											        'color' => 'yellow',
											        'text' => 'Diajukan',
											    ],
											    1 => [
											        'color' => 'green',
											        'text' => 'Diterima',
											    ],
											    2 => [
											        'color' => 'red',
											        'text' => 'Ditolak',
											    ],
											];
											$color = $map[$status]['color'] ?? 'blue';
											$text = $map[$status]['text'] ?? 'Dibatalkan';
										@endphp

										<time class="text-xs font-normal text-gray-400">
											{{ \Carbon\Carbon::parse($attendance['jam_masuk'])->locale('id')->diffForHumans() }}
										</time>

										<span
											class="bg-{{ $color }}-300 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300 rounded-md px-2 py-0.5 text-xs font-normal">
											{{ $text }}
										</span>
									</div>

									<div class="text-sm font-normal text-gray-500 dark:text-gray-300">
										Kamu melakukan
										<a class="font-semibold text-green-600 hover:underline dark:text-green-500" href="#">
											Clock-in
										</a>
										pada jam
										<span
											class="rounded bg-gray-100 px-0.5 py-1 text-xs font-normal text-gray-800 dark:bg-gray-600 dark:text-gray-300">
											{{ \Carbon\Carbon::parse($attendance['jam_masuk'])->format('H:i:s') }}
										</span>
									</div>
								</div>
							</li>
						@else
							<span class="ml-2 text-gray-900 dark:text-white"> Data tidak ditemukan </span>
						@endif
						@if ($attendance['latest_jam_keluar'])
							<li class="mb-5 ms-6">
								<span
									class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900">
									<img class="rounded-full shadow-lg" src="{{ asset('assets/img/profile-picture-5.jpg') }}" alt="Bonnie image"
										loading="lazy" />
								</span>
								<div
									class="items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">
									<div class="flex flex-row items-center gap-x-1">
										@php
											$status = $attendance['status_out'];
											$map = [
											    0 => [
											        'color' => 'yellow',
											        'text' => 'Diajukan',
											    ],
											    1 => [
											        'color' => 'green',
											        'text' => 'Diterima',
											    ],
											    2 => [
											        'color' => 'red',
											        'text' => 'Ditolak',
											    ],
											];
											$color = $map[$status]['color'] ?? 'blue';
											$text = $map[$status]['text'] ?? 'Dibatalkan';
										@endphp

										<time class="text-xs font-normal text-gray-400">
											{{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->locale('id')->diffForHumans() }}
										</time>

										<span
											class="bg-{{ $color }}-300 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300 rounded-md px-2 py-0.5 text-xs font-normal">
											{{ $text }}
										</span>
									</div>
									<div class="text-sm font-normal text-gray-500 dark:text-gray-300">
										Kamu melakukan
										<a class="font-semibold text-red-600 hover:underline dark:text-red-500" href="#">
											Clock-out
										</a>
										pada jam
										<span
											class="rounded bg-gray-100 px-0.5 py-0.5 text-xs font-normal text-gray-800 dark:bg-gray-600 dark:text-gray-300">
											{{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->format('H:i:s') }}
										</span>

									</div>
								</div>
							</li>
						@endif
					@endforeach

				</ol>

			</div>
		</div>
		{{-- end attendance sub menu --}}
	</div>
@endsection
