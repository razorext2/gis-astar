<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.tailwindcss.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon@3.5.0/build/global/luxon.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.4/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

<script>
	const preloader = document.querySelector("#preloader");
	preloader && window.addEventListener("load", (() => {
		preloader.remove()
	}));
	const scrollContainer = document.getElementById("scrollContainer"),
		nextButton = document.getElementById("nextButton"),
		prevButton = document.getElementById("prevButton");

	function scrollContent(e) {
		scrollContainer.scrollBy({
			left: 300 * e,
			behavior: "smooth"
		})
	}

	function updateButtonVisibility() {
		const e = scrollContainer.scrollWidth > scrollContainer.clientWidth;
		nextButton.style.display = prevButton.style.display = e ? "block" : "none"
	}
	nextButton.addEventListener("click", (() => scrollContent(1))), prevButton.addEventListener("click", (() =>
		scrollContent(-1))), updateButtonVisibility(), window.addEventListener("resize", updateButtonVisibility);
	const themeToggleDarkBtn = document.getElementById("theme-toggle-dark"),
		themeToggleLightBtn = document.getElementById("theme-toggle-light");

	function toggleTheme(e) {
		document.documentElement.classList.toggle("dark", e), localStorage.setItem("color-theme", e ? "dark" : "light"),
			themeToggleDarkBtn.classList.toggle("text-gray-300", e), themeToggleDarkBtn.classList.toggle("text-gray-200", !
				e), themeToggleLightBtn.classList.toggle("text-gray-700", e), themeToggleLightBtn.classList.toggle(
				"text-red-400", !e)
	}
	const isDarkMode = "dark" === localStorage.getItem("color-theme") || !("color-theme" in localStorage) && window
		.matchMedia("(prefers-color-scheme: dark)").matches;
	toggleTheme(isDarkMode), themeToggleDarkBtn.addEventListener("click", (() => toggleTheme(!0))), themeToggleLightBtn
		.addEventListener("click", (() => toggleTheme(!1)));
</script>

{{-- echo broadcast --}}
<script type="module">
	const userId = '{{ Auth::user()->id }}';

	window.Echo.private(`exportFiles.${userId}`)
		.listen('.exportCompleted', (data) => {
			console.log('Pesan broadcast: ', data);

			// sembunyikan noNotification
			$('#noNotification').addClass('hidden');

			$('#notificationDot').removeClass('hidden');

			var container = $('#notificationContainer');

			container.prepend(
				`<div class="flex border-b hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-600">
						<div class="w-full p-2">
							<div class="flex-row text-sm text-gray-500 dark:text-gray-400">
								{{-- show notification message --}}
								<div class="mb-1 font-medium text-gray-800 dark:text-white">
									${data.message}
								</div>

								<div class="inline-flex">
									{{-- show notification additional button --}}
									
										<form id="formDownload-${data.id}"
											action="${data.url}">
										</form>
										<button class="me-2 rounded-md bg-blue-200 px-2 py-0.5 font-semibold text-blue-600 hover:bg-blue-400" id="btnDownload" form="formDownload-${data.id}" type="submit">
											Dowload 
										</button>

									{{-- mark as read --}}
									<form id="markAsRead-${data.id}"
										action="${data.mark_as_read}"></form>
									<button class="font-semibold text-blue-600 underline" id="btnMarkAsRead"
										form="markAsRead-${data.id}" type="submit">
										Mark as Read
									</button>
								</div>
							</div>
							<div class="text-xs font-medium text-gray-700 dark:text-gray-400">
								${data.created_at}
							</div>
						</div>
					</div>
				`
			)
		});
</script>
@stack('script')
