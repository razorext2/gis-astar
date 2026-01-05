@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="grid grid-cols-1 gap-6">

        <div
            class="grid grid-cols-1 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">

                <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Pengiriman
                </span>

                <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                    Pengiriman adalah proses memindahkan atau mengirim barang, dokumen, atau produk dari satu pihak ke pihak
                    lain melalui suatu jasa atau sistem logistik, baik dalam jarak dekat maupun jauh.
                </p>

            </div>

            @livewire('spk-delivery-table')

        </div>
    </div>
@endsection
