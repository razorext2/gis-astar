<form class="flex flex-col items-start gap-2 lg:gap-4" method="POST" wire:submit.prevent="store">

    {{-- form info customer --}}
    <div
        class="grid w-full gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:gap-4 lg:p-6">
        <div class="w-full">
            <x-input.basic id="nama_customer" name="nama_customer" wire:model="createForm.nama_customer"
                placeholder="Nama Bon Customer">
                Nama Bon Customer
            </x-input.basic>

            @error('createForm.nama_customer')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full">
            <x-input.basic id="no_telp" name="no_telp" wire:model="createForm.no_telp" placeholder="62858xxxxxxx">
                Nomor Telepon Customer
            </x-input.basic>

            @error('createForm.no_telp')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full">
            <x-input.basic id="contact_person" name="contact_person" wire:model="createForm.contact_person"
                placeholder="Bpk. Andi Nasution...">
                Contact Person
            </x-input.basic>

            @error('createForm.contact_person')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full">
            <x-input.textarea id="alamat_customer" placeholder="Ketik alamat customer..." name="alamat_customer"
                wire:model="createForm.alamat_customer" :labels="true" :textLabel="'Alamat Customer'" />

            @error('createForm.alamat_customer')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>
    {{-- end form info customer --}}

    {{-- form barang --}}
    <div
        class="flex w-full flex-col items-start gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:gap-4 lg:p-6">
        <div class="col-span-2 flex w-full flex-col items-start gap-4">
            <div class="w-full">
                <x-input.select id="tipe_timbangan" name="tipe_timbangan" :labels="true" :textLabel="'Tipe Timbangan Yang Dipesan'"
                    :defaultOption="'Pilih tipe timbangan'" wire:model="createForm.tipe_timbangan" :options="config('spk-config.tipe_timbangan')" />

                @error('createForm.tipe_timbangan')
                    <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                @enderror
            </div>

            <div class="flex w-full gap-2 lg:gap-4">
                <div class="w-full">
                    <x-input.basic id="nama_barang" name="nama_barang" wire:model="barangForm.nama_barang"
                        placeholder="Ketik nama barang">
                        Nama Barang
                    </x-input.basic>

                    @error('barangForm.nama_barang')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <x-input.basic type="number" min="1" id="jumlah_unit" name="jumlah_unit"
                        wire:model="barangForm.jumlah_unit" placeholder="cth: 1, 2, 3, dst">
                        Jumlah Unit
                    </x-input.basic>

                    @error('barangForm.jumlah_unit')
                        <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <x-input.select id="satuan_barang" name="satuan_barang" :labels="true" :textLabel="'Satuan'"
                        :defaultOption="'Pilih satuan'" wire:model="barangForm.satuan_barang" :options="config('spk-config.satuan')" />

                    @error('barangForm.satuan_barang')
                        <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="w-full">
                <x-input.textarea id="spesifikasi" placeholder="Jelaskan spesifikasi barang atau produk..."
                    name="spesifikasi" wire:model="barangForm.spesifikasi" rows="8" :labels="true"
                    :textLabel="'Spesifikasi'" />

                @error('barangForm.spesifikasi')
                    <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                @enderror
            </div>

            <div class="flex w-full justify-end gap-x-2">
                <x-button.primary id="tambah-barang" wire:click="storeBarang">
                    {{ $is_edit ? 'Ubah' : 'Tambah' }}
                </x-button.primary>

                <x-button.danger id="reset-barang" wire:click="resetBarang">
                    Clear
                </x-button.danger>
            </div>
        </div>

        <div class="flex max-h-96 w-full flex-col">
            <p class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Daftar Barang Yang Dipesan</p>

            <div class="flex flex-col gap-y-1 overflow-y-auto rounded-xl bg-gray-50 p-4 dark:bg-gray-600">
                <table id="barang-list-table" class="w-full">
                    <thead
                        class="border-b border-gray-200 text-sm font-semibold text-gray-800 dark:border-gray-400 dark:text-white">
                        <th class="p-2">#</th>
                        <th class="p-2">Nama Barang</th>
                        <th class="p-2">Jumlah</th>
                        <th class="p-2">Satuan</th>
                        <th class="p-2">Aksi</th>
                    </thead>

                    <tbody>
                        @forelse ($createForm->barang as $index => $row)
                            <tr wire:key="{{ $row['_key'] }}">
                                <td rowspan="2"
                                    class="w-10 items-center text-center text-sm text-gray-800 dark:text-white">
                                    {{ $index + 1 }}.
                                </td>
                                <td class="text-sm text-gray-800 dark:text-white">
                                    {{ $row['nama_barang'] }}
                                </td>
                                <td rowspan="2"
                                    class="items-center text-center text-sm text-gray-800 dark:text-white">
                                    {{ $row['jumlah_unit'] }}
                                </td>
                                <td rowspan="2"
                                    class="items-center text-center text-sm text-gray-800 dark:text-white">
                                    {{ $row['satuan_barang'] ?? 'Not set.' }}
                                </td>
                                <td rowspan="2" class="h-full">
                                    <div
                                        class="flex h-full w-full items-center justify-center gap-x-1 py-1.5 lg:gap-x-2">
                                        <x-button.success class="{{ $index !== 0 ? 'block' : 'hidden' }} !p-2 text-xs"
                                            id="barang-up" wire:click="upBarang({{ $index }})">
                                            <x-icons.carred-down class="h-4 w-4 rotate-180" />
                                        </x-button.success>

                                        <x-button.success
                                            class="{{ $index === count($createForm->barang) - 1 ? 'hidden' : 'block' }} !p-2 text-xs"
                                            id="barang-down" wire:click="downBarang({{ $index }})">
                                            <x-icons.carred-down class="h-4 w-4" />
                                        </x-button.success>

                                        <x-button.primary class="!p-2 text-xs" id="edit-barang"
                                            wire:click="editBarang({{ $index }})">
                                            <x-icons.pen class="h-4 w-4" />
                                        </x-button.primary>

                                        <x-button.danger class="!p-2 text-xs" id="hapus-barang"
                                            wire:click="hapusBarang({{ $index }})">
                                            <x-icons.trash-bin class="h-4 w-4" />
                                        </x-button.danger>

                                    </div>
                                </td>
                            </tr>

                            <tr class="border-b border-gray-200 dark:border-gray-400">
                                <td class="text-sm text-gray-800 dark:text-white">
                                    {!! nl2br(e($row['spesifikasi'] ?? '')) !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="h-10 items-center text-center text-sm italic text-red-500">
                                    Belum ada barang pada
                                    list.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @error('createForm.barang')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>
    {{-- end form barang --}}

    {{-- form spk --}}
    <div
        class="grid w-full grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:gap-4 lg:p-6">
        <div class="col-span-2 w-full">
            <x-input.select id="tipe_tagihan" name="tipe_tagihan" wire:model="createForm.tipe_tagihan"
                :defaultOption="'Pilih tipe tagihan'" :options="[
                    'idcnon' => 'IDC Non PPN',
                    'idcppn' => 'IDC PPN',
                    'idyppn' => 'IDY PPN',
                ]" :labels="true" :textLabel="'Tipe Tagihan'" readonly />

            @error('createForm.tipe_tagihan')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 w-full lg:col-span-1">
            <x-input.basic id="nomor_order" name="nomor_order" readonly wire:model="createForm.nomor_order"
                placeholder="000.XXVXXX20XX">
                No. Order
            </x-input.basic>

            @error('createForm.nomor_order')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 w-full lg:col-span-1">
            <x-input.select id="tipe_bayar" name="tipe_bayar" wire:model="createForm.tipe_bayar" :textLabel="'Tipe Bayar'"
                :labels="true" :defaultOption="'Pilih Tipe Bayar'" :options="[
                    'Cash' => 'Tagih Cash',
                    'Bon' => 'Drop & Teken Bon',
                ]" />

            @error('createForm.tipe_bayar')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 w-full lg:col-span-1">
            <x-input.basic id="tgl_cetak" name="tgl_cetak" wire:model="createForm.tgl_cetak"
                placeholder="Tanggal Cetak" type="date">
                Tanggal Cetak
            </x-input.basic>
            @error('createForm.tgl_cetak')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 w-full lg:col-span-1">

            <div class="flex items-center justify-center gap-2">
                <div class="grow">
                    <x-input.basic id="tgl_kirim" name="tgl_kirim" wire:model.live="createForm.tgl_kirim"
                        placeholder="Waktu Penyerahan" type="number" min="1">
                        Waktu Penyerahan
                    </x-input.basic>
                </div>

                <span class="mt-7 text-gray-800 dark:text-white">Hari</span>
            </div>

            <span class="mt-2 text-xs text-green-500">
                * Isi dengan 1 Hari jika ingin mendapatkan output (SEGERA)
            </span>

            @error('createForm.tgl_kirim')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 w-full">
            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="assign_to">
                Assign Ke
            </label>

            <select
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                id="assign_to" name="assign_to" wire:model="createForm.assign_to">
                <option value="">Pilih Produksi</option>
                @forelse ($users as $row)
                    <option value="{{ $row->id ?? '' }}" {{ $row->id == $createForm->assign_to ? 'selected' : '' }}>
                        {{ $row->name ?? '' }}
                    </option>
                @empty
                    <option value="" disabled> Tidak ada data </option>
                @endforelse
            </select>

            @error('createForm.assign_to')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror

        </div>

        <div class="col-span-2 w-full">
            <x-input.textarea placeholder="Jelaskan keterangan lain seperti garansi, masa pengerjaan, dan lain - lain."
                id="keterangan" name="keterangan" wire:model="createForm.keterangan" :labels="true"
                :rows="'10'" :textLabel="'Keterangan Lainnya'" />

            @error('createForm.keterangan')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>
    </div>
    {{-- end form spk --}}

    {{-- form info tambahan --}}
    <div id="informasi-tambahan"
        class="grid w-full grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:grow lg:gap-4 lg:p-6">

        <div
            class="col-span-2 grid w-full grid-cols-1 gap-2 rounded-lg border border-gray-200 p-2 dark:border-gray-600 lg:gap-4 lg:p-4">

            <div x-show="$wire.docForm.new_attachments.length > 0">
                <span class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                    Daftar Lampiran
                </span>

                <ul
                    class="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white shadow-sm dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-700">

                    @foreach ($docForm->new_attachments as $index => $row)
                        <li class="flex items-center gap-2 p-2 transition hover:bg-gray-50 dark:hover:bg-gray-800">
                            <div class="w-8 text-center text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ $index + 1 }}.
                            </div>

                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                    {{ $row['nama_file'] }}
                                </p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $row['tipe_dokumen'] }}
                                </p>
                            </div>

                            <button type="button" wire:click="removeAttachment({{ $index }})"
                                class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                Hapus
                            </button>
                        </li>
                    @endforeach

                </ul>

                @error('docForm.new_attachments.*')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                    for="attachment">Lampiran</label>

                <div class="flex w-full flex-col gap-y-2" x-data="{ uploading: false, progress: 0 }"
                    x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-cancel="uploading = false" x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <label for="attachment"
                        class="flex h-36 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 transition-all duration-500 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-800">
                        <div class="flex flex-col items-center justify-center pb-6 pt-5">
                            <x-icons.cloud-upload class="mb-2 h-8 w-8 text-gray-500 dark:text-gray-400" />

                            <p wire:loading.remove wire:target="docForm.attachment"
                                class="mb-0.5 text-sm text-gray-500 dark:text-white"> Klik untuk upload
                            </p>

                            <p class="mb-0.5 text-sm text-gray-500 dark:text-gray-400">
                                @if ($docForm->attachment)
                                    <span class="font-semibold dark:text-white">
                                        {{ $docForm->attachment->getClientOriginalName() }}</span>
                                @endif
                            </p>

                            <div x-show="uploading"
                                class="mb-2 flex flex-col items-center gap-2 text-gray-800 dark:text-white">
                                <span wire:target="docForm.attachment" class="font-semibold">
                                    Sedang Mengupload...</span>

                                <x-button.danger id="cancel-upload" type="button" class="text-xs"
                                    wire:click="$cancelUpload('docForm.attachment')">
                                    Cancel
                                </x-button.danger>
                            </div>

                            <p class="w-full text-center text-xs text-gray-500 dark:text-gray-400">
                                *Dokumentasi dapat berupa file PNG, JPG, PDF, DOC, XLS (Min, 10KB, Maks 2MB)
                            </p>
                        </div>
                        <input id="attachment" name="attachment" type="file" wire:model="docForm.attachment"
                            class="hidden" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx" />
                    </label>

                    <div x-show="uploading" class="h-4 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                        <div class="h-4 rounded-full bg-blue-600" x-bind:style="{ width: progress + '%' }">
                        </div>
                    </div>

                </div>

                @error('docForm.attachment')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <x-input.select id="attachment_type" name="attachment_type" :defaultOption="'Pilih Tipe Dokumen'" :options="config('spk-config.tipe_dokumen')"
                    :labels="true" :textLabel="'Tipe Dokumen'" wire:model="docForm.attachment_type" />

                @error('docForm.attachment_type')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex w-full justify-end">
                <x-button.primary id="add-attachment" wire:click="storeLampiran" type="button">
                    Tambah
                </x-button.primary>
            </div>

        </div>

        <div class="col-span-2 flex w-full items-center gap-4">
            <div class="{{ $createForm->status_nomor_tagihan == 0 ? 'w-full' : 'w-fit' }}">
                <x-input.select id="status_nomor_tagihan" name="status_nomor_tagihan"
                    wire:model.live="createForm.status_nomor_tagihan" :defaultOption="'Pilih status no. tagihan'" :options="[
                        '0' => 'Belum ada',
                        '1' => 'Sudah ada',
                    ]"
                    :labels="true" :textLabel="'Status No. Tagihan'" />

                @error('createForm.status_nomor_tagihan')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            @if ($createForm->status_nomor_tagihan == 1)
                <div class="flex w-full gap-2" wire:transition>
                    <div class="w-full">
                        <x-input.basic id="nomor_tagihan" name="nomor_tagihan" wire:model="createForm.nomor_tagihan"
                            placeholder="Nomor SR / Nomor Faktur Pajak">
                            No. SR / Faktur Pajak
                        </x-input.basic>
                    </div>

                    <x-button.primary class="h-fit w-fit self-end" id="cek-nomor-tagihan" name="cek-nomor-tagihan"
                        wire:click="cekNomorTagihan">
                        Check
                    </x-button.primary>

                    @error('createForm.nomor_tagihan')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            @endif
        </div>

        <div class="col-span-2 w-full">
            <div>
                <x-input.basic id="nomor_dokumen_penawaran" name="nomor_dokumen_penawaran"
                    wire:model="createForm.nomor_dokumen_penawaran" placeholder="00XX.XX/X/X-X/X/XX">
                    No. Dokumen Penawaran
                </x-input.basic>
            </div>

            <span class="mt-2 text-xs text-green-500 lg:text-sm">
                Kosongkan kolom No. Dokumen Penawaran jika tidak ada, Anda dapat mengeditnya nanti.
            </span>

            @error('createForm.nomor_dokumen_penawaran')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 w-full">
            <div class="flex items-center">
                <input id="is_using_company_driver" type="checkbox"
                    wire:model.live="createForm.is_using_company_driver"
                    class="h-4 w-4 rounded-sm border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800 lg:h-5 lg:w-5">
                <label for="is_using_company_driver"
                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 lg:text-base">
                    Apakah SPK akan dikirim menggunakan supir perusahaan?
                </label>
            </div>

            @error('createForm.is_using_company_driver')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-2 w-full">
            <div class="flex items-center">
                <input id="is_picked_up_by_customer" type="checkbox"
                    wire:model.live="createForm.is_picked_up_by_customer"
                    class="h-4 w-4 rounded-sm border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800 lg:h-5 lg:w-5">
                <label for="is_picked_up_by_customer"
                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 lg:text-base">
                    Apakah SPK akan dijemput oleh customer?
                </label>
            </div>

            @error('createForm.is_picked_up_by_customer')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        @if ($data->status_approval === 0)
            <div class="col-span-2 w-full">
                <div class="flex items-center">
                    <input id="is_booked" type="checkbox" wire:model.live="createForm.is_booked"
                        class="h-4 w-4 rounded-sm border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800 lg:h-5 lg:w-5">
                    <label for="is_booked"
                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 lg:text-base">
                        Book Nomor SPK
                    </label>
                </div>

                @error('createForm.is_booked')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        @endif
    </div>
    {{-- end form info tambahan --}}

    @if ($data->status_approval === 1)
        <div class="w-full" id="accordion-packing-form" x-data="{ accordionOpen: $wire.is_changed, isChanged: $wire.is_changed }">
            <button type="button"
                class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-green-200 p-5 font-medium text-gray-500 shadow-md transition-all duration-300 ease-in-out hover:bg-blue-100 dark:border-gray-600 dark:bg-dark-primary dark:text-gray-400 dark:shadow-none dark:hover:bg-gray-800"
                @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
                <span class="flex flex-col text-left">
                    <h3 class="text-base font-semibold text-green-600 dark:text-green-500">
                        SPK Mengalami Perubahan?
                    </h3>
                    <p class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                        Klik untuk menambahkan detail jika SPK mengalami perubahan.
                    </p>
                </span>

                <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
                    <x-icons.carred-down class="h-4 w-4" />
                </span>
            </button>

            <div class="rounded-b-lg border border-gray-200 bg-white p-5 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none"
                x-show="accordionOpen" x-collapse x-cloak>

                <div>
                    <label class="mb-5 inline-flex cursor-pointer items-center">
                        <input type="checkbox" x-on:click="isChanged = !isChanged" wire:model.live="is_changed"
                            value="" class="peer sr-only">
                        <div
                            class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-blue-600 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full">
                        </div>
                        <span x-show="isChanged == true"
                            class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                            SPK Mengalami Perubahan
                        </span>
                        <span x-show="isChanged == false"
                            class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                            SPK Tidak Mengalami Perubahan</span>
                    </label>

                    <p class="mb-2 text-xs italic text-gray-600 dark:text-gray-400">
                        *Perubahan meliputi berubahnya spesifikasi produk yang dipesan, penambahan item/produk,
                        perubahan
                        informasi customer, dan lain - lain yang dapat dikonfirmasi terlebih dahulu ke Manajemen.
                    </p>
                </div>

                <div x-show="isChanged">
                    <x-input.textarea placeholder="Silahkan deskripsikan perubahan data..."
                        id="revision_request_detail" name="revision_request_detail"
                        wire:model="createForm.revision_request_detail" :labels="true" :textLabel="'Catatan Perubahan'"
                        rows="6" />

                    @error('createForm.revision_request_detail')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>
    @endif

    {{-- accordion delay SPK --}}
    <div class="w-full" id="accordion-packing-form" x-data="{ accordionOpen: $wire.is_delayed, onDelay: $wire.is_delayed }">
        <button type="button"
            class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-red-200 p-5 font-medium text-gray-500 shadow-md transition-all duration-300 ease-in-out hover:bg-blue-100 dark:border-gray-600 dark:bg-dark-primary dark:text-gray-400 dark:shadow-none dark:hover:bg-gray-800"
            @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
            <span class="flex flex-col text-left">
                <h3 class="text-base font-semibold text-red-600 dark:text-red-500">
                    SPK Mengalami Delay?
                </h3>
                <p class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                    Klik untuk menambahkan detail jika SPK mengalami Delay.
                </p>
            </span>

            <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
                <x-icons.carred-down class="h-4 w-4" />
            </span>
        </button>

        <div class="rounded-b-lg border border-gray-200 bg-white p-5 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none"
            x-show="accordionOpen" x-collapse x-cloak>

            <div>
                <label class="mb-5 inline-flex cursor-pointer items-center">
                    <input type="checkbox" x-on:click="onDelay = !onDelay" wire:model="is_delayed" value=""
                        class="peer sr-only">
                    <div
                        class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-blue-600 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full">
                    </div>
                    <span x-show="onDelay == true" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        SPK Mengalami Delay
                    </span>
                    <span x-show="onDelay == false" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        SPK Tidak Mengalami Delay</span>
                </label>
            </div>

            <div x-show="onDelay">
                <x-input.textarea id="delay_note" name="delay_note" wire:model="delay_note" :labels="true"
                    :textLabel="'Catatan'" placeholder="Jelaskan alasan delay..." rows="6" />

                @error('delay_note')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

        </div>
    </div>
    {{-- end accordion delay SPK --}}

    {{-- accordion cancel SPK --}}
    <div class="w-full" id="accordion-packing-form" x-data="{ accordionOpen: $wire.is_cancelled, onCancel: $wire.is_cancelled }">
        <button type="button"
            class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-red-200 p-5 font-medium text-gray-500 shadow-md transition-all duration-300 ease-in-out hover:bg-blue-100 dark:border-gray-600 dark:bg-dark-primary dark:text-gray-400 dark:shadow-none dark:hover:bg-gray-800"
            @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
            <span class="flex flex-col text-left">
                <h3 class="text-base font-semibold text-red-600 dark:text-red-500">
                    SPK Mengalami Cancel?
                </h3>
                <p class="block text-sm font-medium text-gray-600 dark:text-gray-400">
                    Klik untuk menambahkan detail jika SPK mengalami Cancel.
                </p>
            </span>

            <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
                <x-icons.carred-down class="h-4 w-4" />
            </span>
        </button>

        <div class="rounded-b-lg border border-gray-200 bg-white p-5 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none"
            x-show="accordionOpen" x-collapse x-cloak>

            <div>
                <label class="mb-5 inline-flex cursor-pointer items-center">
                    <input type="checkbox" x-on:click="onCancel = !onCancel" wire:model="is_cancelled"
                        value="" class="peer sr-only">
                    <div
                        class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:peer-checked:bg-blue-600 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full">
                    </div>
                    <span x-show="onCancel == true" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        SPK Dibatalkan
                    </span>
                    <span x-show="onCancel == false"
                        class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        SPK Tidak Dibatalkan</span>
                </label>
            </div>

            <div x-show="onCancel">
                <x-input.textarea id="cancel_note" name="cancel_note" wire:model="cancel_note" :labels="true"
                    :textLabel="'Catatan'" placeholder="Jelaskan alasan cancel..." rows="6" />

                @error('cancel_note')
                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

        </div>
    </div>
    {{-- end accordion cancel SPK --}}

    <div class="flex w-full flex-row justify-end gap-2">
        <x-button.success id="ubah-button" type="submit">
            Simpan Perubahan
        </x-button.success>
    </div>
</form>
