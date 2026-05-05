@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-4 rounded-xl bg-white/60 px-3 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">
        <div class="flex flex-row items-center gap-2 lg:gap-4">

            <div>
                <x-button.secondary href="{{ route('spk.index') }}"
                    class="w-fit" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-slot>
                    Kembali
                </x-button.secondary>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">
                    Detail SPK
                    {{ $spk->nomor_order . ($spk->revision_count ? 'R' . str_pad($spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                    <span class="text-sm uppercase italic">( {{ $spk->tipe_tagihan }}
                        )</span>
                </h2>

                <p class="text-sm text-zinc-600 dark:text-zinc-400 md:text-base">
                    Anda dapat melihat progress SPK Customer dari awal sampai selesai melalui halaman ini.
                </p>
            </div>

        </div>

        @livewire('handler.spk.show', ['id' => $spk->id])
    </div>
@endsection
