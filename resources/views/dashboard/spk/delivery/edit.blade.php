@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="grid grid-cols-1 gap-6">

        <div
            class="grid w-full grid-cols-1 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">

                <p class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Update Pengiriman <span class="text-green-500">[{{ $data->customer['nama_perusahaan'] }}]</span>
                </p>

                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    SPK: {{ $data->nomor_order }}
                </p>

                <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                    Halaman ini digunakan untuk memperbarui detail pengiriman produk yang telah selesai diproses dan siap
                    dikirim.
                </p>

            </div>

            @livewire('handler.spk.delivery-update', ['id' => $id])

        </div>
    </div>
@endsection
