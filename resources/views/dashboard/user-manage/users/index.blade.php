@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div
            class="relative grid grid-cols-1 rounded-xl border border-zinc-200 py-2 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">
                        Manajemen User
                    </span>

                    <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                        Kamu dapat menambah user, mengubah nama user, dan menghapus data user.
                    </p>
                </div>

                @can('users-create')
                    <div class="max-w-xs">
                        <x-button.success href="{{ route('users.create') }}">
                            <x-slot name="icon">
                                <x-icons.plus class="h-5 w-5" />
                            </x-slot>
                            {{ __('Tambah User') }}
                        </x-button.success>
                    </div>
                @endcan

            </div>

            <livewire:powergrid-tables.user-table />

        </div>
    </div>
@endsection
