@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="attendancein" />

    @can('attendance-approve')
        <livewire:components.unverified-attendance type="in" />
    @endcan

    <div class="relative grid grid-cols-1 rounded-xl border border-zinc-200 px-2 py-4 dark:border-zinc-800 lg:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-none' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <div class="mb-2 flex flex-col px-3 lg:p-0">
            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Absen Masuk
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Berisi semua data absensi masuk yang dilakukan oleh pegawai.
                </p>
            </div>
        </div>

        <livewire:powergrid-tables.attendance-in-table />
    </div>
@endsection
