<div class="flex flex-col gap-2 lg:gap-4" x-data="{ pdfUrl: null }"
    x-on:show-detail-modal.window="pdfUrl = $event.detail.url">
    {{-- accordion form tambah packing list --}}
    <div id="accordion-packing-form" x-data="{ accordionOpen: false }">
        <button type="button"
            class="d flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-green-500 p-5 font-medium text-white transition-all duration-300 ease-in-out hover:bg-green-400 dark:border-gray-600 dark:bg-green-600 dark:hover:bg-green-500"
            @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
            <h3 class="text-base font-semibold text-white">
                Tambah Packing List?
            </h3>

            <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
                <x-icons.carred-down class="h-4 w-4" />
            </span>
        </button>


        <div class="rounded-b-lg border border-gray-200 p-5 dark:border-gray-700" x-show="accordionOpen" x-collapse
            x-cloak>
            <form class="flex flex-col gap-2 lg:gap-4" wire:submit.prevent="store" method="post">
                <div class="flex flex-col gap-4">
                    {{-- field barang dan ekspedisi --}}
                    <div class="w-full">
                        <x-input.basic id="nama_ekspedisi" name="nama_ekspedisi" :labels="true" :type="'text'"
                            wire:model="itemForm.nama_ekspedisi" placeholder="Input ekspedisi yang digunakan...">
                            Nama Ekspedisi
                        </x-input.basic>

                        @error('itemForm.nama_ekspedisi')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-x-2">
                        <div class="w-full">
                            <x-input.basic id="nama_barang" name="nama_barang" :labels="true" :type="'text'"
                                wire:model="itemForm.nama_barang"
                                placeholder="Input nama barang/produk yang dipesan...">
                                Nama Barang
                            </x-input.basic>

                            @error('itemForm.nama_barang')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex w-fit gap-x-2">
                            <div class="w-full">
                                <x-input.basic id="qty_barang" name="qty_barang" :labels="true" type="number"
                                    min="1" wire:model="itemForm.qty_barang"
                                    placeholder="Input jumlah barang...">
                                    Qty / Jlh
                                </x-input.basic>

                                @error('itemForm.qty_barang')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <x-input.select id="satuan_barang" name="satuan_barang"
                                    wire:model="itemForm.satuan_barang" :textLabel="'Satuan'" :labels="true"
                                    :defaultOption="'Pilih satuan'" :options="config('spk-config.satuan')" />

                                @error('itemForm.satuan_barang')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- end field barang dan ekspedisi --}}

                    <div class="w-full">
                        <x-input.select id="cara_input" name="cara_input" wire:model="itemForm.cara_input"
                            :textLabel="'Cara Input'" :labels="true" :defaultOption="'Pilih Cara Input'" :options="[
                                'manual' => 'Input Manual',
                                'upload' => 'Via Upload File',
                            ]" />

                        @error('itemForm.cara_input')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2 lg:gap-4" x-show="$wire.itemForm.cara_input === 'manual'"
                        x-transition x-cloak>
                        {{-- daftar sparepart --}}
                        <div class="flex flex-col gap-y-2">
                            <h4 class="block text-sm font-medium text-gray-900 dark:text-white">Daftar Part</h4>

                            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
                                <thead
                                    class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 text-center">#</th>
                                        <th scope="col" class="py-3 text-center">Nama Part</th>
                                        <th scope="col" class="py-3 text-center">Qty</th>
                                        <th scope="col" class="py-3 text-center">Satuan</th>
                                        <th scope="col" class="py-3 text-center">Posisi Pack</th>
                                        <th scope="col" class="py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($itemForm->parts as $index => $row)
                                        <tr
                                            class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                            <td class="px-3 py-2 text-center">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $row['nama_part'] }}
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                {{ $row['qty'] }}
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                {{ $row['satuan'] }}
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                {{ $row['pack'] }}
                                            </td>
                                            <td class="flex justify-center px-3 py-2 text-center">
                                                <x-button.danger wire:click="removePart({{ $index }})">
                                                    <x-icons.trash-bin class="h-4 w-4" />
                                                </x-button.danger>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr
                                            class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                            <td colspan="6"
                                                class="px-6 py-4 text-center text-sm font-semibold italic text-red-500">
                                                Belum ada
                                                data
                                                sparepart </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            @error('itemForm.parts')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        {{-- end daftar sparepart --}}

                        {{-- field sparepart --}}
                        <div class="flex flex-col gap-2 lg:gap-4">
                            <div class="flex items-start gap-2">
                                <div class="grow">
                                    <x-input.basic id="nama_part" name="nama_part" :labels="true" :type="'text'"
                                        wire:model="partForm.nama_part"
                                        placeholder="Ketik nama part/sparepart yang dibawa">
                                        Nama Part
                                    </x-input.basic>

                                    @error('partForm.nama_part')
                                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <x-input.basic id="qty" name="qty" :labels="true" :type="'number'"
                                        placeholder="Jumlah part" wire:model="partForm.qty">
                                        Qty
                                    </x-input.basic>

                                    @error('partForm.qty')
                                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <x-input.select id="satuan" name="satuan" :labels="true" :textLabel="'Satuan'"
                                        :defaultOption="'Pilih satuan'" :options="config('spk-config.satuan')" wire:model="partForm.satuan" />

                                    @error('partForm.satuan')
                                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <x-input.select id="pack" name="pack" :labels="true" :textLabel="'Pack'"
                                        :defaultOption="'Pilih pack'" :options="[
                                            'Unpacking' => 'Unpacking',
                                            'Pack' => 'Pack',
                                        ]" wire:model="partForm.pack" />

                                    @error('partForm.pack')
                                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div x-show="$wire.partForm.pack === 'Pack'" x-transition x-cloak>
                                    <x-input.basic id="nama_box" placeholder="Ketik nama box pada packing list"
                                        name="nama_box" wire:model="partForm.nama_box">
                                        Nama Box
                                    </x-input.basic>
                                </div>
                            </div>

                            <div class="flex items-center justify-end">
                                <x-button.primary id="tambahPart" type="button" wire:click="addPart">
                                    <x-slot name="icon">
                                        <x-icons.plus class="h-5 w-5" />
                                    </x-slot>

                                    Part
                                </x-button.primary>
                            </div>
                        </div>
                        {{-- end field sparepart --}}
                    </div>

                    <div x-show="$wire.itemForm.cara_input === 'upload'" x-transition x-cloak
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
                                        <div
                                            class="w-8 text-center text-sm font-medium text-gray-600 dark:text-gray-400">
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
                                            *Dokumentasi dapat berupa file PNG, JPG, PDF, DOC, XLS (Min, 10KB, Maks
                                            5MB)
                                        </p>
                                    </div>
                                    <input id="attachment" name="attachment" type="file"
                                        wire:model="docForm.attachment" class="hidden"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx" />
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
                                :options="[
                                    'packing' => 'Packing List',
                                    'detail' => 'Detail Item Packing',
                                    'all' => 'Semua Dokumen',
                                    'other' => 'Dokumen Lainnya',
                                ]" :labels="true" :textLabel="'Tipe Dokumen'"
                                wire:model.defer="docForm.attachment_type" />

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

                    {{-- field untuk notes --}}
                    <div>
                        <x-input.textarea id="note" name="note" wire:model="itemForm.note"
                            placeholder="Ketik catatan tambahan..." :labels="true" :textLabel="'Catatan'" />

                        @error('itemForm.note')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- end field untuk notes --}}
                </div>

                <div class="flex w-full justify-center gap-2 lg:gap-4">
                    <x-button.success type="submit" id="store">
                        <span wire:loading.remove wire:target="store">Simpan Data</span>
                        <span wire:loading wire:target="store">Memproses...</span>
                    </x-button.success>
                </div>
            </form>
        </div>
    </div>
    {{-- end accordion form tambah packing list --}}

    {{-- table packing list --}}
    <div class="flex flex-col">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
            Daftar Data Packing List
        </h3>

        @livewire('packing-list-table', ['id' => $id], key($id))
    </div>
    {{-- end table packing list --}}

    {{-- modal print packing list --}}
    @if ($showDetailModal)
        <x-modal.base-modal id="detailModal" :title="'Packing List'" :actionName="'showDetailModal'">
            <iframe x-bind:src="pdfUrl" class="h-full w-full" title="Packing List" frameborder="0">
            </iframe>
        </x-modal.base-modal>
    @endif
    {{-- end modal print packing list --}}
</div>
