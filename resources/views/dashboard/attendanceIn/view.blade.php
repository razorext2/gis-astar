@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'attendancein'])

    <div
        class="relative grid grid-cols-1 rounded-xl bg-white/60 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">

        <div class="flex flex-col px-3 lg:p-0">
            <div>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    Absen Masuk
                </span>

                <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                    Berisi semua data absensi masuk yang dilakukan oleh pegawai.
                </p>
            </div>
        </div>

        <livewire:table-refresher table-name="AttendanceInTable" />
    </div>
@endsection
