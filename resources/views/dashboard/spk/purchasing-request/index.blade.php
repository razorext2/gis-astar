@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'spkpurchasingrequest'])

    <div
        class="flex flex-col gap-2 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:gap-4 lg:p-6">

        <div class="flex w-full flex-col p-2 lg:p-0">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Purchasing Request</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
            </p>
        </div>

        {{-- table here --}}
        <div>
            @livewire('purchasing-request-table')
        </div>

    </div>
@endsection
