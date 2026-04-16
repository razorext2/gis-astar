@extends('dashboard.layoutsDash.app')
@section('content')
    @php
        $date = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
    @endphp

    @livewire('components.card', ['type' => 'attendancetoday'])

    <div class="flex flex-col gap-4">
        <div
            class="flex w-full flex-col gap-4 rounded-xl border border-gray-200 bg-white p-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none md:p-6">
            <div>
                <h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Absensi Masuk Hari Ini</h2>
                <p class="text-md text-gray-600 dark:text-gray-300"> Berikut adalah data absensi masuk hari
                    <span class="font-semibold">{{ $date }}</span>
                </p>
            </div>
            <livewire:handler.attendance.today />
        </div>

        <div
            class="flex w-full flex-col gap-4 rounded-xl border border-gray-200 bg-white p-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none md:p-6">
            <div>
                <h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Absensi Keluar Hari Ini</h2>
                <p class="text-md text-gray-600 dark:text-gray-300"> Berikut adalah data absensi keluar hari
                    <span class="font-semibold">{{ $date }}</span>
                </p>
            </div>
            <livewire:handler.attendance.today-out />
        </div>
    </div>
@endsection
