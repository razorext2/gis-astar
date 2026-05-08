<div class="space-y-4" x-data="{ focusNamaCustomer() { this.$nextTick(() => this.$refs.namaCustomer?.focus()); } }" x-init="focusNamaCustomer()"
    x-on:focus-nama-customer.window="focusNamaCustomer()">

    <form class="grid gap-4" method="POST" wire:submit.prevent="store">

        {{-- form info customer --}}
        <div id="informasi-customer"
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none">

            <div class="flex items-center gap-3 border-b border-zinc-200 px-4 py-4 dark:border-zinc-800 lg:px-6">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-500">
                    <x-icons.user class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Customer</h2>
                    <p class="text-sm text-gray-500 dark:text-zinc-400">Informasi data diri dan alamat dari customer.
                    </p>
                </div>
            </div>

            <div class="grid w-full grid-cols-1 gap-4 p-4 md:grid-cols-2 lg:p-6">

                <div class="col-span-1 md:col-span-2">
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

                <div class="col-span-1 md:col-span-2">
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
        <div id="informasi-barang"
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none">

            <div class="flex items-center gap-3 border-b border-zinc-200 px-4 py-4 dark:border-zinc-800 lg:px-6">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-500">
                    <x-icons.archive class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Barang</h2>
                    <p class="text-sm text-gray-500 dark:text-zinc-400">Informasi dan daftar barang yang dipesan.</p>
                </div>
            </div>

            <div class="grid w-full grid-cols-1 gap-6 p-4 lg:p-6">

                {{-- Form Tambah Barang --}}
                <div
                    class="flex w-full flex-col gap-4 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow dark:border-zinc-700 dark:bg-zinc-800">
                    <div class="w-full">
                        <x-input.select id="tipe_timbangan" name="tipe_timbangan" :labels="true" :textLabel="'Tipe Timbangan Yang Dipesan'"
                            :defaultOption="'Pilih tipe timbangan'" wire:model="createForm.tipe_timbangan" :options="config('spk-config.tipe_timbangan')" />

                        @error('createForm.tipe_timbangan')
                            <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-3">
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
                            rows="4" :labels="true" :textLabel="'Spesifikasi'" />

                        @error('barangForm.spesifikasi')
                            <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                        @enderror
                    </div>

                    <div
                        class="mt-2 flex w-full justify-end gap-x-2 border-t border-zinc-100 pt-4 dark:border-zinc-700">
                        <x-button.danger id="reset-barang" wire:click="resetBarang" type="button">
                            Clear
                        </x-button.danger>

                        <x-button.primary id="tambah-barang" wire:click="storeBarang" type="button">
                            <x-slot name="icon">
                                <x-icons.plus class="h-5 w-5" />
                            </x-slot>
                            {{ $is_edit ? 'Ubah Barang' : 'Tambah Barang' }}
                        </x-button.primary>
                    </div>
                </div>

                {{-- Daftar Barang --}}
                <div class="flex w-full flex-col">
                    <h3 class="mb-3 text-base font-semibold text-gray-900 dark:text-white">Daftar Barang Yang Dipesan
                    </h3>

                    <div
                        class="overflow-hidden rounded-xl border border-zinc-200 bg-white/60 shadow backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60">
                        <table id="barang-list-table" class="w-full text-left">
                            <thead
                                class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase tracking-wider text-zinc-600 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                                <tr>
                                    <th class="w-12 px-4 py-3 text-center">#</th>
                                    <th class="px-4 py-3">Barang & Spesifikasi</th>
                                    <th class="w-28 px-4 py-3 text-center">Jumlah</th>
                                    <th class="w-28 px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                @forelse ($createForm->barang as $index => $row)
                                    <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50"
                                        wire:key="{{ $row['_key'] }}">
                                        <td
                                            class="px-4 py-4 text-center align-top text-sm font-medium text-zinc-900 dark:text-white">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $row['nama_barang'] }}</p>
                                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                                {!! nl2br(e($row['spesifikasi'] ?? '-')) !!}</p>
                                        </td>
                                        <td class="px-4 py-4 text-center align-top">
                                            <span
                                                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                                                {{ $row['jumlah_unit'] }} {{ ucfirst($row['satuan_barang'] ?? '') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <div class="flex items-center justify-center gap-1">
                                                <button type="button"
                                                    class="{{ $index !== 0 ? 'block' : 'hidden' }} rounded p-1 text-zinc-400 transition-colors hover:bg-zinc-100 hover:text-blue-600 dark:hover:bg-zinc-800 dark:hover:text-blue-400"
                                                    id="barang-up" wire:click="upBarang({{ $index }})"
                                                    title="Pindah ke Atas">
                                                    <x-icons.carred-down class="h-4 w-4 rotate-180" />
                                                </button>
                                                <button type="button"
                                                    class="{{ $index === count($createForm->barang) - 1 ? 'hidden' : 'block' }} rounded p-1 text-zinc-400 transition-colors hover:bg-zinc-100 hover:text-blue-600 dark:hover:bg-zinc-800 dark:hover:text-blue-400"
                                                    id="barang-down" wire:click="downBarang({{ $index }})"
                                                    title="Pindah ke Bawah">
                                                    <x-icons.carred-down class="h-4 w-4" />
                                                </button>

                                                <button type="button"
                                                    class="rounded p-1 text-zinc-400 transition-colors hover:bg-zinc-100 hover:text-blue-600 dark:hover:bg-zinc-800 dark:hover:text-blue-400"
                                                    id="edit-barang" wire:click="editBarang({{ $index }})"
                                                    title="Edit">
                                                    <x-icons.pen class="h-4 w-4" />
                                                </button>
                                                <button type="button"
                                                    class="rounded p-1 text-zinc-400 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-500"
                                                    id="hapus-barang" wire:click="hapusBarang({{ $index }})"
                                                    title="Hapus">
                                                    <x-icons.trash-bin class="h-4 w-4" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <x-icons.archive
                                                    class="mb-2 h-8 w-8 text-zinc-300 dark:text-zinc-600" />
                                                <p>Belum ada barang yang ditambahkan.</p>
                                            </div>
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
        <div id="informasi-order"
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none">

            <div class="flex items-center gap-3 border-b border-zinc-200 px-4 py-4 dark:border-zinc-800 lg:px-6">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-500">
                    <x-icons.file-invoice class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Order</h2>
                    <p class="text-sm text-gray-500 dark:text-zinc-400">Detail penagihan, nomor urut SPK, dan tenggat
                        waktu penyelesaian.</p>
                </div>
            </div>

            <div class="grid w-full grid-cols-1 gap-4 p-4 md:grid-cols-2 lg:grid-cols-2 lg:p-6">

                <div class="col-span-1 w-full md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="tipe_tagihan">
                        Tipe Tagihan
                    </label>

                    <select
                        class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="tipe_tagihan" name="tipe_tagihan" wire:model.live="createForm.tipe_tagihan">
                        <option value="">Pilih tipe tagihan...</option>
                        @foreach (config('spk-config.spk_tipe_tagihan') as $key => $row)
                            <option value="{{ $key }}"
                                {{ $key === $this->data->tipe_tagihan ? 'selected' : '' }}>
                                {{ $row['label'] }}
                            </option>
                        @endforeach
                    </select>

                    @error('createForm.tipe_tagihan')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
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

                        <span class="mt-7 text-sm font-medium text-gray-800 dark:text-zinc-200">Hari</span>
                    </div>

                    <p class="mt-2 text-xs text-green-600 dark:text-green-400">
                        * Isi dengan 1 Hari jika ingin mendapatkan output (SEGERA)
                    </p>

                    @error('createForm.tgl_kirim')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-1 w-full md:col-span-2">

                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="assign_to">
                        Assign Ke
                    </label>

                    <select
                        class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="assign_to" name="assign_to" wire:model="createForm.assign_to">
                        <option value="">Pilih Produksi</option>
                        @forelse ($users as $row)
                            <option value="{{ $row->id ?? '' }}"
                                {{ $row->id == $createForm->assign_to ? 'selected' : '' }}>
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

                <div class="col-span-1 w-full md:col-span-2">
                    <x-input.textarea id="keterangan" name="keterangan" wire:model="createForm.keterangan"
                        :labels="true" :rows="'5'" :textLabel="'Keterangan Lainnya'" />

                    @error('createForm.keterangan')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>
        {{-- end form spk --}}

        {{-- form info tambahan --}}
        <div id="informasi-tambahan"
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none">

            <div class="flex items-center gap-3 border-b border-zinc-200 px-4 py-4 dark:border-zinc-800 lg:px-6">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-500">
                    <x-icons.cloud-upload class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Additional</h2>
                    <p class="text-sm text-gray-500 dark:text-zinc-400">Lampiran file dan opsi tambahan lainnya.</p>
                </div>
            </div>

            <div class="grid w-full grid-cols-1 gap-6 p-4 lg:grid-cols-2 lg:p-6">

                {{-- Attachment Upload Section --}}
                <div
                    class="col-span-1 flex w-full flex-col gap-4 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow dark:border-zinc-700 dark:bg-zinc-800 lg:col-span-2 lg:flex-row">

                    <div class="flex w-full flex-col lg:w-1/2">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="attachment">Upload Lampiran</label>

                        <div class="flex w-full flex-col gap-y-2" x-data="{ uploading: false, progress: 0 }"
                            x-on:livewire-upload-start="uploading = true"
                            x-on:livewire-upload-finish="uploading = false"
                            x-on:livewire-upload-cancel="uploading = false"
                            x-on:livewire-upload-error="uploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <label for="attachment"
                                class="group flex h-36 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-200 bg-gray-50 transition-all duration-300 hover:border-blue-400 hover:bg-gray-100 dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-blue-500 dark:hover:bg-zinc-700">
                                <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                    <x-icons.cloud-upload
                                        class="mb-2 h-8 w-8 text-gray-400 transition-colors group-hover:text-blue-500 dark:text-gray-500" />

                                    <p wire:loading.remove wire:target="docForm.attachment"
                                        class="mb-0.5 text-sm text-gray-500 dark:text-gray-300">
                                        <span class="font-semibold text-blue-600 dark:text-blue-400">Klik untuk
                                            upload</span> atau drag and drop
                                    </p>

                                    <p class="mb-0.5 text-sm text-gray-500 dark:text-gray-400">
                                        @if ($docForm->attachment)
                                            <span class="font-semibold text-green-600 dark:text-green-400">
                                                {{ $docForm->attachment->getClientOriginalName() }}</span>
                                        @endif
                                    </p>

                                    <div x-show="uploading"
                                        class="mb-2 flex w-full max-w-xs flex-col items-center gap-2 text-gray-800 dark:text-white">
                                        <span wire:target="docForm.attachment" class="text-sm font-medium">
                                            Sedang Mengupload...</span>

                                        <x-button.danger id="cancel-upload" type="button"
                                            class="!px-3 !py-1 text-xs"
                                            wire:click="$cancelUpload('docForm.attachment')">
                                            Cancel
                                        </x-button.danger>
                                    </div>

                                    <p class="mt-2 w-full px-4 text-center text-xs text-gray-400 dark:text-zinc-500">
                                        PNG, JPG, PDF, DOC, XLS (Min 10KB, Maks 2MB)
                                    </p>
                                </div>
                                <input id="attachment" name="attachment" type="file"
                                    wire:model="docForm.attachment" class="hidden"
                                    accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx" />
                            </label>

                            <div x-show="uploading"
                                class="mt-2 h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                                <div class="h-2 rounded-full bg-blue-600 transition-all duration-300"
                                    x-bind:style="{ width: progress + '%' }">
                                </div>
                            </div>

                        </div>

                        @error('docForm.attachment')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex w-full flex-col justify-between gap-4 lg:w-1/2">
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
                                Tambah Lampiran
                            </x-button.primary>
                        </div>
                    </div>

                </div>

                {{-- Attachment List --}}
                <div class="col-span-1 w-full lg:col-span-2" x-show="$wire.docForm.new_attachments.length > 0">
                    <h3 class="mb-3 text-base font-semibold text-gray-900 dark:text-white">Daftar Lampiran Tersimpan
                    </h3>

                    <ul
                        class="flex flex-col divide-y divide-zinc-200 rounded-xl border border-zinc-200 bg-white/60 shadow backdrop-blur-md dark:divide-zinc-800 dark:border-zinc-800 dark:bg-dark-primary/60">
                        @foreach ($docForm->new_attachments as $index => $row)
                            <li
                                class="flex items-center gap-4 px-4 py-3 transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-500">
                                    <x-icons.clipboard class="h-5 w-5" />
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $row['nama_file'] }}
                                    </p>
                                    <p class="mt-0.5 text-xs font-medium text-gray-500 dark:text-zinc-400">
                                        Tipe: {{ $row['tipe_dokumen'] }}
                                    </p>
                                </div>

                                <x-button.danger class="!p-2 text-xs" type="button"
                                    wire:click="removeAttachment({{ $index }})" title="Hapus">
                                    <x-icons.trash-bin class="h-4 w-4" />
                                </x-button.danger>
                            </li>
                        @endforeach
                    </ul>

                    @error('docForm.new_attachments.*')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Other Options --}}
                <div
                    class="col-span-1 flex w-full flex-col gap-4 border-t border-zinc-200 pt-6 dark:border-zinc-800 lg:col-span-2">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Opsi Tambahan & Dokumen Pendukung
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="flex w-full flex-col gap-4">
                            <div class="{{ $createForm->status_nomor_tagihan == 0 ? 'w-full' : 'w-full' }}">
                                <x-input.select id="status_nomor_tagihan" name="status_nomor_tagihan"
                                    wire:model.live="createForm.status_nomor_tagihan" :defaultOption="'Pilih status no. tagihan'"
                                    :options="[
                                        '0' => 'Belum ada',
                                        '1' => 'Sudah ada',
                                    ]" :labels="true" :textLabel="'Status No. Tagihan'" />

                                @error('createForm.status_nomor_tagihan')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($createForm->status_nomor_tagihan == 1)
                                <div class="flex w-full items-end gap-2" wire:transition>
                                    <div class="w-full">
                                        <x-input.basic id="nomor_tagihan" name="nomor_tagihan"
                                            wire:model="createForm.nomor_tagihan"
                                            placeholder="Nomor SR / Nomor Faktur Pajak">
                                            No. SR / Faktur Pajak
                                        </x-input.basic>
                                    </div>

                                    <x-button.primary class="h-fit w-fit" id="cek-nomor-tagihan"
                                        name="cek-nomor-tagihan" wire:click="cekNomorTagihan" type="button">
                                        Check
                                    </x-button.primary>

                                    @error('createForm.nomor_tagihan')
                                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="w-full">
                                <div>
                                    <x-input.basic id="nomor_dokumen_penawaran" name="nomor_dokumen_penawaran"
                                        wire:model="createForm.nomor_dokumen_penawaran"
                                        placeholder="00XX.XX/X/X-X/X/XX">
                                        No. Dokumen Penawaran
                                    </x-input.basic>
                                </div>

                                <span class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    Kosongkan jika tidak ada, dapat diedit kemudian.
                                </span>

                                @error('createForm.nomor_dokumen_penawaran')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="flex w-full flex-col justify-center gap-4 rounded-xl border border-zinc-100 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">

                            <div class="flex items-center">
                                <input id="is_using_company_driver" type="checkbox"
                                    wire:model.live="createForm.is_using_company_driver"
                                    class="h-5 w-5 rounded-md border-zinc-300 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:ring-offset-zinc-800">
                                <label for="is_using_company_driver"
                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-zinc-200">
                                    Dikirim menggunakan supir perusahaan?
                                </label>
                            </div>
                            @error('createForm.is_using_company_driver')
                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                            @enderror

                            <div class="flex items-center">
                                <input id="is_picked_up_by_customer" type="checkbox"
                                    wire:model.live="createForm.is_picked_up_by_customer"
                                    class="h-5 w-5 rounded-md border-zinc-300 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:ring-offset-zinc-800">
                                <label for="is_picked_up_by_customer"
                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-zinc-200">
                                    Dijemput oleh customer?
                                </label>
                            </div>
                            @error('createForm.is_picked_up_by_customer')
                                <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                            @enderror

                            @if ($data->status_approval === 0)
                                <div class="flex items-center">
                                    <input id="is_booked" type="checkbox" wire:model.live="createForm.is_booked"
                                        class="h-5 w-5 rounded-md border-zinc-300 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-zinc-600 dark:bg-zinc-700 dark:ring-offset-zinc-800">
                                    <label for="is_booked"
                                        class="ms-3 text-sm font-medium text-gray-900 dark:text-zinc-200">
                                        Book Nomor SPK
                                    </label>
                                </div>
                                @error('createForm.is_booked')
                                    <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- end form info tambahan --}}

        {{-- Status Modals / Accordions for SPK Mengalami Perubahan, dll. --}}
        @if ($data->status_approval === 1)
            <x-utils.accordion-item id="accordion-spk-change" title="SPK Mengalami Perubahan?"
                description="Klik untuk menambahkan detail jika SPK mengalami perubahan." iconColor="green"
                :expanded="$is_changed" class="w-full">
                <x-slot:icon>
                    <x-icons.file-pen class="h-4 w-4" />
                </x-slot:icon>

                <div x-data="{ isChanged: $wire.entangle('is_changed') }" class="space-y-4">
                    <label class="inline-flex cursor-pointer items-center">
                        <input type="checkbox" wire:model.live="is_changed" value="" class="peer sr-only">
                        <div
                            class="peer relative h-6 w-11 rounded-full bg-zinc-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-zinc-200 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-zinc-800 dark:bg-zinc-700 dark:peer-checked:bg-blue-600 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full">
                        </div>
                        <span x-show="isChanged" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                            SPK Mengalami Perubahan
                        </span>
                        <span x-show="!isChanged" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                            SPK Tidak Mengalami Perubahan</span>
                    </label>

                    <p class="text-xs italic text-zinc-500 dark:text-zinc-400">
                        *Perubahan meliputi berubahnya spesifikasi produk yang dipesan, penambahan item/produk,
                        perubahan informasi customer, dan lain - lain yang dapat dikonfirmasi terlebih dahulu ke
                        Manajemen.
                    </p>

                    <div x-show="isChanged" x-collapse>
                        <x-input.textarea placeholder="Silahkan deskripsikan perubahan data..."
                            id="revision_request_detail" name="revision_request_detail"
                            wire:model="createForm.revision_request_detail" :labels="true" :textLabel="'Catatan Perubahan'"
                            rows="6" />

                        @error('createForm.revision_request_detail')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </x-utils.accordion-item>
        @endif

        {{-- accordion delay SPK --}}
        <x-utils.accordion-item id="accordion-spk-delay" title="SPK Mengalami Delay?"
            description="Klik untuk menambahkan detail jika SPK mengalami Delay." iconColor="red" :expanded="$is_delayed"
            class="w-full">
            <x-slot:icon>
                <x-icons.clock class="h-4 w-4" />
            </x-slot:icon>

            <div x-data="{ onDelay: $wire.entangle('is_delayed') }" class="space-y-4">
                <label class="inline-flex cursor-pointer items-center">
                    <input type="checkbox" wire:model.live="is_delayed" value="" class="peer sr-only">
                    <div
                        class="peer relative h-6 w-11 rounded-full bg-zinc-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-zinc-200 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-zinc-800 dark:bg-zinc-700 dark:peer-checked:bg-blue-600 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full">
                    </div>
                    <span x-show="onDelay" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        SPK Mengalami Delay
                    </span>
                    <span x-show="!onDelay" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        SPK Tidak Mengalami Delay</span>
                </label>

                <div x-show="onDelay" x-collapse>
                    <x-input.textarea id="delay_note" name="delay_note" wire:model="delay_note" :labels="true"
                        :textLabel="'Catatan'" placeholder="Jelaskan alasan delay..." rows="6" />

                    @error('delay_note')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-utils.accordion-item>
        {{-- end accordion delay SPK --}}

        {{-- accordion cancel SPK --}}
        <x-utils.accordion-item id="accordion-spk-cancel" title="SPK Mengalami Cancel?"
            description="Klik untuk menambahkan detail jika SPK mengalami Cancel." iconColor="red" :expanded="$is_cancelled"
            class="w-full">
            <x-slot:icon>
                <x-icons.exclamation-circle class="h-4 w-4" />
            </x-slot:icon>

            <div x-data="{ onCancel: $wire.entangle('is_cancelled') }" class="space-y-4">
                <label class="inline-flex cursor-pointer items-center">
                    <input type="checkbox" wire:model.live="is_cancelled" value="" class="peer sr-only">
                    <div
                        class="peer relative h-6 w-11 rounded-full bg-zinc-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-zinc-200 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-zinc-800 dark:bg-zinc-700 dark:peer-checked:bg-blue-600 dark:peer-focus:ring-blue-800 rtl:peer-checked:after:-translate-x-full">
                    </div>
                    <span x-show="onCancel" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        SPK Dibatalkan
                    </span>
                    <span x-show="!onCancel" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        SPK Tidak Dibatalkan</span>
                </label>

                <div x-show="onCancel" x-collapse>
                    <x-input.textarea id="cancel_note" name="cancel_note" wire:model="cancel_note" :labels="true"
                        :textLabel="'Catatan'" placeholder="Jelaskan alasan cancel..." rows="6" />

                    @error('cancel_note')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-utils.accordion-item>
        {{-- end accordion cancel SPK --}}

        <div
            class="flex w-full items-center justify-end gap-3 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
            <x-button.success id="ubah-button" type="submit">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="store" class="h-4 w-4 animate-spin" />
                    <x-icons.check-circle wire:loading.remove wire:target="store" class="h-4 w-4" />
                </x-slot>

                <span wire:loading.remove wire:target="store">Simpan Perubahan</span>
                <span wire:loading wire:target="store">Menyimpan...</span>
            </x-button.success>
        </div>
    </form>
</div>
