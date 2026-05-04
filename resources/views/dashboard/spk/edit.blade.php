@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="mb-96 flex w-full flex-col gap-4 rounded-xl bg-white/60 px-3 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">
        <div class="flex w-full flex-row items-center gap-2 lg:gap-4">
            <div>
                <x-button.danger href="{{ route('spk.index') }}" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6" />
                    </x-slot>
                    {{ __('Kembali') }}
                </x-button.danger>
            </div>

            <div>
                <p class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Ubah SPK
                    {{ $spk->nomor_order . ($spk->revision_count ? 'R' . str_pad($spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                    <span class="text-sm uppercase italic">( {{ $spk->tipe_tagihan }}
                        )</span>
                </p>

                <p class="text-sm text-gray-600 dark:text-gray-400 md:text-base">
                    Anda dapat mengubah data SPK Customer melalui halaman ini.
                </p>
            </div>
        </div>

        @livewire('handler.spk.edit', ['id' => $spk->id])
    </div>
@endsection
