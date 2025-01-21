export function handleNotification(data) {
	// print data untuk testing
	console.log('Pesan broadcast: ', data);

	const Toast = Swal.mixin({
		toast: true,
		position: "bottom-end",
		showConfirmButton: false,
		timer: 4000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.onmouseenter = Swal.stopTimer;
			toast.onmouseleave = Swal.resumeTimer;
		}
	});

	Toast.fire({
		icon: "info",
		title: "Kamu punya notifikasi baru.",
	});

	// sembunyikan notificationEmpty
	$('#notificationEmpty').addClass('hidden');
	$('#notificationDot').removeClass('hidden');

	// define container
	var container = $('#notificationContainer');

	// tambah notifikasi ke container
	container.prepend(`
		<div class="flex border-t hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-700">
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
										
					<div class="font-base mb-1 text-gray-800 dark:text-white">
						${data.message}
					</div>
					<div class="inline-flex">							
						<form id="formNotification-${data.id}" action="${data.button.url}"></form>
						<button class="me-4 rounded-md bg-blue-200 px-2 py-0.5 font-semibold text-blue-600 hover:bg-blue-400"
							id="btnNotification" form="formNotification-${data.id}" type="submit">
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