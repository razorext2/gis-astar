<form class="grid items-start gap-4 lg:grid-cols-2" method="POST" wire:submit.prevent="store">

    <div
        class="col-span-2 grid grow gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:col-span-1 lg:gap-4 lg:p-6">

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
            <x-input.textarea id="alamat_customer" name="alamat_customer" wire:model="createForm.alamat_customer"
                :labels="true" :textLabel="'Alamat Customer'" />

            @error('createForm.alamat_customer')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

    </div>

    <div
        class="col-span-2 flex flex-col items-start gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:col-span-1 lg:gap-4 lg:p-6">

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

            <div class="flex w-full justify-center">
                <x-button.primary id="tambah-barang" wire:click="tambahBarang">
                    Tambah
                </x-button.primary>
            </div>
        </div>

        <div class="flex max-h-44 w-full flex-col lg:max-h-80">
            <p class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Daftar Barang Yang Dipesan</p>

            <div class="flex flex-col gap-y-1 overflow-y-auto rounded-xl p-4 dark:bg-gray-600">
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
                            <tr>
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

    <div
        class="col-span-2 grid grow grid-cols-2 gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:gap-4 lg:p-6">

        <div class="w-full">
            <x-input.select id="tipe_tagihan" name="tipe_tagihan" wire:model="createForm.tipe_tagihan" :defaultOption="'Pilih tipe tagihan'"
                :options="[
                    'idcnon' => 'IDC Non PPN',
                    'idcppn' => 'IDC PPN',
                    'idyppn' => 'IDY PPN',
                ]" :labels="true" :textLabel="'Tipe Tagihan'" />

            @error('createForm.tipe_tagihan')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex w-full flex-row items-center gap-4">
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

        <div class="w-full">
            <x-input.basic id="nomor_order" name="nomor_order" readonly wire:model="createForm.nomor_order"
                placeholder="000.XXVXXX20XX">
                No. Order
            </x-input.basic>

            @error('createForm.nomor_order')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full">
            <x-input.select id="tipe_bayar" name="tipe_bayar" wire:model="createForm.tipe_bayar" :textLabel="'Tipe Bayar'"
                :labels="true" :defaultOption="'Pilih Tipe Bayar'" :options="[
                    'Cash' => 'Tagih Cash',
                    'Bon' => 'Drop & Teken Bon',
                ]" />

            @error('createForm.tipe_bayar')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full">
            <x-input.basic id="tgl_cetak" name="tgl_cetak" wire:model="createForm.tgl_cetak"
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
            <x-input.textarea id="keterangan" name="keterangan" wire:model="createForm.keterangan" :labels="true"
                :rows="'10'" :textLabel="'Keterangan Lainnya'" />

            @error('createForm.keterangan')
                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

    </div>

    {{-- accordion form tambah packing list --}}
    <div class="col-span-2" id="accordion-packing-form" x-data="{ accordionOpen: $wire.is_delayed, onDelay: $wire.is_delayed }">
        <button type="button"
            class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white p-5 font-medium text-gray-500 shadow-md transition-all duration-300 ease-in-out hover:bg-blue-100 dark:border-gray-600 dark:bg-dark-primary dark:text-gray-400 dark:shadow-none dark:hover:bg-gray-800"
            @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
            <span class="flex flex-col text-left">
                <h3 class="text-base font-semibold text-red-500">
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
                    :textLabel="'Catatan'" rows="6" />
            </div>

        </div>
    </div>
    {{-- end accordion form tambah packing list --}}

    <div class="flex w-full flex-row justify-end gap-2 lg:col-span-2">
        <x-button.success id="ubah-button" type="submit">
            Simpan Perubahan
        </x-button.success>
    </div>
</form>
