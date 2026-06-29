@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div
            class="relative grid grid-cols-1 rounded-xl border border-zinc-200 bg-white/60 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">
                        Manajemen Pegawai
                    </span>

                    <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                        Kamu dapat menambah pegawai, mengubah informasi mengenai pegawai dan menonaktifkan akun pegawai.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    @can('pegawai-create')
                        <x-button.success href="{{ route('pegawai.create') }}">
                            <x-slot name="icon">
                                <x-icons.plus class="h-5 w-5" />
                            </x-slot>
                            {{ __('Tambah Pegawai') }}
                        </x-button.success>
                    @endcan

                    @can('pegawai-edit')
                        <livewire:import-pegawai />
                    @endcan
                </div>

            </div>

            <livewire:powergrid-tables.pegawai-table />

        </div>
    </div>
@endsection
