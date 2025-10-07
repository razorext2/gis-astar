<div class="grid cursor-pointer grid-cols-3 items-center justify-between gap-2 text-gray-500">

	@can('capture')
		<x-menu.mobile-link href="{{ route('capture.index') }}" :label="'Absensi'">
			<x-icons.camera class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	@can('capture-route')
		<x-menu.mobile-link href="{{ route('capture.route') }}" :label="'Absensi Rute'">
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

	@can('driver-approve')
		<x-menu.mobile-link href="{{ route('driver.assign.add') }}" :label="'Assign Laporan Driver'">
			<x-icons.truck class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	@can('driver-list')
		<x-menu.mobile-link href="{{ route('driver.index') }}" :label="'Laporan Driver'">
			<x-icons.truck class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	@can('technician-list')
		<x-menu.mobile-link href="{{ route('technician.index') }}" :label="'Laporan Teknisi'">
			<x-icons.hammer class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	@can('sales-approve')
		<x-menu.mobile-link href="{{ route('routes.sales') }}" :label="'Rute Sales'">
			<x-icons.angle-right class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	@can('driver-approve')
		<x-menu.mobile-link href="{{ route('routes.driver') }}" :label="'Rute Driver'">
			<x-icons.angle-right class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	@can('collect-approve')
		<x-menu.mobile-link href="{{ route('routes.collector') }}" :label="'Rute Kolektor'">
			<x-icons.angle-right class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
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

	@can('technician-approve')
		<x-menu.mobile-link href="{{ route('map.distribution') }}" :label="'Peta Penyebaran'">
			<x-icons.book-open class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
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

	@can('event-manage')
		<x-menu.mobile-link href="{{ route('event.index') }}" :label="'Event'">
			<x-icons.gift-box class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	@can('technician-list')
		<x-menu.mobile-link href="{{ route('points.index') }}" :label="'Poin Masuk'">
			<x-icons.arrow-right class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	@can('point-redeem')
		<x-menu.mobile-link href="{{ route('technicianpoints.transactions') }}" :label="'Poin Keluar'">
			<x-icons.arrow-left class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
		</x-menu.mobile-link>
	@endcan

	<x-menu.mobile-link href="{{ route('profile.edit') }}" :label="'Profile'">
		<x-icons.profile-card class="h-7 w-7 stroke-blue-500 dark:stroke-white" />
	</x-menu.mobile-link>

</div>
