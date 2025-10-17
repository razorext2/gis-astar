@php
	$sidebarLinks = [
	    [
	        'route' => 'collect.index',
	        'check' => 'collect.*',
	        'label' => 'Laporan Kolektor',
	        'icon' => 'collect',
	        'permission' => 'collect-list',
	        'sublinks' => [],
	        'navigate' => false,
	        'indicator' => true,
	    ],
	    [
	        'route' => 'sales.index',
	        'check' => 'sales.*',
	        'label' => 'Laporan Sales',
	        'icon' => 'sales',
	        'permission' => 'sales-list',
	        'sublinks' => [],
	        'navigate' => true,
	        'indicator' => true,
	    ],
	    [
	        'route' => 'technician.index',
	        'check' => 'technician.*',
	        'label' => 'Laporan Teknisi',
	        'icon' => 'technician',
	        'permission' => 'technician-list',
	        'sublinks' => [],
	        'navigate' => true,
	        'indicator' => true,
	    ],
	    [
	        'route' => 'invoice.index',
	        'check' => 'invoice.*',
	        'label' => 'Laporan Invoice',
	        'icon' => 'invoice',
	        'permission' => 'invoice-list',
	        'sublinks' => [],
	        'navigate' => true,
	        'indicator' => false,
	    ],
	    [
	        'route' => 'invoice.index',
	        'check' => 'invoice.*',
	        'label' => 'Laporan Invoice PKU',
	        'icon' => 'invoice',
	        'permission' => 'invoice-list-pku',
	        'sublinks' => [],
	        'navigate' => true,
	        'indicator' => false,
	    ],
	    [
	        'route' => 'invoice.index',
	        'check' => 'invoice.*',
	        'label' => 'Laporan Invoice JKT',
	        'icon' => 'invoice',
	        'permission' => 'invoice-list-jkt',
	        'sublinks' => [],
	        'navigate' => true,
	        'indicator' => false,
	    ],
	    [
	        'route' => 'capture.index',
	        'check' => 'capture.index',
	        'label' => 'Record Attendance',
	        'icon' => 'capture',
	        'permission' => 'capture',
	        'sublinks' => [],
	        'navigate' => false,
	        'indicator' => false,
	    ],
	    [
	        'route' => 'capture.route',
	        'check' => 'capture.route',
	        'label' => 'Absen Rute',
	        'icon' => 'capture',
	        'permission' => 'capture-route',
	        'sublinks' => [],
	        'navigate' => false,
	        'indicator' => false,
	    ],
	    [
	        'route' => 'dayoff.index',
	        'check' => 'dayoff.*',
	        'label' => 'Pengajuan Off',
	        'icon' => 'dayoff',
	        'permission' => 'dayoff-list',
	        'sublinks' => [],
	        'navigate' => false,
	        'indicator' => false,
	    ],
	    [
	        'route' => 'pegawai.index',
	        'check' => 'pegawai.*',
	        'label' => 'Pegawai',
	        'icon' => 'pegawai',
	        'permission' => 'pegawai-list',
	        'sublinks' => [],
	        'navigate' => false,
	        'indicator' => false,
	    ],
	    [
	        'route' => 'jabatan.index',
	        'check' => 'jabatan.*',
	        'label' => 'Jabatan',
	        'icon' => 'jabatan',
	        'permission' => 'jabatan-list',
	        'sublinks' => [],
	        'navigate' => false,
	        'indicator' => false,
	    ],
	    [
	        'route' => 'golongan.index',
	        'check' => 'golongan.*',
	        'label' => 'Golongan',
	        'icon' => 'golongan',
	        'permission' => 'golongan-list',
	        'sublinks' => [],
	        'navigate' => false,
	        'indicator' => false,
	    ],
	];
@endphp

<!-- Sidebar Navigation -->
<aside
	class="left-0 top-0 z-40 hidden h-screen min-w-[265px] flex-col bg-white pb-14 shadow-sm transition-all duration-300 ease-out dark:bg-[#09090b] dark:shadow-none md:fixed md:flex"
	id="logo-sidebar" aria-label="Sidebar" :class="openSidebar ? 'translate-x-0' : '-translate-x-72'">

	<div id="tombolSidebar" :class="openSidebar ? 'translate-x-0' : 'absolute translate-x-24 bg-white dark:bg-[#09090b]'"
		class="mx-auto flex w-full justify-between rounded-br-2xl p-5 shadow-md drop-shadow-lg transition-all duration-200 ease-out dark:border-b-[1px] dark:border-r-[4px] dark:border-red-800 dark:shadow-none dark:drop-shadow-none">
		<div class="flex items-center justify-start">
			<a class="flex items-center" href="{{ config('app.url') }}">
				<img class="h-8" src="{{ asset('assets/img/logo.png') }}" alt="Indodacin Logo" loading="lazy" />
			</a>
		</div>

		<button @click="openSidebar = !openSidebar" class="rounded-lg px-2 py-1">
			<span x-show="!openSidebar">
				<x-icons.open-sidebar-alt data-tooltip-target="open-sidebar-alt"
					class="h-6 w-6 text-gray-800 transition-all duration-300 ease-in-out hover:scale-110 dark:text-white" />

				<div id="open-sidebar-alt" role="tooltip"
					class="shadow-xs tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700">
					Buka Sidebar
					<div class="tooltip-arrow" data-popper-arrow></div>
				</div>
			</span>
			<span x-show="openSidebar">
				<x-icons.close-sidebar-alt data-tooltip-target="close-sidebar-alt"
					class="h-6 w-6 text-gray-800 transition-all duration-300 ease-in-out hover:scale-110 dark:text-white" />

				<div id="close-sidebar-alt" role="tooltip"
					class="shadow-xs tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700">
					Tutup Sidebar
					<div class="tooltip-arrow" data-popper-arrow></div>
				</div>
			</span>
		</button>
	</div>

	<div class="overflow-y-scroll p-5" wire:scroll>
		<ul class="space-y-2 font-medium">

			<li>
				<x-dashboard.sidebar-link href="{{ route('dashboard') }}" wire:navigate :active="Route::is('dashboard')">
					<x-slot name="icon">
						<x-icons.home class="{{ Route::is('dashboard') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
					</x-slot>
					Dashboard
				</x-dashboard.sidebar-link>
			</li>

			<li x-data="{ absensi: {{ Route::is('attendanceIn.index') || Route::is('attendanceOut.index') || Route::is('today.attendance') ? 'true' : 'false' }} }">
				<button
					class="{{ Route::is('attendanceIn.index') || Route::is('attendanceOut.index') || Route::is('today.attendance') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
					type="button" aria-controls="absensi-dropdown" @click="absensi = !absensi" :aria-expanded="absensi">
					<x-icons.grid-plus
						class="{{ Route::is('attendanceIn.index') || Route::is('attendanceOut.index') || Route::is('today.attendance') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
					<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">Absensi</span>

					<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
						x-bind:class="{ 'rotate-180 duration-200': absensi }" />
				</button>

				<!-- Dropdown Menu -->
				<ul class="space-y-4 py-4" id="absensi-dropdown" x-show="absensi"
					x-transition:enter="transition ease-in duration-200" x-transition:enter-start="transform opacity-0 -translate-y-5"
					x-transition:leave="transition ease-out duration-200" x-transition:leave-end="transform opacity-0 -translate-y-5">

					@hasanyrole('Admin|Management|HRD|Service')
						<li>
							<a
								class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
								href="{{ route('today.attendance') }}"
								wire:current.href="!text-red-600 !dark:text-red-600 !dark:font-bold !font-bold bg-gray-100 dark:bg-dark-primary"
								wire:navigate>
								<x-icons.map-pin-alt class="h-6 w-6 group-hover:text-red-600" />
								<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Today's Attendance</span>
							</a>
						</li>
					@endhasanyrole

					<li>
						<a
							class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
							href="{{ route('attendanceIn.index') }}"
							wire:current.href="!text-red-600 !dark:text-red-600 !dark:font-bold !font-bold bg-gray-100 dark:bg-dark-primary"
							wire:navigate>
							<x-icons.arrow-left-bracket class="h-6 w-6 group-hover:text-red-600" />
							<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Masuk</span>
						</a>
					</li>

					<li>
						<a
							class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
							href="{{ route('attendanceOut.index') }}"
							wire:current.href="!text-red-600 !dark:text-red-600 !dark:font-bold !font-bold bg-gray-100 dark:bg-dark-primary"
							wire:navigate>
							<x-icons.arrow-right-bracket class="h-6 w-6 group-hover:text-red-600" />
							<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Keluar</span>
						</a>
					</li>
				</ul>
			</li>

			@if (auth()->user()->hasAnyPermission(['collect-task-list', 'collect-task-list-ppn', 'collect-idy-ppn-list']))
				<li x-data="{ lokasi: {{ Route::is('collect-task.*') || Route::is('collect-task-ppn.*') || Route::is('collect-idy-ppn.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('collect-task.*') || Route::is('collect-task-ppn.*') || Route::is('collect-idy-ppn.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="lokasi-dropdown" @click="lokasi = !lokasi" :aria-expanded="lokasi">

						<x-icons.wallet
							class="{{ Route::is('collect-task.*') || Route::is('collect-task-ppn.*') || Route::is('collect-idy-ppn.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

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
									class="{{ Route::is('collect-task.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('collect-task.index') }}" wire:navigate>
									<x-icons.cash
										class="{{ Route::is('collect-task.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">IDC Non PPN (SR)</span>
								</a>
							</li>
						@endcan

						@can('collect-task-ppn-list')
							<li>
								<a
									class="{{ Route::is('collect-task-ppn.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('collect-task-ppn.index') }}" wire:navigate>
									<x-icons.sale-percent
										class="{{ Route::is('collect-task-ppn.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">IDC PPN (FP)</span>
								</a>
							</li>
						@endcan

						@can('collect-idy-ppn-list')
							<li>
								<a
									class="{{ Route::is('collect-idy-ppn.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('collect-idy-ppn.index') }}" wire:navigate>
									<x-icons.cash-register
										class="{{ Route::is('collect-idy-ppn.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">IDY PPN (FP)</span>
								</a>
							</li>
						@endcan
					</ul>
				</li>
			@endif

			@if (auth()->user()->hasAnyPermission(['driver-approve', 'collect-approve', 'sales-approve']))
				<li x-data="{ routes: {{ Route::is('routes.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('routes.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="routes-dropdown" @click="routes = !routes" :aria-expanded="routes">

						<x-icons.map-pin-alt
							class="{{ Route::is('routes.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">Rute</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': routes }" />
					</button>

					<ul class="space-y-4 py-4" id="routes-dropdown" x-show="routes"
						x-transition:enter="transition ease-in duration-200"
						x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200"
						x-transition:leave-end="transform opacity-0 -translate-y-5">

						@can('driver-approve')
							<li>
								<a
									class="{{ Route::is('routes.driver') || Route::is('routes.driver.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('routes.driver') }}" wire:navigate>
									<x-icons.angle-right
										class="{{ Route::is('routes.driver') || Route::is('routes.driver.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Driver</span>
								</a>
							</li>
						@endcan

						@can('collect-approve')
							<li>
								<a
									class="{{ Route::is('routes.collector') || Route::is('routes.collector.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('routes.collector') }}" wire:navigate>
									<x-icons.angle-right
										class="{{ Route::is('routes.collector') || Route::is('routes.collector.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Kolektor</span>
								</a>
							</li>
						@endcan

						@can('sales-approve')
							<li>
								<a
									class="{{ Route::is('routes.sales') || Route::is('routes.sales.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('routes.sales') }}" wire:navigate>
									<x-icons.angle-right
										class="{{ Route::is('routes.sales') || Route::is('routes.sales.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Sales</span>
								</a>
							</li>
						@endcan

					</ul>
				</li>
			@endif

			@if (auth()->user()->hasAnyPermission(['driver-list']))
				<li x-data="{ routes: {{ Route::is('driver.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('driver.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="routes-dropdown" @click="routes = !routes" :aria-expanded="routes">

						<x-icons.truck class="{{ Route::is('driver.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">Laporan Driver</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': routes }" />
					</button>

					<ul class="space-y-4 py-4" id="routes-dropdown" x-show="routes"
						x-transition:enter="transition ease-in duration-200"
						x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200"
						x-transition:leave-end="transform opacity-0 -translate-y-5">

						@can('driver-approve')
							<li>
								<a
									class="{{ Route::is('driver.assign.add') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('driver.assign.add') }}" wire:navigate>
									<x-icons.angle-right
										class="{{ Route::is('driver.assign.add') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Assign Laporan (SR)</span>
								</a>
							</li>
						@endcan

						@can('driver-list')
							<li>
								<a
									class="{{ Route::is('driver.index') || Route::is('driver.create') || Route::is('driver.show') || Route::is('driver.edit') || Route::is('driver.assign.to') || Route::is('driver.assign.update') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('driver.index') }}" wire:navigate>
									<x-icons.angle-right
										class="{{ Route::is('driver.index') || Route::is('driver.create') || Route::is('driver.show') || Route::is('driver.edit') || Route::is('driver.assign.to') || Route::is('driver.assign.update') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 inline-flex text-sm group-hover:text-red-600">
										Laporan Driver

										@if (auth()->user()->hasPermissionTo('driver-approve'))
											@livewire('utils.report-counter', ['id' => 'driver'])
										@endif
									</span>
								</a>
							</li>
						@endcan

					</ul>
				</li>
			@endif

			@foreach ($sidebarLinks as $link)
				@php
					$navigate = false;
					$isActive = Route::is($link['check']);

					if ($link['icon'] != 'capture') {
					    $navigate = true;
					}
				@endphp

				@if ($link['permission'])
					@can($link['permission'])
						<li>
							<x-dashboard.sidebar-link href="{{ route($link['route']) }}" :active="$isActive" :navigate="$navigate">
								<x-slot name="icon">

									{{-- for icons to show --}}
									@switch($link['icon'])
										@case('collect')
											<x-icons.clipboard class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('capture')
											<x-icons.camera class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('another-capture')
											<x-icons.camera class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('dayoff')
											<x-icons.lock-time class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('pegawai')
											<x-icons.address-book class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('jabatan')
											<x-icons.briefcase class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('golongan')
											<x-icons.users-group class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('sales')
											<x-icons.receipt class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('technician')
											<x-icons.hammer class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break

										@case('invoice')
											<x-icons.file-invoice class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
										@break
									@endswitch

								</x-slot>
								{{ $link['label'] }}

								@if ($link['indicator'])
									@if (auth()->user()->hasPermissionTo($link['icon'] . '-approve'))
										@livewire('utils.report-counter', ['id' => $link['icon']])
									@endif
								@endif

							</x-dashboard.sidebar-link>
						</li>
					@endcan
				@endif
			@endforeach

			@can('team-list')
				<li>
					<a href="{{ route('teams.index') }}"
						class="group flex flex-row items-center rounded-xl p-2 text-gray-900 hover:text-red-600 dark:text-gray-300"
						wire:navigate wire:current.href="!text-red-600 font-bold bg-gray-100 dark:bg-dark-primary">

						<x-icons.users wire:current="!text-red-600" class="h-6 w-6 group-hover:text-red-600" />
						<span class="ms-3 inline-flex text-sm group-hover:text-red-600">
							Tim Teknisi
						</span>
					</a>
				</li>
			@endcan

			@if (auth()->user()->hasAnyPermission(['divisi-list', 'placement-list']))
				<li x-data="{ lokasi: {{ Route::is('division.*') || Route::is('placement.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('division.*') || Route::is('placement.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="lokasi-dropdown" @click="lokasi = !lokasi" :aria-expanded="lokasi">

						<x-icons.map-pin
							class="{{ Route::is('division.*') || Route::is('placement.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">Lokasi</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': lokasi }" />
					</button>

					<ul class="space-y-4 py-4" id="lokasi-dropdown" x-show="lokasi"
						x-transition:enter="transition ease-in duration-200"
						x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200"
						x-transition:leave-end="transform opacity-0 -translate-y-5">
						@can('divisi-list')
							<li>
								<a
									class="{{ Route::is('division.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('division.index') }}" wire:navigate>
									<x-icons.object-column
										class="{{ Route::is('division.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Divisi</span>
								</a>
							</li>
						@endcan

						@can('placement-list')
							<li>
								<a
									class="{{ Route::is('placement.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('placement.index') }}" wire:navigate>
									<x-icons.landmark
										class="{{ Route::is('placement.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
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
						class="{{ Route::is('users.*') || Route::is('permissions.*') || Route::is('roles.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="user-dropdown" @click="usermanage = !usermanage" :aria-expanded="usermanage">
						<x-icons.user-setting
							class="{{ Route::is('users.*') || Route::is('permissions.*') || Route::is('roles.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

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
									class="{{ Route::is('users.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('users.index') }}" wire:navigate>
									<x-icons.profile-card
										class="{{ Route::is('users.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Users</span>
								</a>
							</li>
						@endcan

						@can('roles-list')
							<li>
								<a
									class="{{ Route::is('roles.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('roles.index') }}" wire:navigate>
									<x-icons.badge-check
										class="{{ Route::is('roles.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Roles</span>
								</a>
							</li>
						@endcan

						@can('permissions-list')
							<li>
								<a
									class="{{ Route::is('permissions.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('permissions.index') }}" wire:navigate>
									<x-icons.adjustment
										class="{{ Route::is('permissions.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Permissions</span>
								</a>
							</li>
						@endcan

					</ul>
				</li>
			@endif

			@if (auth()->user()->hasAnyPermission(['announcement-list', 'log-list', 'backup-list']))
				<li x-data="{ system: {{ Route::is('announcement.*') || Route::is('log.*') || Route::is('backup.*') || Route::is('kuesioner.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('announcement.*') || Route::is('log.*') || Route::is('backup.*') || Route::is('kuesioner.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="system-dropdown" @click="system = !system" :aria-expanded="system">
						<x-icons.computer
							class="{{ Route::is('announcement.*') || Route::is('log.*') || Route::is('backup.*') || Route::is('kuesioner.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">System Settings</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': system }" />
					</button>

					<ul class="space-y-4 py-4" id="system-dropdown" x-show="system"
						x-transition:enter="transition ease-in duration-200"
						x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200"
						x-transition:leave-end="transform opacity-0 -translate-y-5">

						{{-- <li>
							<a
								class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
								href="{{ route('kuesioner.index') }}" wire:navigate
								wire:current.href="!text-red-600 !dark:text-red-600 !dark:font-bold !font-bold bg-gray-100 dark:bg-dark-primary">
								<x-icons.question-circle class="h-6 w-6 group-hover:text-red-600" />
								<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Kuesioner</span>
							</a>
						</li> --}}

						@can('announcement-list')
							<li>
								<a
									class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
									href="{{ route('announcement.index') }}" wire:navigate
									wire:current.href="!text-red-600 !dark:text-red-600 !dark:font-bold !font-bold bg-gray-100 dark:bg-dark-primary">
									<x-icons.bullhorn class="h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Pemberitahuan</span>
								</a>
							</li>
						@endcan

						@can('log-list')
							<li>
								<a
									class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
									href="{{ route('log.index') }}" wire:navigate
									wire:current.href="!text-red-600 !dark:text-red-600 !dark:font-bold !font-bold bg-gray-100 dark:bg-dark-primary">
									<x-icons.window class="h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Log Aktivitas</span>
								</a>
							</li>
						@endcan

						@can('backup-list')
							<li>
								<a
									class="group flex w-full items-center rounded-xl p-2 pl-11 text-gray-900 hover:bg-gray-100 hover:text-red-600 dark:text-gray-300 dark:hover:bg-transparent"
									href="{{ route('backup.index') }}"
									wire:current.href="!text-red-600 !dark:text-red-600 !dark:font-bold !font-bold bg-gray-100 dark:bg-dark-primary"
									wire:navigate>
									<x-icons.filezip class="h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 flex-1 whitespace-nowrap text-sm group-hover:text-red-600">Manage Backups</span>
								</a>
							</li>
						@endcan

					</ul>
				</li>
			@endif

			@can('technician-list')
				<li x-data="{ point: {{ Route::is('points.*') || Route::is('technicianpoints.*') ? 'true' : 'false' }} }">
					<button
						class="{{ Route::is('points.*') || Route::is('technicianpoints.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-dark-primary hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 text-base text-gray-900 transition duration-200"
						type="button" aria-controls="point-dropdown" @click="point = !point" :aria-expanded="point">

						<x-icons.wallet
							class="{{ Route::is('points.*') || Route::is('technicianpoints.*') ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

						<span class="ms-3 flex-1 whitespace-nowrap text-left text-sm group-hover:text-red-600">Transaksi Point</span>

						<x-icons.carred-down class="ml-1 mt-1 inline h-4 w-4 transform transition-transform group-hover:text-red-600"
							x-bind:class="{ 'rotate-180 duration-200': point }" />
					</button>

					<ul class="space-y-4 py-4" id="point-dropdown" x-show="point"
						x-transition:enter="transition ease-in duration-200"
						x-transition:enter-start="transform opacity-0 -translate-y-5"
						x-transition:leave="transition ease-out duration-200"
						x-transition:leave-end="transform opacity-0 -translate-y-5">

						@can('technician-list')
							<li>
								<a
									class="{{ Route::is('points.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('points.index') }}" wire:navigate>

									<x-icons.arrow-right wire:current="!text-red-600" class="h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 inline-flex text-sm group-hover:text-red-600">
										Poin Masuk
									</span>
								</a>
							</li>
						@endcan

						@can('point-redeem')
							<li>
								<a
									class="{{ Route::is('technicianpoints.*') ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-transparent hover:text-red-600' }} group flex w-full items-center rounded-xl p-2 pl-11"
									href="{{ route('technicianpoints.transactions') }}" wire:navigate>

									<x-icons.arrow-left wire:current="!text-red-600" class="h-6 w-6 group-hover:text-red-600" />
									<span class="ms-3 inline-flex text-sm group-hover:text-red-600">
										Poin Keluar
									</span>
								</a>
							</li>
						@endcan

					</ul>
				</li>
			@endcan

			@if (auth()->user()->hasRole(['Admin', 'HRD', 'Management', 'Management-Special']))
				<li>
					<a href="{{ route('event.index') }}"
						class="group flex flex-row items-center rounded-xl p-2 text-gray-900 hover:text-red-600 dark:text-gray-300"
						wire:navigate wire:current.href="!text-red-600 font-bold bg-gray-100 dark:bg-dark-primary">

						<x-icons.gift-box wire:current="!text-red-600" class="h-6 w-6 group-hover:text-red-600" />
						<span class="ms-3 inline-flex text-sm group-hover:text-red-600">
							Event
						</span>
					</a>
				</li>
			@endif

			@can('technician-approve')
				<li>
					<a href="{{ route('map.distribution') }}"
						class="group flex flex-row items-center rounded-xl p-2 text-gray-900 hover:text-red-600 dark:text-gray-300"
						wire:navigate wire:current.href="!text-red-600 font-bold bg-gray-100 dark:bg-dark-primary">

						<x-icons.book-open wire:current="!text-red-600" class="h-6 w-6 group-hover:text-red-600" />
						<span class="ms-3 inline-flex text-sm group-hover:text-red-600">
							Peta Penyebaran Teknisi
						</span>
					</a>
				</li>
			@endcan
		</ul>
	</div>

	<!-- start footer -->
	@include('dashboard.layoutsDash.footer')
	<!-- footer -->
</aside>
