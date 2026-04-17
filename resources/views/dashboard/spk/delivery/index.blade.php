@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'spkdelivery'])

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
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="-mb-px flex flex-wrap text-center text-sm font-medium" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block rounded-t-lg border-b-2 p-4" id="semua-pengiriman-tab"
                            data-tabs-target="#semua-pengiriman" type="button" role="tab"
                            aria-controls="semua-pengiriman" aria-selected="false">Semua Pengiriman</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block rounded-t-lg border-b-2 p-4" id="pengiriman-proses-tab"
                            data-tabs-target="#pengiriman-proses" type="button" role="tab"
                            aria-controls="pengiriman-proses" aria-selected="false">
                            Dalam Proses Pengiriman</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block rounded-t-lg border-b-2 p-4 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                            id="dashboard-tab" data-tabs-target="#pengiriman-selesai" type="button" role="tab"
                            aria-controls="pengiriman-selesai" aria-selected="false">
                            Pengiriman Selesai</button>
                    </li>
                </ul>
            </div>

            <div id="default-tab-content">
                <div class="hidden" id="semua-pengiriman" role="tabpanel" aria-labelledby="semua-pengiriman-tab">

                    @livewire('spk-delivery-table')

                </div>

                <div class="hidden" id="pengiriman-proses" role="tabpanel" aria-labelledby="pengiriman-proses-tab">

                    @livewire('spk-delivery-table', ['status_kirim' => 0])

                </div>
                <div class="hidden" id="pengiriman-selesai" role="tabpanel" aria-labelledby="pengiriman-selesai-tab">

                    @livewire('spk-delivery-table', ['status_kirim' => 1])

                </div>
            </div>

        </div>
    </div>
@endsection
