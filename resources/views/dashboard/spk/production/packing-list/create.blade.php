@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 px-3 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-4">

            <x-button.danger href="{{ route('production.index') }}" wire:navigate id="back-button"
                class="my-auto me-4 max-h-10">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <p class="text-xl font-semibold text-gray-900 dark:text-white">
                    Update Packing List
                    {{ $data->spk->nomor_order . ($data->spk->revision_count ? 'R' . str_pad($data->spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                    <span class="text-sm uppercase italic">(
                        {{ $data->spk->customer['nama_perusahaan'] }}
                        )</span>
                </p>

                <p class="text-sm text-gray-600 dark:text-gray-400 md:text-base">
                    Anda sedang mengupdate packing list SPK Customer melalui halaman ini.
                </p>
            </div>

        </div>

        @livewire('handler.production-histories.packing-list', ['id' => $data->id])

    </div>
@endsection
