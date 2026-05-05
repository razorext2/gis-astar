<div class="flex flex-col gap-2 p-4 lg:gap-4 lg:p-0">

    @if (!$spk_data->is_using_company_driver)
        {{-- table barang --}}
        <div id="items-table" class="w-full">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 text-center">#</th>
                        <th scope="col" class="py-3 text-center">Ekspedisi</th>
                        <th scope="col" class="py-3 text-center">Barang</th>
                        <th scope="col" class="py-3 text-center">Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    @if (isset($spk_data->production->packing_list))
                        @foreach ($spk_data->production->packing_list as $index => $row)
                            <tr class="border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-gray-800">
                                <td class="px-3 py-2 text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $row['nama_ekspedisi'] }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $row['nama_barang'] }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $row['qty_barang'] }} {{ ucfirst($row['satuan_barang']) }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-gray-800">
                            <td colspan="4" class="px-6 py-4 text-center text-sm font-semibold italic text-red-500">
                                Packing list belum ditambah.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        {{-- end table barang --}}
    @endif

    {{-- form tambah info pengiriman --}}
    <div id="accordion-packing-form"
        class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
        x-data="{ accordionOpen: false }">

        {{-- Accordion Trigger --}}
        <button type="button"
            class="flex w-full items-center justify-between gap-3 p-5 text-left transition-colors duration-200 hover:bg-zinc-50 dark:hover:bg-zinc-800/50"
            @click="accordionOpen = !accordionOpen">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-500/20">
                    <x-icons.truck class="h-4 w-4" />
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">Tambah Riwayat Pengiriman</h3>
                    <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Klik untuk membuka form pengiriman</p>
                </div>
            </div>
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 transition-all duration-300 dark:bg-zinc-800"
                :class="accordionOpen ? 'rotate-180 bg-blue-50 dark:bg-blue-950/30' : ''">
                <x-icons.carred-down class="h-4 w-4 text-zinc-500 dark:text-zinc-400" />
            </div>
        </button>

        {{-- Accordion Body --}}
        <div x-show="accordionOpen" x-collapse x-cloak>
            <div class="border-t border-zinc-200 dark:border-zinc-800">
                <div class="p-5 lg:p-6">
                    <p class="mb-5 text-sm font-medium text-zinc-500 dark:text-zinc-400">
                        Silakan perbarui informasi pengiriman pada form di bawah ini untuk barang yang telah selesai diproses.
                    </p>

                    <form wire:submit.prevent="store" class="grid grid-cols-1 gap-5 lg:grid-cols-2">

                        {{-- Tipe Pengiriman --}}
                        <div class="col-span-2">
                            <x-input.select id="via" name="via" :labels="true" :textLabel="'Tipe Pengiriman'"
                                :defaultOption="'Pilih tipe pengiriman'" :options="[
                                    'laut' => 'Laut / Container',
                                    'darat' => 'Darat / Truck',
                                    'supir' => 'Supir Perusahaan',
                                ]" wire:model.live="form.via" />
                            @error('form.via')
                                <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Pilih Barang --}}
                        @if (isset($spk_data->production->packing_list) && $form->via !== 'supir')
                            <div class="col-span-2">
                                <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white">
                                    Pilih Barang yang Dikirim
                                </label>
                                <div class="flex flex-col gap-2">
                                    @forelse ($spk_data->production->packing_list as $index => $row)
                                        <label for="cb-{{ $index }}"
                                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-zinc-200 p-3 transition-colors hover:bg-zinc-50 dark:border-zinc-800 dark:hover:bg-zinc-800/50">
                                            <input type="checkbox" id="cb-{{ $index }}"
                                                value="{{ $row['id_barang'] }}" wire:model="form.products"
                                                class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-700">
                                            <span class="text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                                {{ $row['nama_barang'] }}
                                            </span>
                                        </label>
                                    @empty
                                        <div class="flex items-center gap-2 rounded-xl border border-dashed border-zinc-200 p-3 dark:border-zinc-800">
                                            <x-icons.exclamation-circle class="h-4 w-4 shrink-0 text-red-500" />
                                            <span class="text-xs font-medium italic text-red-500">Tidak ada barang dalam packing list.</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endif

                        {{-- Laut --}}
                        @if ($form->via === 'laut')
                            <div class="col-span-2 lg:col-span-1">
                                <x-input.basic id="partay" name="partay" placeholder="Masukkan nomor partay.."
                                    wire:model="form.partay">Partay</x-input.basic>
                                @error('form.partay')
                                    <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <x-input.basic id="no_container" name="no_container"
                                    placeholder="Masukkan nomor container.." wire:model="form.no_container">
                                    No. Container
                                </x-input.basic>
                                @error('form.no_container')
                                    <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <x-input.basic id="nama_kapal" name="nama_kapal" placeholder="Masukkan nama kapal.."
                                    wire:model="form.nama_kapal">Nama Kapal</x-input.basic>
                                @error('form.nama_kapal')
                                    <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        {{-- Darat / Supir --}}
                        @if ($form->via === 'darat' || $form->via === 'supir')

                            {{-- Supir Perusahaan: SR + Cari Supir --}}
                            @if ($form->via === 'supir')
                                <div class="col-span-2">
                                    <div class="flex items-end gap-3">
                                        <div class="grow">
                                            <x-input.basic type="text" id="nomor_sr" name="nomor_sr"
                                                wire:model="form.nomor_sr" placeholder="SR-XXXXXXXX">
                                                Nomor SR
                                                <span class="font-normal text-zinc-500">(SPK: {{ strtoupper($spk_data->tipe_tagihan) }})</span>
                                            </x-input.basic>
                                            @error('form.nomor_sr')
                                                <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <x-button.primary class="h-fit shrink-0" wire:click="fetchSR">
                                            <span wire:loading.remove wire:target="fetchSR">Fetch</span>
                                            <span wire:loading wire:target="fetchSR">Loading...</span>
                                        </x-button.primary>
                                    </div>

                                    <div wire:show="show_customer"
                                        class="mt-3 rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">
                                        <p class="text-sm font-bold text-zinc-900 dark:text-white">{{ $nama_customer }}</p>
                                        <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">{{ $alamat_customer }}</p>
                                    </div>
                                </div>

                                <div class="col-span-2 lg:col-span-1">
                                    <x-input.basic id="search_supir" name="search_supir"
                                        placeholder="Cari nama atau kode jari supir.."
                                        wire:model.live="search_supir">
                                        Cari Supir
                                    </x-input.basic>
                                    <p class="mt-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                        *Dapat mencari berdasarkan nama atau kode jari supir.
                                    </p>

                                    @if (count($drivers))
                                        <div class="mt-2 overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
                                            @foreach ($drivers as $driver)
                                                <button type="button"
                                                    class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800 {{ !$loop->last ? 'border-b border-zinc-200 dark:border-zinc-800' : '' }}"
                                                    wire:click="selectDriver('{{ $driver->kode_pegawai }}', '{{ $driver->name }}')">
                                                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-xs font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                                        {{ strtoupper(substr($driver->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-zinc-900 dark:text-white">{{ $driver->name }}</p>
                                                        <p class="text-xs text-zinc-500">{{ $driver->kode_pegawai }}</p>
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Nama Supir --}}
                            <div class="{{ $form->via === 'supir' ? 'col-span-2 lg:col-span-1' : 'col-span-2 lg:col-span-1' }}">
                                <x-input.basic id="nama_supir" name="nama_supir" placeholder="Masukkan nama supir.."
                                    wire:model="form.nama_supir">Nama Supir</x-input.basic>
                                @if ($form->via === 'supir')
                                    <p class="mt-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                        *Otomatis terisi jika memilih supir dari daftar di atas.
                                    </p>
                                @endif
                                @error('form.nama_supir')
                                    <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Darat: Telp + Plat --}}
                            @if ($form->via === 'darat')
                                <div class="col-span-2 lg:col-span-1">
                                    <x-input.basic id="no_telp_supir" name="no_telp_supir"
                                        placeholder="Masukkan nomor telepon supir.." wire:model="form.no_telp_supir">
                                        No. Telp Supir
                                    </x-input.basic>
                                    @error('form.no_telp_supir')
                                        <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-span-2">
                                    <x-input.basic id="no_plat" name="no_plat" placeholder="Masukkan nomor plat.."
                                        wire:model="form.no_plat">
                                        Nomor Plat Kendaraan
                                    </x-input.basic>
                                    @error('form.no_plat')
                                        <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        @endif

                        {{-- Berat --}}
                        <div class="col-span-2">
                            <x-input.basic id="berat" name="berat" placeholder="Masukkan estimasi berat barang.."
                                wire:model="form.berat">
                                Estimasi Berat Total Barang
                            </x-input.basic>
                            @error('form.berat')
                                <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- ETD & ETA --}}
                        <div class="col-span-2 lg:col-span-1">
                            <x-input.basic id="etd" name="etd" wire:model="form.etd" type="date">
                                Estimasi Waktu Berangkat
                            </x-input.basic>
                            @error('form.etd')
                                <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 lg:col-span-1">
                            <x-input.basic id="eta" name="eta" wire:model="form.eta" type="date">
                                Estimasi Waktu Sampai
                            </x-input.basic>
                            @error('form.eta')
                                <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Catatan --}}
                        <div class="col-span-2">
                            <x-input.textarea id="note" name="note" wire:model="form.note" :textLabel="'Catatan'" />
                            @error('form.note')
                                <span class="mt-1.5 block text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="col-span-2 flex items-center justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                            <x-button.secondary type="button" wire:click="clearForm" id="clearFormBtn">
                                <span wire:loading.remove wire:target="clearForm">Reset Form</span>
                                <span wire:loading wire:target="clearForm">Mereset...</span>
                            </x-button.secondary>
                            <x-button.primary type="submit" id="submitBtn">
                                <span wire:loading.remove wire:target="store">Simpan Pengiriman</span>
                                <span wire:loading wire:target="store">Menyimpan...</span>
                            </x-button.primary>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end form tambah info pengiriman --}}

    @livewire('handler.spk.delivery-barang-list', ['id' => $spk_data->id])
</div>
