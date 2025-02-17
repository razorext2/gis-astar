@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="mb-4 grid grid-cols-1 gap-4 xl:gap-6">

		<div
			class="grid max-h-36 w-full grid-cols-3 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b] xl:p-6">
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
			<div class="w-full items-center self-center p-0 text-right">
				<div class="pt-2">
					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<a class="font-base text-md cursor-pointer text-blue-500 hover:underline md:text-lg" :href="route('logout')"
							onclick="event.preventDefault();
                            this.closest('form').submit();">
							Logout
						</a>
					</form>
				</div>
			</div>
		</div>

		<div
			class="hidden w-full rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b] lg:block xl:p-6">
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
									<img class="rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
										alt="Bonnie image" loading="lazy" />
								</span>
								<div
									class="items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">
									<time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
										@php
											$input = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $attendance['jam_masuk']);
											$current = \Carbon\Carbon::now();
											$diff = $input->diffInSeconds($current);

											if ($diff < 60) {
											    echo round($diff) . ' seconds ago';
											} elseif ($diff < 3600) {
											    echo round($input->diffInMinutes($current)) . ' minutes ago';
											} else {
											    echo round($input->diffInHours($current)) . ' hours ago';
											}
										@endphp
									</time>
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
								</div>
							</li>
						@else
							<span class="ml-2 text-gray-900 dark:text-white"> Data tidak ditemukan </span>
						@endif
						@if ($attendance['latest_jam_keluar'])
							<li class="mb-5 ms-6">
								<span
									class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 ring-8 ring-white dark:bg-blue-900 dark:ring-gray-900">
									<img class="rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
										alt="Bonnie image" loading="lazy" />
								</span>
								<div
									class="items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">
									<time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
										@php
											$input = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $attendance['latest_jam_keluar']);
											$current = \Carbon\Carbon::now();
											$diff = $input->diffInSeconds($current);

											if ($diff < 60) {
											    echo round($diff) . ' seconds ago';
											} elseif ($diff < 3600) {
											    echo round($input->diffInMinutes($current)) . ' minutes ago';
											} else {
											    echo round($input->diffInHours($current)) . ' hours ago';
											}
										@endphp
									</time>
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
								</div>
							</li>
						@endif
					@endforeach

				</ol>

			</div>
		</div>

		{{-- All Menu --}}
		<div
			class="w-full rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b] md:hidden lg:col-span-2 xl:col-span-3 xl:p-6">
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
				<div class="grid cursor-pointer grid-cols-4 items-center justify-between gap-2 text-gray-500">

					@can('capture')
						<x-menu.mobile-link href="{{ route('capture.index') }}" :label="'Record'">
							<x-icons.camera class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					<x-menu.mobile-link href="{{ route('attendanceIn.index') }}" :label="'Clock-in'">
						<x-icons.arrow-left-bracket class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
					</x-menu.mobile-link>

					<x-menu.mobile-link href="{{ route('attendanceOut.index') }}" :label="'Clock-out'">
						<x-icons.arrow-right-bracket class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
					</x-menu.mobile-link>

					@can('collect-list')
						<x-menu.mobile-link href="{{ route('collect.index') }}" :label="'Laporan Kolektor'">
							<x-icons.clipboard class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('collect-task-list')
						<x-menu.mobile-link href="{{ route('collect-task.index') }}" :label="'IDC Non PPN (SR)'">
							<x-icons.cash class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('collect-task-ppn-list')
						<x-menu.mobile-link href="{{ route('collect-task-ppn.index') }}" :label="'IDC PPN (FP)'">
							<x-icons.sale-percent class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('collect-idy-ppn-list')
						<x-menu.mobile-link href="{{ route('collect-idy-ppn.index') }}" :label="'IDY PPN (FP)'">
							<x-icons.cash-register class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('sales-list')
						<x-menu.mobile-link href="{{ route('sales.index') }}" :label="'Laporan Sales'">
							<x-icons.receipt class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('technician-list')
						<x-menu.mobile-link href="{{ route('technician.index') }}" :label="'Laporan Teknisi'">
							<x-icons.hammer class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('dayoff-list')
						<x-menu.mobile-link href="{{ route('dayoff.index') }}" :label="'Cuti'">
							<x-icons.lock-time class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('pegawai-list')
						<x-menu.mobile-link href="{{ route('pegawai.index') }}" :label="'Pegawai'">
							<x-icons.address-book class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('jabatan-list')
						<x-menu.mobile-link href="{{ route('jabatan.index') }}" :label="'Jabatan'">
							<x-icons.briefcase class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('golongan-list')
						<x-menu.mobile-link href="{{ route('golongan.index') }}" :label="'Golongan'">
							<x-icons.users-group class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('division-list')
						<x-menu.mobile-link href="{{ route('division.index') }}" :label="'Divisi'">
							<x-icons.object-column class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('placement-list')
						<x-menu.mobile-link href="{{ route('placement.index') }}" :label="'Penempatan'">
							<x-icons.landmark class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('users-list')
						<x-menu.mobile-link href="{{ route('users.index') }}" :label="'Users'">
							<x-icons.profile-card class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('roles-list')
						<x-menu.mobile-link href="{{ route('roles.index') }}" :label="'Roles'">
							<x-icons.badge-check class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('permissions-list')
						<x-menu.mobile-link href="{{ route('permissions.index') }}" :label="'Hak Akses'">
							<x-icons.adjustment class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('announcement-list')
						<x-menu.mobile-link href="{{ route('announcement.index') }}" :label="'Pemberitahuan'">
							<x-icons.bullhorn class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('log-list')
						<x-menu.mobile-link href="{{ route('log.index') }}" :label="'Log Aktivitas'">
							<x-icons.window class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					@can('backup-list')
						<x-menu.mobile-link href="{{ route('backup.index') }}" :label="'Manage Backup'">
							<x-icons.filezip class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
						</x-menu.mobile-link>
					@endcan

					<x-menu.mobile-link href="{{ route('profile.edit') }}" :label="'Profile'">
						<x-icons.profile-card class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
					</x-menu.mobile-link>

				</div>
			</div>
		</div>
		{{-- All Menu --}}

		<div
			class="w-full rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b] lg:hidden xl:p-6">
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
									<img class="rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
										alt="Bonnie image" loading="lazy" />
								</span>
								<div
									class="items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">
									<time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
										{{ \Carbon\Carbon::parse($attendance['jam_masuk'])->locale('id')->diffForHumans() }}
									</time>
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
									<img class="rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
										alt="Bonnie image" loading="lazy" />
								</span>
								<div
									class="items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-600 dark:bg-gray-700 sm:flex">
									<time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0">
										{{ \Carbon\Carbon::parse($attendance['latest_jam_keluar'])->locale('id')->diffForHumans() }}
									</time>
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
	</div>
@endsection
