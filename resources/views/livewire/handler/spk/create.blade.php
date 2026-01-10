<div class="flex flex-col gap-4" x-data="{ open: false, pdfUrl: '', focusNamaCustomer() { this.$nextTick(() => this.$refs.namaCustomer?.focus()); } }" x-init="focusNamaCustomer()"
    x-on:focus-nama-customer.window="focusNamaCustomer()"
    x-on:show-pdf-modal.window="open = true; pdfUrl = $event.detail.url">

    <form class="grid gap-4" method="POST" wire:submit.prevent="store">

        <div id="informasi-customer" class="flex flex-col items-start gap-2 lg:flex-row lg:gap-0">

            <div class="flex w-full flex-row items-start lg:w-44 xl:w-60">
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

        <div id="informasi-barang" class="flex flex-col items-start gap-2 lg:flex-row lg:gap-0">
            <div class="flex w-full flex-row items-start lg:w-44 xl:w-60">
                <a href="#informasi-barang"
                    class="text-wrap rounded-b-xl rounded-tl-xl border-t-2 border-gray-200 bg-white p-4 py-2 text-lg font-semibold text-gray-900 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:text-blue-700 dark:border-gray-700 dark:bg-dark-primary dark:text-white hover:dark:text-blue-600">
                    Barang
                </a>
                <hr width="100%" class="border border-t border-gray-200 dark:border-gray-700">
            </div>

            <div
                class="grid w-full grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:grow lg:gap-4 lg:rounded-b-xl lg:rounded-tl-none lg:rounded-tr-xl lg:p-6">

                <div class="col-span-2 flex w-full flex-col items-start gap-4">
                    <div class="flex w-full gap-2 lg:gap-4">
                        <div class="w-full">
                            <x-input.basic id="nama_barang" name="nama_barang" wire:model="nama_barang"
                                placeholder="Ketik nama barang">
                                Nama Barang
                            </x-input.basic>

                            @error('nama_barang')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <x-input.basic type="number" min="1" id="jumlah_unit" name="jumlah_unit"
                                wire:model="jumlah_unit" placeholder="cth: 1, 2, 3, dst">
                                Jumlah Unit
                            </x-input.basic>

                            @error('jumlah_unit')
                                <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <x-input.select id="satuan_barang" name="satuan_barang" :labels="true" :textLabel="'Satuan'"
                                :defaultOption="'Pilih satuan'" wire:model="satuan_barang" :options="config('spk-config.satuan')" />

                            @error('satuan_barang')
                                <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full">
                        <x-input.textarea id="spesifikasi" name="spesifikasi" wire:model="spesifikasi" rows="8"
                            :labels="true" :textLabel="'Spesifikasi'" />

                        @error('spesifikasi')
                            <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex w-full justify-end">
                        <x-button.primary id="tambah-barang" wire:click="tambahBarang">
                            <x-slot name="icon">
                                <x-icons.plus class="h-5 w-5" />
                            </x-slot>
                            Tambah
                        </x-button.primary>
                    </div>
                </div>

                <div class="col-span-2 flex w-full flex-col">
                    <p class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Daftar Barang Yang Dipesan</p>

                    <div class="flex flex-col gap-y-1 rounded-xl p-4 dark:bg-gray-600">
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
                                    <tr class="py-1">
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
                                        <td rowspan="2" class="items-center">
                                            <x-button.danger class="!p-1 text-xs" id="hapus-barang"
                                                wire:click="hapusBarang({{ $index }})">
                                                <x-icons.trash-bin class="h-4 w-4" />
                                            </x-button.danger>
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

        <div id="informasi-order" class="flex flex-col items-start gap-2 lg:flex-row lg:gap-0">
            <div class="flex w-full flex-row items-start lg:w-44 xl:w-60">
                <a href="#informasi-order"
                    class="text-wrap rounded-b-xl rounded-tl-xl border-t-2 border-gray-200 bg-white p-4 py-2 text-lg font-semibold text-gray-900 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:text-blue-700 dark:border-gray-700 dark:bg-dark-primary dark:text-white hover:dark:text-blue-600">
                    Order
                </a>
                <hr width="100%" class="border border-t border-gray-200 dark:border-gray-700">
            </div>

            <div
                class="grid w-full grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:grow lg:gap-4 lg:rounded-b-xl lg:rounded-tl-none lg:rounded-tr-xl lg:p-6">

                <div class="col-span-2 w-full dark:text-white">
                    <x-input.select id="tipe_tagihan" name="tipe_tagihan" wire:model.live="createForm.tipe_tagihan"
                        :defaultOption="'Pilih tipe tagihan'" :options="[
                            'idcnon' => 'IDC Non PPN',
                            'idcppn' => 'IDC PPN',
                            // 'idyppn' => 'IDY PPN',
                        ]" :labels="true" :textLabel="'Tipe Tagihan'" />

                    @error('createForm.tipe_tagihan')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 flex w-full flex-row items-center gap-4">
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
                        <div class="flex w-full flex-row gap-2" wire:transition>
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

                <div class="w-full">
                    <div>
                        <x-input.basic id="nomor_order" name="nomor_order" wire:model.live="createForm.nomor_order"
                            placeholder="000.XXVXXX20XX">
                            No. Order
                        </x-input.basic>
                    </div>

                    <span class="mt-2 text-sm text-green-500">
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
                            <option value="{{ $row->id ?? '' }}">
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
                    <x-input.textarea id="keterangan" name="keterangan" wire:model="createForm.keterangan"
                        :labels="true" :rows="'10'" :textLabel="'Keterangan Lainnya'" />

                    @error('createForm.keterangan')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

        <div class="flex w-full flex-row justify-start gap-2 lg:pl-[8.75rem] xl:pl-48 2xl:pl-[12.5rem]">
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
