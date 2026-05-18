<div class="space-y-4">
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">

        {{-- Header Section: Order Status --}}
        <div
            class="flex flex-col justify-between gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800 md:flex-row md:items-start">
            <div class="flex flex-col gap-2">
                <div class="flex flex-wrap items-center gap-2">
                    <h1 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-2xl">
                        {{ $data->nomor_order . ($data->revision_count ? 'R' . str_pad($data->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                    </h1>

                    @php
                        $badgeClasses = match ($data->status_approval) {
                            0
                                => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-900/20 dark:text-amber-400 dark:ring-amber-500/30',
                            1
                                => 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-500/30',
                            2
                                => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-500/30',
                            3
                                => 'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-900/20 dark:text-amber-400 dark:ring-amber-500/30',
                            4
                                => 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-500/30',
                            default
                                => 'bg-zinc-50 text-zinc-700 ring-zinc-600/20 dark:bg-zinc-900/20 dark:text-zinc-400 dark:ring-zinc-500/30',
                        };
                    @endphp
                    <span class="{{ $badgeClasses }} rounded-lg px-2.5 py-1 text-xs font-medium ring-1">
                        {{ $data->status_approval_description }}
                    </span>

                    @if ($data->is_booked)
                        <span
                            class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-500/30">
                            Booked
                        </span>
                    @endif

                    @if ($data->is_cancelled && $data->cancel_request_validated_by === null)
                        <span
                            class="rounded-lg bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20 dark:bg-yellow-900/20 dark:text-yellow-400 dark:ring-yellow-500/30">
                            Request Pembatalan
                        </span>
                    @endif
                </div>

                @if ($data->latest_revision_request_detail)
                    <p class="text-sm text-red-600 dark:text-red-400">
                        <span class="font-semibold text-zinc-700 dark:text-zinc-300">Revisi Terakhir:</span>
                        {{ $data->latest_revision_request_detail }}
                    </p>
                @endif

                @if ($data->is_cancelled && $data->cancel_request_reason)
                    <p class="text-sm text-red-600 dark:text-red-400">
                        <span class="font-semibold text-zinc-700 dark:text-zinc-300">Alasan Pembatalan:</span>
                        {{ $data->cancel_request_reason }}
                    </p>
                @endif
            </div>

            <div class="flex shrink-0 gap-2">
                @if (
                    $data->status_approval === 0 &&
                        auth()->user()->can('spk-validate') &&
                        ($data->is_booked == false && $data->is_cancelled == false))
                    <x-button.primary id="btn-validate-spk" wire:click="validateSpk" wire:loading.attr="disabled"
                        wire:target="validateSpk">
                        <x-slot name="icon">
                            <x-icons.check-circle class="h-5 w-5" wire:loading.remove wire:target="validateSpk" />
                            <x-icons.loading wire:loading wire:target="validateSpk" class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading.remove wire:target="validateSpk">Setujui SPK</span>
                        <span wire:loading wire:target="validateSpk">Memproses...</span>
                    </x-button.primary>
                @endif

                @if (auth()->user()->can('spk-reassign') && $data->reassign_to == null)
                    <x-button.secondary id="btn-reassign-spk" wire:click="openReassignModal"
                        wire:loading.attr="disabled" wire:target="openReassignModal">
                        <x-slot name="icon">
                            <x-icons.user-add class="h-5 w-5" wire:loading.remove wire:target="openReassignModal" />
                            <x-icons.loading wire:loading wire:target="openReassignModal"
                                class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading.remove wire:target="openReassignModal">Reassign SPK</span>
                        <span wire:loading wire:target="openReassignModal">Memproses...</span>
                    </x-button.secondary>
                @endif

                @if ($data->is_cancelled && auth()->user()->can('spk-validate') && $data->cancel_request_validated_by === null)
                    <x-button.danger
                        wire:confirm.prompt="Apakah anda yakin ingin membatalkan SPK ini? SPK yang dibatalkan tidak dapat diproses lagi.\n\nKetik BATAL untuk mengkonfirmasi.|BATAL"
                        id="btn-cancel-spk" wire:click="cancelSpk" wire:loading.attr="disabled" wire:target="cancelSpk">
                        <x-slot name="icon">
                            <x-icons.check-circle class="h-5 w-5" wire:loading.remove wire:target="cancelSpk" />
                            <x-icons.loading wire:loading wire:target="cancelSpk" class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading.remove wire:target="cancelSpk">Setujui Pembatalan</span>
                        <span wire:loading wire:target="cancelSpk">Memproses...</span>
                    </x-button.danger>
                @endif
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- download button --}}
            @if ($data->status_approval === 1 || auth()->user()->can('spk-validate'))
                <div class="flex justify-between gap-2 md:col-span-2 lg:justify-end">
                    @can('spk-create')
                        <x-button.primary id="spk-pdf-export" wire:click="export" wire:loading.attr="disabled"
                            wire:target="export">
                            <x-slot name="icon">
                                <x-icons.loading wire:loading wire:target="export" class="h-4 w-4 animate-spin" />
                                <x-icons.file-invoice wire:loading.remove wire:target="export" class="h-4 w-4" />
                            </x-slot>

                            <span wire:loading.remove wire:target="export">Ekspor SPK</span>
                            <span wire:loading wire:target="export">Memproses...</span>
                        </x-button.primary>
                    @endcan

                    @hasanyrole(['Produksi', 'Admin', 'Management'])
                        <x-button.primary href="{{ route('spk.generate.pdf', ['id' => $data->id]) }}" id="spk-pdf-export">
                            Ekspor SPK (Produksi)
                        </x-button.primary>
                    @endhasanyrole
                </div>
            @endif
            {{-- end download button --}}

            {{-- Card: Detail Order --}}
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 dark:shadow-none">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.file-invoice class="h-4 w-4 text-blue-500" /> Detail Order
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tanggal Cetak</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $data->tgl_cetak ? \Carbon\Carbon::parse($data->tgl_cetak)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Waktu Penyerahan</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $data->tgl_kirim }} Hari {{ $data->tgl_kirim <= 1 ? '(SEGERA)' : '' }}
                        </span>
                    </div>

                    @if (auth()->user()->can('spk-create') || auth()->user()->can('spk-validate'))
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tipe Tagihan</span>
                            <span
                                class="text-sm font-semibold uppercase text-zinc-900 dark:text-white">{{ $data->tipe_tagihan }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tipe Bayar</span>
                            <span
                                class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $data->tipe_bayar }}</span>
                        </div>
                        <div class="col-span-2 flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nomor Tagihan</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                                {{ $data->status_nomor_tagihan ? $data->nomor_tagihan : $data->status_nomor_tagihan_description }}
                            </span>
                        </div>
                        <div class="col-span-2 flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">No. Dokumen
                                Penawaran</span>
                            <span
                                class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $data->nomor_dokumen_penawaran ?? 'Belum diatur.' }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Card: Customer --}}
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 dark:shadow-none">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.user class="h-4 w-4 text-blue-500" /> Informasi Customer
                </h3>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nama Perusahaan /
                            Customer</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $data->customer['nama_perusahaan'] ?? 'N/A' }}</span>
                    </div>

                    @hasanyrole(['Admin', 'Marketing', 'Management', 'Management-Special'])
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Contact Person</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                                {{ $data->customer['contact_person'] ?? '-' }}
                                <span class="font-normal text-zinc-500">(Telp:
                                    {{ $data->customer['no_hp'] ?? '-' }})</span>
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Alamat Pengiriman</span>
                            <span class="text-sm font-medium leading-relaxed text-zinc-700 dark:text-zinc-300">
                                {{ $data->customer['alamat'] ?? '-' }}
                            </span>
                        </div>
                    @endhasanyrole
                </div>
            </div>

            {{-- Card: Produk --}}
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 dark:shadow-none md:col-span-2">
                <div
                    class="flex flex-wrap items-center justify-between gap-4 border-b border-zinc-100 pb-3 dark:border-zinc-800">
                    <h3 class="flex items-center gap-2 text-sm font-semibold text-zinc-900 dark:text-white">
                        <x-icons.archive class="h-4 w-4 text-blue-500" /> Daftar Produk Dipesan
                    </h3>
                    <span
                        class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium uppercase text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                        {{ $data->tipe_timbangan ?? 'Tipe timbangan tidak diatur.' }}
                    </span>
                </div>

                <div class="max-h-52 overflow-x-auto overflow-y-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b border-zinc-100 text-xs text-zinc-500 dark:border-zinc-800 dark:text-zinc-400">
                            <tr>
                                <th class="pb-2 font-medium">Nama Barang / Spesifikasi</th>
                                <th class="w-32 pb-2 text-center font-medium">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @forelse ($data->products as $row)
                                <tr>
                                    <td class="py-3 pr-4">
                                        <p class="font-semibold text-zinc-900 dark:text-white">
                                            {{ $row['nama_barang'] ?? '-' }}</p>
                                        @if (isset($row['spesifikasi']))
                                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                {!! nl2br(e($row['spesifikasi'])) !!}</p>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center align-top">
                                        <span
                                            class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">
                                            {{ $row['jumlah_unit'] ?? '' }} {{ $row['satuan_barang'] ?? '' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-center text-sm text-zinc-500">Tidak ada produk
                                        dipesan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @can('produksi-create')
                    <div
                        class="mt-2 flex flex-col justify-between gap-4 rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800/50 sm:flex-row sm:items-center">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">Produksi menggunakan bahan
                                stok lama?</span>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">Fitur khusus produksi untuk
                                mengidentifikasi bahan baku yang digunakan.</span>
                        </div>

                        @if ($data->is_using_old_stock == false)
                            <x-button.primary class="shrink-0 text-sm" id="old-stock" type="button"
                                wire:click="setOldStock" wire:confirm.prompt="Silahkan ketik YA untuk melanjutkan|YA"
                                wire:loading.attr="disabled" wire:target="setOldStock">
                                <x-slot name="icon">
                                    <x-icons.loading wire:loading wire:target="setOldStock"
                                        class="h-4 w-4 animate-spin" />
                                    <x-icons.archive wire:loading.remove wire:target="setOldStock" class="h-4 w-4" />
                                </x-slot>

                                <span wire:loading.remove wire:target="setOldStock">Gunakan Stok Lama</span>
                                <span wire:loading wire:target="setOldStock">Memakai Stok...</span>
                            </x-button.primary>
                        @else
                            <span
                                class="inline-flex shrink-0 items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                Menggunakan Stok Lama
                            </span>
                        @endif
                    </div>
                @endcan
            </div>

            {{-- Card: Keterlibatan & Riwayat --}}
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 dark:shadow-none">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.users class="h-4 w-4 text-blue-500" /> Staff
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Dibuat Oleh</span>
                        <span
                            class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">{{ $data->addedBy->name }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Diproduksi Oleh</span>
                        <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">
                            {{ $data->assignTo?->name ?? 'Belum di assign.' }}
                        </span>
                        @if ($data->assignTo)
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $data->assignTo?->pegawai?->jabatanRelasi?->nama_jabatan ?? '' }}
                                ({{ $data->assignTo?->pegawai?->jabatanRelasi?->placementRelasi?->penempatan ?? '' }})
                            </span>
                        @endif
                    </div>

                    @if ($data->reassign_to)
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Reassign Ke</span>
                            <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">
                                {{ $data->reassignTo?->name ?? '-' }}
                            </span>
                            @if ($data->reassignTo?->pegawai?->jabatanRelasi)
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $data->reassignTo->pegawai->jabatanRelasi->nama_jabatan ?? '' }}
                                    ({{ $data->reassignTo->pegawai->jabatanRelasi->placementRelasi?->penempatan ?? '' }})
                                </span>
                            @endif
                        </div>
                    @endif

                    @if ($data->is_booked)
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Dibooking Oleh</span>
                            <span
                                class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">{{ $data->bookedBy->name ?? '-' }}</span>
                        </div>
                    @endif

                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Divalidasi Oleh</span>
                        <span
                            class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">{{ $data->approvedBy->name ?? '-' }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Divalidasi Pada</span>
                        <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">
                            {{ $data->approved_at ? \Carbon\Carbon::parse($data->approved_at)->locale('id')->isoFormat('D MMMM Y HH:mm:ss') : '-' }}
                        </span>
                    </div>

                    @if ($data->is_cancelled)
                        <div
                            class="col-span-2 mt-2 flex flex-col gap-2 rounded-lg border border-red-100 bg-red-50 p-3 dark:border-red-900/30 dark:bg-red-900/20">
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-red-600 dark:text-red-400">Dibatalkan Oleh</span>
                                <span
                                    class="text-sm font-semibold capitalize text-red-700 dark:text-red-300">{{ $data->cancelRequestBy->name ?? '-' }}</span>
                            </div>
                            <div class="mt-1 flex flex-col">
                                <span class="text-xs font-medium text-red-600 dark:text-red-400">Pembatalan Divalidasi
                                    Oleh</span>
                                <span
                                    class="text-sm font-semibold capitalize text-red-700 dark:text-red-300">{{ $data->cancelRequestValidatedBy->name ?? '-' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Card: Dokumen Pendukung --}}
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 dark:shadow-none">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.clipboard class="h-4 w-4 text-blue-500" /> Dokumen Pendukung
                </h3>

                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Request Fondasi</span>
                        <div
                            class="flex flex-col divide-y divide-zinc-100 overflow-hidden rounded-lg border border-zinc-100 dark:divide-zinc-800 dark:border-zinc-800">
                            @forelse ($this->filteredAttachmentsOnlyRequestFondasi as $index => $row)
                                <a href="{{ route('spk.attachment.download', $row['url']) }}"
                                    class="flex items-center justify-between p-3 transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50"
                                    target="_blank">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $row['nama_file'] }}</span>
                                        <span
                                            class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $row['tipe_dokumen'] }}</span>
                                    </div>
                                    <span class="text-xs font-medium text-blue-600 dark:text-blue-400">Download</span>
                                </a>
                            @empty
                                <div class="p-3 text-center text-xs italic text-zinc-500 dark:text-zinc-400">Tidak ada
                                    request fondasi dari Customer.</div>
                            @endforelse
                        </div>
                    </div>

                    @if (auth()->user()->can('spk-validate') || auth()->user()->can('spk-create') || auth()->user()->can('spk-lampiran'))
                        <div class="flex flex-col gap-2">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Lampiran Lainnya</span>
                            <div
                                class="flex flex-col divide-y divide-zinc-100 overflow-hidden rounded-lg border border-zinc-100 dark:divide-zinc-800 dark:border-zinc-800">
                                @forelse ($this->filteredAttachmentsExcludeRequestFondasi as $index => $row)
                                    <a href="{{ route('spk.attachment.download', $row['url']) }}"
                                        class="flex items-center justify-between p-3 transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50"
                                        target="_blank">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $row['nama_file'] }}</span>
                                            <span
                                                class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $row['tipe_dokumen'] }}</span>
                                        </div>
                                        <span
                                            class="text-xs font-medium text-blue-600 dark:text-blue-400">Download</span>
                                    </a>
                                @empty
                                    <div class="p-3 text-center text-xs italic text-zinc-500 dark:text-zinc-400">Tidak
                                        ada lampiran.</div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- progress spk --}}
    @livewire('utils.progres-spk', ['id' => $data->id])
    {{-- end progress spk --}}

    @can('spk-history')
        @livewire('handler.spk.spk-histories', ['id' => $data->id])
    @endcan

    {{-- laporan fondasi --}}
    @can('laporan-fondasi-list')
        @livewire('handler.spk.laporan-fondasi.index', ['id_spk' => $data->id])
    @endcan

    {{-- Modal Reassign SPK --}}
    @can('spk-reassign')
        <x-modal.base-modal show="showReassignModal" title="Reassign SPK" subtitle="Pilih pegawai tujuan reassign"
            iconContainerClass="bg-blue-600 shadow-blue-500/20" maxWidth="lg">
            <x-slot name="icon">
                <x-icons.user-add class="h-5 w-5" />
            </x-slot>

            <div class="flex flex-col gap-4">
                <div class="space-y-1">
                    <label for="reassign-select" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Pilih Pegawai Produksi
                    </label>
                    <select id="reassign-select" wire:model.live="selectedReassignUserId"
                        class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:focus:border-blue-500">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach ($this->produksiUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->kode_pegawai }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <x-slot name="footer">
                <x-button.secondary @click="open = false">
                    Batal
                </x-button.secondary>
                <x-button.primary id="btn-process-reassign" wire:click="processReassign" wire:loading.attr="disabled"
                    wire:target="processReassign" :disabled="!$selectedReassignUserId">
                    <x-slot name="icon">
                        <x-icons.check-circle class="h-4 w-4" wire:loading.remove wire:target="processReassign" />
                        <x-icons.loading wire:loading wire:target="processReassign" class="h-4 w-4 animate-spin" />
                    </x-slot>

                    <span wire:loading.remove wire:target="processReassign">Proses Reassign</span>
                    <span wire:loading wire:target="processReassign">Memproses...</span>
                </x-button.primary>
            </x-slot>
        </x-modal.base-modal>
    @endcan
</div>
