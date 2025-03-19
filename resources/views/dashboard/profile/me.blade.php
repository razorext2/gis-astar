@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="grid grid-cols-2 gap-4 rounded-xl">
		<div
			class="col-span-2 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 lg:p-6">
			<div class="flex flex-col gap-4">
				<h3
					class="border-b border-gray-200 pb-4 text-base font-semibold tracking-wider text-gray-800 dark:border-gray-700 dark:text-white md:text-xl">
					Data Pegawai
				</h3>

				<div class="grid items-center space-y-4 tracking-wider lg:grid-cols-2 lg:space-x-10 lg:space-y-0 xl:space-x-20">
					<div class="flex flex-col gap-4">
						<div class="flex flex-row items-center gap-x-4">
							<img class="h-20 w-20 rounded-lg object-cover"
								src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
								alt="user photo" loading="lazy">

							<div class="flex flex-col gap-y-1">
								<span
									class="w-fit rounded-md bg-green-700 px-2 text-xs text-green-300">{{ auth()->user()->roles->first()->name }}</span>
								<h4 class="text-lg font-semibold text-gray-800 dark:text-white">{{ auth()->user()->name }}</h4>
							</div>
						</div>

						<div class="flex flex-row justify-between">
							<div class="space-y-2">
								<dl>
									<dt class="font-medium text-gray-800 dark:text-white">Kode Jari</dt>
									<dd class="text-gray-500 dark:text-gray-400">{{ $data->kode_pegawai ?? 'Not set' }}</dd>
								</dl>
								<dl>
									<dt class="font-medium text-gray-800 dark:text-white">NIK Pegawai</dt>
									<dd class="text-gray-500 dark:text-gray-400">{{ $data->nik_pegawai ?? 'Not set' }}</dd>
								</dl>
								<dl>
									<dt class="font-medium text-gray-800 dark:text-white">Nama Panggilan</dt>
									<dd class="text-gray-500 dark:text-gray-400">
										{{ $data->nick_name ?? 'Not set' }}
									</dd>
								</dl>
								<dl>
									<dt class="font-medium text-gray-800 dark:text-white">Tanggal Lahir</dt>
									<dd class="text-gray-500 dark:text-gray-400">
										{{ optional($data)->tgl_lahir ? \Carbon\Carbon::parse($data->tgl_lahir)->translatedFormat('d F Y') : 'Not set' }}
									</dd>
								</dl>
							</div>

							<div class="space-y-2">
								<dl>
									<dt class="font-medium text-gray-800 dark:text-white">Alamat</dt>
									<dd class="text-gray-500 dark:text-gray-400">
										{{ $data->alamat ?? 'Not set' }}
									</dd>
								</dl>
								<dl>
									<dt class="font-medium text-gray-800 dark:text-white">Jabatan</dt>
									<dd class="text-gray-500 dark:text-gray-400">{{ $data->jabatanRelasi->nama_jabatan ?? 'Not set' }}</dd>
								</dl>
								<dl>
									<dt class="font-medium text-gray-800 dark:text-white">Golongan</dt>
									<dd class="text-gray-500 dark:text-gray-400">
										{{ $data->golonganRelasi->nama_golongan ?? 'Not set' }}
									</dd>
								</dl>
								<dl>
									<dt class="font-medium text-gray-800 dark:text-white">Storage</dt>
									<dd class="text-gray-500 dark:text-gray-400">
										{{ $data->storage ?? 'Not set' }}
									</dd>
								</dl>
							</div>
						</div>
					</div>

					<div class="rounded-lg p-4 shadow-md dark:border dark:border-gray-700">
						<div class="flex flex-col space-y-2">
							<p class="text-base font-semibold text-gray-700 dark:text-gray-200">Permissions</p>

							<div class="flex max-h-56 flex-row flex-wrap gap-1 overflow-y-auto">
								@foreach (auth()->user()->getPermissionsViaRoles() as $permission)
									<span class="w-fit rounded bg-green-400 px-2 py-0.5 text-xs dark:bg-green-700 dark:text-green-300">
										{{ $permission->name }}</span>
								@endforeach

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div
			class="col-span-2 content-center rounded-xl bg-white px-6 py-10 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 lg:col-span-1">
			<div class="flex flex-col items-center gap-y-3">
				<x-icons.file-pen class="h-20 w-20 text-gray-100 dark:text-gray-700/30" />
				<h3 class="text-lg font-semibold text-gray-700 dark:text-white">Mulai buat laporanmu.</h3>
				<p class="text-center text-gray-700 dark:text-gray-300">
					Laporanmu akan membantu kamu untuk mengelola data dengan lebih mudah.
				</p>
				<div class="flex flex-wrap justify-center gap-2">
					@can('collect-create')
						<x-button.link href="{{ route('collect.index') }}" class="w-44 justify-center">
							<x-slot name="icon">Laporan Koletor</x-slot>
							<x-icons.arrow-right class="h-4 w-4 -rotate-45 text-green-500 dark:text-white" />
						</x-button.link>
					@endcan
					@can('driver-create')
						<x-button.link href="{{ route('driver.create') }}" class="w-44 justify-center">
							<x-slot name="icon">Laporan Driver</x-slot>
							<x-icons.arrow-right class="h-4 w-4 -rotate-45 text-green-500 dark:text-white" />
						</x-button.link>
					@endcan
					@can('sales-create')
						<x-button.link href="{{ route('sales.create') }}" class="w-44 justify-center">
							<x-slot name="icon">Laporan Sales</x-slot>
							<x-icons.arrow-right class="h-4 w-4 -rotate-45 text-green-500 dark:text-white" />
						</x-button.link>
					@endcan
					@can('technician-create')
						<x-button.link href="{{ route('technician.index') }}" class="w-44 justify-center">
							<x-slot name="icon">Laporan Teknisi</x-slot>
							<x-icons.arrow-right class="h-4 w-4 -rotate-45 text-green-500 dark:text-white" />
						</x-button.link>
					@endcan
				</div>
			</div>
		</div>

		<div class="rounded-xl bg-white py-2 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 lg:p-6">
			{{-- @if (auth()->user()->kode_pegawai)
				@livewire('utils.attendance-calendar')
			@endif --}}
		</div>

	</div>
@endsection
