import { showAlert, showToast } from "./alert";

export function fetchNotification() {
	$('body').on('click', '#notificationButton', async function () {

		$('#notificationContainer').html(`
			<div class="w-full px-10 py-20 text-sm text-gray-800 dark:text-white md:p-32" id="notificationEmpty">
				Memuat data notifikasi...
			</div>
		`);

		try {
			const response = await axios.get(`${APP_URL}/notifications/fetch`);

			// Hapus indikator loading
			$('#notificationContainer').empty();

			if (response.data.success) {
				let data = response.data.data;

				// kosongkan item di container
				$('#notificationContainer').empty();

				if (data.length > 0) {
					data.forEach((item) => {
						let d = item.data;

						$('#notificationContainer').append(
							`
						<div class="flex border-t hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-700">

								<div class="w-full px-3.5 py-3 md:p-4">
									<div class="grid gap-1 text-sm text-gray-500 dark:text-gray-400">
										<div class="grid grid-cols-2 text-xs font-medium text-gray-700 dark:text-gray-400">
											<div class="text-left">
												${d.created_at}
											</div>
										</div>

										<div class="font-base mb-1 text-gray-800 dark:text-white">
											${d.message}
										</div>

										<div class="inline-flex">

											<form id="formNotification-${item.id}" action="${d.button.url}">
											</form>
											<button class="me-4 rounded-md bg-blue-200 px-2 py-0.5 font-semibold text-blue-600 hover:bg-blue-400"
												id="btnNotification" form="formNotification-${item.id}" type="submit">
												${d.button.label}
											</button>

											<form id="markAsRead-${item.id}"
												action="${APP_URL}/notifications/${item.id}/mark-as-read/"></form>
											<button class="font-semibold text-blue-600" id="btnMarkAsRead" form="markAsRead-${item.id}"
												type="submit">
												Mark as Read
											</button>
										</div>

									</div>

								</div>
							</div>
						`
						)
					});
				} else {
					$('#notificationContainer').prepend(`
						<div class="w-full px-10 py-20 text-sm text-gray-800 dark:text-white md:p-32" id="notificationEmpty">
							Tidak ada notifikasi baru.
						</div>
					`);
				}
			} else {
				showAlert('error', response.data.message, response.data.data);
			}
		} catch (error) {
			// Hapus indikator loading jika terjadi error
			$('#notificationContainer').empty();
			showAlert('error', 'Terjadi kesalahan saat memuat notifikasi.');
		}

	});
}

export function handleNotification(data) {
	let message = data.message.split('.').slice(0, 2).join('. ') + (data.message.split('.').length > 2 ? '...' : '');
	showToast('info', message);

	// sembunyikan notificationEmpty
	$('#notificationEmpty').addClass('hidden');
	$('#notificationDot').removeClass('hidden');

	if (window.location.pathname === '/dashboard/notifications' || window.location.pathname === '/attendance/dashboard/notifications') { // jika di halaman notifikasi
		const containerCenter = $('#notificationCenterContainer'); // define container

		// tambah notifikasi ke container
		containerCenter.prepend(`
		<div class="bg-gray-100 dark:bg-gray-800 flex rounded-lg transition-all duration-300 hover:scale-110 hover:bg-gray-100 dark:hover:bg-gray-700">
			<div class="w-full px-3.5 py-3 md:p-4">
				<div class="grid gap-1 text-sm text-gray-500 dark:text-gray-400">
					<div class="grid grid-cols-2 text-xs font-medium text-gray-700 dark:text-gray-400">
						<div class="text-left">
							${data.created_at}
						</div>

						<div class="text-right">
							<span class="rounded-lg animate-pulse bg-green-500 px-2 py-0.5 text-xs text-white">
								New
							</span>
						</div>
					</div>

					<div class="font-base font-semibold mb-1 text-gray-800 dark:text-white">
						${data.message}
					</div>

					<div class="inline-flex">
						<form id="formNotification-${data.id}" action="${data.button.url}"></form>
						<button class="me-4 rounded-md bg-blue-200 px-2 py-0.5 font-semibold text-blue-600 hover:bg-blue-400" id="btnNotification" form="formNotification-${data.id}" type="submit">
							${data.button.label}
						</button>

						<form id="markAsRead-${data.id}" action="${data.mark_as_read}"></form>
						<button class="font-semibold text-blue-600" id="btnMarkAsRead" form="markAsRead-${data.id}" type="submit">
							Mark as Read
						</button>
					</div>
				</div>
			</div>
		</div>
		`);
	}
}

export function handleAnnouncement(data) {
	const container = $('#announcement-container');

	$('#notification-alert').addClass('hidden');

	container.prepend(`
		<div class="relative mb-6 flex items-center gap-x-2 rounded-xl border-x border-b border-t-4 border-x-gray-200 border-b-gray-200 border-t-red-300 bg-white p-2 text-gray-600 dark:border-x-gray-700 dark:border-b-gray-700 dark:border-t-red-800 dark:bg-[#18181b] dark:text-white md:gap-x-4 md:p-4" id="broadcast-alert" role="alert">
			<div class="absolute -top-3.5 left-4 items-center justify-center rounded-lg border-t border-red-300 bg-white px-2 py-1 text-xs font-semibold text-red-700 dark:border-red-800">
				<span class="capitalize" id="announcement-title">${data.title}</span>
			</div>

			<div class="flex w-full flex-row items-center gap-x-2 text-sm font-medium md:gap-x-4">
				<div>
					<x-icons.bell class="h-5 w-5" />
				</div>
				<div class="w-full text-wrap capitalize" id="announcement-description">
					${data.description}
				</div>

				<button class="flex flex-row items-center gap-2 rounded-lg p-2 ring-1 ring-red-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-red-300 focus:scale-105 dark:bg-red-800 dark:text-white dark:ring-gray-700 dark:hover:bg-red-900" data-dismiss-target="#broadcast-alert" id="close" type="button" aria-label="Close">
					<svg aria-hidden="true" class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
					</svg>
				</button>
			</div>
		</div>
		`)
}