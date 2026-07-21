@extends('layouts.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div class="relative grid grid-cols-1 rounded-xl border border-zinc-200 py-2 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">
                        Manajemen Pengumuman
                    </span>

                    <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                        Kamu dapat membuat pengumuman, mengubah status dan menghapus pengumuman disini.
                    </p>
                </div>

                @can('announcement-create')
                    <div class="max-w-xs">
                        <x-button.success id="add-button" href="{{ route('announcement.create') }}" wire:navigate>
                            <x-slot name="icon">
                                <x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
                            </x-slot>
                            Tambah Data
                        </x-button.success>
                    </div>
                @endcan

            </div>

            <livewire:powergrid-tables.announcement-table />

        </div>
    </div>
@endsection
