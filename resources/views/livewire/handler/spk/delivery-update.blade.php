<div class="flex flex-col gap-2 p-4 lg:gap-4 lg:p-0">

    {{-- table barang --}}
    <div id="items-table" class="w-full">
        @if (isset($data['packing_list']))
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 text-center">#</th>
                        <th scope="col" class="py-3 text-center">ID</th>
                        <th scope="col" class="py-3 text-center">Barang</th>
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
        @endif
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

                <form type="post" wire:submit.prevent="store" class="mt-2 grid gap-2 lg:grid-cols-2 lg:gap-4">

                    @if (isset($data['packing_list']))
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
                    @endif

                    <div class="col-span-2">
                        <x-input.select id="via" name="via" :labels="true" :textLabel="'Pilih tipe pengiriman'"
                            :defaultOption="'Pilih tipe pengiriman'" :options="[
                                'laut' => 'Laut / Container',
                                'darat' => 'Darat / Truck',
                                'supir' => 'Supir Perusahaan',
                            ]" wire:model.live="form.via" />
                    </div>

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
                    @elseif($form->via === 'darat' || $form->via === 'supir')
                        @if ($form->via === 'supir')
                            <div class="col-span-2">
                                <div class="flex gap-2">
                                    <div class="grow">
                                        <x-input.basic type="text" id="nomor_sr" name="nomor_sr"
                                            wire:model="form.nomor_sr" placeholder="SR-XXXXXXXX">
                                            Nomor SR
                                        </x-input.basic>

                                        @error('form.nomor_sr')
                                            <span class="mt-2 text-xs text-red-500"> {{ $message }} </span>
                                        @enderror
                                    </div>

                                    <x-button.primary class="mt-7 h-fit w-fit shrink" wire:click="fetchSR">
                                        <span wire:loading.remove wire:target="fetchSR">Fetch</span>
                                        <span wire:loading wire:target="fetchSR">Loading...</span>
                                    </x-button.primary>
                                </div>

                                <div wire:show="show_customer"
                                    class="mt-2 rounded-lg border border-gray-300 bg-gray-100 p-2 dark:border-gray-600 dark:bg-gray-600 lg:p-4">
                                    <p class="text-base font-semibold text-gray-800 dark:text-white">
                                        {{ $nama_customer }} </p>
                                    <p class="text-sm text-gray-800 dark:text-white"> {{ $alamat_customer }} </p>
                                </div>
                            </div>

                            <div class="col-span-2 lg:col-span-1">
                                <div>
                                    <x-input.basic id="search_supir" name="search_supir"
                                        placeholder="Cari supir berdasarkan kode jari atau nama.."
                                        wire:model.live="search_supir">
                                        Cari Supir
                                    </x-input.basic>

                                    <span class="mt-2 text-xs text-green-500"> *Anda dapat mencari berdasarkan nama atau
                                        kode jari supir.</span>
                                </div>

                                <ul class="mt-2 divide-y divide-gray-100 dark:divide-gray-700 dark:text-white">
                                    @foreach ($drivers as $driver)
                                        <li class="{{ $loop->first ? 'rounded-t-lg' : '' }} {{ $loop->last ? 'rounded-b-lg' : '' }} p-2 hover:cursor-pointer dark:bg-gray-600"
                                            wire:click="selectDriver('{{ $driver->kode_pegawai }}', '{{ $driver->name }}')">
                                            ({{ $driver->kode_pegawai }})
                                            {{ $driver->name }}
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        @endif

                        <div class="col-span-2 lg:col-span-1">
                            <x-input.basic id="nama_supir" name="nama_supir" placeholder="Masukkan nama supir.."
                                wire:model="form.nama_supir">
                                Nama Supir
                            </x-input.basic>

                            @if ($form->via === 'supir')
                                <span class="mt-2 text-xs text-green-500">
                                    *Otomatis terisi jika pilih supir berdasarkan list pada form supir.
                                </span>
                            @endif
                        </div>

                        @if ($form->via === 'darat')
                            <div class="col-span-2 lg:col-span-1">
                                <x-input.basic id="no_telp_supir" name="no_telp_supir"
                                    placeholder="Masukkan nomor telepon supir.." wire:model="form.no_telp_supir">
                                    No. Telp Supir
                                </x-input.basic>
                            </div>

                            <div class="col-span-2">
                                <x-input.basic id="no_plat" name="no_plat" placeholder="Masukkan nomor plat.."
                                    wire:model="form.no_plat">
                                    Nomor Plat Kendaraan
                                </x-input.basic>
                            </div>
                        @endif
                    @endif

                    <div class="col-span-2">
                        <x-input.basic id="berat" name="berat" placeholder="Masukkan estimasi berat barang.."
                            wire:model="form.berat">
                            Estimasi Berat Total Barang
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <x-input.basic id="etd" name="etd" wire:model="form.etd" type="date">
                            Estimasi Waktu Berangkat
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 lg:col-span-1">
                        <x-input.basic id="eta" name="eta" wire:model="form.eta" type="date">
                            Estimasi Waktu Sampai
                        </x-input.basic>
                    </div>

                    <div class="col-span-2">
                        <x-input.textarea id="note" name="note" wire:model="form.note" :textLabel="'Catatan'" />
                    </div>

                    <div class="col-span-2 flex justify-end gap-2">
                        <x-button.danger type="button" wire:click="clearForm" id="clearFormBtn">
                            <span wire:loading.remove wire:target="clearForm">Clear</span>
                            <span wire:loading wire:target="clearForm">Menghapus...</span>
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
                        {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                    </span>

                    <table id="delivery-history-content-table" class="w-full dark:text-gray-400">
                        <tr>
                            <td>Via</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">{{ ucfirst($row->via) }}</td>
                        </tr>

                        @if ($row['via'] === 'laut')
                            <tr>
                                <td>Partay</td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row->partay }} </td>
                            </tr>
                            <tr>
                                <td>No. Container </td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row->no_container }}
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Kapal</td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row->nama_kapal }}
                                </td>
                            </tr>
                        @elseif ($row->via === 'supir')
                            <tr>
                                <td>Nomor SR</td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row->nomor_sr }}</td>
                            </tr>
                            <tr>
                                <td>Kode Jari Supir </td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row->nama_supir }}
                                </td>
                            </tr>
                        @elseif ($row['via'] === 'darat')
                            <tr>
                                <td>Nama Supir </td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row->nama_supir }}
                                </td>
                            </tr>
                            <tr>
                                <td>No. Telp </td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row->no_telp_supir }}
                                </td>
                            </tr>
                            <tr>
                                <td>No. Plat</td>
                                <td class="w-8 text-center">:</td>
                                <td class="text-right text-gray-800 dark:text-white">
                                    {{ $row->no_plat }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td>Estimasi Berat Barang</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->berat }} </td>
                        </tr>
                        <tr>
                            <td>ETD</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->etd }}
                            </td>
                        </tr>
                        <tr>
                            <td>ETA</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->eta }}
                            </td>
                        </tr>

                        <tr>
                            <td>Catatan</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->note ?? '-' }}
                            </td>
                        </tr>
                    </table>

                    @if ($row->via != 'supir')
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
                    @endif

                </div>
            @empty
                <p class="col-span-2 text-center text-sm italic text-red-500">Belum ada riwayat pengiriman.</p>
            @endforelse
        </div>

        {{ $deliveries->links(data: ['scrollTo' => '#delivery-history-section']) }}
    </div>
    {{-- end riwayat pengiriman --}}
</div>
