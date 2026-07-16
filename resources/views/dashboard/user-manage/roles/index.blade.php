@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div class="relative grid grid-cols-1 rounded-xl border border-zinc-200 py-2 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">
                        Manajemen Role
                    </span>

                    <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                        Kamu dapat membuat role, mengubah status dan menghapus role disini.
                    </p>
                </div>

                @can('roles-create')
                    <div class="max-w-xs">
                        <x-button.success class="w-fit" href="{{ route('roles.create') }}" wire:navigate>
                            <x-slot name="icon">
                                <x-icons.plus class="h-6 w-6" />
                            </x-slot>
                            {{ __('Tambah Role') }}
                        </x-button.success>
                    </div>
                @endcan

            </div>

            <livewire:powergrid-tables.roles-table />

        </div>
    </div>
@endsection
