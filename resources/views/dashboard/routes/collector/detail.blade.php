@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-2 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

        <div class="flex flex-col px-2 lg:p-0">
            <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                Laporan rute {{ $pegawai->full_name }}
            </span>

            <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                Kamu dapat melihat detail rute harian <i class="font-semibold not-italic">{{ $pegawai->full_name }}</i>
                dihalaman ini.
            </p>
        </div>

        @livewire('handler.route.collector', ['kode_pegawai' => $pegawai->kode_pegawai])

    </div>
@endsection
