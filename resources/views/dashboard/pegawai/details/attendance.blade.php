{{-- Goal: Display employee attendance records in accordion, Livewire: attendance-in-table, attendance-out-table, Alpine: none --}}
@extends('dashboard.pegawai.detail')
@section('menus')
    <!-- Attendance In Section -->
    <x-utils.accordion-item id="attendance-in" title="Absensi Masuk {{ $pegawai->full_name }}" iconColor="green"
        :expanded="true">
        <x-slot:icon>
            <x-icons.checklist-stepper class="h-5 w-5" />
        </x-slot:icon>

        <livewire:attendance-in-table :kodePegawai="$pegawai->kode_pegawai" />
    </x-utils.accordion-item>

    <!-- Attendance Out Section -->
    <x-utils.accordion-item id="attendance-out" title="Absensi Keluar {{ $pegawai->full_name }}" iconColor="red"
        :expanded="false">
        <x-slot:icon>
            <x-icons.arrow-right-bracket class="h-5 w-5" />
        </x-slot:icon>

        <div class="overflow-hidden rounded-2xl border border-white/20 bg-white/30 dark:border-zinc-800 dark:bg-black/10">
            <livewire:attendance-out-table :kodePegawai="$pegawai->kode_pegawai" />
        </div>
    </x-utils.accordion-item>
@endsection
