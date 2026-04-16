@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'collectoridcnonppn'])

    <div class="relative grid grid-cols-1 gap-6">

        <div
            class="rounded-xl border border-gray-200 bg-white p-4 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none">
            <ul class="flex flex-wrap text-center text-sm font-medium">
                <li>
                    <a class="{{ Route::is('collect-task.index') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task.index') }}">Belum Tagih</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task.pending') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task.pending') }}">Tertunda</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task.onprogress') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-task.onprogress') }}">Berjalan</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-task.completed') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600"
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
