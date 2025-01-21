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
									<img class="rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" loading="lazy"
										alt="Bonnie image" />
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
									<img class="rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" loading="lazy"
										alt="Bonnie image" />
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
						<a
							class="group mb-2 flex h-full w-auto transform cursor-pointer flex-col items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-2 text-blue-700 shadow transition duration-75 ease-in hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-gray-700 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800"
							href="{{ route('capture.index') }}">
							<svg class="fi-sidebar-item-icon h-7 w-7 stroke-blue-500 dark:stroke-white" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
								<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
								<g id="SVGRepo_iconCarrier">
									<path
										d="M3 4H8M3 11H9.76389M14.2361 11H21M21 7.2V16.8C21 17.9201 21 18.4802 20.782 18.908C20.5903 19.2843 20.2843 19.5903 19.908 19.782C19.4802 20 18.9201 20 17.8 20H6.2C5.0799 20 4.51984 20 4.09202 19.782C3.71569 19.5903 3.40973 19.2843 3.21799 18.908C3 18.4802 3 17.9201 3 16.8V10.2C3 9.0799 3 8.51984 3.21799 8.09202C3.40973 7.71569 3.71569 7.40973 4.09202 7.21799C4.51984 7 5.0799 7 6.2 7H7.67452C8.1637 7 8.40829 7 8.63846 6.94474C8.84254 6.89575 9.03763 6.81494 9.21657 6.70528C9.4184 6.5816 9.59135 6.40865 9.93726 6.06274L11.0627 4.93726C11.4086 4.59136 11.5816 4.4184 11.7834 4.29472C11.9624 4.18506 12.1575 4.10425 12.3615 4.05526C12.5917 4 12.8363 4 13.3255 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V17H7C5.89543 17 5 17.8954 5 19ZM15 13C15 14.6569 13.6569 16 12 16C10.3431 16 9 14.6569 9 13C9 11.3431 10.3431 10 12 10C13.6569 10 15 11.3431 15 13Z"
										stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"></path>
								</g>
							</svg>
							<p class="mt-1 text-xs">Record</p>
						</a>
					@endcan

					@can('collect-list')
						<a
							class="group mb-2 flex h-full w-auto transform cursor-pointer flex-col items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-2 text-blue-700 shadow transition duration-75 ease-in hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-gray-700 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800"
							href="{{ route('collect.index') }}">
							<svg class="fi-sidebar-item-icon h-7 w-7 stroke-blue-700 dark:stroke-white" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
								<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
								<g id="SVGRepo_iconCarrier">
									<path
										d="M5 19V6.2C5 5.0799 5 4.51984 5.21799 4.09202C5.40973 3.71569 5.71569 3.40973 6.09202 3.21799C6.51984 3 7.0799 3 8.2 3H15.8C16.9201 3 17.4802 3 17.908 3.21799C18.2843 3.40973 18.5903 3.71569 18.782 4.09202C19 4.51984 19 5.0799 19 6.2V17H7C5.89543 17 5 17.8954 5 19ZM5 19C5 20.1046 5.89543 21 7 21H19M18 17V21M14.5 8V7.91667C14.5 6.85812 13.6419 6 12.5833 6H11.5C10.3954 6 9.5 6.89543 9.5 8C9.5 9.10457 10.3954 10 11.5 10H12.5C13.6046 10 14.5 10.8954 14.5 12C14.5 13.1046 13.6046 14 12.5 14H11.4583C10.3768 14 9.5 13.1232 9.5 12.0417V12"
										stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
								</g>
							</svg>
							<p class="mt-1 text-center text-xs">Laporan Kolektor</p>
						</a>
					@endcan

					@can('collect-task-list')
						<a
							class="group mb-2 flex h-full w-auto transform cursor-pointer flex-col items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-2 text-blue-700 shadow transition duration-75 ease-in hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-gray-700 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800"
							href="{{ route('collect-task.index') }}">
							<x-icons.sale-percent class="mb-1 h-6 w-6" />
							<p class="mt-1 text-center text-xs">IDC Non PPN (SR)</p>
						</a>
					@endcan

					@can('sales-list')
						<a
							class="group mb-2 flex h-full w-auto transform cursor-pointer flex-col items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-2 text-blue-700 shadow transition duration-75 ease-in hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-gray-700 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800"
							href="{{ route('sales.index') }}">
							<x-icons.receipt class="mb-1 h-6 w-6" />
							<p class="mt-1 text-center text-xs">Laporan Sales</p>
						</a>
					@endcan

					<a
						class="group mb-2 flex h-full w-auto transform cursor-pointer flex-col items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-2 text-blue-700 shadow transition duration-75 ease-in hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-gray-700 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800"
						href="{{ route('attendanceIn.index') }}">
						<svg class="mb-1 h-6 w-6 rotate-180 fill-blue-700 dark:fill-white" aria-hidden="true"
							xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
							<path fill-rule="evenodd"
								d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25ZM15 13C15 14.6569 13.6569 16 12 16C10.3431 16 9 14.6569 9 13C9 11.3431 10.3431 10 12 10C13.6569 10 15 11.3431 15 13Z"
								clip-rule="evenodd"></path>
							<path fill-rule="evenodd"
								d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 19 10Z"
								clip-rule="evenodd"></path>
						</svg>
						<p class="mt-1 text-xs">Clock-in</p>
					</a>

					<a
						class="group mb-2 flex h-full w-auto transform cursor-pointer flex-col items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-2 text-blue-700 shadow transition duration-75 ease-in hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-gray-700 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800"
						href="{{ route('attendanceOut.index') }}">
						<svg class="mb-1 h-6 w-6 fill-blue-700 dark:fill-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20">
							<path fill-rule="evenodd"
								d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25ZM15 13C15 14.6569 13.6569 16 12 16C10.3431 16 9 14.6569 9 13C9 11.3431 10.3431 10 12 10C13.6569 10 15 11.3431 15 13Z"
								clip-rule="evenodd"></path>
							<path fill-rule="evenodd"
								d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 19 10Z"
								clip-rule="evenodd"></path>
						</svg>
						<p class="mt-1 text-xs">Clock-out</p>
					</a>

					@can('dayoff-list')
						<a
							class="group mb-2 flex h-full w-auto transform cursor-pointer flex-col items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-2 text-blue-700 shadow transition duration-75 ease-in hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-gray-700 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800"
							href="{{ route('dashboard.dayoff') }}">
							<svg class="fi-sidebar-item-icon h-7 w-7 stroke-blue-700 dark:stroke-white" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
								<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
								<g id="SVGRepo_iconCarrier">
									<path
										d="M3 5.5L5 3.5M21 5.5L19 3.5M9 9.5L15 15.5M15 9.5L9 15.5M20 12.5C20 16.9183 16.4183 20.5 12 20.5C7.58172 20.5 4 16.9183 4 12.5C4 8.08172 7.58172 4.5 12 4.5C16.4183 4.5 20 8.08172 20 12.5Z"
										stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
									</path>
								</g>
							</svg>
							<p class="mt-1 text-xs">Timeoff</p>
						</a>
					@endcan

					<a
						class="group mb-2 flex h-full w-auto transform cursor-pointer flex-col items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-2 text-blue-700 shadow transition duration-75 ease-in hover:scale-95 hover:bg-gray-100 hover:shadow-md dark:border-gray-700 dark:bg-gray-700 dark:text-white hover:dark:bg-gray-800"
						href="{{ route('profile.edit') }}">
						<svg class="mb-1 h-5 w-5 fill-blue-700 dark:fill-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20">
							<path
								d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
						</svg>
						<p class="mt-1 text-xs">Profile</p>
					</a>

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
									<img class="rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" loading="lazy"
										alt="Bonnie image" />
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
									<img class="rounded-full shadow-lg" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" loading="lazy"
										alt="Bonnie image" />
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
	</div>
@endsection
