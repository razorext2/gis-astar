<div class="grid gap-4 md:grid-cols-2" id="laporan-content">
    <div class="col-span-2 w-full">
        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="nofakturpajak">
            Cari Bukti Tanda Terima Invoice
        </label>

        <div class="flex flex-row items-start gap-2 lg:gap-4">
            <div class="w-fit">
                <x-input.select id="tipe_tagihan" required name="tipe_tagihan" :labels="false" :defaultOption="'Pilih tipe tagihan'"
                    :options="[
                        'idcppn' => 'IDC PPN',
                        'idyppn' => 'IDY PPN',
                    ]" wire:model="fetchDataForm.tipe_tagihan" :value="$fetchDataForm->tipe_tagihan" />
            </div>

            <form wire:submit="fetchFakturPajak" class="flex w-full flex-col gap-2">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <x-icons.search class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                    </div>

                    <x-input.basic class="ps-10" wire:model.live="fetchDataForm.nofakturpajak" id="nofakturpajak"
                        name="nofakturpajak" placeholder="No. Faktur Pajak" :labels="false" />

                    <x-button.primary type="submit" class="absolute bottom-[1px] end-0 focus:outline"
                        id="nofakturpajak_submit">
                        <span wire:loading wire:target="fetchFakturPajak">Loading...</span>
                        <span wire:loading.remove wire:target="fetchFakturPajak">Cek</span>
                    </x-button.primary>
                </div>

                @error('fetchDataForm.nofakturpajak')
                    <span class="error text-sm text-red-500">{{ $message }}</span>
                @enderror
                @error('fetchDataForm.tipe_tagihan')
                    <span class="error text-sm text-red-500">{{ $message }}</span>
                @enderror
            </form>
        </div>

    </div>

    <form wire:submit="store" class="col-span-2 grid grid-cols-2 gap-4">
        <div class="col-span-2 grid grid-cols-2 gap-4 rounded-lg bg-gray-100 p-4 dark:bg-dark-secondary">
            <div class="w-full">
                <x-input.basic id="btt_number" readonly name="btt_number" wire:model="addForm.btt_number"
                    placeholder="Nomor BTT">
                    Nomor BTT
                </x-input.basic>

                @error('addForm.btt_number')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <x-input.basic id="btt_created_at" readonly name="btt_created_at" wire:model="addForm.btt_created_at"
                    placeholder="Tanggal BTT Dibuat">
                    Tanggal BTT Dibuat
                </x-input.basic>

                @error('addForm.btt_created_at')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 w-full">
                <x-input.basic id="company_name" readonly name="company_name" wire:model="addForm.company_name"
                    placeholder="Nama Perusahaan">
                    Nama PT
                </x-input.basic>

                @error('addForm.company_name')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <x-input.basic id="invoice_date" readonly name="invoice_date" wire:model="addForm.invoice_date"
                    placeholder="Tanggal Invoice">
                    Tanggal Invoice
                </x-input.basic>

                @error('addForm.invoice_date')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <x-input.basic id="receivable_number" readonly name="receivable_number"
                    wire:model="addForm.receivable_number" placeholder="Nomor Piutang">
                    Nomor Piutang
                </x-input.basic>

                @error('addForm.receivable_number')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <x-input.basic id="sale_number" name="sale_number" readonly wire:model="addForm.sale_number"
                    placeholder="Nomor Penjualan">
                    Nomor Penjualan
                </x-input.basic>

                @error('addForm.sale_number')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <x-input.basic id="tax_number" name="tax_number" readonly wire:model="addForm.tax_number"
                    placeholder="Nomor Faktur Pajak">
                    Nomor Faktur Pajak
                </x-input.basic>

                @error('addForm.tax_number')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="col-span-2 flex w-full flex-col">
            <p class="text-sm font-medium text-gray-900 dark:text-white">Status Saat Ini</p>
            <p class="font-semibold text-green-500">{{ $status ?? 'Sudah ready untuk diteruskan ke Piutang.' }}
            </p>
        </div>

        <div class="col-span-2 flex w-full flex-col">
            <label for="newest_status" class="block text-sm font-medium text-gray-900 dark:text-white">Status
                Baru</label>

            <x-input.textarea id="newest_status" name="newest_status" :labels="false"
                wire:model="addForm.newest_status" placeholder="Berikan status terbaru" />

            @error('addForm.newest_status')
                <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full">
            <x-input.select id="invoice_type" name="invoice_type" :labels="true"
                wire:model.live="addForm.invoice_type" :textLabel="'Tipe Invoice'" :options="['dalkot' => 'Dalam Kota', 'lukot' => 'Luar Kota']" :defaultOption="'Pilih Tipe Invoice'"
                :value="$addForm->invoice_type" />

            @error('addForm.invoice_type')
                <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full">
            <x-input.select id="delivery_status" name="delivery_status" :labels="true"
                wire:model.live="addForm.delivery_status" :textLabel="'Status Pengiriman'" :options="[
                    '0' => 'Belum dikirim',
                    '1' => 'Sedang Dalam Pengiriman',
                    '2' => 'Sudah diterima',
                    '3' => 'Belum Diterima',
                ]" :defaultOption="'Pilih Status Pengiriman'"
                :value="$addForm->delivery_status" />

            @error('addForm.delivery_status')
                <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        @if ($addForm->delivery_status == 1 && $addForm->invoice_type == 'lukot')
            <div class="w-full">
                <x-input.select required id="invoice_destination" name="invoice_destination" :labels="true"
                    wire:model.live="addForm.invoice_destination" :textLabel="'Tipe Pengiriman'" :options="['cust' => 'Customer Langsung', 'pku' => 'IDC Pekanbaru', 'jkt' => 'IDC Jakarta']"
                    :defaultOption="'Pilih Tipe Pengiriman'" :value="$addForm->invoice_destination" />

                @error('addForm.invoice_destination')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <x-input.basic required id="resi_number" name="resi_number" :labels="true"
                    wire:model.live="addForm.resi_number" placeholder="Nomor Resi">
                    Nomor Resi
                </x-input.basic>

                @error('addForm.resi_number')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        @endif

        <div class="col-span-2 w-full">

            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                for="documentations">Dokumentasi</label>

            @if (!$addForm->documentations)
                <div class="flex w-full flex-col gap-y-2">
                    <label for="documentations"
                        class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 transition-all duration-500 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-800">
                        <div class="flex flex-col items-center justify-center pb-6 pt-5">
                            <x-icons.cloud-upload class="mb-2 h-8 w-8 text-gray-500 dark:text-gray-400" />
                            <p class="mb-0.5 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold"> Klik untuk upload</span>
                            </p>
                            <p class="w-full text-center text-xs text-gray-500 dark:text-gray-400">
                                *Dokumentasi dapat berupa <b>foto dokumen BTT, resi </b> atau lainnya (PNG, JPG, Jpeg)
                            </p>
                            <p>

                            </p>
                        </div>
                        <input id="documentations" name="documentations" type="file" accept="image/*"
                            wire:model="addForm.documentations" class="hidden" multiple />
                    </label>
                </div>
            @else
                <div class="mt-2 flex flex-col gap-2">
                    <div
                        class="dark:highlight-white/5 relative min-w-0 overflow-auto rounded-xl border border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">

                        <div class="flex overflow-x-scroll">

                            @foreach ($addForm->documentations as $index => $doc)
                                <div class="flex-none px-1.5 py-3 first:pl-3 last:pr-3">
                                    <div class="relative flex flex-col items-center justify-center gap-3">
                                        <img class="w-24 rounded-lg" src="{{ $doc->temporaryUrl() }}">
                                        <button type="button"
                                            class="absolute end-0 top-0 rounded-lg bg-red-500 p-1 text-white hover:bg-red-600"
                                            wire:click="removeDocumentation({{ $index }})">
                                            <x-icons.close class="h-4 w-4" />
                                        </button>
                                        <p class="text-xs text-gray-600 dark:text-white">
                                            @php
                                                $name = $doc->getClientOriginalName();
                                                $label =
                                                    strlen($name) > 10
                                                        ? substr($name, 0, 5) . '...' . substr($name, -5)
                                                        : $name;
                                            @endphp
                                            {{ $label }}
                                        </p>
                                    </div>
                                </div>

                                @php
                                    $total = $index + 1;
                                @endphp
                            @endforeach
                        </div>
                    </div>

                    <p class="text-xs text-gray-600 dark:text-gray-100">Total {{ $total ?? '0' }} file.</p>

                </div>
            @endif

            @error('addForm.documentations.*')
                <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="relative col-span-2 w-full">
            <x-button.primary class="float-right" id="store" type="submit">
                <x-slot name="icon">
                    <x-icons.angle-right class="icon h-5 w-5" />
                </x-slot>
                Update Riwayat Invoice
            </x-button.primary>
        </div>
    </form>
</div>
