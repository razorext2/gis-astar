@extends('dashboard.layoutsDash.app')
@section('content')
    @php
        $date = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
    @endphp

    @livewire('components.card', ['type' => 'attendancetoday'])

    <div class="flex flex-col gap-6">
        {{-- Absensi Masuk --}}
        <div
            class="flex w-full flex-col gap-5 rounded-xl border border-zinc-200 p-4 shadow-sm dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex items-center gap-3 border-b border-zinc-200 pb-5 dark:border-zinc-800/50">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-lg shadow-emerald-500/20">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Absensi Masuk Hari Ini</h2>
                    <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                        {{ $date }}</p>
                </div>
            </div>
            <livewire:handler.attendance.today />
        </div>

        {{-- Absensi Keluar --}}
        <div
            class="flex w-full flex-col gap-5 rounded-xl border border-zinc-200 p-4 shadow-sm dark:border-zinc-800 md:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex items-center gap-3 border-b border-zinc-200 pb-5 dark:border-zinc-800/50">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-lg shadow-red-500/20">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Absensi Keluar Hari Ini</h2>
                    <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                        {{ $date }}</p>
                </div>
            </div>
            <livewire:handler.attendance.today-out />
        </div>
    </div>
@endsection
