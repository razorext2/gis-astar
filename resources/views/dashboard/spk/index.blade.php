@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- carousel for cards --}}
    @livewire('components.card', ['type' => 'spk'])

    <div class="relative space-y-4">

        <div
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Manajemen SPK
            </span>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Kamu dapat menambah invoice, mengubah nama invoice, dan menghapus data Manajemen SPK adalah feature yang
                diperuntukkan untuk Marketing dalam mengelola data SPK Customer.
            </p>
        </div>

        @can('spk-create')
            <x-button.success href="{{ route('spk.create') }}" class="max-w-fit" id="add-button">
                <x-slot name="icon">
                    <x-icons.plus class="h-5 w-5" />
                </x-slot>
                SPK
            </x-button.success>
        @endcan

        <div
            class="rounded-xl border border-zinc-200 bg-white/60 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none">

            <div class="border-b border-zinc-200 px-4 pt-2 dark:border-zinc-800 lg:px-6">
                <ul class="-mb-px flex flex-wrap text-center text-sm font-medium" id="default-tab"
                    data-tabs-toggle="#spk-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <x-nav.tab :active="true" id="semua-jenis-timbangan-tab"
                            data-tabs-target="#semua-jenis-timbangan" aria-controls="semua-jenis-timbangan">
                            Semua Jenis Timbangan
                        </x-nav.tab>
                    </li>
                    <li class="me-2" role="presentation">
                        <x-nav.tab id="timbangan-jembatan-tab" data-tabs-target="#timbangan-jembatan"
                            aria-controls="timbangan-jembatan">
                            Timbangan Jembatan
                        </x-nav.tab>
                    </li>
                    <li class="me-2" role="presentation">
                        <x-nav.tab id="dashboard-tab" data-tabs-target="#non-timbangan-jembatan"
                            aria-controls="non-timbangan-jembatan">
                            Non Timbangan Jembatan
                        </x-nav.tab>
                    </li>
                </ul>
            </div>

            <div id="spk-tab-content" class="px-2 py-4 lg:p-6">
                <div class="hidden" id="semua-jenis-timbangan" role="tabpanel" aria-labelledby="semua-jenis-timbangan-tab">
                    @livewire('spk-table')
                </div>

                <div class="hidden" id="timbangan-jembatan" role="tabpanel" aria-labelledby="timbangan-jembatan-tab">
                    @livewire('spk-table', ['tipe_timbangan' => 'timbangan jembatan'])
                </div>

                <div class="hidden" id="non-timbangan-jembatan" role="tabpanel"
                    aria-labelledby="non-timbangan-jembatan-tab">
                    @livewire('spk-table', ['tipe_timbangan' => 'non timbangan jembatan'])
                </div>
            </div>
        </div>
    </div>
@endsection
