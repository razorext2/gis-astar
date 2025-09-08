<div
	class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
	id="deductionedit" aria-hidden="true" tabindex="-1">
	<div class="modal-body relative max-h-full w-full max-w-md p-4" id="modalAddBody">
		<!-- Modal content -->
		<div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
			<!-- Modal header -->
			<div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
				<h3 class="text-lg font-semibold text-gray-900 dark:text-white">
					Update deduction
				</h3>
			</div>

			<!-- Modal body -->
			<div class="p-4 md:p-5">
				<div class="mb-4 grid grid-cols-2 gap-4">
					<input id="deduction_id" type="hidden">
					<div class="col-span-2">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="deduction_name_edit">Name</label>
						<input
							class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							id="deduction_name_edit" type="text" placeholder="Type deduction name" required="">
						<div class="mt-2 text-sm text-red-500" id="alert-deduction_name_edit" role="alert"></div>
					</div>
					<div class="col-span-2 sm:col-span-1">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="deduction_type_edit">Type</label>
						<select
							class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							id="deduction_type_edit">
							<option selected="">Select type</option>
							<option value="Terbilang">Terbilang</option>
							<option value="Persenan">% (Persenan)</option>
						</select>
						<div class="mt-2 text-sm text-red-500" id="alert-deduction_type_edit" role="alert"></div>
					</div>

					<div class="col-span-2 sm:col-span-1">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="deduction_fee_edit">Nilai</label>
						<input
							class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							id="deduction_fee_edit" type="number" placeholder="Ex: 50000 or 5%" required="">
						<div class="mt-2 text-sm text-red-500" id="alert-deduction_fee_edit" role="alert"></div>
					</div>

					{{-- show if persenan is selected --}}
					<div class="col-span-2" id="percentage-result-container">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
							for="calculated_deduction_edit">Fee</label>
						<input
							class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
							id="calculated_deduction_edit" name="calculated_deduction" type="text" readonly placeholder="Rp. xxx.xxx">
					</div>
					{{-- end calculated deduction --}}

					<div class="col-span-2">
						<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="deduction_period_edit">
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
								id="deduction_period_edit" type="text" datepicker datepicker-buttons datepicker-autoselect-today
								placeholder="Select date">
						</div>
						<div class="mt-2 text-sm text-red-500" id="alert-deduction_period_edit" role="alert"></div>

					</div>
				</div>
				<button
					class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
					id="update-deduction" type="button">
					<svg class="-ms-1 me-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd"
							d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd">
						</path>
					</svg>
					Update deduction
				</button>
			</div>
		</div>
	</div>
</div>

@push('script')
	<script type="module">
		const deductionEdit = document.getElementById('deductionedit');
		const deductionEditModal = new Modal(deductionEdit);
		const deductionTypeInput = document.getElementById('deduction_type_edit');
		const percentageResultContainer = document.getElementById('percentage-result-container');
		const calculatedDeductionInput = document.getElementById('calculated_deduction_edit');
		const valueInput = document.getElementById('deduction_fee_edit');
		const salary = {{ $pegawai->salaryRelasi->salary_fee ?? '0' }};
		let deduction_fee;
		let deduction_type;
		let selectedType;

		$('body').on('click', '#btn-edit-deduction', function() {
			//open deductionEditModal
			let deduction_id = $(this).data('id');
			$.ajax({
				url: `/dashboard/pegawai/deductions/${deduction_id}`,
				type: 'GET',
				cache: false,
				success: function(response) {
					$('#deduction_id').val(response.data.id);
					$('#deduction_name_edit').val(response.data.deduction_name);
					$('#deduction_fee_edit').val(response.data.deduction_type);
					$('#calculated_deduction_edit').val(response.data.deduction_fee);

					deduction_type = response.data.deduction_type;
					deduction_fee = response.data.deduction_fee;

					if (deduction_type <= 100) {
						$('#deduction_type_edit').val('Persenan');
						$('#calculated_deduction_edit').val(
							`Rp. ${response.data.deduction_fee.toLocaleString('id-ID')}`);
						$('#deduction_fee_edit').val(response.data.deduction_type);
						selectedType = 'Persenan';
					} else {
						$('#deduction_type_edit').val('Terbilang');
						$('#calculated_deduction_edit').val(
							`Rp. ${response.data.deduction_fee.toLocaleString('id-ID')}`);
						$('#deduction_fee_edit').val(response.data.deduction_fee);
						selectedType = 'Terbilang'
					}
					$('#deduction_period_edit').val(response.data.deduction_period);

					deductionEditModal.show();
				}
			})
		});

		valueInput.addEventListener('input', function() {
			if (selectedType === "Persenan") {
				// kalo Persenan
				const percentage = $('#deduction_fee_edit').val();
				const calculatedDeduction = (percentage / 100) * salary;
				calculatedDeductionInput.value = `Rp. ${calculatedDeduction.toLocaleString('id-ID')}`;
				deduction_fee = calculatedDeduction;
				deduction_type = percentage;
			} else {
				// kalo terbilang
				const fee = $('#deduction_fee_edit').val();
				calculatedDeductionInput.value = `Rp. ${fee.toLocaleString('id-ID')}`
				deduction_fee = fee;
				deduction_type = fee;
			}
		})

		deductionTypeInput.addEventListener('change', function() {
			selectedType = this.value;
			$('#deduction_fee_edit').val('');
			$('#calculated_deduction_edit').val('');
			return selectedType
		})



		//action create deduction
		$('#update-deduction').click(function(e) {
			e.preventDefault();

			// Define variables
			let deduction_id = $('#deduction_id').val();
			let kode_pegawai = $('#kode_pegawai_edit').val();
			let deduction_name = $('#deduction_name_edit').val();
			let deduction_type_edit = deduction_type;
			let deduction_fee_edit = deduction_fee;
			// let deduction_type = $('#deduction_type_edit').val();
			// let deduction_fee = $('#deduction_fee_edit').val();
			let deduction_period = $('#deduction_period_edit').val();
			let token = $("meta[name='csrf-token']").attr("content");

			// Ajax call
			$.ajax({
				url: `/dashboard/pegawai/deductions/${deduction_id}`,
				type: "PUT",
				cache: false,
				data: {
					"kode_pegawai": kode_pegawai,
					"deduction_name": deduction_name,
					"deduction_type": deduction_type_edit,
					"deduction_fee": deduction_fee_edit,
					"deduction_period": deduction_period,
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
					$('#table-deduction').DataTable().ajax.reload(null, false);
					deductionEditModal.hide();
				},
				error: function(error) {
					// Handle validation errors
					if (error.responseJSON.deduction_name[0]) {
						$('#alert-deduction_name_edit').removeClass('none').addClass('block').html(error
							.responseJSON.deduction_name[0]);
					}
					if (error.responseJSON.deduction_type[0]) {
						$('#alert-deduction_type_edit').removeClass('none').addClass('block').html(error
							.responseJSON.deduction_type[0]);
					}
					if (error.responseJSON.deduction_fee[0]) {
						$('#alert-deduction_fee_edit').removeClass('none').addClass('block').html(error
							.responseJSON.deduction_fee[0]);
					}
					if (error.responseJSON.deduction_period[0]) {
						$('#alert-deduction_period_edit').removeClass('none').addClass('block').html(error
							.responseJSON.deduction_period[0]);
					}
				}
			});
		});
	</script>
@endpush
