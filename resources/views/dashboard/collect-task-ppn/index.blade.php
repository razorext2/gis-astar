@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="collectoridcppn" />

    <div class="relative grid grid-cols-1 gap-4">
        <div
            class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <ul class="flex flex-wrap gap-x-4 text-center text-sm font-medium">
                <li>
                    <a class="{{ Route::is('collect-task-ppn.index') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task-ppn.index') }}">Belum Tagih</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task-ppn.pending') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task-ppn.pending') }}">Tertunda</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task-ppn.onprogress') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task-ppn.onprogress') }}">Berjalan</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task-ppn.completed') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task-ppn.completed') }}">Selesai</a>
                </li>
            </ul>
        </div>

        @if (Auth::user()->can('collect-task-ppn-create') || Auth::user()->can('collect-task-ppn-assign'))
            <div class="inline-flex gap-4">
                @can('collect-task-ppn-create')
                    <div>
                        <form id="add-collect-task-ppn" action="{{ route('collect-task-ppn.create') }}"></form>
                        <x-button.success id="add-button" form="add-collect-task-ppn" type="submit">
                            <x-slot name="icon">
                                <x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
                            </x-slot>
                            Tambah Data
                        </x-button.success>
                    </div>
                @endcan
            </div>
        @endif

        @yield('subcontent')
    </div>
@endsection
