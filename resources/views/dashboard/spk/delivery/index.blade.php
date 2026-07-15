{{-- Goal: Show SPK Delivery index page with Livewire wrapper component, Livewire: App\Livewire\Handler\Spk\DeliveryTabs, Alpine: false --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="spkdelivery" />

    <div class="relative space-y-4">
        <div
            class="flex flex-col rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Manajemen Pengiriman
            </span>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Manajemen Pengiriman adalah feature yang diperuntukkan untuk Bagian Logistik dalam mengelola data
                Pengiriman.
            </p>
        </div>

        <livewire:handler.spk.delivery-tabs />
    </div>
@endsection
