<nav
	class="fixed top-0 z-50 w-full border-b border-gray-200 bg-white px-4 py-2.5 dark:border-[#232327] dark:bg-[#18181b] lg:px-6">
	<div class="flex flex-wrap items-center justify-between">
		<div class="flex items-center justify-start">

			<a class="flex items-center" href="#">
				<img class="h-8" src="{{ asset('assets/img/logo.png') }}" alt="Indodacin Logo" loading="lazy" />
				<span class="text-md self-center whitespace-nowrap font-semibold italic dark:text-white">attendance</span>
			</a>

		</div>

		<div class="flex items-center lg:order-2">

			<!-- Notifications -->
			<button
				class="mr-1 rounded-xl p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600"
				id="notificationButton" data-dropdown-toggle="notification-dropdown" data-dropdown-placement="bottom-end"
				data-dropdown-offset-distance="11" type="button">
				<span class="sr-only">View notifications</span>
				<!-- Bell icon -->
				<div class="relative w-full" id="notifications-bell">
					<x-icons.bell class="h-6 w-6 text-gray-800 dark:text-white" />

					@if (count(auth()->user()->unreadNotifications))
						<div class="absolute -left-0.5 bottom-0 block h-2 w-2" id="notificationDot" aria-live="polite">
							<span
								class="absolute mx-auto inline-flex h-full w-full animate-ping rounded-full bg-yellow-400 opacity-75"></span>
							<span class="absolute h-2 w-2 rounded-full bg-red-500"></span>
						</div>
					@endif

					<div class="absolute -left-0.5 bottom-0 hidden h-2 w-2" id="notificationDot" aria-live="polite">
						<span
							class="absolute mx-auto inline-flex h-full w-full animate-ping rounded-full bg-yellow-400 opacity-75"></span>
						<span class="absolute h-2 w-2 rounded-full bg-red-500"></span>
					</div>

				</div>
			</button>

			<!-- Dropdown menu -->
			<div
				class="z-50 my-4 me-4 hidden max-w-full items-center rounded-b-lg bg-white shadow-md dark:border-x dark:border-b dark:border-gray-700 dark:bg-[#18181b] md:max-w-xl"
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

			<button class="ms-3 flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
				id="user-menu-button" data-dropdown-toggle="dropdown" data-dropdown-placement="bottom-end"
				data-dropdown-offset-distance="13" type="button" aria-expanded="false">
				<span class="sr-only">Open user menu</span>
				<img class="h-9 w-9 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
					alt="user photo" loading="lazy">
			</button>

			<div
				class="z-50 my-4 hidden w-56 list-none divide-y divide-gray-100 rounded-b-lg bg-white text-base shadow-md dark:divide-gray-600 dark:border-x dark:border-b dark:border-gray-700 dark:bg-[#18181b]"
				id="dropdown">
				<div class="px-4 py-3">
					<span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
					<span class="block truncate text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</span>
				</div>
				<ul class="py-1 text-gray-500 dark:text-gray-400" aria-labelledby="dropdown">
					<li>

						<a
							class="block px-4 py-2 text-sm hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
							href="#">My profile</a>

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
				</ul>
			</div>
		</div>
	</div>
</nav>
