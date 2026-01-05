<div class="flex flex-col gap-2 p-4 lg:gap-4 lg:p-0">

    {{-- table barang --}}
    <div id="items-table" class="w-full">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 text-center">#</th>
                    <th scope="col" class="py-3 text-center">ID</th>
                    <th scope="col" class="py-3 text-center">Barang</th>
                    {{-- <th scope="col" class="py-3 text-center">Aksi</th> --}}
                </tr>
            </thead>

            <tbody>
                @forelse ($data['packing_list'] as $index => $row)
                    <tr class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                        <td class="px-3 py-2 text-center">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-3 py-2">
                            {{ $row['id_barang'] }}
                        </td>
                        <td class="px-3 py-2">
                            {{ $row['nama_barang'] }}
                        </td>
                        {{-- <td class="flex justify-center px-3 py-2 text-center">
                            <x-button.success class="gap-x-1" wire:click="removePart({{ $index }})">
                                <x-slot name="icon">
                                    <x-icons.trash-bin class="h-4 w-4" />
                                </x-slot>
                                Update
                            </x-button.success>
                        </td> --}}
                    </tr>
                @empty
                    <tr class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                        <td colspan="3" class="px-6 py-4 text-center text-sm font-semibold italic text-red-500">
                            Packing list belum ditambah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- end table barang --}}

    {{-- form tambah info pengiriman --}}
    <div id="accordion-packing-form" x-data="{ accordionOpen: false }">
        <button type="button"
            class="flex w-full items-center justify-between gap-3 rounded-lg border border-gray-200 p-5 font-medium text-gray-500 transition-all duration-300 ease-in-out hover:bg-blue-100 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-800"
            @click="accordionOpen = !accordionOpen" :class="accordionOpen ? 'rounded-b-none border-b-0' : ''">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                Tambah Riwayat Pengiriman?
            </h3>

            <span class="transition-all duration-300 ease-in-out" :class="accordionOpen ? 'rotate-180' : ''">
                <x-icons.carred-down class="h-4 w-4" />
            </span>
        </button>


        <div class="rounded-b-lg border border-gray-200 p-5 dark:border-gray-700" x-show="accordionOpen" x-collapse
            x-cloak>
            <div id="delivery-history-add-form" class="w-full">
                <p class="text-base text-gray-600 dark:text-gray-400">
                    Silakan perbarui informasi pengiriman pada form dibawah ini untuk barang yang telah selesai
                    diproses.
                </p>

                <form type="post" wire:submit.prevent="store"
                    class="mt-2 grid gap-2 rounded-lg border-[1px] border-gray-200 p-2 dark:border-gray-600 lg:grid-cols-2 lg:gap-4 lg:p-4">
                    <div class="col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Pilih Barang yang Dikirim
                        </label>

                        @forelse ($data['packing_list'] as $index => $row)
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="cb-{{ $index }}" value="{{ $row['id_barang'] }}"
                                    wire:model="form.barangs">
                                <label for="cb-{{ $index }}"
                                    class="text-sm text-gray-800 dark:text-white">{{ $row['nama_barang'] }}</label>
                            </div>
                        @empty
                            <span class="text-xs italic text-red-500"> Tidak ada barang dalam packing list. </span>
                        @endforelse
                    </div>

                    <div class="col-span-2">
                        <x-input.select id="via" name="via" :labels="true" :textLabel="'Pilih tipe pengiriman'"
                            :defaultOption="'Pilih tipe pengiriman'" :options="[
                                'laut' => 'Laut / Container',
                                'darat' => 'Darat / Truck',
                            ]" wire:model.live="form.via" />
                    </div>

                    {{-- <div class="col-span-2 lg:col-span-1">
                        <x-input.basic id="no_kontrak" name="no_kontrak" placeholder="Masukkan nomor kontrak.."
                            wire:model="form.no_kontrak">
                            Nomor Kontrak
                        </x-input.basic>
                    </div> --}}

                    @if ($form->via === 'laut')
                        <div class="col-span-2 lg:col-span-1">
                            <x-input.basic id="partay" name="partay" placeholder="Masukkan nomor partay.."
                                wire:model="form.partay">
                                Partay
                            </x-input.basic>
                        </div>

                        <div class="col-span-2 lg:col-span-1">
                            <x-input.basic id="no_container" name="no_container"
                                placeholder="Masukkan nomor container.." wire:model="form.no_container">
                                No. Container
                            </x-input.basic>
                        </div>

                        <div class="col-span-2">
                            <x-input.basic id="nama_kapal" name="nama_kapal" placeholder="Masukkan nama kapal.."
                                wire:model="form.nama_kapal">
                                Nama Kapal
                            </x-input.basic>
                        </div>
                    @elseif ($form->via === 'darat')
                        <div class="col-span-2 lg:col-span-1">
                            <x-input.basic id="no_plat" name="no_plat" placeholder="Masukkan nomor plat.."
                                wire:model="form.no_plat">
                                Nomor Plat Kendaraan
                            </x-input.basic>
                        </div>

                        <div class="col-span-2 lg:col-span-1">
                            <x-input.basic id="nama_supir" name="nama_supir" placeholder="Masukkan nama supir.."
                                wire:model="form.nama_supir">
                                Nama Supir
                            </x-input.basic>
                        </div>

                        <div class="col-span-2">
                            <x-input.basic id="no_telp_supir" name="no_telp_supir"
                                placeholder="Masukkan nomor telepon supir.." wire:model="form.no_telp_supir">
                                No. Telp Supir
                            </x-input.basic>
                        </div>

                        {{-- <div class="lg:col-span-2">
                            <x-input.basic id="sim" name="sim" placeholder="Masukkan SIM supir.."
                                wire:model="sim">
                                SIM
                            </x-input.basic>
                        </div> --}}
                    @endif

                    <div class="col-span-2">
                        <x-input.basic id="berat" name="berat" placeholder="Masukkan estimasi berat barang.."
                            wire:model="form.berat">
                            Estimasi Berat Total Barang
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <x-input.basic id="etd" name="etd" wire:model="form.etd" type="datetime-local">
                            Estimasi Waktu Berangkat
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <x-input.basic id="eta" name="eta" wire:model="form.eta" type="datetime-local">
                            Estimasi Waktu Sampai
                        </x-input.basic>
                    </div>

                    <div class="col-span-2">
                        <x-input.textarea id="note" name="note" wire:model="form.note" :textLabel="'Catatan'" />
                    </div>

                    <div class="col-span-2 flex justify-end gap-2">
                        <x-button.danger type="button" wire:click="clear" id="clearBtn">
                            <span wire:loading.remove wire:target="clear">Clear</span>
                            <span wire:loading wire:target="clear">Menghapus...</span>
                        </x-button.danger>

                        <x-button.primary type="submit" id="submitBtn">
                            <span wire:loading.remove wire:target="store">Simpan</span>
                            <span wire:loading wire:target="store">Menyimpan...</span>
                        </x-button.primary>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- end form tambah info pengiriman --}}

    {{-- riwayat pengiriman --}}
    <div id="delivery-history-section" class="flex w-full flex-col gap-2 lg:gap-4">
        <div id="delivery-history-header">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white lg:text-lg">
                Riwayat Pengiriman
            </h3>

            <p class="text-base text-gray-600 dark:text-gray-400">
                Berikut ini adalah riwayat pengiriman SPK dengan no spk: <span
                    class="font-semibold text-gray-800 dark:text-gray-200">{{ $spk_data->nomor_order }}</span>
            </p>
        </div>

        <div id="delivery-history-content" class="grid w-full gap-2 lg:grid-cols-2 lg:gap-4">
            @forelse ($deliveries as $row)
                <div id="delivery-history-content-child"
                    class="flex flex-col gap-2 rounded-lg border-[1px] border-gray-200 bg-gray-100 p-2 text-sm dark:border-gray-600 dark:bg-gray-600 lg:p-4">

                    <span class="w-full text-center text-xs font-semibold text-gray-800 dark:text-white">
                        {{ \Carbon\Carbon::parse($row['created_at'])->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                    </span>

                    <table id="delivery-history-content-table" class="w-full dark:text-gray-400">
                        <tr>
                            <td>Via</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">{{ ucfirst($row['via']) }}</td>
                        </tr>

                        @if ($row['via'] === 'laut')
                            <tr>
                                <td>Partay</td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row['partay'] }} </td>
                            </tr>
                            <tr>
                                <td>No. Container </td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row['no_container'] }}
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Kapal</td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row['nama_kapal'] }}
                                </td>
                            </tr>
                        @elseif ($row['via'] === 'darat')
                            <tr>
                                <td>No. Plat</td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row['no_plat'] }} </td>
                            </tr>
                            <tr>
                                <td>Nama Supir </td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row['nama_supir'] }}
                                </td>
                            </tr>
                            <tr>
                                <td>No. Telp </td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row['no_telp_supir'] }}
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td>Estimasi Berat Barang</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row['berat'] }} </td>
                        </tr>
                        <tr>
                            <td>ETD</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($row['etd'])->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                            </td>
                        </tr>
                        <tr>
                            <td>ETA</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($row['eta'])->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                            </td>
                        </tr>

                        <tr>
                            <td>Catatan</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row['note'] ?? '-' }}
                            </td>
                        </tr>
                    </table>

                    <div class="flex w-full flex-col gap-1">
                        <p
                            class="text-center font-semibold text-gray-800 underline underline-offset-2 dark:text-gray-400">
                            Barang yang
                            dibawah</p>
                        <ul class="text-gray-600 dark:text-white">
                            @foreach ($row['products'] as $key => $barang)
                                <li>{{ $key + 1 }}. {{ $barang }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            @empty
                <p class="col-span-2 text-center text-sm italic text-red-500">Belum ada riwayat pengiriman.</p>
            @endforelse
        </div>

        {{ $deliveries->links(data: ['scrollTo' => '#delivery-history-section']) }}
    </div>
    {{-- end riwayat pengiriman --}}
</div>
