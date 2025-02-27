@php
	$sidebarLinks = [
	    [
	        'route' => 'collect.index',
	        'check' => 'collect.*',
	        'label' => 'Laporan Kolektor',
	        'icon' => 'collect',
	        'permission' => 'collect-list',
	        'sublinks' => [],
	        'badge' => 'App\Models\Collector',
	        'condition' => ['status' => 2],
	    ],
	    [
	        'route' => 'sales.index',
	        'check' => 'sales.*',
	        'label' => 'Laporan Sales',
	        'icon' => 'sales',
	        'permission' => 'sales-list',
	        'sublinks' => [],
	        'badge' => 'App\Models\Sales',
	        'condition' => ['status' => 0],
	    ],
	    [
	        'route' => 'technician.index',
	        'check' => 'technician.*',
	        'label' => 'Laporan Teknisi',
	        'icon' => 'technician',
	        'permission' => 'technician-list',
	        'sublinks' => [],
	        'badge' => false,
	        'condition' => null,
	    ],
	    [
	        'route' => 'capture.index',
	        'check' => 'capture.*',
	        'label' => 'Record Attendance',
	        'icon' => 'capture',
	        'permission' => 'capture',
	        'sublinks' => [],
	        'badge' => false,
	        'condition' => null,
	    ],
	    [
	        'route' => 'dayoff.index',
	        'check' => 'dayoff.*',
	        'label' => 'Pengajuan Off',
	        'icon' => 'dayoff',
	        'permission' => 'dayoff-list',
	        'sublinks' => [],
	        'badge' => false,
	        'condition' => null,
	    ],
	    [
	        'route' => 'pegawai.index',
	        'check' => 'pegawai.*',
	        'label' => 'Pegawai',
	        'icon' => 'pegawai',
	        'permission' => 'pegawai-list',
	        'sublinks' => [],
	        'badge' => false,
	        'condition' => null,
	    ],
	    [
	        'route' => 'jabatan.index',
	        'check' => 'jabatan.*',
	        'label' => 'Jabatan',
	        'icon' => 'jabatan',
	        'permission' => 'jabatan-list',
	        'sublinks' => [],
	        'badge' => false,
	        'condition' => null,
	    ],
	    [
	        'route' => 'golongan.index',
	        'check' => 'golongan.*',
	        'label' => 'Golongan',
	        'icon' => 'golongan',
	        'permission' => 'golongan-list',
	        'sublinks' => [],
	        'badge' => false,
	        'condition' => null,
	    ],
	];
@endphp

<!-- Sidebar Navigation -->
<aside class="left-0 top-0 hidden h-screen flex-col bg-gray-50 pb-16 pt-16 dark:bg-[#09090b] md:fixed md:flex"
	id="logo-sidebar" aria-label="Sidebar">

	<div class="overflow-y-scroll p-5" wire:scroll>
		<ul class="space-y-2 font-medium">

			<li>
				<x-dashboard.sidebar-link href="{{ route('dashboard') }}" :active="Route::is('dashboard')">
					<x-slot name="icon">

						<x-icons.home
							class="{{ Route::is('dashboard') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />

					</x-slot>
					Dashboard
				</x-dashboard.sidebar-link>
			</li>

			<li x-data="{ absensi: {{ Route::is('attendanceIn.index') || Route::is('attendanceOut.index') ? 'true' : 'false' }} }">
				<button
					class="{{ Route::is('attendanceIn.index') || Route::is('attendanceOut.index') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-[#18181b] hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
					type="button" aria-controls="absensi-dropdown" @click="absensi = !absensi" :aria-expanded="absensi">
					<x-icons.grid-plus
						class="{{ Route::is('attendanceIn.index') || Route::is('attendanceOut.index') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
					<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">Absensi</span>

					<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
						x-bind:class="{ 'rotate-180 duration-200': absensi }" />
				</button>

				<!-- Dropdown Menu -->
				<ul class="space-y-4 py-4" id="absensi-dropdown" x-show="absensi"
					x-transition:enter="transition ease-in duration-200" x-transition:enter-start="transform opacity-0 -translate-y-5"
					x-transition:leave="transition ease-out duration-200" x-transition:leave-end="transform opacity-0 -translate-y-5">
					<li>
						<a
							class="{{ Route::is('attendanceIn.index') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
							href="{{ route('attendanceIn.index') }}">
							<x-icons.arrow-left-bracket
								class="{{ Route::is('attendanceIn.index') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
							<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Masuk</span>
						</a>
					</li>
					<li>
						<a
							class="{{ Route::is('attendanceOut.index') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
							href="{{ route('attendanceOut.index') }}">
							<x-icons.arrow-right-bracket
								class="{{ Route::is('attendanceOut.index') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
							<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Keluar</span>
						</a>
					</li>
				</ul>
			</li>

			@if (auth()->user()->hasAnyPermission(['collect-task-list', 'collect-task-list-ppn', 'collect-idy-ppn-list']))
				<li x-data="{ lokasi: {{ Route::is('collect-task.*') || Route::is('collect-task-ppn.*') || Route::is('collect-idy-ppn.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('collect-task.*') || Route::is('collect-task-ppn.*') || Route::is('collect-idy-ppn.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-[#18181b] hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="lokasi-dropdown" @click="lokasi = !lokasi" :aria-expanded="lokasi">

						<x-icons.wallet
							class="{{ Route::is('collect-task.*') || Route::is('collect-task-ppn.*') || Route::is('collect-idy-ppn.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">Piutang</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': lokasi }" />
					</button>

					<ul class="space-y-4 py-4" id="lokasi-dropdown" x-show="lokasi"
						x-transition:enter="transition ease-in duration-200" x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200" x-transition:leave-end="transform opacity-0 -translate-y-5">
						@can('collect-task-list')
							<li>
								<a
									class="{{ Route::is('collect-task.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('collect-task.index') }}">
									<x-icons.cash
										class="{{ Route::is('collect-task.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">IDC Non PPN (SR)</span>
								</a>
							</li>
						@endcan

						@can('collect-task-ppn-list')
							<li>
								<a
									class="{{ Route::is('collect-task-ppn.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('collect-task-ppn.index') }}">
									<x-icons.sale-percent
										class="{{ Route::is('collect-task-ppn.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">IDC PPN (FP)</span>
								</a>
							</li>
						@endcan

						@can('collect-idy-ppn-list')
							<li>
								<a
									class="{{ Route::is('collect-idy-ppn.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('collect-idy-ppn.index') }}">
									<x-icons.cash-register
										class="{{ Route::is('collect-idy-ppn.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">IDY PPN (FP)</span>
								</a>
							</li>
						@endcan
					</ul>
				</li>
			@endif

			@foreach ($sidebarLinks as $link)
				@php
					$isActive = Route::is($link['check']);
				@endphp

				@if ($link['permission'])
					@can($link['permission'])
						<li>
							<x-dashboard.sidebar-link href="{{ route($link['route']) }}" :active="$isActive">
								<x-slot name="icon">

									{{-- for icons to show --}}
									@switch($link['icon'])
										@case('collect')
											<x-icons.clipboard
												class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('capture')
											<x-icons.camera class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('dayoff')
											<x-icons.lock-time
												class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('pegawai')
											<x-icons.address-book
												class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('jabatan')
											<x-icons.briefcase
												class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('golongan')
											<x-icons.users-group
												class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('sales')
											<x-icons.receipt class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('technician')
											<x-icons.hammer class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
										@break
									@endswitch

								</x-slot>
								{{ $link['label'] }}

								@if ($link['badge'])
									@if (auth()->user()->hasPermissionTo($link['icon'] . '-approve'))
										@livewire('utils.report-counter', ['model' => $link['badge']])
									@endif
								@endif

							</x-dashboard.sidebar-link>
						</li>
					@endcan
				@endif
			@endforeach

			@if (auth()->user()->hasAnyPermission(['divisi-list', 'placement-list']))
				<li x-data="{ lokasi: {{ Route::is('division.*') || Route::is('placement.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('division.*') || Route::is('placement.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-[#18181b] hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="lokasi-dropdown" @click="lokasi = !lokasi" :aria-expanded="lokasi">

						<x-icons.map-pin
							class="{{ Route::is('division.*') || Route::is('placement.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">Lokasi</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': lokasi }" />
					</button>

					<ul class="space-y-4 py-4" id="lokasi-dropdown" x-show="lokasi"
						x-transition:enter="transition ease-in duration-200" x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200" x-transition:leave-end="transform opacity-0 -translate-y-5">
						@can('divisi-list')
							<li>
								<a
									class="{{ Route::is('division.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('division.index') }}">
									<x-icons.object-column
										class="{{ Route::is('division.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Divisi</span>
								</a>
							</li>
						@endcan

						@can('placement-list')
							<li>
								<a
									class="{{ Route::is('placement.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('placement.index') }}">
									<x-icons.landmark
										class="{{ Route::is('placement.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Penempatan</span>
								</a>
							</li>
						@endcan
					</ul>
				</li>
			@endif

			@if (auth()->user()->hasAnyPermission(['users-list', 'roles-list', 'permissions-list']))
				<li x-data="{ usermanage: {{ Route::is('users.*') || Route::is('permissions.*') || Route::is('roles.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('users.*') || Route::is('permissions.*') || Route::is('roles.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-[#18181b] hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="user-dropdown" @click="usermanage = !usermanage" :aria-expanded="usermanage">
						<x-icons.user-setting
							class="{{ Route::is('users.*') || Route::is('permissions.*') || Route::is('roles.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">User Settings</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': usermanage }" />
					</button>

					<ul class="space-y-4 py-4" id="user-dropdown" x-show="usermanage"
						x-transition:enter="transition ease-in duration-200"
						x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200"
						x-transition:leave-end="transform opacity-0 -translate-y-5">

						@can('users-list')
							<li>
								<a
									class="{{ Route::is('users.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('users.index') }}">
									<x-icons.profile-card
										class="{{ Route::is('users.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Users</span>
								</a>
							</li>
						@endcan

						@can('roles-list')
							<li>
								<a
									class="{{ Route::is('roles.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('roles.index') }}">
									<x-icons.badge-check
										class="{{ Route::is('roles.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Roles</span>
								</a>
							</li>
						@endcan

						@can('permissions-list')
							<li>
								<a
									class="{{ Route::is('permissions.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('permissions.index') }}">
									<x-icons.adjustment
										class="{{ Route::is('permissions.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Permissions</span>
								</a>
							</li>
						@endcan

					</ul>
				</li>
			@endif

			@if (auth()->user()->hasAnyPermission(['announcement-list', 'log-list', 'backup-list']))
				<li x-data="{ system: {{ Route::is('announcement.*') || Route::is('log.*') || Route::is('backup.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('announcement.*') || Route::is('log.*') || Route::is('backup.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-[#18181b] hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="system-dropdown" @click="system = !system" :aria-expanded="system">
						<x-icons.computer
							class="{{ Route::is('announcement.*') || Route::is('log.*') || Route::is('backup.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">System Settings</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': system }" />
					</button>

					<ul class="space-y-4 py-4" id="system-dropdown" x-show="system"
						x-transition:enter="transition ease-in duration-200"
						x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200"
						x-transition:leave-end="transform opacity-0 -translate-y-5">

						@can('announcement-list')
							<li>
								<a
									class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
									href="{{ route('announcement.index') }}" wire:navigate
									wire:current.exact="text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]">
									<x-icons.bullhorn class="h-6 w-6 -rotate-45 text-gray-400 group-hover:text-red-600"
										wire:current.exact="text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Pemberitahuan</span>
								</a>
							</li>
						@endcan

						@can('log-list')
							<li>
								<a
									class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
									href="{{ route('log.index') }}" wire:navigate
									wire:current.exact="text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]">
									<x-icons.window class="h-6 w-6 text-gray-400 group-hover:text-red-600" wire:current.exact="text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Log Aktivitas</span>
								</a>
							</li>
						@endcan

						@can('backup-list')
							<li>
								<a
									class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
									href="{{ route('backup.index') }}" wire:current.exact="text-red-600 font-bold bg-gray-100 dark:bg-[#18181b]"
									wire:navigate>
									<x-icons.filezip class="h-6 w-6 text-gray-400 group-hover:text-red-600" wire:current.exact="text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Manage Backups</span>
								</a>
							</li>
						@endcan

					</ul>
				</li>
			@endif

		</ul>
	</div>

	<!-- start footer -->
	@include('dashboard.layoutsDash.footer')
	<!-- footer -->
</aside>
