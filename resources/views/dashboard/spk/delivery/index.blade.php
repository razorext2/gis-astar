@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'spkdelivery'])

    <div class="grid grid-cols-1 gap-6">

        <div
            class="grid grid-cols-1 rounded-xl bg-white/60 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">

                <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Pengiriman
                </span>

                <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                    Pengiriman adalah proses memindahkan atau mengirim barang, dokumen, atau produk dari satu pihak ke pihak
                    lain melalui suatu jasa atau sistem logistik, baik dalam jarak dekat maupun jauh.
                </p>

            </div>
            <div class="mb-4 border-b border-zinc-200 dark:border-zinc-800">
                <ul class="-mb-px flex flex-wrap text-center text-sm font-medium" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <x-nav.tab :active="true" id="semua-pengiriman-tab" data-tabs-target="#semua-pengiriman"
                            aria-controls="semua-pengiriman">
                            Semua Pengiriman
                        </x-nav.tab>
                    </li>
                    <li class="me-2" role="presentation">
                        <x-nav.tab id="pengiriman-proses-tab" data-tabs-target="#pengiriman-proses"
                            aria-controls="pengiriman-proses">
                            Dalam Proses Pengiriman
                        </x-nav.tab>
                    </li>
                    <li class="me-2" role="presentation">
                        <x-nav.tab id="dashboard-tab" data-tabs-target="#pengiriman-selesai"
                            aria-controls="pengiriman-selesai">
                            Pengiriman Selesai
                        </x-nav.tab>
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
