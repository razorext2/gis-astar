@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'collectoridyppn'])

    <div class="relative grid grid-cols-1 gap-4">

        <div
            class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <ul class="flex flex-wrap gap-x-4 text-center text-sm font-medium">
                <li>
                    <a class="{{ Route::is('collect-idy-ppn.index') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-idy-ppn.index') }}">Belum Tagih</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-idy-ppn.pending') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-idy-ppn.pending') }}">Tertunda</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-idy-ppn.onprogress') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-idy-ppn.onprogress') }}">Berjalan</a>
                </li>
                <li>
                    <a class="{{ Route::is('collect-idy-ppn.completed') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                        href="{{ route('collect-idy-ppn.completed') }}">Selesai</a>
                </li>
            </ul>
        </div>

        @if (Auth::user()->can('collect-idy-ppn-create') || Auth::user()->can('collect-idy-ppn-assign'))
            <div class="inline-flex gap-4">

                @can('collect-idy-ppn-create')
                    <div>
                        <form id="add-collect-idy-ppn" action="{{ route('collect-idy-ppn.create') }}"></form>
                        <x-button.success id="add-button" form="add-collect-idy-ppn" type="submit">
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
