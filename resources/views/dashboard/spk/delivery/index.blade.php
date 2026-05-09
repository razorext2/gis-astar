@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'spkdelivery'])

    <div class="relative space-y-4">
        <div
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Manajemen Pengiriman
            </span>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Manajemen Pengiriman adalah feature yang diperuntukkan untuk Bagian Logistik dalam mengelola data
                Pengiriman.
            </p>
        </div>

        <div
            class="rounded-xl border border-zinc-200 bg-white/60 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none">

            <div class="border-b border-zinc-200 px-4 pt-2 dark:border-zinc-800 lg:px-6">
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

            <div id="default-tab-content" class="px-2 py-4 lg:p-6">
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
