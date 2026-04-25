@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div
            class="relative grid grid-cols-1 rounded-xl bg-white py-2 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                        Manajemen Jabatan
                    </span>

                    <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                        Kamu dapat menambah jabatan, mengubah nama jabatan, dan menghapus data jabatan.
                    </p>
                </div>

                @can('jabatan-create')
                    <div class="max-w-xs">
                        <x-button.success class="w-fit" href="{{ route('jabatan.create') }}">
                            <x-slot name="icon">
                                <x-icons.plus class="h-6 w-6" />
                            </x-slot>
                            {{ __('Tambah Data') }}
                        </x-button.success>
                    </div>
                @endcan

            </div>

            <livewire:table-refresher table-name="JabatanTable" />

        </div>
    </div>
@endsection
