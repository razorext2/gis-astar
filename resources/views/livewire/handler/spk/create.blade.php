<div class="flex flex-col gap-4" x-data="{ open: false, pdfUrl: '', focusNamaCustomer() { this.$nextTick(() => this.$refs.namaCustomer?.focus()); } }" x-init="focusNamaCustomer()"
    x-on:focus-nama-customer.window="focusNamaCustomer()"
    x-on:show-pdf-modal.window="open = true; pdfUrl = $event.detail.url">

    <form class="grid gap-4" method="POST" wire:submit.prevent="store">

        {{-- form info customer --}}
        <div id="informasi-customer" class="flex flex-col items-start gap-2 lg:flex-row lg:gap-0">

            <div class="flex w-full items-start lg:w-44 xl:w-60">
                <a href="#informasi-customer"
                    class="text-wrap rounded-b-xl rounded-tl-xl border-t-2 border-gray-200 bg-white p-4 py-2 text-lg font-semibold text-gray-900 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:text-blue-700 dark:border-gray-700 dark:bg-dark-primary dark:text-white hover:dark:text-blue-600">
                    Customer
                </a>
                <hr width="100%" class="border border-t border-gray-200 dark:border-gray-700">
            </div>

            <div
                class="grid w-full grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:grow lg:gap-4 lg:rounded-b-xl lg:rounded-tl-none lg:rounded-tr-xl lg:p-6">

                <div class="col-span-2 w-full">
                    <x-input.basic x-ref="namaCustomer" id="nama_customer" name="nama_customer"
                        wire:model="createForm.nama_customer" placeholder="Nama Bon Customer">
                        Nama Bon Customer
                    </x-input.basic>

                    @error('createForm.nama_customer')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <x-input.basic id="no_telp" name="no_telp" wire:model="createForm.no_telp"
                        placeholder="62858xxxxxxx">
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

                <div class="col-span-2 w-full">
                    <x-input.textarea id="alamat_customer" name="alamat_customer"
                        wire:model="createForm.alamat_customer" :labels="true" :textLabel="'Alamat Customer'" />

                    @error('createForm.alamat_customer')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>
        {{-- end form info customer --}}

        {{-- form barang --}}
        <div id="informasi-barang" class="flex flex-col items-start gap-2 lg:flex-row lg:gap-0">
            <div class="flex w-full items-start lg:w-44 xl:w-60">
                <a href="#informasi-barang"
                    class="text-wrap rounded-b-xl rounded-tl-xl border-t-2 border-gray-200 bg-white p-4 py-2 text-lg font-semibold text-gray-900 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:text-blue-700 dark:border-gray-700 dark:bg-dark-primary dark:text-white hover:dark:text-blue-600">
                    Barang
                </a>
                <hr width="100%" class="border border-t border-gray-200 dark:border-gray-700">
            </div>

            <div
                class="grid w-full grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:grow lg:gap-4 lg:rounded-b-xl lg:rounded-tl-none lg:rounded-tr-xl lg:p-6">

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
                        <x-input.textarea id="spesifikasi" name="spesifikasi" wire:model="barangForm.spesifikasi"
                            rows="8" :labels="true" :textLabel="'Spesifikasi'" />

                        @error('barangForm.spesifikasi')
                            <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex w-full justify-end gap-x-2">
                        <x-button.primary id="tambah-barang" wire:click="tambahBarang">
                            <x-slot name="icon">
                                <x-icons.plus class="h-5 w-5" />
                            </x-slot>
                            {{ $is_edit ? 'Ubah' : 'Tambah' }}
                        </x-button.primary>

                        <x-button.danger id="reset-barang" wire:click="resetBarang">
                            Clear
                        </x-button.danger>
                    </div>
                </div>

                <div class="col-span-2 flex w-full flex-col">
                    <p class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Daftar Barang Yang Dipesan</p>

                    <div class="flex flex-col gap-y-1 rounded-xl bg-gray-50 p-4 dark:bg-gray-600">
                        <table id="barang-list-table" class="w-full">
                            <thead
                                class="border-b border-gray-200 text-sm font-semibold text-gray-800 dark:border-gray-400 dark:text-white">
                                <th class="px-2 py-2">#</th>
                                <th class="px-2 py-2">Nama Barang</th>
                                <th class="px-2 py-2">Jumlah</th>
                                <th class="px-2 py-2">Satuan</th>
                                <th class="px-2 py-2">Aksi</th>
                            </thead>
                            <tbody>
                                @forelse ($createForm->barang as $index => $row)
                                    <tr class="py-1" wire:key="{{ $row['_key'] }}">
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
                                            class="items-center text-center text-sm text-gray-800 first-letter:uppercase dark:text-white">
                                            {{ $row['satuan_barang'] }}
                                        </td>
                                        <td rowspan="2" class="h-full">
                                            <div
                                                class="flex h-full w-full items-center justify-center gap-x-1 py-1.5 lg:gap-x-2">
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
                                        <td colspan="5"
                                            class="h-10 items-center text-center text-sm italic text-red-500">
                                            Belum ada barang pada list.
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
        </div>
        {{-- end form barang --}}

        {{-- form spk --}}
        <div id="informasi-order" class="flex flex-col items-start gap-2 lg:flex-row lg:gap-0">
            <div class="flex w-full items-start lg:w-44 xl:w-60">
                <a href="#informasi-order"
                    class="text-wrap rounded-b-xl rounded-tl-xl border-t-2 border-gray-200 bg-white p-4 py-2 text-lg font-semibold text-gray-900 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:text-blue-700 dark:border-gray-700 dark:bg-dark-primary dark:text-white hover:dark:text-blue-600">
                    Order
                </a>
                <hr width="100%" class="border border-t border-gray-200 dark:border-gray-700">
            </div>

            <div
                class="grid w-full grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:grow lg:gap-4 lg:rounded-b-xl lg:rounded-tl-none lg:rounded-tr-xl lg:p-6">

                <div class="col-span-2 w-full dark:text-white">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="tipe_tagihan">
                        Tipe Tagihan
                    </label>

                    <select
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="tipe_tagihan" name="tipe_tagihan" wire:model.live="createForm.tipe_tagihan">
                        <option value="">Pilih tipe tagihan...</option>
                        @foreach (config('spk-config.spk_tipe_tagihan') as $key => $row)
                            <option value="{{ $key }}">
                                {{ $row['label'] }}
                            </option>
                        @endforeach
                    </select>

                    @error('createForm.tipe_tagihan')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <div>
                        <x-input.basic id="nomor_order" name="nomor_order" wire:model.live="createForm.nomor_order"
                            placeholder="000.XXVXXX20XX">
                            No. Order
                        </x-input.basic>
                    </div>

                    <span class="mt-2 text-xs text-green-500 lg:text-sm">
                        SPK Terakhir: {{ $nomor_order_lama }}
                    </span>

                    @error('createForm.nomor_order')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <x-input.select id="tipe_bayar" name="tipe_bayar" wire:model="createForm.tipe_bayar"
                        :textLabel="'Tipe Bayar'" :labels="true" :defaultOption="'Pilih Tipe Bayar'" :options="[
                            'Cash' => 'Tagih Cash',
                            'Bon' => 'Drop & Teken Bon',
                        ]" />

                    @error('createForm.tipe_bayar')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <x-input.basic id="tgl_cetak" name="tgl_cetak" wire:model.live="createForm.tgl_cetak"
                        placeholder="Tanggal Cetak" type="date">
                        Tanggal Cetak
                    </x-input.basic>
                    @error('createForm.tgl_cetak')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">

                    <div class="flex items-center justify-center gap-2">
                        <div class="grow">
                            <x-input.basic id="tgl_kirim" name="tgl_kirim" wire:model="createForm.tgl_kirim"
                                placeholder="Waktu Penyerahan" type="number" min="1">
                                Waktu Penyerahan
                            </x-input.basic>
                        </div>

                        <span class="mt-7 text-gray-800 dark:text-white">Hari</span>
                    </div>

                    <p class="mt-2 text-xs text-green-500">
                        * Isi dengan 1 Hari jika ingin mendapatkan output (SEGERA)
                    </p>

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
                            <option value="{{ $row->id }}">
                                {{ $row->name }} - {{ $row->pegawai->jabatanRelasi->nama_jabatan }}
                                ({{ $row->pegawai->jabatanRelasi?->placementRelasi?->penempatan }})
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
                    <x-input.textarea id="keterangan" name="keterangan" wire:model="createForm.keterangan"
                        :labels="true" :rows="'10'" :textLabel="'Keterangan Lainnya'" />

                    @error('createForm.keterangan')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>
        {{-- end form spk --}}

        {{-- form info tambahan --}}
        <div id="informasi-tambahan" class="flex flex-col items-start gap-2 lg:flex-row lg:gap-0">
            <div class="flex w-full items-start lg:w-44 xl:w-60">
                <a href="#informasi-tambahan"
                    class="text-wrap rounded-b-xl rounded-tl-xl border-t-2 border-gray-200 bg-white p-4 py-2 text-lg font-semibold text-gray-900 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:text-blue-700 dark:border-gray-700 dark:bg-dark-primary dark:text-white hover:dark:text-blue-600">
                    Additional
                </a>
                <hr width="100%" class="border border-t border-gray-200 dark:border-gray-700">
            </div>

            <div
                class="grid w-full grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:grow lg:gap-4 lg:rounded-b-xl lg:rounded-tl-none lg:rounded-tr-xl lg:p-6">

                <div
                    class="col-span-2 grid w-full grid-cols-1 gap-2 rounded-lg border border-gray-200 p-2 dark:border-gray-600 lg:gap-4 lg:p-4">

                    <div x-show="$wire.docForm.new_attachments.length > 0">
                        <span class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Daftar Lampiran
                        </span>

                        <ul
                            class="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white shadow-sm dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-700">

                            @foreach ($docForm->new_attachments as $index => $row)
                                <li
                                    class="flex items-center gap-2 p-2 transition hover:bg-gray-50 dark:hover:bg-gray-800">
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
                            x-on:livewire-upload-start="uploading = true"
                            x-on:livewire-upload-finish="uploading = false"
                            x-on:livewire-upload-cancel="uploading = false"
                            x-on:livewire-upload-error="uploading = false"
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
                                <input id="attachment" name="attachment" type="file"
                                    wire:model="docForm.attachment" class="hidden"
                                    accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx" />
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
                        <x-input.select id="attachment_type" name="attachment_type" :defaultOption="'Pilih Tipe Dokumen'"
                            :options="config('spk-config.tipe_dokumen')" :labels="true" :textLabel="'Tipe Dokumen'"
                            wire:model="docForm.attachment_type" />

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
                                <x-input.basic id="nomor_tagihan" name="nomor_tagihan"
                                    wire:model="createForm.nomor_tagihan" placeholder="Nomor SR / Nomor Faktur Pajak">
                                    No. SR / Faktur Pajak
                                </x-input.basic>
                            </div>

                            <x-button.primary class="h-fit w-fit self-end" id="cek-nomor-tagihan"
                                name="cek-nomor-tagihan" wire:click="cekNomorTagihan">
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

            </div>
        </div>
        {{-- end form info tambahan --}}

        <div class="flex w-full justify-start gap-2 lg:pl-[8.75rem] xl:pl-48 2xl:pl-[12.5rem]">
            <x-button.primary id="summary-button" wire:click="summary">
                Summary
            </x-button.primary>

            <x-button.success id="simpan-button" type="submit">
                Simpan
            </x-button.success>
        </div>
    </form>

    @if ($showSummary)
        <!-- Overlay -->
        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            x-transition.opacity>
            <!-- Modal -->
            <div class="h-[85vh] w-[90vw] overflow-hidden rounded-lg bg-white text-gray-800 shadow-xl dark:bg-dark-secondary dark:text-white"
                @keydown.escape.window="open=false">
                <div class="flex items-center justify-between border-b px-4 py-2">
                    <h2 class="font-semibold">SPK Summary</h2>

                    <button class="p-2" @click="open=false; $wire.set('showSummary', false)">
                        <x-icons.close class="h-5 w-5 text-red-500" />
                    </button>
                </div>

                <!-- Konten PDF: iframe -->
                <div class="h-[calc(85vh-48px)] w-full">
                    <iframe x-bind:src="pdfUrl" class="h-full w-full" title="SPK Summary PDF"
                        frameborder="0">
                    </iframe>
                </div>
            </div>
        </div>
    @endif

</div>
