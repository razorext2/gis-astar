@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6 md:max-w-lg lg:max-w-xl xl:max-w-2xl">

        <div class="flex items-center space-x-4">
            @php
                $currentRoute = request()->route()->getName();
                $routePrefix = Str::beforeLast($currentRoute, '.');
            @endphp

            <x-button.danger wire:navigate href="{{ route($routePrefix . '.index') }}" class="max-h-10">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Riwayat Invoice
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Cari terlebih dahulu invoice yang ingin ditambah berdasarkan
                    <span class="font-semibold text-green-500">Nomor Faktur Pajak</span>
                </p>
            </div>
        </div>

        @livewire('handler.invoice.create', ['id' => $id, 'tipe_tagihan' => null])
    </div>
@endsection
