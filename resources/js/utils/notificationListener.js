import { showAlert, showToast } from "./alert";

export function fetchNotification() {
    $("body").on("click", "#notificationButton", async function () {
        $("#notificationContainer").html(`
			<div class="w-full px-10 py-20 text-sm text-gray-800 dark:text-white md:p-32" id="notificationEmpty">
				Memuat data notifikasi...
			</div>
		`);

        try {
            const response = await axios.get(`/notifications/fetch`);

            // Hapus indikator loading
            $("#notificationContainer").empty();

            if (response.data.success) {
                let data = response.data.data;

                // kosongkan item di container
                $("#notificationContainer").empty();

                if (data.length > 0) {
                    data.forEach((item) => {
                        let d = item.data;

                        $("#notificationContainer").append(
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
												action="/notifications/${item.id}/mark-as-read/"></form>
											<button class="font-semibold text-blue-600" id="btnMarkAsRead" form="markAsRead-${item.id}"
												type="submit">
												Mark as Read
											</button>
										</div>

									</div>

								</div>
							</div>
						`
                        );
                    });
                } else {
                    $("#notificationContainer").prepend(`
						<div class="w-full px-10 py-20 text-sm text-gray-800 dark:text-white md:p-32" id="notificationEmpty">
							Tidak ada notifikasi baru.
						</div>
					`);
                }
            } else {
                showAlert("error", response.data.message, response.data.data);
            }
        } catch (error) {
            // Hapus indikator loading jika terjadi error
            $("#notificationContainer").empty();
            showAlert("error", "Terjadi kesalahan saat memuat notifikasi.");
        }
    });
}

export function handleNotification(data) {
    let message =
        data.message.split(".").slice(0, 2).join(". ") +
        (data.message.split(".").length > 2 ? "..." : "");
    showToast("info", message);

    // sembunyikan notificationEmpty
    $("#notificationEmpty").addClass("hidden");
    $("#notificationDot").removeClass("hidden");
}
