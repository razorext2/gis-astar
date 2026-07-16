@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <div class="flex items-center space-x-4">
            <x-button.danger class="max-h-10" href="{{ route('invoice.all.index') }}" wire:navigate>
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Invoice
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Cari terlebih dahulu invoice yang ingin ditambah berdasarkan <span class="font-semibold text-green-500">
                        Nomor Faktur Pajak ({{ Request::get('tipe_tagihan') }})</span>
                </p>
            </div>
        </div>

        <livewire:handler.invoice.create :id="null" :tipe_tagihan="Request::get('tipe_tagihan')" />
    </div>
@endsection
