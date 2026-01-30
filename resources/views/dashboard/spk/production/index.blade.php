@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div
            class="relative grid grid-cols-1 gap-2 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">

                <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Manajemen Laporan Produksi
                </span>

                <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                    Manajemen Laporan Produksi adalah feature yang diperuntukkan untuk Bagian Produksi dalam mengelola data
                    Laporan
                    Produksi.
                </p>

            </div>

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="-mb-px flex flex-wrap text-center text-sm font-medium" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block rounded-t-lg border-b-2 p-4" id="semua-jenis-timbangan-tab"
                            data-tabs-target="#semua-jenis-timbangan" type="button" role="tab"
                            aria-controls="semua-jenis-timbangan" aria-selected="false">Semua Jenis Timbangan</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block rounded-t-lg border-b-2 p-4" id="timbangan-jembatan-tab"
                            data-tabs-target="#timbangan-jembatan" type="button" role="tab"
                            aria-controls="timbangan-jembatan" aria-selected="false">Timbangan Jembatan</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block rounded-t-lg border-b-2 p-4 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                            id="dashboard-tab" data-tabs-target="#non-timbangan-jembatan" type="button" role="tab"
                            aria-controls="non-timbangan-jembatan" aria-selected="false">Non Timbangan Jembatan</button>
                    </li>
                </ul>
            </div>

            <div id="default-tab-content">
                <div class="hidden" id="semua-jenis-timbangan" role="tabpanel" aria-labelledby="semua-jenis-timbangan-tab">

                    @livewire('production-table')

                </div>

                <div class="hidden" id="timbangan-jembatan" role="tabpanel" aria-labelledby="timbangan-jembatan-tab">

                    @livewire('production-table', ['tipe_timbangan' => 'timbangan jembatan'])

                </div>
                <div class="hidden" id="non-timbangan-jembatan" role="tabpanel"
                    aria-labelledby="non-timbangan-jembatan-tab">

                    @livewire('production-table', ['tipe_timbangan' => 'non timbangan jembatan'])

                </div>
            </div>

        </div>
    </div>
@endsection
