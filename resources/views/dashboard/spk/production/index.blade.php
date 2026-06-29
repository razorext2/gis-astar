{{-- Goal: Show Production index page with Livewire wrapper component, Livewire: App\Livewire\Handler\Spk\ProductionTabs, Alpine: false --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'spkproduction'])

    <div class="relative space-y-4">
        <div
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Manajemen Laporan Produksi
            </span>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Manajemen Laporan Produksi adalah feature yang diperuntukkan untuk Bagian Produksi dalam mengelola data
                Laporan
                Produksi.
            </p>
        </div>

        @livewire('handler.spk.production-tabs')
    </div>
@endsection
