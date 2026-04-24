<div class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
    id="allowanceadd" aria-hidden="true" tabindex="-1">
    <div class="modal-body relative max-h-full w-full max-w-md p-4" id="modalAddBody">
        <!-- Modal content -->
        <div class="relative rounded-xl bg-white shadow ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-zinc-800 md:p-5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Add new allowance
                </h3>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div class="mb-4 grid grid-cols-2 gap-4">
                    <input id="id" type="hidden" value="{{ $pegawai->id }}">
                    <input id="kode_pegawai_add" type="hidden" value="{{ $pegawai->kode_pegawai }}">
                    <div class="col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="allowance_name_add">Name</label>
                        <input
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="allowance_name_add" name="allowance_name" type="text"
                            placeholder="Type allowance name" required="">
                        <div class="mt-2 text-sm text-red-500" id="alert-allowance_name_add" role="alert"></div>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="allowance_type_add">Type</label>
                        <select
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="allowance_type_add" name="allowance_add">
                            <option selected="">Select type</option>
                            <option value="Terbilang">Terbilang</option>
                            <option value="Persenan">% (Persenan)</option>
                        </select>
                        <div class="mt-2 text-sm text-red-500" id="alert-allowance_type_add" role="alert"></div>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="allowance_fee_add">Nilai</label>
                        <input
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-600 focus:ring-blue-600 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="allowance_fee_add" name="allowance_fee" type="number" min="0"
                            placeholder="Rp. xxx.xxx" required="">
                        <div class="mt-2 text-sm text-red-500" id="alert-allowance_fee_add" role="alert"></div>
                    </div>

                    {{-- show if persenan is selected --}}
                    <div class="col-span-2" id="percentage-result-container">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="calculated_allowance_add">Fee</label>
                        <input
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="calculated_allowance_add" name="calculated_allowance" type="text" readonly
                            placeholder="Rp. xxx.xxx">
                    </div>
                    {{-- end calculated allowance --}}

                    <div class="col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="allowance_period_add">
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
                                id="allowance_period_add" name="allowance_period" type="text" datepicker
                                datepicker-buttons datepicker-autoselect-today placeholder="Select date">
                        </div>
                        <div class="mt-2 text-sm text-red-500" id="alert-allowance_period_add" role="alert"></div>

                    </div>
                </div>
                <button
                    class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    id="store-allowance" type="button">
                    <svg class="-ms-1 me-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd">
                        </path>
                    </svg>
                    Add new allowance
                </button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script type="module">
        const allowanceAdd = document.getElementById('allowanceadd');
        const allowanceAddModal = new Modal(allowanceAdd);
        const allowanceTypeInput = document.getElementById('allowance_type_add');
        const percentageResultContainer = document.getElementById('percentage-result-container');
        const calculatedAllowanceInput = document.getElementById('calculated_allowance_add');
        const valueInput = document.getElementById('allowance_fee_add');
        const salary = {{ $pegawai->salaryRelasi->salary_fee ?? '0' }};

        let allowance_fee;
        let selectedType;

        $('body').on('click', '#btn-create-allowance', function() {
            allowanceAddModal.show();
        });

        allowanceTypeInput.addEventListener('change', function() {
            selectedType = this.value;
            $('#allowance_fee_add').val('');
            $('#calculated_allowance_add').val('');

            return selectedType
        })

        valueInput.addEventListener('input', function() {
            if (selectedType === "Persenan") {
                // kalo Persenan
                const percentage = $('#allowance_fee_add').val();
                const calculatedAllowance = (percentage / 100) * salary;
                calculatedAllowanceInput.value = `Rp ${calculatedAllowance.toLocaleString('id-ID')}`;
                allowance_fee = calculatedAllowance;

            } else {
                // kalo terbilang
                const fee = $('#allowance_fee_add').val();
                calculatedAllowanceInput.value = `Rp ${fee.toLocaleString('id-ID')}`
                allowance_fee = fee;
            }
        })

        //action create allowance
        $('#store-allowance').click(function(e) {
            e.preventDefault();

            let kode_pegawai = $('#kode_pegawai_add').val();
            // let allowance_fee = $('#allowance_fee_add').val();
            let allowance_type = $('#allowance_fee_add').val();
            let allowance_name = $('#allowance_name_add').val();
            let allowance_period = $('#allowance_period_add').val();
            let token = $("meta[name='csrf-token']").attr("content");

            // Ajax call
            $.ajax({
                url: `/dashboard/pegawai/allowances`,
                type: "POST",
                cache: false,
                data: {
                    "kode_pegawai": kode_pegawai,
                    "allowance_name": allowance_name,
                    "allowance_type": allowance_type,
                    "allowance_fee": allowance_fee,
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

                    // Clear form
                    $('#allowance_name_add').val('');
                    $('#allowance_type_add').prop('selectedIndex', 0);
                    $('#allowance_period_add').val('');
                    $('#allowance_fee_add').val('');
                    $('#calculated_allowance_add').val('');
                    percentageResultContainer.classList.add('hidden');

                    // Hide modal
                    allowanceAddModal.hide();

                },
                error: function(error) {
                    // Handle validation errors
                    if (error.responseJSON.allowance_name[0]) {
                        $('#alert-allowance_name_add').removeClass('none').addClass('block').html(error
                            .responseJSON.allowance_name[0]);
                    }
                    if (error.responseJSON.allowance_type[0]) {
                        $('#alert-allowance_type_add').removeClass('none').addClass('block').html(error
                            .responseJSON.allowance_type[0]);
                    }
                    if (error.responseJSON.allowance_fee[0]) {
                        $('#alert-allowance_fee_add').removeClass('none').addClass('block').html(error
                            .responseJSON.allowance_fee[0]);
                    }
                    if (error.responseJSON.allowance_period[0]) {
                        $('#alert-allowance_period_add').removeClass('none').addClass('block').html(
                            error
                            .responseJSON.allowance_period[0]);
                    }
                }
            });
        });
    </script>
@endpush
