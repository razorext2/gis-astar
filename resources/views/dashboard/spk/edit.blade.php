@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="mb-96 flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 px-3 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
        <div class="flex w-full flex-row items-center gap-2 lg:gap-4">
            <div>
                <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('spk.index') }}" wire:navigate>
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>
            </div>

            <div>
                <p class="text-xl font-semibold text-gray-900 dark:text-white">
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
