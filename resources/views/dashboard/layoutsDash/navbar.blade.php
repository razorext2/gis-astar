<nav
	class="fixed top-0 z-40 w-full border-b border-gray-200 bg-white px-4 py-2.5 shadow-sm dark:border-[#232327] dark:bg-dark-primary dark:shadow-none lg:px-6">
	<div class="flex flex-wrap items-center justify-between gap-2 sm:flex-nowrap">
		{{-- title dan icon --}}
		<div :class="openSidebar ? '-translate-x-40' : 'translate-x-20'"
			class="flex items-center justify-start transition-all duration-500 ease-out">

			<a class="flex items-center" href="{{ config('app.url') }}">
				<img class="h-8" src="{{ asset('assets/img/logo.png') }}" alt="Indodacin Logo" loading="lazy" />
				<span class="text-md self-center whitespace-nowrap font-semibold italic dark:text-white">attendance</span>
			</a>

		</div>

		{{-- poin --}}
		<div>
			@if (auth()->user()->hasRole('Teknisi'))
				@livewire('widget.technician.points-accumulation')
			@endif
		</div>

		{{-- notification, ping checker, profile --}}
		<div class="flex w-full items-center justify-between gap-2 sm:w-auto lg:gap-4">

			@livewire('utils.ping-checker')

			<!-- Notifications -->
			<button
				class="mr-2 rounded-xl p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600"
				id="notificationButton" data-dropdown-toggle="notification-dropdown" data-dropdown-placement="bottom-end"
				data-dropdown-offset-distance="11" type="button">
				<span class="sr-only">View notifications</span>
				<!-- Bell icon -->
				@livewire('notification-bell')
			</button>

			<!-- Notifikasi Dropdown -->
			<div
				class="z-50 my-4 me-4 hidden max-w-full items-center rounded-b-lg bg-white shadow-md dark:border-x dark:border-b dark:border-gray-700 dark:bg-dark-primary dark:shadow-none md:max-w-xl"
				id="notification-dropdown">
				<div class="bg-gray-50 p-4 font-medium text-gray-700 dark:bg-gray-800 dark:text-white">
					Notifikasi
				</div>

				{{-- notifikasi --}}
				<div class="max-h-72 overflow-y-auto md:max-h-96" id="notificationContainer"></div>
				<div class="w-full rounded-b-lg bg-gray-50 p-4 font-medium text-gray-700 dark:bg-gray-800 dark:text-white">
					<a class="p-4" href="{{ route('notifications.index') }}">
						Lihat semua notifikasi
					</a>
				</div>

			</div>

			{{-- Profile Photo --}}
			<button class="flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
				id="user-menu-button" data-dropdown-toggle="dropdown" data-dropdown-placement="bottom-end"
				data-dropdown-offset-distance="13" type="button" aria-expanded="false">
				<span class="sr-only">Open user menu</span>
				<img class="h-9 w-9 rounded-full object-cover"
					src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
					alt="user photo" loading="lazy" onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">
			</button>

			{{-- Dropdown Profile --}}
			<div
				class="z-50 my-4 hidden w-56 list-none divide-y divide-gray-100 rounded-b-lg bg-white text-base shadow-md dark:divide-gray-600 dark:border-x dark:border-b dark:border-gray-700 dark:bg-dark-primary"
				id="dropdown">
				<div class="px-4 py-3">
					<span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
					<span class="block truncate text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</span>
				</div>
				<ul class="py-1 text-gray-500 dark:text-gray-400" aria-labelledby="dropdown">
					<li>
						<a
							class="block px-4 py-2 text-sm hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
							href="{{ route('profile.me') }}">My profile</a>
					</li>
					<li>
						<form id="editProfile" action="{{ route('profile.edit') }}" onclick="event.preventDefault();"></form>
						<button
							class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
							form="editProfile" type="submit">
							Account settings
						</button>
					</li>
					<li>
						<div class="flex flex-row gap-x-4 px-4 py-2">
							<x-button-dark />
							<x-button-light />
						</div>
					</li>
				</ul>

				<ul class="py-1 text-gray-500 dark:text-gray-400" aria-labelledby="dropdown">
					<li>
						<form id="logout" method="post" action="{{ route('logout') }}" onclick="event.preventDefault();">@csrf</form>
						<button
							class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
							form="logout" type="submit">Sign out</button>
					</li>
					<li class="flex items-center px-4 py-3" id="installAppContainer">
						<button
							class="rounded-lg bg-green-600 px-4 py-2 text-center text-sm text-white ring-1 ring-gray-200 transition-colors duration-500 ease-in-out hover:bg-green-700 dark:bg-green-700 dark:ring-gray-700 dark:hover:bg-green-800 dark:hover:text-white"
							id="installApp">
							Install App
						</button>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>
