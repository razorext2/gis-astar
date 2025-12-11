@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl bg-white p-4 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 sm:p-6 md:max-w-lg lg:max-w-xl xl:max-w-2xl">

        <div>
            <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                Tambah Invoice
            </span>

            <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                Cari terlebih dahulu invoice yang ingin ditambah berdasarkan <span class="font-semibold text-green-500">Nomor
                    Faktur
                    Pajak</span>
            </p>
        </div>

        @livewire('handler.invoice.create', ['id' => $id, 'tipe_tagihan' => null])
    </div>
@endsection
