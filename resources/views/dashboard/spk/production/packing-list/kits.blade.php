@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl bg-white px-3 py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-600 lg:p-6">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-4">

            <x-button.link href="{{ route('production.packing-list.add', ['production' => $data->id]) }}"
                class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" wire:navigate id="back-button">
                <x-slot name="icon">
                    <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                </x-slot>
                Kembali
            </x-button.link>

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
                class="col-span-2 flex w-full flex-col rounded-lg bg-gray-100 p-2 ring-1 ring-gray-200 dark:bg-gray-700 dark:ring-gray-600 lg:col-span-1 lg:p-4">
                <span class="text-xs text-gray-600 dark:text-gray-400"> Ekspedisi </span>
                <span class="text-gray-800 dark:text-white"> {{ $barang['nama_ekspedisi'] }} </span>
            </div>

            <div
                class="col-span-2 flex w-full flex-col rounded-lg bg-gray-100 p-2 ring-1 ring-gray-200 dark:bg-gray-700 dark:ring-gray-600 lg:col-span-1 lg:p-4">
                <span class="text-xs text-gray-600 dark:text-gray-400"> Nama Barang </span>
                <span class="capitalize text-gray-800 dark:text-white">
                    {{ $barang['qty_barang'] . ' ' . $barang['satuan_barang'] . ' (' . Terbilang::make($barang['qty_barang']) . ') ' . $barang['nama_barang'] }}
                </span>
            </div>
        </div>

        @livewire('handler.production-histories.packing-list-kit', ['idbarang' => $barang['id_barang'], 'idspk' => $data->spk->id])

        <div class="w-full">
            <h4 class="text-base font-semibold text-gray-800 dark:text-white">Daftar Peti</h4>

            @livewire('packing-list-kit-table', ['idbarang' => $barang['id_barang']])
        </div>


    </div>
@endsection
