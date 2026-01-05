@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-2 lg:gap-4 rounded-xl bg-white p-2 shadow-md border-[1px] border-gray-200 dark:bg-dark-primary dark:shadow-none dark:border-gray-700 lg:p-6 w-full ">

        <div class="flex flex-row gap-2 lg:gap-4 items-center">

            <div>
                <x-button.link href="{{ route('purchasing-request.index') }}"
                    class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                    </x-slot>
                    Kembali
                </x-button.link>
            </div>

            <div class="w-full gap-0.5 p-2 lg:p-0 flex flex-col">
                <h3 class="text-lg dark:text-white font-semibold text-gray-800">Purchasing Request
                    {{ $data->nomor_order ?? 'N/A' }}
                </h3>
                <h4 class="uppercase text-sm font-semibold dark:text-white text-gray-800">
                    {{ $data->customer['nama_perusahaan' ?? 'N/A'] }}
                </h4>
                <p class="text-sm dark:text-gray-400 text-gray-600">
                    Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
                </p>
            </div>
        </div>

        @livewire('handler.spk.fetch-purchasing-request', ['id' => $data->id])

    </div>
@endsection
