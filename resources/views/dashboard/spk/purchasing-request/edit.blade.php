@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-2 rounded-xl border border-zinc-200 bg-white/60 p-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:gap-4 lg:p-6">

        <div class="flex items-center">

            <div>
                <x-button.danger href="{{ route('purchasing-request.index') }}" wire:navigate id="back-button"
                    class="my-auto me-4 max-h-10">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
            </div>

            <div class="flex w-full flex-col gap-0.5 p-2 lg:p-0">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Purchasing Request
                    {{ $data->nomor_order . ($data->revision_count ? 'R' . str_pad($data->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                </h3>
                <h4 class="text-sm font-semibold uppercase text-gray-800 dark:text-white">
                    {{ $data->customer['nama_perusahaan' ?? 'N/A'] }}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
                </p>
            </div>
        </div>

        @livewire('handler.spk.fetch-purchasing-request', ['id' => $data->id])

    </div>
@endsection
