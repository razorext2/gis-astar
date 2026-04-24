@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex flex-col gap-4">
        <div
            class="flex flex-row items-center gap-2 rounded-xl bg-white px-3 py-2 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 lg:gap-4 lg:p-6">

            <div>
                <x-button.danger href="{{ route('spk.index') }}" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6" />
                    </x-slot>
                    {{ __('Kembali') }}
                </x-button.danger>
            </div>

            <div>
                <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
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
