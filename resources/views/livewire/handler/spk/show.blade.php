<div class="flex flex-col gap-4">
    <div class="relative flex flex-col rounded-lg text-gray-800 ring-1 ring-zinc-200 dark:text-white dark:ring-zinc-800">

        {{-- informasi spk --}}
        <div class="grid grid-cols-2 rounded-t-lg bg-gray-50 transition-all duration-500 dark:bg-gray-700">

            <div
                class="{{ auth()->user()->cannot('spk-create') ? '' : 'lg:col-span-1 ' }} col-span-2 rounded-t-lg border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:rounded-tl-lg lg:rounded-tr-none">
                <p class="text-xs italic">Nomor Order </p>
                <div class="flex flex-col gap-y-2 font-semibold">
                    <div class="flex items-center gap-x-2">
                        <p>
                            {{ $data->nomor_order . ($data->revision_count ? 'R' . str_pad($data->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                        </p>

                        @php
                            $color = match ($data->status_approval) {
                                0 => 'yellow',
                                1 => 'green',
                                2 => 'red',
                                3 => 'yellow',
                                4 => 'red',
                                default => 'gray',
                            };
                        @endphp

                        <span
                            class="bg-{{ $color }}-500 text-{{ $color }}-800 rounded-lg px-2 py-1 text-xs">
                            {{ $data->status_approval_description }}
                        </span>

                        @if ($data->is_booked)
                            <span
                                class='flex w-fit items-center justify-center rounded-lg bg-blue-500 px-2 py-1.5 text-xs text-blue-800'>
                                Booked
                            </span>
                        @endif

                        @if ($data->is_cancelled && $data->cancel_request_validated_by === null)
                            <span
                                class='flex w-fit items-center justify-center rounded-lg bg-yellow-500 px-2 py-1.5 text-xs text-yellow-800'>
                                Request Pembatalan
                            </span>
                        @endif
                    </div>

                    @if (
                        $data->status_approval === 0 &&
                            auth()->user()->can('spk-validate') &&
                            ($data->is_booked == false && $data->is_cancelled == false))
                        <x-button.primary class="w-fit text-sm" id="btn-validate-spk" wire:click="validateSpk">
                            Setujui SPK
                        </x-button.primary>
                    @endif

                    @if ($data->is_cancelled && auth()->user()->can('spk-validate') && $data->cancel_request_validated_by === null)
                        <x-button.danger class="w-fit text-sm"
                            wire:confirm.prompt="Apakah anda yakin ingin membatalkan SPK ini? SPK yang dibatalkan tidak dapat diproses lagi.\n\nKetik BATAL untuk mengkonfirmasi.|BATAL"
                            id="btn-validate-spk" wire:click="cancelSpk">
                            Setujui Pembatalan
                        </x-button.danger>
                    @endif

                    @if ($data->latest_revision_request_detail)
                        <p class="text-sm font-light text-red-500">
                            <span class="font-semibold tracking-wide text-gray-600 dark:text-gray-100">
                                Revisi Terakhir:
                            </span>
                            {{ $data->latest_revision_request_detail }}
                        </p>
                    @endif

                    @if ($data->is_cancelled && $data->cancel_request_reason)
                        <p class="text-sm font-light text-red-500">
                            <span class="font-semibold tracking-wide text-gray-600 dark:text-gray-100">
                                Alasan Pembatalan:
                            </span>
                            {{ $data->cancel_request_reason }}
                        </p>
                    @endif
                </div>
            </div>

            @if (auth()->user()->can('spk-create') || auth()->user()->can('spk-validate'))
                <div
                    class="col-span-2 flex flex-col gap-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1 lg:rounded-tr-lg">
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
                    class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
                    <p class="text-xs italic"> Nomor Tagihan </p>
                    <p class="font-semibold">
                        {{ $data->status_nomor_tagihan ? $data->nomor_tagihan : $data->status_nomor_tagihan_description }}
                    </p>
                </div>

                <div
                    class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
                    <p class="text-xs italic">Tipe Bayar </p>
                    <p class="font-semibold"> {{ $data->tipe_bayar }}</p>
                </div>
            @endif

            @can('produksi-create')
                <div
                    class="col-span-2 border-2 border-green-200 bg-green-200 p-2.5 text-green-800 dark:border-green-600 dark:bg-green-600 dark:text-white">
                    <p class="font-semibold"> Produksi menggunakan bahan stok lama? </p>

                    @if ($data->is_using_old_stock == false)
                        <x-button.primary class="mt-2 text-sm" id="old-stock" type="button" wire:click="setOldStock"
                            wire:confirm.prompt="Silahkan ketik YA untuk melanjutkan|YA">
                            Ya, produksi menggunakan stok lama
                        </x-button.primary>
                    @else
                        <p class="font-bold"> Ya </p>
                    @endif
                </div>
            @endcan

            <div
                class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
                <p class="text-xs italic">Tanggal Cetak </p>
                <p class="font-semibold">
                    {{ $data->tgl_cetak ? \Carbon\Carbon::parse($data->tgl_cetak)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
                <p class="text-xs italic">Waktu Penyerahan</p>
                <p class="font-semibold">
                    {{ $data->tgl_kirim }} Hari
                    {{ $data->tgl_kirim <= 1 ? '(SEGERA)' : '' }}
                </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
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
                class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
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
                class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Dibuat Oleh </p>
                <p class="font-semibold capitalize"> {{ $data->addedBy->name }}</p>
            </div>

            <div
                class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Diproduksi Oleh </p>
                <p class="font-semibold capitalize"> {{ $data->assignTo?->name ?? 'Belum di assign.' }}
                    {{ $data->assignTo?->pegawai?->jabatanRelasi?->nama_jabatan ?? '' }}
                    ({{ $data->assignTo?->pegawai?->jabatanRelasi?->placementRelasi?->penempatan ?? '' }})</p>
            </div>

            <div
                class="col-span-2 flex flex-col gap-y-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
                @if ($data->is_booked)
                    <div>
                        <p class="text-xs italic"> Dibooking Oleh </p>
                        <p class="font-semibold capitalize"> {{ $data->bookedBy->name ?? '-' }}</p>
                    </div>
                @endif

                <div>
                    <p class="text-xs italic"> Divalidasi Oleh </p>
                    <p class="font-semibold capitalize"> {{ $data->approvedBy->name ?? '-' }}</p>
                </div>

                @if ($data->is_cancelled)
                    <div
                        class="flex flex-col rounded-lg border border-red-500 bg-red-200 p-2 dark:bg-transparent lg:p-4">
                        <div class="text-red-500">
                            <p class="text-xs italic"> Dibatalkan Oleh </p>
                            <p class="font-semibold capitalize"> {{ $data->cancelRequestBy->name ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs italic"> Pembatalan Divalidasi Oleh </p>
                            <p class="font-semibold capitalize text-gray-800 dark:text-white">
                                {{ $data->cancelRequestValidatedBy->name ?? '-' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div
                class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Divalidasi Pada </p>
                <p class="font-semibold capitalize">
                    {{ $data->approved_at
                        ? \Carbon\Carbon::parse($data->approved_at)->locale('id')->isoFormat('D MMMM Y HH:mm:ss')
                        : '-' }}
                </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white">
                <p class="text-xs italic"> Request Fondasi </p>
                <div
                    class="mt-2 flex flex-col divide-y divide-gray-200 rounded-lg border border-zinc-200 bg-white shadow-sm dark:divide-gray-700 dark:border-zinc-800 dark:bg-gray-700">
                    @forelse ($this->filteredAttachmentsOnlyRequestFondasi as $index => $row)
                        <a href="{{ route('spk.attachment.download', $row['url']) }}"
                            class="p-2 transition hover:bg-gray-50 dark:hover:bg-gray-800 lg:p-4">
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                {{ $row['nama_file'] }}
                            </p>
                            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                {{ $row['tipe_dokumen'] }}
                            </p>
                        </a>
                    @empty
                        <p class="p-2 text-xs font-semibold capitalize italic lg:p-4">
                            Tidak ada request fondasi dari Customer.
                        </p>
                    @endforelse
                </div>
            </div>

            @if (auth()->user()->can('spk-validate') || auth()->user()->can('spk-create') || auth()->user()->can('spk-lampiran'))
                <div
                    class="col-span-2 border-[1px] border-zinc-200 p-2.5 text-gray-800 dark:border-zinc-800 dark:text-white">
                    <p class="text-xs italic"> Lampiran </p>

                    <div
                        class="mt-2 flex flex-col divide-y divide-gray-200 rounded-lg border border-zinc-200 bg-white shadow-sm dark:divide-gray-700 dark:border-zinc-800 dark:bg-gray-700">
                        @forelse ($this->filteredAttachmentsExcludeRequestFondasi as $index => $row)
                            <a href="{{ route('spk.attachment.download', $row['url']) }}"
                                class="p-2 transition hover:bg-gray-50 dark:hover:bg-gray-800 lg:p-4">
                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                    {{ $row['nama_file'] }}
                                </p>
                                <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $row['tipe_dokumen'] }}
                                </p>
                            </a>
                        @empty
                            <p class="p-2 text-xs font-semibold capitalize italic lg:p-4">
                                Tidak ada lampiran.
                            </p>
                        @endforelse
                    </div>

                </div>
            @endif

        </div>
        {{-- end informasi spk --}}

        {{-- progress spk --}}
        @livewire('utils.progres-spk', ['id' => $data->id])
        {{-- end progress spk --}}

        {{-- download button --}}
        @if ($data->status_approval === 1 || auth()->user()->can('spk-validate'))
            <div
                class="flex justify-center gap-x-1 rounded-b-lg bg-gray-50 p-2 text-center dark:bg-gray-700 lg:absolute lg:right-0 lg:top-0 lg:rounded-none lg:bg-transparent lg:p-0">
                @can('spk-create')
                    <x-button.primary id="spk-pdf-export" wire:click="export">
                        Ekspor SPK
                    </x-button.primary>
                @endcan

                @hasanyrole(['Produksi', 'Admin', 'Management'])
                    <x-button.link
                        class="ring-1 ring-blue-700 hover:bg-blue-300 dark:bg-blue-800 dark:text-white dark:ring-zinc-800 dark:hover:bg-blue-900"
                        href="{{ route('spk.generate.pdf', ['id' => $data->id]) }}" id="spk-pdf-export">
                        Ekspor SPK (Produksi)
                    </x-button.link>
                @endhasanyrole
            </div>
        @endif
        {{-- end download button --}}
    </div>

    @can('spk-history')
        @livewire('handler.spk.spk-histories', ['id' => $data->id])
    @endcan

    {{-- laporan fondasi --}}
    @can('laporan-fondasi-list')
        @livewire('handler.spk.laporan-fondasi.index', ['id_spk' => $data->id])
    @endcan
</div>
