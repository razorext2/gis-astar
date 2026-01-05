@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="grid grid-cols-1 gap-6">

        <div
            class="grid grid-cols-1 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                        Manajemen SPK
                    </span>

                    <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                        Manajemen SPK adalah feature yang diperuntukkan untuk Marketing dalam mengelola data SPK Customer.
                    </p>
                </div>

                <div class="max-w-xs">
                    <x-button.link href="{{ route('spk.create') }}" id="add-button" wire:navigate
                        class="w-fit ring-1 ring-green-700 dark:bg-green-800 dark:text-white">
                        <x-slot name="icon">
                            <x-icons.plus class="h-6 w-6 text-green-500 dark:text-white" />
                        </x-slot>
                        SPK
                    </x-button.link>
                </div>

            </div>

            @livewire('spk-table')

        </div>
    </div>
@endsection
