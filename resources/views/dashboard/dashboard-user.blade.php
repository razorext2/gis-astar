@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex flex-col gap-5">

        {{-- Greetings --}}
        <livewire:utils.greetings />

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
            class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 md:hidden lg:p-6">
            <div class="mb-4 flex items-center gap-2 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                <h3 class="text-base font-bold tracking-wide text-zinc-800 dark:text-white">Menu</h3>
            </div>
            <div class="pt-1">
                <x-drawer.dashboard-menu />
            </div>
        </div>

    </div>
@endsection
