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
				id="notificationButton" data-dropdown-toggle="notification-dropdown" data-dropdown-placement="bottom-end"
				type="button">
				<span class="sr-only">View notifications</span>
				<!-- Bell icon -->
				<div class="relative w-full" id="notifications-bell">
					<x-icons.bell class="h-6 w-6 text-gray-800 dark:text-white" />
					@if (count(auth()->user()->unreadNotifications) > 0)
						<div class="absolute -left-0.5 bottom-0 h-2 w-2" id="notificationDot">
							<span
								class="absolute mx-auto inline-flex h-full w-full animate-ping rounded-full bg-yellow-400 opacity-75"></span>
							<span class="absolute h-2 w-2 rounded-full bg-red-500" id="notificationDot"></span>
						</div>
					@endif

					<div class="absolute -left-0.5 bottom-0 hidden h-2 w-2" id="notificationDot">
						<span
							class="absolute mx-auto inline-flex h-full w-full animate-ping rounded-full bg-yellow-400 opacity-75"></span>
						<span class="absolute h-2 w-2 rounded-full bg-red-500" id="notificationDot"></span>
					</div>
				</div>
			</button>

			<!-- Dropdown menu -->
			<div
				class="z-50 my-4 me-4 hidden max-h-96 min-h-36 max-w-xs list-none items-center divide-y divide-gray-100 overflow-y-auto rounded-lg bg-white shadow-md dark:divide-gray-600 dark:bg-[#1d1d20]"
				id="notification-dropdown">
				<div
					class="block rounded-t-lg bg-gray-50 px-4 py-2 text-center font-medium text-gray-700 dark:bg-gray-800 dark:text-white">
					Notifikasi
				</div>
				<div class="py-2.5" id="notificationContainer">
					{{-- notifikasi --}}
					@if (count(auth()->user()->unreadNotifications) > 0)
						@foreach (auth()->user()->unreadNotifications as $notification)
							<div class="flex border-b hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-600">

								<div class="w-full p-2">
									<div class="flex-row text-sm text-gray-500 dark:text-gray-400">
										{{-- show notification message --}}
										<div class="mb-1 font-medium text-gray-800 dark:text-white">
											{{ $notification->data['message'] }}
										</div>

										<div class="inline-flex">
											{{-- show notification additional button --}}
											@if ($notification->data['url'])
												<form id="formDownload-{{ $notification->id }}"
													action="{{ route('export.collector.download', $notification->data['url']) }}">
												</form>
												<button class="me-2 rounded-md bg-blue-200 px-2 py-0.5 font-semibold text-blue-600 hover:bg-blue-400"
													id="btnDownload" form="formDownload-{{ $notification->id }}" type="submit">
													Dowload </button>
											@endif

											{{-- mark as read --}}
											<form id="markAsRead-{{ $notification->id }}"
												action="{{ route('notification.mark-as-read', $notification->id) }}"></form>
											<button class="font-semibold text-blue-600 underline" id="btnMarkAsRead"
												form="markAsRead-{{ $notification->id }}" type="submit">
												Mark as Read
											</button>
										</div>
									</div>
									<div class="text-xs font-medium text-gray-700 dark:text-gray-400">
										{{ Carbon\Carbon::parse($notification->data['created_at'])->locale('id')->isoFormat('DD MMM YYYY HH:mm:ss') }}
									</div>
								</div>
							</div>
						@endforeach
					@else
						<span class="w-full p-4 text-sm text-gray-800 dark:text-white" id="noNotification">
							Tidak ada notifikasi baru.
						</span>
					@endif

				</div>

			</div>

			<button class="ms-3 flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600"
				id="user-menu-button" data-dropdown-toggle="dropdown" data-dropdown-placement="bottom-end" type="button"
				aria-expanded="false">
				<span class="sr-only">Open user menu</span>
				<img class="h-9 w-9 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
					alt="user photo">
			</button>

			<div
				class="z-50 my-4 hidden w-56 list-none divide-y divide-gray-100 rounded-lg bg-white text-base shadow-md dark:divide-gray-600 dark:bg-gray-700"
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
