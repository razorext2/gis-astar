@extends('dashboard.layoutsDash.app')
@section('content')
	<form id="add-pegawai" action="{{ route('pegawai.create') }}"></form>
	<div class="relative grid grid-cols-1 gap-6">
		@can('pegawai-create')
			<div class="absolute left-6 top-56 z-10 max-w-xs sm:left-auto sm:right-6 md:top-40 lg:left-6 lg:right-auto lg:top-24">
				<button
					class="flex flex-row rounded-lg px-4 py-2 ring-1 ring-green-700 hover:bg-green-300 dark:bg-green-800 dark:text-white dark:ring-gray-700 dark:hover:bg-green-900 lg:px-8"
					form="add-pegawai">
					<svg class="rotate-180 dark:fill-white" class="icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
						viewBox="0 0 1024 1024" fill="#000000" version="1.1">
						<path
							d="M669.6 849.6c8.8 8 22.4 7.2 30.4-1.6s7.2-22.4-1.6-30.4l-309.6-280c-8-7.2-8-17.6 0-24.8l309.6-270.4c8.8-8 9.6-21.6 2.4-30.4-8-8.8-21.6-9.6-30.4-2.4L360.8 480.8c-27.2 24-28 64-0.8 88.8l309.6 280z"
							fill="" />
					</svg>
					<span class="hidden sm:block">Tambah</span> <span class="hidden sm:block">Data</span>
				</button>
			</div>
		@endcan

		<div class="flex h-auto items-center justify-center">
			<div
				class="grid w-full grid-cols-2 gap-4 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700">
				<div class="col-span-2 grid grid-cols-2 gap-4 md:col-span-2 lg:col-span-1">
					<div>
						<div class="relative">
							<div class="pointer-events-none absolute inset-y-0 end-0 top-0 flex items-center pe-3.5">
								<svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
									fill="currentColor" viewBox="0 0 24 24">
									<path fill-rule="evenodd"
										d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
										clip-rule="evenodd" />
								</svg>
							</div>
							<input
								class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-white p-4 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
								id="min" name="min" type="text" placeholder="Start" required />
						</div>
					</div>
					<div>
						<div class="relative">
							<div class="pointer-events-none absolute inset-y-0 end-0 top-0 flex items-center pe-3.5">
								<svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
									fill="currentColor" viewBox="0 0 24 24">
									<path fill-rule="evenodd"
										d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
										clip-rule="evenodd" />
								</svg>
							</div>
							<input
								class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-white p-4 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
								id="max" name="max" type="text" placeholder="End" required />
						</div>
					</div>
				</div>
				<div class="relative col-span-2 md:col-span-2 lg:col-span-1">
					<form id="searchForm" action="" method="get">
						<div class="relative">
							<div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
								<svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
									fill="none" viewBox="0 0 20 20">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
								</svg>
							</div>
							<input
								class="block w-full rounded-lg border border-gray-300 bg-white p-4 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
								id="searchText" type="search" placeholder="Search..." />

							<div class="absolute inset-y-0 right-24 flex cursor-pointer items-center" id="clearIcon" style="display:none;">
								<svg class="h-4 w-4 text-gray-500 hover:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
									fill="none" viewBox="0 0 20 20">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M6 6l8 8M6 14L14 6" />
								</svg>
							</div>
							<div>
								<button
									class="absolute bottom-2.5 end-2.5 rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
									id="mySearchButton" type="submit">
									Search
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-span-2">
					<table class="mt-20 w-full text-left text-sm text-gray-500 dark:text-gray-300 sm:mt-4" id="table-pegawai">
						<thead class="text-xs uppercase">
							<tr>
								<th></th>
								<th>
									<span class="flex items-center text-gray-800 dark:text-white">
										Kode
									</span>
								</th>
								<th>
									<span class="flex items-center text-gray-800 dark:text-white">
										Full Name
									</span>
								</th>
								<th>
									<span class="flex items-center text-gray-800 dark:text-white">
										No Telepon
									</span>
								</th>
								<th>
									<span class="flex items-center text-gray-800 dark:text-white">
										Jabatan
									</span>
								</th>
								<th>
									<span class="flex items-center text-gray-800 dark:text-white">
										Golongan
									</span>
								</th>
							</tr>
						</thead>
						<tbody class="!text-left">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	@include('dashboard.layoutsDash.modals')
@endsection
@push('script')
	<script type="module">
		function showDatatables() {
			// Initialize DataTable
			let table = $('#table-pegawai').DataTable({
				processing: true,
				serverSide: true,
				responsive: true,
				perPageSelect: [5, 25, 50, 100],
				ajax: {
					url: "pegawai",
				},
				columns: [{
						data: 'action',
						name: 'action'
					},
					{
						data: 'kode_pegawai',
						name: 'kode_pegawai'
					},
					{
						data: 'full_name_nik',
						name: 'full_name_nik'
					},
					{
						data: 'no_telp',
						name: 'no_telp',
					},
					{
						data: 'nama_jabatan',
						name: 'nama_jabatan'
					},
					{
						data: 'nama_golongan',
						name: 'nama_golongan'
					},
				],
				dom: `<"absolute top-1 md:left-0 {{ auth()->user()->can('pegawai-create') ? 'lg:left-48 right-0' : '' }} mt-14 lg:mt-0 dark:text-white max-w-xs"B><"text-left lg:text-right dark:text-white"l><"relative overflow-x-auto w-full mt-20 lg:mt-4"t><"grid text-center gap-6 lg:grid-cols-2 mt-4 dark:text-white"<"lg:mt-3 lg:text-left"i><"lg:text-right dark:text-gray-900"p>>`,
				buttons: [{
						extend: "csv",
						exportOptions: {
							stripHtml: false
						}
					},
					{
						extend: "excel",
						exportOptions: {
							stripHtml: false,
							decodeEntities: false
						}
					},
					{
						extend: "print",
						exportOptions: {
							columns: [1, 2, 3, 4, 5]
						},
						title: '', // Custom title in print view
						customize: function(win) {
							// Menambahkan CSS inline khusus untuk print
							$(win.document.head).append(`
                                <style>
                                    body {
                                        background-color: #fff;
                                    }
                                    table {
                                        margin: 20px;
                                        border: 1px solid;
                                        border-collapse: collapse;
                                        width: 100%;
                                    }
                                    th {
                                        text-align: center !important; /* Membuat teks di <th> berada di tengah */
                                    }
                                    td, th {
                                        padding: 8px;
                                        border: 1px solid #ddd;
                                    }
                                    h3 {
                                        text-align: center;
                                        font-size: 2rem;
                                        margin-bottom: 1rem;
                                    }
                                    /* Footer fixed untuk cetakan */
                                    footer {
                                        position: fixed;
                                        bottom: 0;
                                        width: 100%;
                                        text-align: center;
                                        font-size: 1.2rem;
                                        background-color: #fff;
                                        padding: 10px; /* Menambahkan padding agar ada ruang di sekitar teks */
                                    }
                                    /* Menghilangkan border dari elemen footer */
                                    footer table, footer td, footer th {
                                        border: none !important;
                                        padding: 0;
                                    }
                                    /* Agar tabel di dalam footer berada di kanan */
                                    footer table {
                                        float: right; /* Membuat tabel mengambang ke kanan */
                                        margin-bottom: 50px;
                                    }
                                </style>
                            `);

							// Menambahkan header atau judul tambahan
							$(win.document.body).prepend(
								'<h3>Laporan Data Karyawan</h3>'
							);

							$(win.document.body).append(`
                                <footer>
                                    <table style="width: auto;">
                                        <tr>
                                            <td>Di keluarkan oleh ` + namaPegawai + `</td>
                                        </tr>
                                        <tr>
                                            <td>Pada tanggal, ` + tanggal + `</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 80px;"></td>
                                        </tr>
                                        <tr>
                                            <td>` + namaPegawai + `</td>
                                        </tr>
                                    </table>
                                </footer>
                            `);
						},
					},
				],
				"deferRender": true,
				"language": {
					"infoFiltered": ""
				}
			});

			// Bind the submit event of the form
			$('#searchForm').on('submit', function(e) {
				e.preventDefault(); // Prevent the default form submission
				// Execute the search on DataTable
				table.search($('#searchText').val()).draw();
			});

			const searchInput = document.getElementById("searchText");
			const clearIcon = document.getElementById("clearIcon");

			searchInput.addEventListener("input", function() {
				if (searchInput.value.length > 0) {
					clearIcon.style.display = "flex"; // Show clear icon
				} else {
					clearIcon.style.display = "none"; // Hide clear icon
				}
			});

			// Clear the search input and refresh the datatable when clear icon is clicked
			clearIcon.addEventListener("click", function() {
				searchInput.value = "";
				clearIcon.style.display = "none";
				// Call function to refresh DataTable
				refreshDataTable();
			});

			// Refresh DataTable (assuming you're using DataTables.js)
			function refreshDataTable() {
				// Assuming you have a DataTable instance initialized
				// Replace 'yourDataTable' with your actual DataTable instance variable
				$('#table-pegawai').DataTable().search('').draw(); // Clear the search and redraw table
			}
		}
		// end datatables //

		function deleteModal() {

			const modalEl = document.getElementById('deleteModal');
			if (modalEl) {
				new Modal(modalEl); // Assuming you have imported Modal from Flowbite

				const currentRoute = '{{ request()->segment(2) }}';

				// Delegate click event to the table
				$('#table-pegawai').on('click', '.delete-btn', function() {
					// Get the id from data attribute
					var id = $(this).data('id');
					// Set the form action for deletion
					$('#deleteForm').attr('action', currentRoute +
						'/' + id);
					// Show the modal
					$('#deleteModal').removeClass('hidden');
				});

				// Close modal
				$('[data-modal-hide="deleteModal"]').on('click', function() {
					$('#deleteModal').addClass('hidden');
				});
			}
		}
		// end delete modal //

		$(document).ready(function() {
			showDatatables();
			deleteModal();
		});
	</script>
@endpush
