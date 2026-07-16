@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="flex items-center">

            <div>
                <x-button.danger href="{{ route('production.show', $data->id) }}" wire:navigate id="back-button"
                    class="my-auto me-4 max-h-10">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
            </div>

            <div>
                <p class="text-xl font-semibold text-gray-900 dark:text-white">
                    Laporan Progres Produksi
                    {{ $data->spk->nomor_order . ($data->spk->revision_count ? 'R' . str_pad($data->spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                    <span class="text-sm uppercase italic">(
                        {{ $data->spk->customer['nama_perusahaan'] }}
                        )</span>
                </p>

                <p class="text-sm text-gray-600 dark:text-gray-400 md:text-base">
                    Anda sedang menambah laporan progress SPK Customer melalui halaman ini.
                </p>
            </div>

        </div>

        <livewire:handler.production-histories.create :id_produksi="$data->id" :status_produksi="$data->productionHistories?->last()?->status_produksi" />

    </div>
@endsection
