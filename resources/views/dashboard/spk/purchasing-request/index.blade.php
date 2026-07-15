@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="spkpurchasingrequest" />

    <div
        class="flex flex-col gap-2 rounded-xl border border-zinc-200 px-2 py-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:gap-4 lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <div class="flex w-full flex-col p-2 lg:p-0">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Purchasing Request</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
            </p>
        </div>

        {{-- table here --}}
        <div>
            <livewire:purchasing-request-table />
        </div>

    </div>
@endsection
