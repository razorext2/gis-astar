@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-4 rounded-xl bg-white px-3 py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-600 lg:p-6">
        {{-- header --}}
        <div class="flex flex-row items-center gap-2 lg:gap-4">
            <div>
                <x-button.link href="{{ route('production.index') }}"
                    class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                    </x-slot>
                    Kembali
                </x-button.link>
            </div>

            <div>
                <p class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Laporan Progres Produksi
                    {{ $data->spk->nomor_order . ($data->spk->revision_count ? 'R' . str_pad($data->spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                    <span class="text-sm uppercase italic">(
                        {{ $data->spk->customer['nama_perusahaan'] }}
                        )</span>
                </p>

                <p class="text-sm text-gray-600 dark:text-gray-400 md:text-base">
                    Anda dapat melihat progress SPK Customer dari awal sampai selesai melalui halaman ini.
                </p>
            </div>
        </div>
        {{-- end header --}}

        {{-- informasi produksi --}}
        <div class="relative grid grid-cols-2 rounded-lg bg-gray-50 transition-all duration-500 dark:bg-gray-700">

            <div
                class="col-span-2 rounded-t-lg border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1 lg:rounded-tl-lg lg:rounded-tr-none">
                <p class="text-xs italic">Nomor Order </p>
                <div class="flex flex-col gap-y-2 font-semibold">
                    <div class="flex items-center gap-x-2">
                        <p> {{ $data->spk->nomor_order . ($data->spk->revision_count ? 'R' . str_pad($data->spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                        </p>

                        @php
                            $color = match ($data->spk->status_approval) {
                                0 => 'yellow',
                                1 => 'green',
                                2 => 'red',
                                3 => 'yellow',
                                default => 'yellow',
                            };
                        @endphp

                        <span
                            class="bg-{{ $color }}-500 text-{{ $color }}-700 rounded-full px-2 py-1 text-xs">
                            {{ $data->spk->status_approval_description }} </span>
                    </div>

                    @if ($data->spk->latest_revision_request_detail)
                        <p class="text-sm font-light text-red-500">
                            <span class="font-semibold tracking-wide text-gray-600 dark:text-gray-100">
                                Revisi Terakhir:
                            </span>
                            {{ $data->spk->latest_revision_request_detail }}
                        </p>
                    @endif
                </div>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1 lg:rounded-tr-lg">
                <p class="text-xs italic">Tipe Tagihan</p>
                <p class="font-semibold"> {{ $data->spk->tipe_tagihan }} </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic">Tanggal Cetak </p>
                <p class="font-semibold">
                    {{ \Carbon\carbon::parse($data->spk->tgl_cetak)->locale('id')->isoFormat('D MMMM Y') }}
                </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic">Waktu Penyerahan</p>
                <p class="font-semibold">
                    {{ $data->spk->tgl_kirim }} Hari
                    {{ $data->spk->tgl_kirim <= 1 ? '(SEGERA)' : '' }}
                </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic">Nama Customer </p>
                <p class="font-semibold"> {{ $data->spk->customer['nama_perusahaan'] ?? 'N/A' }} </p>
                <p class="text-sm"> {{ $data->spk->customer['contact_person'] ?? '-' }}
                    (telp: {{ $data->spk->customer['no_hp'] ?? '-' }})
                </p>
                <p class="text-sm"> {{ $data->spk->customer['alamat'] ?? '-' }} </p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Produk Dipesan </p>
                <p class="text-sm font-semibold capitalize">
                    {{ $data->spk->tipe_timbangan ?? 'Tipe timbangan tidak diatur.' }} </p>
                <ul class="ml-5 list-disc text-sm font-semibold">
                    @forelse ($data->spk->products as $row)
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
                <p class="font-semibold capitalize"> {{ $data->spk->addedBy->name }}</p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1">
                <p class="text-xs italic"> Diproduksi Oleh </p>
                <p class="font-semibold capitalize"> {{ $data->spk->assignTo->name ?? '-' }}</p>
            </div>

            <div
                class="col-span-2 border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1 lg:rounded-bl-lg">
                <p class="text-xs italic"> Divalidasi Oleh </p>
                <p class="font-semibold capitalize"> {{ $data->spk->approvedBy->name ?? '-' }}</p>
            </div>

            <div
                class="col-span-2 rounded-b-lg border-[1px] border-gray-200 p-2.5 text-gray-800 dark:border-gray-600 dark:text-white lg:col-span-1 lg:rounded-bl-none lg:rounded-br-lg">
                <p class="text-xs italic"> Divalidasi Pada </p>
                <p class="font-semibold capitalize">
                    {{ $data->spk->approved_at
                        ? \Carbon\Carbon::parse($data->spk->approved_at)->locale('id')->isoFormat('D MMMM Y HH:mm:ss')
                        : '-' }}
                </p>
            </div>

            @hasanyrole(['Admin', 'Produksi'])
                <div class="absolute right-0 top-0">
                    <x-button.link
                        class="ring-1 ring-blue-700 hover:bg-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
                        href="{{ route('spk.generate.pdf', ['id' => $data->spk->id]) }}" id="spk-pdf-export">
                        Ekspor SPK
                    </x-button.link>
                </div>
            @endhasanyrole

        </div>
        {{-- end informasi produksi --}}

        {{-- progress produksi --}}
        <div class="relative w-full rounded-lg bg-gray-200 dark:bg-gray-700">
            <div class="rounded-lg bg-blue-600 p-4 text-center text-xs font-medium leading-none text-blue-100"
                style="width: {{ $data->productionHistories?->last()->status_produksi_description['percentage'] ?? '0' }}%;">
                {{ $data->productionHistories?->last()->status_produksi_description['label'] ?? '' }}
            </div>
        </div>
        {{-- end progress produksi --}}

        @can('produksi-list')
            {{-- tambah riwayat --}}
            @can('produksi-create')
                <div class="flex flex-row items-center gap-x-4">
                    <x-button.link wire:navigate :href="route('production.history.add', $data->id)" wire:transition.duration.300ms
                        class="flex w-fit flex-row items-center justify-center gap-x-2 px-2.5 py-2 ring-1 ring-green-700 dark:bg-green-800 dark:text-white dark:ring-gray-700"
                        id="produksi-histories-add">
                        <x-slot name="icon">
                            <x-icons.plus class="h-6 w-6 -rotate-90 text-green-500 dark:text-white" />
                        </x-slot>

                        Laporan
                    </x-button.link>

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Riwayat Produksi
                    </h3>
                </div>
                {{-- tambah riwayat --}}
            @endcan

            {{-- history produksi --}}
            @livewire('handler.production-histories.histories-list', ['id' => $data->id], $data->id)
            {{-- end history produksi --}}
        @endcan
    </div>
@endsection
