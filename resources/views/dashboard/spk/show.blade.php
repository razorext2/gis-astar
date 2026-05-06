@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 px-3 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
        <div class="flex items-center">

            <div>
                <x-button.danger href="{{ route('spk.index') }}" class="w-fit" wire:navigate id="back-button"
                    class="my-auto me-4 max-h-10">
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
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
