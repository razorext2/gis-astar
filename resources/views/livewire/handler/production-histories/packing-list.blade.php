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
                <div class="flex flex-col gap-2 lg:gap-4">
                    {{-- field barang dan ekspedisi --}}
                    <div class="w-full">
                        <x-input.basic id="nama_ekspedisi" name="nama_ekspedisi" :labels="true" :type="'text'"
                            wire:model="nama_ekspedisi" placeholder="Input ekspedisi yang digunakan...">
                            Nama Ekspedisi
                        </x-input.basic>

                        @error('nama_ekspedisi')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-x-2">
                        <div class="w-full">
                            <x-input.basic id="nama_barang" name="nama_barang" :labels="true" :type="'text'"
                                wire:model="nama_barang" placeholder="Input nama barang/produk yang dipesan...">
                                Nama Barang
                            </x-input.basic>

                            @error('nama_barang')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex w-fit gap-x-2">
                            <div class="w-full">
                                <x-input.basic id="qty_barang" name="qty_barang" :labels="true" type="number"
                                    min="1" wire:model="qty_barang" placeholder="Input jumlah barang...">
                                    Qty / Jlh
                                </x-input.basic>

                                @error('qty_barang')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <x-input.select id="satuan_barang" name="satuan_barang" wire:model="satuan_barang"
                                    :textLabel="'Satuan'" :labels="true" :defaultOption="'Pilih satuan'" :options="config('spk-config.satuan')" />

                                @error('satuan_barang')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- end field barang dan ekspedisi --}}

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
                                @forelse ($parts as $index => $row)
                                    <tr class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
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
                                    <tr class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-sm font-semibold italic text-red-500">
                                            Belum ada
                                            data
                                            sparepart </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @error('parts')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- end daftar sparepart --}}

                    {{-- field sparepart --}}
                    <div class="flex flex-col gap-2 lg:gap-4">
                        <div class="flex items-start gap-2">
                            <div class="grow">
                                <x-input.basic id="nama_part" name="nama_part" :labels="true" :type="'text'"
                                    wire:model="form.nama_part" placeholder="Ketik nama part/sparepart yang dibawa">
                                    Nama Part
                                </x-input.basic>

                                @error('form.nama_part')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <x-input.basic id="qty" name="qty" :labels="true" :type="'number'"
                                    placeholder="Jumlah part" wire:model="form.qty">
                                    Qty
                                </x-input.basic>

                                @error('form.qty')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <x-input.select id="satuan" name="satuan" :labels="true" :textLabel="'Satuan'"
                                    :defaultOption="'Pilih satuan'" :options="config('spk-config.satuan')" wire:model="form.satuan" />

                                @error('form.satuan')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <x-input.select id="pack" name="pack" :labels="true" :textLabel="'Pack'"
                                    :defaultOption="'Pilih pack'" :options="[
                                        'Unpacking' => 'Unpacking',
                                        'Pack' => 'Pack',
                                    ]" wire:model="form.pack" x-model="pack" />

                                @error('form.pack')
                                    <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>


                            <div x-show="$wire.form.pack === 'Pack'" x-transition x-cloak>
                                <x-input.basic id="nama_box" placeholder="Ketik nama box pada packing list"
                                    name="nama_box" wire:model="form.nama_box">
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

                    {{-- field untuk notes --}}
                    <div>
                        <x-input.textarea id="note" name="note" wire:model="note"
                            placeholder="Ketik catatan tambahan..." :labels="true" :textLabel="'Catatan'" />

                        @error('note')
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
