<div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
    id="deductionadd" aria-hidden="true" tabindex="-1">
    <div class="modal-body relative max-h-full w-full max-w-md p-4" id="modalAddBody">
        <!-- Modal content -->
        <div class="relative rounded-xl bg-white shadow ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-zinc-800 md:p-5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Add new deduction
                </h3>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <input id="id" type="hidden" value="{{ $pegawai->id }}">
                    <input id="kode_pegawai_add" type="hidden" value="{{ $pegawai->kode_pegawai }}">
                    <div class="col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="deduction_name_add">Name</label>
                        <input
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="deduction_name_add" name="deduction_name" type="text"
                            placeholder="Type deduction name" required="">
                        <div class="mt-2 text-sm text-red-500" id="alert-deduction_name_add" role="alert"></div>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="deduction_type_add">Type</label>
                        <select
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="deduction_type_add" name="deduction_add">
                            <option selected="">Select type</option>
                            <option value="Terbilang">Terbilang</option>
                            <option value="Persenan">% (Persenan)</option>
                        </select>
                        <div class="mt-2 text-sm text-red-500" id="alert-deduction_type_add" role="alert"></div>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="deduction_fee_add">Nilai</label>
                        <input
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="deduction_fee_add" name="deduction_fee" type="number" min="0"
                            placeholder="Rp. xxx.xxx" required="">
                        <div class="mt-2 text-sm text-red-500" id="alert-deduction_fee_add" role="alert"></div>
                    </div>

                    {{-- show if persenan is selected --}}
                    <div class="col-span-2" id="percentage-result-container">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="calculated_deduction_add">Fee</label>
                        <input
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="calculated_deduction_add" name="calculated_deduction" type="text" readonly
                            placeholder="Rp. xxx.xxx">
                    </div>
                    {{-- end calculated deduction --}}

                    <div class="col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="deduction_period_add">
                            Periode</label>

                        <div class="relative max-w-sm">
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input
                                class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                id="deduction_period_add" name="deduction_period" type="text" datepicker
                                datepicker-buttons datepicker-autoselect-today placeholder="Select date">
                        </div>
                        <div class="mt-2 text-sm text-red-500" id="alert-deduction_period_add" role="alert"></div>

                    </div>
                </div>
                <button
                    class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    id="store-deduction" type="button">
                    <svg class="-ms-1 me-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd">
                        </path>
                    </svg>
                    Add new deduction
                </button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script type="module">
        const deductionAdd = document.getElementById('deductionadd');
        const deductionAddModal = new Modal(deductionAdd);
        const deductionTypeInput = document.getElementById('deduction_type_add');
        const percentageResultContainer = document.getElementById('percentage-result-container');
        const calculatedDeductionInput = document.getElementById('calculated_deduction_add');
        const valueInput = document.getElementById('deduction_fee_add');
        const salary = {{ $pegawai->salaryRelasi->salary_fee ?? '0' }};

        let deduction_fee;
        let selectedType;

        $('body').on('click', '#btn-create-deduction', function() {
            deductionAddModal.show();
        });

        deductionTypeInput.addEventListener('change', function() {
            selectedType = this.value;
            $('#deduction_fee_add').val('');
            $('#calculated_deduction_add').val('');

            return selectedType
        })

        valueInput.addEventListener('input', function() {
            if (selectedType === "Persenan") {
                // kalo Persenan
                const percentage = $('#deduction_fee_add').val();
                const calculatedDeduction = (percentage / 100) * salary;
                calculatedDeductionInput.value = `Rp ${calculatedDeduction.toLocaleString('id-ID')}`;
                deduction_fee = calculatedDeduction;

            } else {
                // kalo terbilang
                const fee = $('#deduction_fee_add').val();
                calculatedDeductionInput.value = `Rp ${fee.toLocaleString('id-ID')}`
                deduction_fee = fee;
            }
        })

        //action create deduction
        $('#store-deduction').click(function(e) {
            e.preventDefault();

            let kode_pegawai = $('#kode_pegawai_add').val();
            // let deduction_fee = $('#deduction_fee_add').val();
            let deduction_type = $('#deduction_fee_add').val();
            let deduction_name = $('#deduction_name_add').val();
            let deduction_period = $('#deduction_period_add').val();
            let token = $("meta[name='csrf-token']").attr("content");

            // Ajax call
            $.ajax({
                url: `/dashboard/pegawai/deductions`,
                type: "POST",
                cache: false,
                data: {
                    "kode_pegawai": kode_pegawai,
                    "deduction_name": deduction_name,
                    "deduction_type": deduction_type,
                    "deduction_fee": deduction_fee,
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

                    // Clear form
                    $('#deduction_name_add').val('');
                    $('#deduction_type_add').prop('selectedIndex', 0);
                    $('#deduction_period_add').val('');
                    $('#deduction_fee_add').val('');
                    $('#calculated_deduction_add').val('');
                    percentageResultContainer.classList.add('hidden');

                    // Hide modal
                    deductionAddModal.hide();

                },
                error: function(error) {
                    // Handle validation errors
                    if (error.responseJSON.deduction_name[0]) {
                        $('#alert-deduction_name_add').removeClass('none').addClass('block').html(error
                            .responseJSON.deduction_name[0]);
                    }
                    if (error.responseJSON.deduction_type[0]) {
                        $('#alert-deduction_type_add').removeClass('none').addClass('block').html(error
                            .responseJSON.deduction_type[0]);
                    }
                    if (error.responseJSON.deduction_fee[0]) {
                        $('#alert-deduction_fee_add').removeClass('none').addClass('block').html(error
                            .responseJSON.deduction_fee[0]);
                    }
                    if (error.responseJSON.deduction_period[0]) {
                        $('#alert-deduction_period_add').removeClass('none').addClass('block').html(
                            error
                            .responseJSON.deduction_period[0]);
                    }
                }
            });
        });
    </script>
@endpush
