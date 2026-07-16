{{-- Goal: Handler for updating delivery info, Caller: delivery.edit, Livewire: Handler\Spk\DeliveryUpdate --}}
<div class="flex flex-col gap-6">

    @if (!$spk_data->is_using_company_driver)
        {{-- Table Barang dari Packing List --}}
        <div class="space-y-3">
            <div class="flex items-center gap-2">
                <x-icons.archive class="h-4 w-4 text-zinc-400" />
                <h4 class="text-sm font-bold text-zinc-900 dark:text-white">Data Packing List</h4>
            </div>

            <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow dark:border-zinc-800"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <table class="w-full text-left text-sm">
                    <thead
                        class="bg-zinc-50 text-[10px] font-bold uppercase tracking-wider text-zinc-500 dark:bg-zinc-800/50 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 text-center">#</th>
                            <th class="px-4 py-3">Ekspedisi</th>
                            <th class="px-4 py-3">Barang</th>
                            <th class="px-4 py-3 text-center">Jumlah</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @if (isset($spk_data->production->packing_list))
                            @foreach ($spk_data->production->packing_list as $index => $row)
                                <tr class="transition-colors hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30">
                                    <td class="px-4 py-3 text-center font-mono text-xs text-zinc-400">
                                        {{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-medium text-zinc-900 dark:text-white">
                                        {{ $row['nama_ekspedisi'] }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">{{ $row['nama_barang'] }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-flex items-center rounded-full bg-zinc-100 px-2 py-0.5 text-xs font-bold text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200">
                                            {{ $row['qty_barang'] }} {{ ucfirst($row['satuan_barang']) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm italic text-red-500">
                                    Packing list belum tersedia.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Form Tambah Riwayat Pengiriman --}}
    <x-utils.accordion-item id="accordion-delivery-form" title="Tambah Riwayat Pengiriman"
        description="Catat logistik pengiriman barang baru" iconColor="blue" :expanded="false">
        <x-slot:icon>
            <x-icons.truck class="h-4 w-4" />
        </x-slot:icon>

        <form wire:submit.prevent="store" class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Metode Pengiriman --}}
            <div
                class="col-span-2 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-zinc-800/30">
                <x-input.select id="via" name="via" :labels="true" :textLabel="'Metode Logistik'" :defaultOption="'Pilih tipe pengiriman'"
                    :options="[
                        'laut' => 'Laut / Container',
                        'darat' => 'Darat / Trucking',
                        'supir' => 'Kurir / Supir Perusahaan',
                    ]" wire:model.live="form.via" />

                @error('form.via')
                    <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Checklist Barang --}}
            @if (isset($spk_data->production->packing_list) && $form->via !== 'supir')
                <div class="col-span-2 space-y-3">
                    <label class="text-sm font-bold text-zinc-900 dark:text-white">Pilih Item yang Dikirim</label>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        @forelse ($spk_data->production->packing_list as $index => $row)
                            <label for="cb-{{ $index }}"
                                wire:key="product-{{ $index }}-{{ $row['id_barang'] }}"
                                class="group relative flex cursor-pointer items-center gap-3 rounded-xl border border-zinc-200 bg-white p-3 transition-all hover:border-blue-400 hover:bg-blue-50/30 dark:border-zinc-800 dark:hover:border-blue-500/50"
                                x-bind:class="dynamicBg ?
                                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                <input type="checkbox" id="cb-{{ $index }}" value="{{ $row['id_barang'] }}"
                                    wire:model.live="form.products"
                                    class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800">
                                <div class="flex flex-col">
                                    <span
                                        class="text-xs font-bold text-zinc-900 dark:text-white">{{ $row['nama_barang'] }}</span>
                                    <span class="text-[10px] text-zinc-500">{{ $row['nama_ekspedisi'] }}</span>
                                </div>
                            </label>
                        @empty
                            <div
                                class="col-span-2 rounded-xl border border-dashed border-red-200 bg-red-50/30 p-4 text-center dark:border-red-900/30">
                                <p class="text-xs font-medium italic text-red-500">Tidak ada barang dalam antrean
                                    packing.</p>
                            </div>
                        @endforelse
                    </div>

                    @if (empty($form->products))
                        <span class="mt-2 text-xs font-bold text-red-600 dark:text-red-400">
                            Pilih minimal 1 barang yang dikirim.
                        </span>
                    @endif

                    @error('form.products')
                        <span class="mt-2 text-xs font-bold text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            {{-- Detail Laut --}}
            @if ($form->via === 'laut')
                <div class="col-span-2 grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div>
                        <x-input.basic id="partay" name="partay" placeholder="Contoh: Partay 01"
                            wire:model="form.partay">Nomor Partay</x-input.basic>
                        @error('form.partay')
                            <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <x-input.basic id="no_container" name="no_container" placeholder="Contoh: CONT-12345"
                            wire:model="form.no_container">No. Container</x-input.basic>
                        @error('form.no_container')
                            <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="lg:col-span-2">
                        <x-input.basic id="nama_kapal" name="nama_kapal" placeholder="Contoh: KM. Meratus Jaya"
                            wire:model="form.nama_kapal">Nama Kapal</x-input.basic>
                        @error('form.nama_kapal')
                            <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- Detail Supir Perusahaan --}}
            @if ($form->via === 'supir')
                <div class="col-span-2 space-y-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                        <div class="grow">
                            <x-input.basic id="nomor_sr" name="nomor_sr" wire:model="form.nomor_sr"
                                placeholder="Input nomor SR (Surat Road)...">
                                Nomor SR
                                <span class="ml-1 text-[10px] font-normal italic text-zinc-400">(SPK:
                                    {{ strtoupper($spk_data->tipe_tagihan) }})</span>
                            </x-input.basic>
                            @error('form.nomor_sr')
                                <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <x-button.primary class="shrink-0 !py-2.5" wire:click="fetchSR" wire:loading.attr="disabled"
                            wire:target="fetchSR">
                            <x-slot name="icon">
                                <x-icons.angle-right wire:loading.remove wire:target="fetchSR" class="icon h-5 w-5" />
                                <x-icons.loading wire:loading wire:target="fetchSR" class="h-4 w-4 animate-spin" />
                            </x-slot>

                            <span wire:loading.remove wire:target="fetchSR">Fetch Data</span>
                            <span wire:loading wire:target="fetchSR">Memuat...</span>
                        </x-button.primary>
                    </div>

                    <div x-show="$wire.show_customer" x-transition
                        class="flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50/50 p-4 dark:border-blue-900/30 dark:bg-blue-900/20">
                        <x-icons.check-circle class="mt-0.5 h-5 w-5 text-blue-500" />
                        <div>
                            <p class="text-sm font-bold text-blue-900 dark:text-blue-200">{{ $nama_customer }}</p>
                            <p class="text-xs text-blue-700 dark:text-blue-400">{{ $alamat_customer }}</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-input.basic id="search_supir" name="search_supir" placeholder="Ketik nama atau NIK supir..."
                            wire:model.live="search_supir">Cari Supir Perusahaan</x-input.basic>

                        @if (count($drivers))
                            <div class="max-h-48 overflow-y-auto rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800"
                                x-bind:class="dynamicBg ?
                                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                @foreach ($drivers as $driver)
                                    <button type="button"
                                        class="flex w-full items-center gap-3 border-b border-zinc-100 px-4 py-2.5 text-left transition-all last:border-0 hover:bg-blue-50 dark:border-zinc-800 dark:hover:bg-blue-900/20"
                                        wire:click="selectDriver('{{ $driver->kode_pegawai }}', '{{ $driver->name }}')">
                                        <div
                                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-[10px] font-bold text-zinc-500 dark:bg-zinc-800">
                                            {{ strtoupper(substr($driver->name, 0, 2)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-xs font-bold text-zinc-900 dark:text-white">{{ $driver->name }}</span>
                                            <span
                                                class="font-mono text-[10px] text-zinc-500">{{ $driver->kode_pegawai }}</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Detail Darat / Input Nama Supir --}}
            @if ($form->via === 'darat' || $form->via === 'supir')
                <div class="col-span-2 grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="lg:col-span-{{ $form->via === 'darat' ? '1' : '2' }}">
                        <x-input.basic id="nama_supir" name="nama_supir" placeholder="Input nama pengemudi..."
                            wire:model="form.nama_supir">
                            Nama Supir
                        </x-input.basic>
                        @error('form.nama_supir')
                            <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                        @enderror
                        @if ($form->via === 'supir')
                            <p class="mt-1 text-[10px] italic text-blue-500">*Otomatis terisi jika memilih dari daftar
                            </p>
                        @endif
                    </div>

                    @if ($form->via === 'darat')
                        <div>
                            <x-input.basic id="no_telp_supir" name="no_telp_supir" placeholder="Contoh: 0812..."
                                wire:model="form.no_telp_supir">No. Telp Supir</x-input.basic>
                            @error('form.no_telp_supir')
                                <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="lg:col-span-2">
                            <x-input.basic id="no_plat" name="no_plat" placeholder="Contoh: B 1234 ABC"
                                wire:model="form.no_plat">Nomor Plat Kendaraan</x-input.basic>
                            @error('form.no_plat')
                                <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>
            @endif

            {{-- Berat & Estimasi --}}
            <div class="col-span-2 grid grid-cols-1 gap-4 lg:grid-cols-3">
                <div>
                    <x-input.basic id="berat" name="berat" placeholder="Contoh: 500kg / 2 Ton"
                        wire:model="form.berat">Estimasi Berat</x-input.basic>
                    @error('form.berat')
                        <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-input.basic id="etd" name="etd" wire:model="form.etd" type="date">Tgl.
                        Keberangkatan</x-input.basic>
                    @error('form.etd')
                        <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-input.basic id="eta" name="eta" wire:model="form.eta" type="date">Estimasi
                        Tiba</x-input.basic>
                    @error('form.eta')
                        <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Catatan --}}
            <div class="col-span-2">
                <x-input.textarea id="note" name="note" wire:model="form.note" :textLabel="'Catatan Logistik'"
                    placeholder="Ketik catatan pengiriman di sini..." />
                @error('form.note')
                    <span class="mt-1.5 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- Submit Actions --}}
            <div
                class="col-span-2 flex items-center justify-end gap-3 border-t border-zinc-100 pt-6 dark:border-zinc-800">
                <x-button.secondary type="button" wire:click="clearForm" class="!px-6">Reset</x-button.secondary>

                <x-button.primary type="submit" wire:loading.attr="disabled" wire:target="store">
                    <x-slot name="icon">
                        <x-icons.angle-right wire:loading.remove wire:target="store" class="icon h-5 w-5" />
                        <x-icons.loading wire:loading wire:target="store" class="h-4 w-4 animate-spin" />
                    </x-slot>
                    <span wire:loading.remove wire:target="store">Simpan Pengiriman</span>
                    <span wire:loading wire:target="store" class="flex items-center gap-2"> Menyimpan... </span>
                </x-button.primary>
            </div>

        </form>
    </x-utils.accordion-item>

    {{-- Riwayat List --}}
    <livewire:handler.spk.delivery-barang-list :id="$spk_data->id" />
</div>
