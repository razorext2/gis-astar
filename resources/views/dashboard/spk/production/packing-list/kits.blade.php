@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 px-3 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-4">

            <x-button.danger href="{{ route('production.packing-list.add', ['production' => $data->id]) }}" wire:navigate
                id="back-button" class="my-auto me-4 max-h-10">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <p class="text-lg font-semibold text-gray-800 dark:text-white">
                    Tambah Detail Komponen untuk Packing List
                </p>
                <p class="text-xl font-semibold italic text-gray-900 dark:text-white">
                    {{ $data->spk->customer['nama_perusahaan'] }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400 md:text-base">
                    Anda sedang menambah kit untuk packing list SPK Customer melalui halaman ini.
                </p>
            </div>

        </div>

        <div class="grid w-full grid-cols-2 gap-2 rounded-lg">
            <div
                class="col-span-2 flex w-full flex-col rounded-lg border border-zinc-200 bg-gray-100/80 p-2 backdrop-blur-sm dark:border-zinc-800 dark:bg-gray-700/80 lg:col-span-1 lg:p-4">
                <span class="text-xs text-gray-600 dark:text-gray-400"> Ekspedisi </span>
                <span class="text-gray-800 dark:text-white"> {{ $barang['nama_ekspedisi'] }} </span>
            </div>

            <div
                class="col-span-2 flex w-full flex-col rounded-lg border border-zinc-200 bg-gray-100/80 p-2 backdrop-blur-sm dark:border-zinc-800 dark:bg-gray-700/80 lg:col-span-1 lg:p-4">
                <span class="text-xs text-gray-600 dark:text-gray-400"> Nama Barang </span>
                <span class="capitalize text-gray-800 dark:text-white">
                    {{ $barang['qty_barang'] . ' ' . $barang['satuan_barang'] . ' (' . Terbilang::make($barang['qty_barang']) . ') ' . $barang['nama_barang'] }}
                </span>
            </div>
        </div>

        <div>
            @if ($barang['packing_list_type'] === 'manual')
                @livewire('handler.production-histories.packing-list-kit', ['idbarang' => $barang['id_barang'], 'idspk' => $data->spk->id])

                <div class="w-full">
                    <h4 class="mt-2 text-base font-semibold text-gray-800 dark:text-white lg:mt-4">Daftar Peti</h4>

                    @livewire('packing-list-kit-table', ['idbarang' => $barang['id_barang']])
                </div>
            @endif

            @if ($barang['packing_list_type'] === 'upload')
                @livewire('handler.production-histories.packing-list-files', ['idbarang' => $barang['id_barang'], 'idspk' => $data->spk->id])
            @endif
        </div>

    </div>
@endsection
