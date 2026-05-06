@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="space-y-4 lg:space-y-6">
        <!-- Header Navigation & Tabs -->
        <div
            class="rounded-xl border border-white/30 bg-white/60 p-4 shadow-xl backdrop-blur-md dark:border-white/10 dark:bg-dark-primary/60 lg:p-6">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center">

                    <x-button.danger id="back-btn" class="my-auto me-4 max-h-10" wire:navigate
                        href="{{ route('pegawai.index') }}">
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-gray-800 dark:text-white">Detail Pegawai</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Manajemen informasi dan riwayat staf.</p>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <nav class="scrollbar-hide flex flex-wrap items-center gap-1 overflow-x-auto pb-1 lg:gap-2">
                    @php
                        $tabClasses =
                            'flex items-center gap-2 px-4 py-2.5 text-xs font-bold transition-all duration-300 rounded-2xl whitespace-nowrap group';
                        $activeClasses = 'bg-red-600 text-white';
                        $inactiveClasses =
                            'text-gray-500 hover:bg-white/50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-zinc-800/50';
                    @endphp

                    <a href="{{ route('pegawai.detail', $pegawai->id) }}" wire:navigate
                        class="{{ $tabClasses }} {{ Route::is('pegawai.detail') ? $activeClasses : $inactiveClasses }}">
                        <x-icons.info class="h-4 w-4" />
                        <span>Profil</span>
                    </a>

                    <a href="{{ route('pegawai.attendance', $pegawai->id) }}" wire:navigate
                        class="{{ $tabClasses }} {{ Route::is('pegawai.attendance') ? $activeClasses : $inactiveClasses }}">
                        <x-icons.checklist-stepper class="h-4 w-4" />
                        <span>Absensi</span>
                    </a>

                    <a href="{{ route('pegawai.timeline', $pegawai->kode_pegawai) }}"
                        class="{{ $tabClasses }} {{ Route::is('pegawai.timeline') ? $activeClasses : $inactiveClasses }}">
                        <x-icons.lock-time class="h-4 w-4" />
                        <span>Timeline</span>
                    </a>

                    @if ($pegawai->userRelasi->hasRole('Collector'))
                        <a href="{{ route('pegawai.collectors', $pegawai->kode_pegawai) }}"
                            class="{{ $tabClasses }} {{ Route::is('pegawai.collectors') ? $activeClasses : $inactiveClasses }}">
                            <x-icons.info class="h-4 w-4" />
                            <span>Kolektor</span>
                        </a>
                    @endif

                    @if ($pegawai->userRelasi->hasRole(['Sales', 'Sales-JKT', 'Sales-PKU', 'Sales-IDY', 'Sales-Agrotec', 'Kurir-Bank']))
                        <a href="{{ route('pegawai.sales', $pegawai->kode_pegawai) }}"
                            class="{{ $tabClasses }} {{ Route::is('pegawai.sales') ? $activeClasses : $inactiveClasses }}">
                            <x-icons.info class="h-4 w-4" />
                            <span>Sales</span>
                        </a>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Main Dynamic Content -->
        <div id="mainContent" class="space-y-2 lg:space-y-4">
            @yield('menus')
        </div>
    </div>
@endsection
