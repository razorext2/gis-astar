@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'spkpurchasingrequest'])

    <div
        class="flex flex-col gap-2 rounded-xl border border-zinc-200 bg-white/60 px-2 py-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:gap-4 lg:p-6">

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
