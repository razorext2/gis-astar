@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl bg-white px-3 py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-600 lg:p-6">
        <div class="flex flex-row items-center gap-2 lg:gap-4">

            <div>
                <x-button.link href="{{ route('production.show', $data->id) }}"
                    class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                    </x-slot>
                    Kembali
                </x-button.link>
            </div>

            <div>
                <p class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Laporan Progres Produksi {{ $data->spk->nomor_order }} <span class="text-sm uppercase italic">(
                        {{ $data->spk->customer['nama_perusahaan'] }}
                        )</span>
                </p>

                <p class="text-sm text-gray-600 dark:text-gray-400 md:text-base">
                    Anda sedang menambah laporan progress SPK Customer melalui halaman ini.
                </p>
            </div>

        </div>

        @livewire('handler.production-histories.create', [
            'id_produksi' => $data->id,
            'status_produksi' => $data->productionHistories?->last()?->status_produksi,
        ])

    </div>
@endsection
