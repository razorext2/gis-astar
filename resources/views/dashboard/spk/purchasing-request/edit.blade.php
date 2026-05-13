@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mb-16 space-y-4">

        <div
            class="flex items-center gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">


            <x-button.danger href="{{ route('purchasing-request.index') }}" wire:navigate id="back-button"
                class="max-h-10 max-w-fit">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div class="flex w-full flex-col gap-0.5 p-2 lg:p-0">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Purchasing Request
                    {{ $data->nomor_order }}
                </h3>
                <h4 class="text-sm font-semibold uppercase text-gray-800 dark:text-white">
                    {{ $data->customer['nama_perusahaan' ?? 'N/A'] }}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
                </p>
            </div>
        </div>

        @livewire('handler.spk.fetch-purchasing-request', ['id' => $data->id, 'nomorOrder' => $data->nomor_order])

    </div>
@endsection
