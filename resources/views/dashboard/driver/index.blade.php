@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="driverreport" />

    <div class="relative grid grid-cols-1 gap-4">

        <div
            class="rounded-xl border border-zinc-200 p-2 shadow-md dark:border-zinc-800 dark:shadow-none md:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            {{-- desktop view --}}
            <div class="hidden items-center lg:flex">
                <ul class="flex flex-wrap gap-6 text-sm font-medium">
                    <li>
                        <a class="{{ Route::is('driver.index') && !Request::query('status') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('driver.index') }}">Semua Laporan</a>
                    </li>

                    @can('driver-approve')
                        <li>
                            <a class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'notassigned' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                                wire:navigate href="{{ route('driver.index', ['status' => 'notassigned']) }}">Belum di Assign</a>
                        </li>
                    @endcan

                    <li>
                        <a class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'notupdated' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('driver.index', ['status' => 'notupdated']) }}">Belum
                            Diupdate(SR)</a>
                    </li>

                    <li>
                        <a class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'unapproved' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('driver.index', ['status' => 'unapproved']) }}">Belum Disetujui</a>
                    </li>
                    <li>
                        <a class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'needrevision' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('driver.index', ['status' => 'needrevision']) }}">Perlu Revisi</a>
                    </li>
                    <li>
                        <a class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'approved' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('driver.index', ['status' => 'approved']) }}">Disetujui</a>
                    </li>
                    <li>
                        <a class="{{ Route::is('driver.index') && Request::query('status') && Request::query('status') == 'rejected' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('driver.index', ['status' => 'rejected']) }}">Ditolak</a>
                    </li>
                </ul>
            </div>

            {{-- mobile view --}}
            <div class="lg:hidden" id="sub-navbar" x-data="{ open: false }">
                {{-- button --}}
                <x-button.secondary class="flex w-full items-center justify-between !p-2.5" @click="open = ! open">
                    <span>Menu...</span>
                    <x-icons.carred-down class="h-3 w-3 shrink-0 transform transition-transform duration-300" 
                        ::class="{ 'rotate-180 ': open }" />
                </x-button.secondary>

                {{-- list --}}
                <div class="mt-2 grid w-full gap-2 md:mt-4 md:gap-4" x-show="open" x-transition>
                    <ul class="rounded-lg bg-white text-gray-700 shadow dark:bg-gray-800 dark:text-gray-200">
                        <li>
                            <a class="{{ Route::is('driver.index') && !Request::query('status') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} will-change-transformduration-300 inline-block w-full rounded-lg border-none p-3 text-sm transition-all ease-in-out hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('driver.index') }}">Semua Laporan</a>
                        </li>

                        @can('driver-approve')
                            <li>
                                <a class="{{ Route::is('driver.index') && Request::query('status') == 'notassigned' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                    href="{{ route('driver.index', ['status' => 'notassigned']) }}">Belum di Assign</a>
                            </li>
                        @endcan

                        <li>
                            <a class="{{ Route::is('driver.index') && Request::query('status') == 'notupdated' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('driver.index', ['status' => 'notupdated']) }}">Belum di Update (SR)</a>
                        </li>

                        <li>
                            <a class="{{ Route::is('driver.index') && Request::query('status') == 'needrevision' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('driver.index', ['status' => 'needrevision']) }}">Perlu Revisi</a>
                        </li>
                        <li>
                            <a class="{{ Route::is('driver.index') && Request::query('status') == 'approved' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('driver.index', ['status' => 'approved']) }}">Disetujui</a>
                        </li>
                        <li>
                            <a class="{{ Route::is('driver.index') && Request::query('status') == 'rejected' ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('driver.index', ['status' => 'rejected']) }}">Ditolak</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        @can('driver-create')
            <div class="max-w-xs">
                <x-button.success href="{{ route('driver.create') }}">
                    <x-slot name="icon">
                        <x-icons.plus class="h-5 w-5" />
                    </x-slot>
                    Tambah Data
                </x-button.success>
            </div>
        @endcan

        <div
            class="relative grid grid-cols-1 rounded-xl py-2 shadow-md border border-zinc-200 dark:shadow-none dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            <livewire:powergrid-tables.driver-table />

        </div>
    </div>
@endsection
