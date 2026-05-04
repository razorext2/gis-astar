@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl bg-white/60 p-4 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 sm:p-6">

        <div>
            <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                Tambah Invoice
            </span>

            <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                Cari terlebih dahulu invoice yang ingin ditambah berdasarkan <span class="font-semibold text-green-500">
                    Nomor Faktur Pajak ({{ Request::get('tipe_tagihan') }})</span>
            </p>
        </div>

        @livewire('handler.invoice.create', ['id' => null, 'tipe_tagihan' => Request::get('tipe_tagihan')])
    </div>
@endsection
