@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="collectoridcnonppn" />

    <div class="relative grid grid-cols-1 gap-4">

        <div class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <ul class="flex flex-wrap gap-x-4 text-sm font-medium">
                <li>
                    <a class="{{ Route::is('collect-task.index') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task.index') }}">Belum Tagih</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task.pending') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task.pending') }}">Tertunda</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task.onprogress') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task.onprogress') }}">Berjalan</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task.completed') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task.completed') }}">Selesai</a>
                </li>
            </ul>
        </div>

        @if (Auth::user()->can('collect-task-create') || Auth::user()->can('collect-task-assign'))
            <div class="inline-flex gap-4">
                @can('collect-task-create')
                    <div>
                        <form id="add-collect-task" action="{{ route('collect-task.create') }}"></form>
                        <x-button.success id="add-button" form="add-collect-task" type="submit">
                            <x-slot name="icon">
                                <x-icons.angle-right class="h-6 w-6 text-white" />
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
