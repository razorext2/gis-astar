<div id="accordion-box-form" x-data="{ accordionOpen: true }">
    <button type="button"
        class="d flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 bg-blue-500 p-5 font-medium text-white transition-all duration-300 ease-in-out hover:bg-blue-400 dark:border-gray-600 dark:bg-blue-600 dark:hover:bg-blue-500"
        @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
        <h3 class="text-base font-semibold text-white">
            Tambah Detail Item di Peti?
        </h3>

        <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
            <x-icons.carred-down class="h-4 w-4" />
        </span>
    </button>

    <div class="rounded-b-lg border border-gray-200 p-5 dark:border-gray-700" x-show="accordionOpen" x-collapse x-cloak>
        <form class="flex flex-col gap-2 lg:gap-4" wire:submit.prevent="store" method="post">
            <div class="flex flex-col gap-2 lg:gap-4">
                {{-- field barang dan ekspedisi --}}
                <div class="w-full">
                    <x-input.basic id="customer_name" name="customer_name" :labels="true" :type="'text'"
                        wire:model="formBox.customer_name" placeholder="Input nama customer yang memesan..." readonly>
                        Nama Customer
                    </x-input.basic>

                    @error('formBox.customer_name')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-x-2">
                    <div class="w-full">
                        <x-input.basic id="title" name="title" :labels="true" :type="'text'"
                            wire:model="formBox.title"
                            placeholder="Input judul detail komponen yang akan muncul diatas laporan...">
                            Judul Detail Komponen
                        </x-input.basic>

                        @error('formBox.title')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex w-fit gap-x-2">
                        <div class="w-full">
                            <x-input.basic id="qty_barang" name="qty_barang" :labels="true" type="number"
                                min="1" wire:model="formBox.qty_barang" placeholder="Input jumlah barang...">
                                Qty / Jlh
                            </x-input.basic>

                            @error('formBox.qty_barang')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <x-input.select id="satuan_barang" name="satuan_barang" wire:model="formBox.satuan_barang"
                                :textLabel="'Satuan'" :labels="true" :defaultOption="'Pilih satuan'" :options="config('spk-config.satuan')" />

                            @error('formBox.satuan_barang')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- end field barang dan ekspedisi --}}

                <div
                    class="relative mt-2 flex flex-col gap-2 rounded-lg p-2 ring-1 ring-gray-400 dark:ring-gray-600 lg:p-4">


                    <h4
                        class="absolute -top-2.5 left-4 block bg-gray-100 text-sm font-medium text-gray-900 dark:bg-dark-primary dark:text-white">
                        Daftar Peti
                    </h4>

                    {{-- daftar peti --}}
                    <div class="flex flex-col gap-y-2">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
                            <thead
                                class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 text-center" width="5%">#</th>
                                    <th scope="col" class="py-3 text-center" width="25%">Nama Peti</th>
                                    <th scope="col" class="py-3 text-center">Isi Peti</th>
                                    <th scope="col" class="py-3 text-center" width="10%">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($formBox->boxs as $index => $row)
                                    <tr class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                        <td class="px-3 py-2 text-center">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $row['box_name'] }}
                                        </td>
                                        <td class="px-3 py-2">
                                            <ul>
                                                @foreach ($row['kits'] as $i => $item)
                                                    <li>
                                                        {{ $i + 1 }}.
                                                        {{ $item['kit_qty'] }} {{ $item['kit_unit'] }}
                                                        {{ $item['kit_name'] }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="flex justify-center px-3 py-2 text-center">
                                            <x-button.danger wire:click="removeBox({{ $index }})">
                                                <x-icons.trash-bin class="h-4 w-4" />
                                            </x-button.danger>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                        <td colspan="6"
                                            class="px-6 py-4 text-center text-sm font-semibold italic text-red-500">
                                            Belum ada detail peti yang ditambah
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @error('formKit.kits')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                        @error('formBox.boxs')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- end daftar sparepart --}}

                    {{-- field sparepart --}}
                    <div class="flex flex-col gap-2 lg:gap-4">

                        <div class="w-full">
                            <x-input.basic id="nama_peti" name="nama_peti" :labels="true" :type="'text'"
                                wire:model="formBox.box_name" placeholder="Ketik nama peti yang dibawa">
                                Nama Peti
                            </x-input.basic>

                            @error('formBox.box_name')
                                <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- form input untuk kit --}}
                        @for ($i = 0; $i < $formBox->kitRow; $i++)
                            @php
                                $hasRowError =
                                    $errors->has("formKit.kits.$i.kit_name") ||
                                    $errors->has("formKit.kits.$i.kit_qty") ||
                                    $errors->has("formKit.kits.$i.kit_unit");
                            @endphp

                            <div class="flex items-stretch gap-2">

                                <div class="grow">
                                    <x-input.basic id="nama_kit{{ $i }}" name="nama_kit{{ $i }}"
                                        :labels="true" type="text"
                                        wire:model="formKit.kits.{{ $i }}.kit_name"
                                        placeholder="Ketik nama item/part yang dibawa">
                                        Nama Item
                                    </x-input.basic>

                                    @error("formKit.kits.$i.kit_name")
                                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <x-input.basic id="jumlah_kit{{ $i }}"
                                        name="jumlah_kit{{ $i }}" :labels="true" type="number"
                                        wire:model="formKit.kits.{{ $i }}.kit_qty"
                                        placeholder="Jumlah part">
                                        Qty
                                    </x-input.basic>

                                    @error("formKit.kits.$i.kit_qty")
                                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <x-input.select id="satuan_kit{{ $i }}"
                                        name="satuan_kit{{ $i }}" :labels="true" textLabel="Satuan"
                                        defaultOption="Pilih satuan" :options="config('spk-config.satuan')"
                                        wire:model="formKit.kits.{{ $i }}.kit_unit" />

                                    @error("formKit.kits.$i.kit_unit")
                                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="{{ $hasRowError ? 'items-center' : 'items-end mb-1' }} flex gap-x-2">
                                    <x-button.primary type="button" wire:click="addRow">
                                        <x-icons.plus class="h-5 w-5" />
                                    </x-button.primary>

                                    @if ($i > 0)
                                        <x-button.danger type="button" wire:click="removeRow({{ $i }})">
                                            <x-icons.minus class="h-5 w-5" />
                                        </x-button.danger>
                                    @endif
                                </div>

                            </div>
                        @endfor
                        {{-- end form input untuk kit --}}

                        <div class="flex h-full items-center justify-center">
                            <x-button.primary id="tambahKit" class="h-full" type="button" wire:click="storeBox">
                                Simpan Peti
                            </x-button.primary>
                        </div>

                    </div>
                    {{-- end field sparepart --}}
                </div>
            </div>

            <div class="flex w-full gap-2 lg:gap-4">
                <x-button.success type="submit" id="store">
                    <span wire:loading.remove wire:target="store">Simpan Data</span>
                    <span wire:loading wire:target="store">Memproses...</span>
                </x-button.success>
            </div>
        </form>
    </div>
</div>
