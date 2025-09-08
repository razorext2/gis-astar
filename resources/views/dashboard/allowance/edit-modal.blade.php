<div
	class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
	id="allowanceedit" aria-hidden="true" tabindex="-1">
	<div class="modal-body relative max-h-full w-full max-w-md p-4" id="modalAddBody">
		<!-- Modal content -->
		<div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
			<!-- Modal header -->
			<div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
				<h3 class="text-lg font-semibold text-gray-900 dark:text-white">
					Update allowance
				</h3>
			</div>

			<!-- Modal body -->
			<div class="p-4 md:p-5">
				<div class="mb-4 grid grid-cols-2 gap-4">
					<input id="allowance_id" type="hidden">
					<div class="col-span-2">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="allowance_name_edit">Name</label>
						<input
							class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							id="allowance_name_edit" type="text" placeholder="Type allowance name" required="">
						<div class="mt-2 text-sm text-red-500" id="alert-allowance_name_edit" role="alert"></div>
					</div>
					<div class="col-span-2 sm:col-span-1">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="allowance_type_edit">Type</label>
						<select
							class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							id="allowance_type_edit">
							<option selected="">Select type</option>
							<option value="Terbilang">Terbilang</option>
							<option value="Persenan">% (Persenan)</option>
						</select>
						<div class="mt-2 text-sm text-red-500" id="alert-allowance_type_edit" role="alert"></div>
					</div>

					<div class="col-span-2 sm:col-span-1">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="allowance_fee_edit">Nilai</label>
						<input
							class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							id="allowance_fee_edit" type="number" placeholder="Ex: 50000 or 5%" required="">
						<div class="mt-2 text-sm text-red-500" id="alert-allowance_fee_edit" role="alert"></div>
					</div>

					{{-- show if persenan is selected --}}
					<div class="col-span-2" id="percentage-result-container">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							for="calculated_allowance_edit">Fee</label>
						<input
							class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							id="calculated_allowance_edit" name="calculated_allowance" type="text" readonly placeholder="Rp. xxx.xxx">
					</div>
					{{-- end calculated allowance --}}

					<div class="col-span-2">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="allowance_period_edit">
							Periode</label>

						<div class="relative max-w-sm">
							<div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
								<svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
									fill="currentColor" viewBox="0 0 20 20">
									<path
										d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
								</svg>
							</div>
							<input
								class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
								id="allowance_period_edit" type="text" datepicker datepicker-buttons datepicker-autoselect-today
								placeholder="Select date">
						</div>
						<div class="mt-2 text-sm text-red-500" id="alert-allowance_period_edit" role="alert"></div>

					</div>
				</div>
				<button
					class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
					id="update-allowance" type="button">
					<svg class="-ms-1 me-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd"
							d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd">
						</path>
					</svg>
					Update allowance
				</button>
			</div>
		</div>
	</div>
</div>

@push('script')
	<script type="module">
		const allowanceEdit = document.getElementById('allowanceedit');
		const allowanceEditModal = new Modal(allowanceEdit);
		const allowanceTypeInput = document.getElementById('allowance_type_edit');
		const percentageResultContainer = document.getElementById('percentage-result-container');
		const calculatedAllowanceInput = document.getElementById('calculated_allowance_edit');
		const valueInput = document.getElementById('allowance_fee_edit');
		const salary = {{ $pegawai->salaryRelasi->salary_fee ?? '0' }};
		let allowance_fee;
		let allowance_type;
		let selectedType;

		$('body').on('click', '#btn-edit-allowance', function() {
			//open allowanceEditModal
			let allowance_id = $(this).data('id');
			$.ajax({
				url: `/dashboard/pegawai/allowances/${allowance_id}`,
				type: 'GET',
				cache: false,
				success: function(response) {
					$('#allowance_id').val(response.data.id);
					$('#allowance_name_edit').val(response.data.allowance_name);
					$('#allowance_fee_edit').val(response.data.allowance_type);
					$('#calculated_allowance_edit').val(response.data.allowance_fee);

					allowance_type = response.data.allowance_type;
					allowance_fee = response.data.allowance_fee;

					// cek type 
					if (allowance_type <= 100) {
						// persenan
						allowanceTypeInput.value = 'Persenan';
						$('#calculated_allowance_edit').val(
							`Rp. ${response.data.allowance_fee.toLocaleString('id-ID')}`);
						$('#allowance_fee_edit').val(response.data.allowance_type);
						selectedType = 'Persenan';
					} else if (allowance_type > 100) {
						// terbilang 
						allowanceTypeInput.value = 'Terbilang';
						$('#calculated_allowance_edit').val(
							`Rp. ${response.data.allowance_fee.toLocaleString('id-ID')}`);
						$('#allowance_fee_edit').val(response.data.allowance_fee);
						selectedType = 'Terbilang'
					} else {
						console.log('error dibagian cek type');
					}

					$('#allowance_period_edit').val(response.data.allowance_period);

					allowanceEditModal.show();
				}
			})
		});

		valueInput.addEventListener('input', function() {
			if (selectedType === "Persenan") {
				// kalo Persenan
				const percentage = $('#allowance_fee_edit').val();
				const calculatedAllowance = (percentage / 100) * salary;
				calculatedAllowanceInput.value = `Rp. ${calculatedAllowance.toLocaleString('id-ID')}`;
				allowance_fee = calculatedAllowance;
				allowance_type = percentage;
			} else if (selectedType === "Terbilang") {
				// kalo terbilang
				const fee = $('#allowance_fee_edit').val();
				calculatedAllowanceInput.value = `Rp. ${fee.toLocaleString('id-ID')}`
				allowance_fee = fee;
				allowance_type = fee;
			} else {
				console.log('error di bagian addEventListener(input)');
			}
			return allowance_fee, allowance_type;
		})

		allowanceTypeInput.addEventListener('change', function() {
			selectedType = this.value;
			$('#allowance_fee_edit').val('');
			$('#calculated_allowance_edit').val('');
			return selectedType
		})

		//action create allowance
		$('#update-allowance').click(function(e) {
			e.preventDefault();

			// Define variables
			let allowance_id = $('#allowance_id').val();
			let kode_pegawai = $('#kode_pegawai_edit').val();
			let allowance_name = $('#allowance_name_edit').val();
			let allowance_type_edit = allowance_type;
			let allowance_fee_edit = allowance_fee;
			let allowance_period = $('#allowance_period_edit').val();
			let token = $("meta[name='csrf-token']").attr("content");

			// Ajax call
			$.ajax({
				url: `/dashboard/pegawai/allowances/${allowance_id}`,
				type: "PUT",
				cache: false,
				data: {
					"kode_pegawai": kode_pegawai,
					"allowance_name": allowance_name,
					"allowance_type": allowance_type_edit,
					"allowance_fee": allowance_fee_edit,
					"allowance_period": allowance_period,
					"_token": token
				},
				success: function(response) {
					// Show success message
					Swal.fire({
						icon: 'success',
						title: `${response.message}`,
						showConfirmButton: false,
						timer: 3000
					});

					// Reload DataTable
					$('#table-allowance').DataTable().ajax.reload(null, false);

					allowanceEditModal.hide();
				},
				error: function(error) {
					// Handle validation errors
					if (error.responseJSON.allowance_name[0]) {
						$('#alert-allowance_name_edit').removeClass('none').addClass('block').html(error
							.responseJSON.allowance_name[0]);
					}
					if (error.responseJSON.allowance_type[0]) {
						$('#alert-allowance_type_edit').removeClass('none').addClass('block').html(error
							.responseJSON.allowance_type[0]);
					}
					if (error.responseJSON.allowance_fee[0]) {
						$('#alert-allowance_fee_edit').removeClass('none').addClass('block').html(error
							.responseJSON.allowance_fee[0]);
					}
					if (error.responseJSON.allowance_period[0]) {
						$('#alert-allowance_period_edit').removeClass('none').addClass('block').html(error
							.responseJSON.allowance_period[0]);
					}
				}
			});
		});
	</script>
@endpush
