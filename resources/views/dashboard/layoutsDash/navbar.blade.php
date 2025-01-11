<nav
	class="fixed top-0 z-50 w-full border-b border-gray-200 bg-white px-4 py-2.5 dark:border-[#232327] dark:bg-[#18181b] lg:px-6">
	<div class="flex flex-wrap items-center justify-between">
		<div class="flex items-center justify-start">

			<a class="flex items-center" href="#">
				<img class="h-8" src="{{ asset('assets/img/logo.png') }}" alt="Indodacin Logo" />
				<span class="text-md self-center whitespace-nowrap font-semibold italic dark:text-white">attendance</span>
			</a>

		</div>

		<div class="flex items-center lg:order-2">

			<!-- Notifications -->
			<button
				class="mr-1 rounded-xl p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600"
				id="notificationButton" data-dropdown-toggle="notification-dropdown" type="button">
				<span class="sr-only">View notifications</span>
				<!-- Bell icon -->
				<div class="relative w-full" id="notifications-bell">
					<x-icons.bell class="h-6 w-6 text-gray-800 dark:text-white" />
					@if (count(auth()->user()->unreadNotifications) > 0)
						<span class="absolute bottom-0 left-0 h-1 w-1 rounded-full bg-red-500"></span>
					@endif
				</div>
			</button>
			<!-- Dropdown menu -->
			<div
				class="z-50 my-4 hidden max-w-sm list-none divide-y divide-gray-100 overflow-hidden rounded-lg bg-white text-base shadow-lg dark:divide-gray-600 dark:bg-[#1d1d20]"
				id="notification-dropdown">
				<div
					class="block bg-gray-50 px-4 py-2 text-center text-base font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-400">
					Notifikasi
				</div>
				<div class="py-2.5">

					{{-- notifikasi --}}
					@if (count(auth()->user()->unreadNotifications) > 0)
						@foreach (auth()->user()->unreadNotifications as $notification)
							<div class="flex border-b px-4 py-3 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-600">

								<div class="w-full pl-3">
									<div class="mb-1.5 text-sm font-normal text-gray-500 dark:text-gray-400">
										{{-- show notification message --}}
										<span class="font-medium text-gray-800 dark:text-white">
											{{ $notification->data['message'] }}
										</span>

										<div class="inline-flex">
											{{-- show notification additional button --}}
											@if ($notification->data['url'])
												<form id="formDownload" action="{{ route('export.collector.download', $notification->data['url']) }}">
												</form>
												<button class="me-2 font-semibold text-blue-600 underline" id="btnDownload" form="formDownload"
													type="submit">
													Dowload </button>
											@endif

											{{-- mark as read --}}
											<form id="markAsRead" action="{{ route('notification.mark-as-read', $notification->id) }}"></form>
											<button class="font-semibold text-blue-600 underline" id="btnMarkAsRead" form="markAsRead" type="submit">
												Mark as Read
											</button>
										</div>
									</div>
									<div class="text-xs font-medium text-gray-700 dark:text-gray-400">{{ $notification->data['created_at'] }}
									</div>
								</div>
							</div>
						@endforeach
					@else
						<span class="w-full p-4 text-sm text-gray-800 dark:text-white">
							Tidak ada notifikasi baru.
						</span>
					@endif

				</div>

				{{-- read all notifications --}}
				{{-- <a
					class="block bg-gray-50 py-2 text-center text-base font-medium text-gray-900 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline"
					href="#">
					<div class="inline-flex items-center">
						<svg class="mr-2 h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
							xmlns="http://www.w3.org/2000/svg">
							<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
							<path fill-rule="evenodd"
								d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
								clip-rule="evenodd"></path>
						</svg>
						View all
					</div>
				</a> --}}
				
			</div>

			<button class="ms-3 flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
				id="user-menu-button" data-dropdown-toggle="dropdown" type="button" aria-expanded="false">
				<span class="sr-only">Open user menu</span>
				<img class="h-9 w-9 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
					alt="user photo">
			</button>

			<div
				class="z-50 my-4 hidden w-56 list-none divide-y divide-gray-100 rounded-lg bg-white text-base shadow dark:divide-gray-600 dark:bg-gray-700"
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
