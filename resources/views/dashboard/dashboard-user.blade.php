@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex flex-col gap-5">

        {{-- Greetings --}}
        <livewire:utils.greetings />

        <div x-data="{ offline: !navigator.onLine }" @offline.window="offline = true" @online.window="offline = false" x-show="offline"
            style="display: none;" x-transition>
            <x-notification-alert :id="'offline-alert'" type="offline">
                <x-slot name="title">
                    KONEKSI TERPUTUS
                </x-slot>
                <x-slot name="desc">
                    Kamu sedang dalam kondisi offline. Periksa koneksi internetmu untuk melanjutkan aktivitas.
                </x-slot>
            </x-notification-alert>
        </div>

        <x-signature-reminder />

        {{-- Schedule Card --}}
        <livewire:dashboard.user-schedule-overview />

        {{-- Sales Percentage --}}
        @can('sales-create')
            <livewire:dashboard.user-sales-stats />
        @endcan

        {{-- Teknisi Report --}}
        @hasrole('Teknisi')
            <livewire:plugin.tech-report-percentage />
        @endhasrole

        {{-- Attendance History --}}
        <livewire:dashboard.user-attendance-history />

        {{-- All Menu (Mobile only) --}}
        <div
            class="rounded-xl border border-zinc-200 p-5 shadow-sm dark:border-zinc-800 dark: md:hidden lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="mb-4 flex items-center gap-2 border-b border-zinc-200 pb-4 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                <h3 class="text-base font-bold tracking-wide text-zinc-800 dark:text-white">Menu</h3>
            </div>
            <div class="pt-1">
                <x-drawer.dashboard-menu />
            </div>
        </div>

    </div>
    {{-- Signal popup FABs to auto-open on this page --}}
    <script>window.addEventListener('load', () => window.dispatchEvent(new CustomEvent('enable-autopop')), { once: true });</script>
@endsection
