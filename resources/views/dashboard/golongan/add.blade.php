@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full">
		<form class="mt-4" action="{{ route('golongan.store') }}" method="POST">
			@csrf
			<div class="w-full md:max-w-lg">
				<div class="w-full space-y-6 xl:col-span-2">
					<div
						class="rounded-xl bg-white p-4 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 sm:p-6">
						<div class="max-w-xl">
							<header class="flex flex-row gap-x-3">
								<div class="max-w-xs">
									<x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
										href="{{ route('golongan.index') }}" wire:navigate>
										<x-slot name="icon">
											<x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
										</x-slot>
										Kembali
									</x-button.link>
								</div>
								<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
									{{ __('Tambah Data Golongan') }}
								</h2>
							</header>
							<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
								{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
							</p>

							<div class="my-4 grid gap-6 sm:gap-6 md:grid-cols-2">
								<div class="w-full">
									<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="nama_golongan">Nama
										Golongan</label>
									<input
										class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900"
										id="nama_golongan" name="nama_golongan" type="text" placeholder="Nama Golongan" required="">
								</div>
								<div class="w-full">
									<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="alias">Alias</label>
									<input
										class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900"
										id="alias" name="alias" type="text" placeholder="Alias" required="">
								</div>
							</div>

							<header class="flex flex-row">
								<h2 class="text-lg font-medium text-gray-900 dark:text-white">
									{{ __('Atur Jadwal') }}
								</h2>
							</header>
							<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
								{{ __('Atur jam masuk dan jam keluar untuk setiap hari.') }}
							</p>

							<div class="rounded-lg sm:my-4" id="jadwal">
								<!-- Looping for each day -->
								@php
									$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
								@endphp
								@foreach ($days as $day)
									<div class="w-full border-b border-b-gray-500">
										<div class="grid gap-2 py-4 sm:flex md:gap-4">

											<div class="w-20 sm:flex-none">
												<h3 class="text-md mt-0 font-semibold text-gray-700 dark:text-white md:mt-9">
													{{ $day }}</h3>
											</div>

											<div class="w-full sm:flex-1">
												<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
													for="jam_masuk_{{ strtolower($day) }}">Jam
													Masuk</label>
												<input
													class="focus:ring-primary-600 block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900"
													id="jam_masuk_{{ strtolower($day) }}" name="jam_masuk_{{ strtolower($day) }}" type="time" required>
											</div>

											<div class="w-full sm:flex-1">
												<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
													for="jam_keluar_{{ strtolower($day) }}">Jam
													Keluar</label>
												<input
													class="focus:ring-primary-600 block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900"
													id="jam_keluar_{{ strtolower($day) }}" name="jam_keluar_{{ strtolower($day) }}" type="time" required>
											</div>

										</div>
									</div>
								@endforeach
							</div>

							<div class="mt-4 flex items-center">
								<button
									class="inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 hover:bg-blue-800 hover:text-white focus:text-white focus:ring-4 focus:ring-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
									type="submit">
									Submit
									<svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 14 10">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M1 5h12m0 0L9 1m4 4L9 9" />
									</svg>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection
