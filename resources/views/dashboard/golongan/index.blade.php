@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div
            class="relative grid grid-cols-1 rounded-xl border border-zinc-200 bg-white/60 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">
                        Manajemen Golongan
                    </span>

                    <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                        Kamu dapat menambah golongan, mengubah nama golongan, dan menghapus data golongan.
                    </p>
                </div>

                @can('golongan-create')
                    <div class="max-w-xs">
                        <x-button.success class="w-fit" href="{{ route('golongan.create') }}" wire:navigate>
                            <x-slot name="icon">
                                <x-icons.plus class="h-6 w-6" />
                            </x-slot>
                            {{ __('Tambah Data') }}
                        </x-button.success>
                    </div>
                @endcan

            </div>

            <livewire:table-refresher table-name="GolonganTable" />

        </div>
    </div>
@endsection
