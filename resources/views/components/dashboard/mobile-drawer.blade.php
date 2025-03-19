<x-drawer.navigation>
	<x-drawer.button href="{{ route('dashboard') }}" :label="'Home'" :active="Route::is('dashboard')">
		<x-icons.home
			class="{{ Route::is('dashboard') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
	</x-drawer.button>

	<x-drawer.button href="{{ route('attendanceIn.index') }}" :label="'Masuk'" :active="Route::is('attendanceIn.index')">
		<x-icons.arrow-left-bracket
			class="{{ Route::is('attendanceIn.index') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
	</x-drawer.button>

	<div class="flex items-center justify-center">
		<button
			class="group absolute bottom-8 inline-flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 font-medium outline outline-8 outline-blue-300 transition-transform duration-500 ease-in-out will-change-transform hover:scale-110 hover:bg-blue-700 hover:outline-blue-200"
			data-drawer-target="drawer-swipe" data-drawer-toggle="drawer-swipe" data-drawer-placement="bottom"
			data-drawer-edge="true" data-drawer-edge-offset="-bottom-20" type="button" aria-controls="drawer-swipe">
			<x-icons.bar
				class="h-8 w-8 text-white transition-transform duration-500 ease-in-out will-change-transform group-hover:size-9 group-hover:rotate-90 group-hover:text-gray-100" />
			<span class="sr-only">Menu</span>
		</button>
	</div>

	<x-drawer.button href="{{ route('attendanceOut.index') }}" :label="'Keluar'" :active="Route::is('attendanceOut.index')">
		<x-icons.arrow-right-bracket
			class="{{ Route::is('attendanceOut.index') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
	</x-drawer.button>

	<x-drawer.button href="{{ route('profile.edit') }}" :label="'Profile'" :active="Route::is('profile.edit')">
		<x-icons.profile-card
			class="{{ Route::is('profile.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
	</x-drawer.button>
</x-drawer.navigation>

<!-- drawer component -->
<div
	class="fixed bottom-12 z-50 mx-auto w-11/12 translate-y-full overflow-y-auto rounded-t-2xl border bg-white transition-transform dark:border-gray-700 dark:bg-dark-primary md:hidden"
	id="drawer-swipe" aria-labelledby="drawer-swipe-label" tabindex="-1">
	<div class="cursor-pointer p-4 hover:bg-gray-50 dark:hover:bg-gray-700" data-drawer-toggle="drawer-swipe">
		<span class="absolute left-1/2 top-3 h-1 w-8 -translate-x-1/2 rounded-xl bg-gray-300 dark:bg-gray-600"></span>
	</div>
	<div class="grid max-h-96 grid-cols-3 gap-6 overflow-y-auto px-4 pb-[60px] pt-4 lg:grid-cols-4">

		@php
			$drawerLinks = [
			    [
			        'permission' => 'dayoff-list',
			        'link' => 'dayoff.index',
			        'check' => 'dayoff.*',
			        'label' => 'Pengajuan Cuti',
			        'icon' => 'dayoff',
			    ],
			    [
			        'permission' => 'collect-task-list',
			        'link' => 'collect-task.index',
			        'check' => 'collect-task.*',
			        'label' => 'IDC Non (SR)',
			        'icon' => 'collect-task',
			    ],
			    [
			        'permission' => 'collect-task-ppn-list',
			        'link' => 'collect-task-ppn.index',
			        'check' => 'collect-task-ppn.*',
			        'label' => 'IDC PPN (FP)',
			        'icon' => 'collect-task-ppn',
			    ],
			    [
			        'permission' => 'collect-idy-ppn-list',
			        'link' => 'collect-idy-ppn.index',
			        'check' => 'collect-idy-ppn.*',
			        'label' => 'IDY PPN (FP)',
			        'icon' => 'collect-idy-ppn',
			    ],
			    [
			        'permission' => 'driver-list',
			        'link' => 'driver.index',
			        'check' => 'driver.*',
			        'label' => 'Laporan Driver',
			        'icon' => 'driver',
			    ],
			    [
			        'permission' => 'collect-list',
			        'link' => 'collect.index',
			        'check' => 'collect.*',
			        'label' => 'Laporan Kolektor',
			        'icon' => 'collect',
			    ],
			    [
			        'permission' => 'sales-list',
			        'link' => 'sales.index',
			        'check' => 'sales.*',
			        'label' => 'Laporan Sales',
			        'icon' => 'sales',
			    ],
			    [
			        'permission' => 'technician-list',
			        'link' => 'technician.index',
			        'check' => 'technician.*',
			        'label' => 'Laporan Teknisi',
			        'icon' => 'technician',
			    ],
			    [
			        'permission' => 'capture',
			        'link' => 'capture.index',
			        'check' => 'capture.*',
			        'label' => 'Record',
			        'icon' => 'capture',
			    ],
			    [
			        'permission' => 'pegawai-list',
			        'link' => 'pegawai.index',
			        'check' => 'pegawai.*',
			        'label' => 'Pegawai',
			        'icon' => 'pegawai',
			    ],
			    [
			        'permission' => 'jabatan-list',
			        'link' => 'jabatan.index',
			        'check' => 'jabatan.*',
			        'label' => 'Jabatan',
			        'icon' => 'jabatan',
			    ],
			    [
			        'permission' => 'golongan-list',
			        'link' => 'golongan.index',
			        'check' => 'golongan.*',
			        'label' => 'Golongan',
			        'icon' => 'golongan',
			    ],
			    [
			        'permission' => 'divisi-list',
			        'link' => 'division.index',
			        'check' => 'division.*',
			        'label' => 'Divisi',
			        'icon' => 'division',
			    ],
			    [
			        'permission' => 'placement-list',
			        'link' => 'placement.index',
			        'check' => 'placement.*',
			        'label' => 'Lokasi',
			        'icon' => 'placement',
			    ],
			    [
			        'permission' => 'users-list',
			        'link' => 'users.index',
			        'check' => 'users.*',
			        'label' => 'Users',
			        'icon' => 'users',
			    ],
			    [
			        'permission' => 'roles-list',
			        'link' => 'roles.index',
			        'check' => 'roles.*',
			        'label' => 'Roles',
			        'icon' => 'roles',
			    ],
			    [
			        'permission' => 'permissions-list',
			        'link' => 'permissions.index',
			        'check' => 'permissions.*',
			        'label' => 'Hak Akses',
			        'icon' => 'permissions',
			    ],
			    [
			        'permission' => 'log-list',
			        'link' => 'log.index',
			        'check' => 'log.*',
			        'label' => 'Log',
			        'icon' => 'log',
			    ],
			    [
			        'permission' => 'announcement-list',
			        'link' => 'announcement.index',
			        'check' => 'announcement.*',
			        'label' => 'Pusat Notifikasi',
			        'icon' => 'announcement',
			    ],

			    [
			        'permission' => 'backup-list',
			        'link' => 'backup.index',
			        'check' => 'backup.*',
			        'label' => 'Manage Backup',
			        'icon' => 'backup',
			    ],
			];
		@endphp

		@foreach ($drawerLinks as $item)
			@php
				$isActive = Route::is($item['check']);
			@endphp

			@can($item['permission'])
				<a
					class="{{ $isActive ? 'bg-gray-100 dark:bg-gray-700' : 'dark:bg-dark-primary bg-white' }} group cursor-pointer rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-600"
					href="{{ route($item['link']) }}">
					<div
						class="{{ $isActive ? 'bg-gray-100 dark:bg-gray-700' : 'dark:bg-gray-600 bg-gray-200' }} mx-auto mb-2 flex h-[48px] max-h-[48px] w-[48px] max-w-[48px] items-center justify-center rounded-xl group-hover:bg-gray-100 dark:group-hover:bg-gray-600">

						@php
							$iconClass = $isActive ? 'text-red-600' : 'text-gray-400';
							$iconSize =
							    'h-7 w-7 group-hover:text-red-600 group-hover:scale-125 transition-transform ease-in-out duration-500';
						@endphp

						@switch($item['icon'])
							@case('dayoff')
								<x-icons.lock-time class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('collect')
								<x-icons.clipboard class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('collect-task')
								<x-icons.cash class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('collect-task-ppn')
								<x-icons.sale-percent class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('collect-idy-ppn')
								<x-icons.cash-register class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('driver')
								<x-icons.truck class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('sales')
								<x-icons.receipt class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('technician')
								<x-icons.hammer class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('capture')
								<x-icons.camera class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('pegawai')
								<x-icons.address-book class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('jabatan')
								<x-icons.briefcase class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('golongan')
								<x-icons.users-group class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('division')
								<x-icons.object-column class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('placement')
								<x-icons.landmark class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('users')
								<x-icons.profile-card class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('roles')
								<x-icons.badge-check class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('permissions')
								<x-icons.adjustment class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('log')
								<x-icons.window class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('announcement')
								<x-icons.bullhorn class="{{ $iconClass }} {{ $iconSize }}" />
							@break

							@case('backup')
								<x-icons.filezip class="{{ $iconClass }} {{ $iconSize }}" />
							@break
						@endswitch

					</div>
					<div
						class="{{ $isActive ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 ' }} text-center text-sm font-medium group-hover:text-gray-900 group-hover:dark:text-white">
						{{ $item['label'] }}
					</div>
				</a>
			@endcan
		@endforeach
	</div>
</div>
