@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex flex-col gap-4">
        <div
            class="flex flex-row items-center gap-2 rounded-xl border border-zinc-200 bg-white/60 px-3 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:gap-4 lg:p-6">

            <div>
                <x-button.danger href="{{ route('spk.index') }}" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6" />
                    </x-slot>
                    {{ __('Kembali') }}
                </x-button.danger>
            </div>

            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah SPK
                </span>

                <p class="text-sm text-gray-600 dark:text-gray-400 md:text-base">
                    Manajemen SPK adalah feature yang diperuntukkan untuk Marketing dalam mengelola data SPK Customer.
                </p>
            </div>

        </div>

        @livewire('handler.spk.create')
    </div>
@endsection
