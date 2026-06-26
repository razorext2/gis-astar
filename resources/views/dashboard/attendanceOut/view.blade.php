@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'attendanceout'])

    <div
        class="relative grid grid-cols-1 rounded-xl border border-zinc-200 bg-white/60 px-2 py-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

        <div class="flex flex-col px-3 lg:p-0">
            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Absen Keluar
                </span>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Berisi semua data absensi keluar yang dilakukan oleh pegawai.
                </p>
            </div>
        </div>

        <livewire:powergrid-tables.attendance-out-table />
    </div>
@endsection
