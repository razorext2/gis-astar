@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-6">

        <div
            class="relative grid grid-cols-1 rounded-xl bg-white/60 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">
                <div class="mb-2">
                    <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                        Manajemen User
                    </span>

                    <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
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

            <livewire:table-refresher table-name="UserTable" />

        </div>
    </div>
@endsection
