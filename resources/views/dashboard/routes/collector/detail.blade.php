@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-2 rounded-xl bg-white/60 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">

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
