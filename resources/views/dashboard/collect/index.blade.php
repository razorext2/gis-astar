@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="collectorreport" />

    <div class="relative grid grid-cols-1 gap-4">

        <div class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none md:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            {{-- desktop view --}}
            <div class="hidden items-center lg:flex">
                <ul class="flex flex-wrap gap-6 text-sm font-medium">
                    <li>
                        <a class="{{ Route::is('collect.index') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('collect.index') }}">Belum Dilengkapi</a>
                    </li>
                    <li>
                        <a class="{{ Route::is('collect.submitted') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('collect.submitted') }}">Diajukan</a>
                    </li>
                    <li>
                        <a class="{{ Route::is('collect.revision') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('collect.revision') }}">Perlu revisi</a>
                    </li>
                    <li>
                        <a class="{{ Route::is('collect.approved') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('collect.approved') }}">Disetujui</a>
                    </li>
                    <li>
                        <a class="{{ Route::is('collect.rejected') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg py-2 hover:text-red-600 dark:hover:text-red-600"
                            wire:navigate href="{{ route('collect.rejected') }}">Ditolak</a>
                    </li>
                </ul>

                {{-- <div class="absolute right-6 float-right">
                    <x-button.success class="getCollectorExcel" id="getCollectorExcel">
                        <x-slot name="icon">
                            <x-icons.file-excel class="h-5 w-5" />
                        </x-slot>
                        Tarik Laporan
                    </x-button.success>
                </div> --}}
            </div>

            {{-- mobile view --}}
            <div class="lg:hidden" id="sub-navbar" x-data="{ open: false }">
                {{-- button --}}
                <x-button.secondary class="flex w-full items-center justify-between !p-2.5" @click="open = ! open">
                    <span>Actions...</span>
                    <x-icons.carred-down class="h-3 w-3 shrink-0 transform transition-transform duration-300"
                        ::class="{ 'rotate-180 ': open }" />
                </x-button.secondary>

                {{-- list --}}
                <div class="mt-2 grid w-full gap-2 md:mt-4 md:gap-4" x-show="open" x-transition>
                    <ul class="rounded-lg bg-white text-gray-700 shadow dark:bg-gray-800 dark:text-gray-200">
                        <li>
                            <a class="{{ Route::is('collect.index') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} will-change-transformduration-300 inline-block w-full rounded-lg border-none p-3 text-sm transition-all ease-in-out hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('collect.index') }}">Belum Dilengkapi</a>
                            </a>
                        </li>
                        <li>
                            <a class="{{ Route::is('collect.submitted') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('collect.submitted') }}">Diajukan</a>
                        </li>
                        <li>
                            <a class="{{ Route::is('collect.revision') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('collect.revision') }}">Perlu revisi</a>
                        </li>
                        <li>
                            <a class="{{ Route::is('collect.approved') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('collect.approved') }}">Disetujui</a>
                        </li>
                        <li>
                            <a class="{{ Route::is('collect.rejected') ? 'text-red-600 border-b border-zinc-200' : 'text-gray-600 dark:text-gray-400' }} inline-block w-full rounded-lg border-none p-3 text-sm transition-all duration-300 ease-in-out will-change-transform hover:scale-105 hover:dark:bg-gray-500"
                                href="{{ route('collect.rejected') }}">Ditolak</a>
                        </li>
                    </ul>
                    {{-- <x-button.success class="getCollectorExcel flex w-full items-center !p-3">
                        <x-slot name="icon">
                            <x-icons.file-excel class="h-5 w-5" />
                        </x-slot>
                        Tarik Laporan
                    </x-button.success> --}}
                </div>
            </div>
        </div>

        <div class="grid h-auto w-full grid-cols-2 items-center justify-center gap-2 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none md:gap-4 md:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            {{-- filter --}}
            <div class="col-span-2 mb-4">
                <x-filter.filter-bar>
                    <div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
                        <x-filter.filter-input-text id="no_sr" name="no_sr" :text="'no SR'">
                            <x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                        </x-filter.filter-input-text>
                    </div>

                    <div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
                        <x-filter.filter-input-text id="kode_pegawai" name="kode_pegawai" :text="'kode jari pegawai'">
                            <x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                        </x-filter.filter-input-text>
                    </div>

                    <div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
                        <x-filter.filter-input-text id="title" name="title" :text="'nama customer'">
                            <x-icons.font-case class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                        </x-filter.filter-input-text>
                    </div>

                    <div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
                        <x-filter.filter-input-select id="bill_type" name="bill_type" :options="['idcnonppn' => 'IDC Non PPN', 'idcppn' => 'IDC PPN', 'idyppn' => 'IDY PPN']"
                            default-option="Filter by tipe" />
                    </div>

                    <div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
                        <x-filter.date-range />
                    </div>

                </x-filter.filter-bar>
            </div>
            {{-- end filter --}}

            {{-- subcontent --}}
            @yield('subcontent')
        </div>
    </div>

    <livewire:handler.collect.manage-collect />
@endsection
