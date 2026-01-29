<div class="flex flex-col gap-4">
    <div class="relative flex flex-col rounded-lg text-gray-800 ring-1 ring-gray-200 dark:text-white dark:ring-gray-700">

        {{-- informasi spk --}}
        <div class="grid grid-cols-2 rounded-t-lg bg-gray-50 transition-all duration-500 dark:bg-gray-700">

            <div
                class="{{ auth()->user()->cannot('spk-create') ? '' : 'lg:col-span-1 ' }} col-span-2 rounded-t-lg border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:rounded-tl-lg lg:rounded-tr-none">
                <p class="text-xs italic">Nomor Order </p>
                <div class="flex flex-col gap-y-2 font-semibold">
                    <div class="flex items-center gap-x-2">
                        <p> {{ $data->nomor_order }} </p>

                        @php
                            $color = match ($data->status_approval) {
                                0 => 'yellow',
                                1 => 'green',
                                2 => 'red',
                                3 => 'yellow',
                                default => 'yellow',
                            };
                        @endphp

                        <span
                            class="bg-{{ $color }}-500 text-{{ $color }}-700 rounded-full px-2 py-1 text-xs">
                            {{ $data->status_approval_description }}
                        </span>

                        @if ($data->is_booked)
                            <span
                                class='flex w-fit items-center justify-center rounded-full bg-blue-500 px-2 py-1.5 text-xs text-blue-800'>
                                Booked
                            </span>
                        @endif
                    </div>

                    @if ($data->status_approval != 1 && auth()->user()->can('spk-validate'))
                        <x-button.primary class="w-fit text-sm" id="btn-validate-spk" wire:click="validateSpk">
                            Validasi
                        </x-button.primary>
                    @endif
                </div>
            </div>

            @if (auth()->user()->can('spk-create') || auth()->user()->can('spk-validate'))
                <div
                    class="col-span-2 flex flex-col gap-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1 lg:rounded-tr-lg">
                    <div>
                        <p class="text-xs italic">Tipe Tagihan</p>
                        <p class="font-semibold"> {{ $data->tipe_tagihan }} </p>
                    </div>

                    <div>
                        <p class="text-xs italic">No. Dokumen Penawaran</p>
                        <p class="font-semibold"> {{ $data->nomor_dokumen_penawaran ?? 'Belum diatur.' }} </p>
                    </div>
                </div>

                <div
                    class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                    <p class="text-xs italic"> Nomor Tagihan </p>
                    <p class="font-semibold">
                        {{ $data->status_nomor_tagihan ? $data->nomor_tagihan : $data->status_nomor_tagihan_description }}
                    </p>
                </div>

                <div
                    class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                    <p class="text-xs italic">Tipe Bayar </p>
                    <p class="font-semibold"> {{ $data->tipe_bayar }}</p>
                </div>
            @endif

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic">Tanggal Cetak </p>
                <p class="font-semibold">
                    {{ $data->tgl_cetak ? \Carbon\Carbon::parse($data->tgl_cetak)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic">Waktu Penyerahan</p>
                <p class="font-semibold">
                    {{ $data->tgl_kirim }} Hari
                    {{ $data->tgl_kirim <= 1 ? '(SEGERA)' : '' }}
                </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic">Nama Customer </p>
                <p class="font-semibold"> {{ $data->customer['nama_perusahaan'] ?? 'N/A' }} </p>


                @hasanyrole(['Admin', 'Marketing', 'Management', 'Management-Special'])
                    <p class="text-sm"> {{ $data->customer['contact_person'] ?? '-' }}
                        (telp: {{ $data->customer['no_hp'] ?? '-' }})
                    </p>
                    <p class="text-sm"> {{ $data->customer['alamat'] ?? '-' }} </p>'
                @endhasanyrole
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Produk Dipesan </p>
                <p class="text-sm font-semibold capitalize">
                    {{ $data->tipe_timbangan ?? 'Tipe timbangan tidak diatur.' }} </p>
                <ul class="ml-5 list-disc text-sm font-semibold">
                    @forelse ($data->products as $row)
                        <li>
                            {{ $row['jumlah_unit'] ?? '' }}
                            {{ $row['satuan_barang'] ?? '' }}
                            {{ $row['nama_barang'] ?? '' }}
                        </li>
                    @empty
                        Tidak ada produk dipesan
                    @endforelse
                </ul>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Ditambah Oleh </p>
                <p class="font-semibold capitalize"> {{ $data->addedBy->name }}</p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Diproduksi Oleh </p>
                <p class="font-semibold capitalize"> {{ $data->assignTo->name ?? '-' }}</p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Divalidasi Oleh </p>
                <p class="font-semibold capitalize"> {{ $data->approvedBy->name ?? '-' }}</p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Divalidasi Pada </p>
                <p class="font-semibold capitalize">
                    {{ $data->approved_at
                        ? \Carbon\Carbon::parse($data->approved_at)->locale('id')->isoFormat('D MMMM Y HH:mm:ss')
                        : '-' }}
                </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white">
                <p class="text-xs italic"> Request Fondasi </p>
                <div
                    class="mt-2 flex flex-col divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white shadow-sm dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-700">
                    @forelse ($this->filteredAttachmentsOnlyRequestFondasi as $index => $row)
                        <a href="{{ route('spk.attachment.download', $row['url']) }}"
                            class="p-2 transition hover:bg-gray-50 dark:hover:bg-gray-800">
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                {{ $row['nama_file'] }}
                            </p>
                            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                {{ $row['tipe_dokumen'] }}
                            </p>
                        </a>
                    @empty
                        <p class="text-xs font-semibold capitalize italic">
                            Tidak ada request fondasi dari Customer.
                        </p>
                    @endforelse
                </div>
            </div>

            @if (auth()->user()->can('spk-validate') || auth()->user()->can('spk-create'))
                <div
                    class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white">
                    <p class="text-xs italic"> Lampiran </p>

                    <div
                        class="mt-2 flex flex-col divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white shadow-sm dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-700">
                        @forelse ($this->filteredAttachmentsExcludeRequestFondasi as $index => $row)
                            <a href="{{ route('spk.attachment.download', $row['url']) }}"
                                class="p-2 transition hover:bg-gray-50 dark:hover:bg-gray-800">
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                    {{ $row['nama_file'] }}
                                </p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $row['tipe_dokumen'] }}
                                </p>
                            </a>
                        @empty
                            <p class="text-xs font-semibold capitalize italic">
                                Tidak ada lampiran.
                            </p>
                        @endforelse
                    </div>

                </div>
            @endif

        </div>
        {{-- end informasi spk --}}

        {{-- progress spk --}}
        <div
            class="{{ $data->on_delay ? 'overflow-hidden' : 'overflow-x-scroll' }} relative flex w-full flex-row items-center gap-2 dark:text-white">
            @php
                $status = [
                    [
                        'status' => 0,
                        'desc' => 'SPK telah dibuat',
                        'icon' => 'spk-selesai.webp',
                    ],
                    [
                        'status' => 1,
                        'desc' => 'Dalam proses produksi',
                        'icon' => 'diproduksi.webp',
                    ],
                    [
                        'status' => 2,
                        'desc' => 'Dalam proses pengiriman',
                        'icon' => 'dikirim.webp',
                    ],
                    [
                        'status' => 3,
                        'desc' => 'Dalam proses penagihan',
                        'icon' => 'penagihan.webp',
                    ],
                    [
                        'status' => 4,
                        'desc' => 'Dalam proses pemasangan',
                        'icon' => 'pemasangan.webp',
                    ],
                    [
                        'status' => 5,
                        'desc' => 'Selesai',
                        'icon' => 'selesai.webp',
                    ],
                ];
            @endphp

            @foreach ($status as $item)
                <x-icons.spk-delivery-status :desc="$item['desc']" :itemstatus="$item['status']" :status="$data->status" :icon="$item['icon']"
                    :last="$loop->last" :ping="$item['status'] == $data->status" />
            @endforeach

            @if ($data->on_delay)
                <div
                    class="absolute left-0 top-0 z-10 flex h-full w-full items-center justify-center rounded-b-lg bg-red-500/75 text-white">
                    <div class="flex flex-col gap-1">
                        <p class="text-center text-sm">
                            {{ $data->on_delay_at }}
                        </p>
                        <p class="rounded-full bg-red-500 px-4 py-1 text-center font-semibold italic shadow-md">
                            SPK mengalami delay.
                        </p>
                        <p class="text-center text-sm">
                            {{ $data->on_delay_notes }} (by: {{ $data->onDelayBy->name }})
                        </p>
                    </div>
                </div>
            @endif
        </div>
        {{-- end progress spk --}}

        {{-- download button --}}
        @if ($data->status_approval === 1)
            <div
                class="flex justify-center gap-x-1 rounded-b-lg bg-gray-50 p-2 text-center dark:bg-gray-700 lg:absolute lg:right-0 lg:top-0 lg:rounded-none lg:bg-transparent lg:p-0">
                @can('spk-create')
                    <x-button.primary id="spk-pdf-export" wire:click="export">
                        Ekspor SPK
                    </x-button.primary>
                @endcan

                @hasanyrole(['Produksi', 'Admin', 'Management'])
                    <x-button.link
                        class="ring-1 ring-blue-700 hover:bg-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
                        href="{{ route('spk.generate.pdf', ['id' => $data->id]) }}" id="spk-pdf-export">
                        Ekspor SPK (Produksi)
                    </x-button.link>
                @endhasanyrole
            </div>
        @endif
        {{-- end download button --}}
    </div>

    @can('spk-history')
        {{-- riwayat spk --}}
        <section class="rounded-lg text-gray-800 ring-1 ring-gray-200 dark:text-white dark:ring-gray-700 lg:gap-4">

            <div
                class="{{ $showRiwayatSpk ? 'rounded-t-lg' : 'rounded-lg' }} flex flex-row items-center justify-between p-2.5 transition-all duration-500 ease-in-out hover:cursor-pointer hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-800">
                <h3 class="text-lg font-[900] text-red-600 dark:text-white">
                    Riwayat SPK
                </h3>

                <div>
                    <x-button.primary class="w-fit" wire:click="$toggle('showRiwayatSpk')">
                        <x-icons.carred-down
                            class="{{ $showRiwayatSpk ? 'rotate-180' : '' }} h-5 w-5 transition-all duration-300 ease-in-out dark:text-white" />
                    </x-button.primary>
                </div>
            </div>

            @if ($showRiwayatSpk)
                <div class="flex flex-col gap-2 p-2 lg:gap-4 lg:p-4">
                    @forelse ($spkHistories as $row)
                        <div class="border-b border-gray-200 p-1 text-gray-800 dark:border-gray-600 dark:text-white">
                            <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                                <div class="text-right text-xs lg:text-left">
                                    <p>
                                        Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}</p>
                                    <p>
                                        {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}</p>
                                </div>

                                <div>
                                    <h4 class="text-base font-semibold"> {{ $row->title }} </h4>
                                    <p class="text-sm"> {{ $row->keterangan }} </p>
                                </div>
                            </div>

                            <p class="text-right text-xs italic">Oleh: {{ $row->addedBy->name }}</p>
                        </div>
                    @empty
                        <p class="text-center text-sm">
                            Belum ada riwayat SPK.
                        </p>
                    @endforelse

                    {{ $spkHistories->links(data: ['scrollTo' => false]) }}
                </div>
            @endif
        </section>
        {{-- end riwayat spk --}}
    @endcan

    {{-- laporan fondasi --}}
    @can('laporan-fondasi-list')
        <section class="rounded-lg text-gray-800 ring-1 ring-gray-200 dark:text-white dark:ring-gray-700 lg:gap-4">

            <div
                class="{{ $showLaporanFondasi ? 'rounded-t-lg' : 'rounded-lg' }} z-0 flex flex-row items-center justify-between gap-2 p-2.5 transition-all duration-500 ease-in-out hover:cursor-pointer hover:bg-gray-50 dark:bg-gray-700 dark:hover:bg-gray-800 lg:gap-4">
                <div class="w-fit text-nowrap">
                    <h3 class="text-lg font-[900] text-red-600 dark:text-white">
                        Laporan Fondasi
                    </h3>
                </div>

                <div class="relative hidden w-full rounded-full bg-blue-200 lg:block">
                    <div class="flex h-6 items-center justify-center gap-2 rounded-full bg-blue-600 p-0.5"
                        style="width: {{ $laporanFondasiLastProgress['value'] }}%">
                    </div>

                    <div
                        class="absolute left-1/2 top-1/2 flex -translate-x-1/2 -translate-y-1/2 flex-row text-center text-xs font-medium leading-none text-white">
                        <span>{{ $laporanFondasiLastProgress['value'] }}%</span>
                        {{-- <span>({{ $laporanFondasiLastProgress['description'] }})</span> --}}
                    </div>
                </div>

                <div class="flex flex-row gap-x-2">
                    @can('laporan-fondasi-create')
                        <x-button.success wire:click="openCreateLaporanFondasiModal" class="z-10 w-fit">
                            <x-icons.plus class="h-5 w-5 dark:text-white" />
                        </x-button.success>
                    @endcan

                    <x-button.primary class="w-fit" wire:click="$toggle('showLaporanFondasi')">
                        <x-icons.carred-down
                            class="{{ $showLaporanFondasi ? 'rotate-180' : '' }} h-5 w-5 transition-all duration-300 ease-in-out dark:text-white" />
                    </x-button.primary>
                </div>
            </div>

            @if ($showLaporanFondasi)
                <div class="flex flex-col gap-2 p-2 lg:gap-4 lg:p-4">
                    @forelse ($laporanFondasi as $row)
                        <div
                            class="flex flex-col gap-2 border-b border-gray-200 pb-2 text-gray-800 dark:border-gray-600 dark:text-white">
                            <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                                <div class="text-right text-xs lg:text-left">
                                    <p>Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}</p>
                                    <p>{{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}
                                    </p>
                                </div>

                                <div class="flex flex-col">
                                    <h4 class="text-base font-semibold"> {{ $row->judul }} </h4>
                                    <p class="text-sm"> {{ $row->keterangan }} </p>

                                    @if (count($row->dokumentasi) > 0)
                                        <div class="mt-2 flex w-full flex-row gap-2 overflow-x-auto">
                                            @foreach ($row->dokumentasi as $i => $img)
                                                <img class="h-20 w-20 rounded-xl object-cover"
                                                    id="documentations-{{ $i }}"
                                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                                    data-url="{{ asset('storage/' . $img['path_file']) }}"
                                                    src="{{ asset('storage/' . $img['path_file']) }}" alt=""
                                                    onclick="javascript:void(0)" loading="lazy">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-row justify-between text-xs">
                                <p class="rounded-lg bg-green-500 px-2 py-0.5">{{ $row->status_pengerjaan_description }}
                                </p>
                                <p class="text-right italic">Oleh: {{ $row->addedBy->name }}</p>
                            </div>

                            <div class="flex flex-row justify-end gap-2 text-xs">
                                @can('laporan-fondasi-edit')
                                    <a class="cursor-pointer text-gray-500 hover:underline"
                                        wire:click="editLaporanFondasi('{{ $row->id }}')">Edit</a>
                                @endcan

                                @can('laporan-fondasi-delete')
                                    <a class="cursor-pointer text-red-500 hover:underline"
                                        wire:click="deleteLaporanFondasi('{{ $row->id }}')">Delete</a>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-sm">
                            Belum ada laporan fondasi.
                        </p>
                    @endforelse

                    {{ $laporanFondasi->links(data: ['scrollTo' => false]) }}
                </div>
            @endif
        </section>
        {{-- end laporan fondasi --}}
    @endcan

    {{-- modal tambah laporan Fondasi --}}
    <div id="laporan-fondasi-modal" wire:show="showModalAddLaporanFondasi" wire:transition.duration.300ms
        class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-70 py-8">

        @if ($showModalAddLaporanFondasi)
            <div class="mx-4 my-6 flex w-full flex-col gap-1 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary md:w-2/3 md:gap-2 lg:w-1/2 xl:w-2/5"
                style="max-height: calc(100vh - 6rem);">

                <h2 class="mb-2 text-center text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                    {{ $isEditing ? 'Edit' : 'Tambah' }} Laporan Fondasi
                </h2>

                <form wire:submit="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}"
                    class="flex w-full flex-col gap-2 lg:gap-4">

                    <div class="w-full">
                        <x-input.basic name="title" id="title" wire:model="form.title">
                            Judul Laporan
                        </x-input.basic>

                        @error('form.title')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (!$isEditing)
                        <div class="w-full">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="documentations">Dokumentasi</label>


                            <div class="flex w-full flex-col gap-y-2">
                                <label for="documentations"
                                    class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 transition-all duration-500 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-800">
                                    <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                        <x-icons.cloud-upload class="mb-2 h-8 w-8 text-gray-500 dark:text-gray-400" />
                                        <p class="mb-0.5 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-semibold"> Klik untuk upload</span>
                                        </p>
                                        <p class="w-full text-center text-xs text-gray-500 dark:text-gray-400">
                                            *Dokumentasi dapat berupa <b>foto dokumen BTT, resi </b> atau lainnya (PNG,
                                            JPG,
                                            Jpeg)
                                        </p>
                                    </div>
                                    <input id="documentations" name="documentations" type="file" accept="image/*"
                                        wire:model.live="form.newDocumentations" class="hidden" multiple />
                                </label>
                            </div>

                            @if ($form->documentations)
                                <div class="mt-2 flex flex-col gap-2">
                                    <div
                                        class="dark:highlight-white/5 relative min-w-0 overflow-auto rounded-xl border border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700">

                                        <div class="flex overflow-x-scroll">

                                            @foreach ($form->documentations as $index => $doc)
                                                <div class="flex-none px-1.5 py-3 first:pl-3 last:pr-3">
                                                    <div
                                                        class="relative flex flex-col items-center justify-center gap-3">
                                                        <img class="w-24 rounded-lg"
                                                            src="{{ $doc->temporaryUrl() }}">
                                                        <button type="button"
                                                            class="absolute end-0 top-0 rounded-lg bg-red-500 p-1 text-white hover:bg-red-600"
                                                            wire:click="removeDocumentation({{ $index }})">
                                                            <x-icons.close class="h-4 w-4" />
                                                        </button>
                                                        <p class="text-xs text-gray-600 dark:text-white">
                                                            @php
                                                                $name = $doc->getClientOriginalName();
                                                                $label =
                                                                    strlen($name) > 10
                                                                        ? substr($name, 0, 5) .
                                                                            '...' .
                                                                            substr($name, -5)
                                                                        : $name;
                                                            @endphp
                                                            {{ $label }}
                                                        </p>
                                                    </div>
                                                </div>

                                                @php
                                                    $total = $index + 1;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>

                                    <p class="text-xs text-gray-600 dark:text-gray-100">Total {{ $total ?? '0' }}
                                        file.
                                    </p>

                                </div>
                            @endif

                            @error('form.newDocumentations.*')
                                <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                            @error('form.documentations')
                                <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                            @error('form.documentations.*')
                                <span class="error mt-2 text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <div class="w-full">
                        <x-input.select id="progress" name="progress" :labels="true" :textLabel="'Progres Pengerjaan'"
                            :defaultOption="'Pilih Status'" :options="[
                                10 => 'Persiapan bahan',
                                33 => 'Tahap 1',
                                50 => 'Tahap 2',
                                88 => 'Finishing',
                                100 => 'Selesai',
                            ]" wire:model="form.progress" />

                        @error('form.progress')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-full">
                        <x-input.textarea :textLabel="'Keterangan'" wire:model="form.description" id="keterangan"
                            name="keterangan" :rows="8" />

                        @error('form.description')
                            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex w-full justify-end space-x-2">
                        <x-button.success id="save-laporan-fondasi" type="submit">
                            <span wire:loading.remove
                                wire:target="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}">
                                {{ $isEditing ? 'Update' : 'Simpan' }}
                            </span>
                            <span wire:loading
                                wire:target="{{ $isEditing ? 'updateLaporanFondasi' : 'storeLaporanFondasi' }}">
                                {{ $isEditing ? 'Mengupdate...' : 'Menyimpan...' }}
                            </span>
                        </x-button.success>

                        <x-button.primary id="close-modal-laporan-fondasi" wire:click="closeLaporanFondasiModal">
                            Batal
                        </x-button.primary>
                    </div>
                </form>

            </div>
        @endif

    </div>
    {{-- end modal tambah laporan fondasi --}}

    {{-- modal delete laporan fondasi --}}
    <div id="delete-laporan-fondasi-modal" wire:show="showModalDeleteLaporanFondasi" wire:transition.duration.300ms
        class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-70 py-8">

        @if ($showModalDeleteLaporanFondasi)
            <div class="mx-4 my-6 flex w-fit flex-col gap-2 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary"
                style="max-height: calc(100vh - 6rem);">

                <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                    Hapus Laporan Fondasi?
                </h2>

                <p class="text-center text-sm text-gray-700 dark:text-gray-100 lg:text-base">
                    Apakah anda yakin ingin menghapus Laporan ini?
                </p>

                <div class="flex flex-row justify-end gap-2">
                    <x-button.danger id="delete-laporan-fondasi" type="button"
                        wire:click="deleteLaporanFondasiAction">
                        <span wire:loading.remove wire:target="deleteLaporanFondasiAction">Hapus</span>
                        <span wire:loading wire:target="deleteLaporanFondasiAction">Loading</span>
                    </x-button.danger>

                    <x-button.primary id="cancel-delete-laporan-fondasi" type="button"
                        wire:click="$set('showModalDeleteLaporanFondasi', false)">
                        Batal
                    </x-button.primary>
                </div>

            </div>
        @endif

    </div>
    {{-- end modal delete laporan fondasi --}}
</div>
