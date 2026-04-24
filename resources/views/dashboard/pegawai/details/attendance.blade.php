@extends('dashboard.pegawai.detail')
@section('menus')
@section('menus')
    <div class="space-y-4" id="attendance-accordion-icon" data-accordion="collapse">

        <!-- Attendance In Section -->
        <div
            class="overflow-hidden rounded-3xl border border-white/30 bg-white/70 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
            <h2 id="attendance-accordion-heading-1">
                <button type="button"
                    class="flex w-full items-center justify-between gap-3 p-6 transition-all duration-300 hover:bg-white/50 dark:hover:bg-white/5"
                    data-accordion-target="#attendance-accordion-body-1" aria-expanded="true"
                    aria-controls="attendance-accordion-body-1">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/10 text-green-600 dark:bg-green-500/20 dark:text-green-400">
                            <x-icons.checklist-stepper class="h-5 w-5" />
                        </div>
                        <h3 class="text-left font-bold tracking-tight text-gray-800 dark:text-white">
                            Absensi Masuk {{ $pegawai->full_name }}
                        </h3>
                    </div>
                    <x-icons.carred-down data-accordion-icon
                        class="h-5 w-5 text-gray-400 transition-transform duration-300" />
                </button>
            </h2>
            <div id="attendance-accordion-body-1" aria-labelledby="attendance-accordion-heading-1"
                class="transition-all duration-500">
                <div class="border-t border-white/20 p-6 dark:border-zinc-800">
                    <div
                        class="overflow-hidden rounded-2xl border border-white/20 bg-white/30 dark:border-zinc-800 dark:bg-black/10">
                        <livewire:attendance-in-table :kodePegawai="$pegawai->kode_pegawai" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Out Section -->
        <div
            class="overflow-hidden rounded-3xl border border-white/30 bg-white/70 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60">
            <h2 id="attendance-accordion-heading-2">
                <button type="button"
                    class="flex w-full items-center justify-between gap-3 p-6 transition-all duration-300 hover:bg-white/50 dark:hover:bg-white/5"
                    data-accordion-target="#attendance-accordion-body-2" aria-expanded="false"
                    aria-controls="attendance-accordion-body-2">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/10 text-red-600 dark:bg-red-500/20 dark:text-red-400">
                            <x-icons.carred-down class="h-5 w-5" />
                        </div>
                        <h3 class="text-left font-bold tracking-tight text-gray-800 dark:text-white">
                            Absensi Keluar {{ $pegawai->full_name }}
                        </h3>
                    </div>
                    <x-icons.carred-down data-accordion-icon
                        class="h-5 w-5 text-gray-400 transition-transform duration-300" />
                </button>
            </h2>
            <div id="attendance-accordion-body-2" class="hidden transition-all duration-500"
                aria-labelledby="attendance-accordion-heading-2">
                <div class="border-t border-white/20 p-6 dark:border-zinc-800">
                    <div
                        class="overflow-hidden rounded-2xl border border-white/20 bg-white/30 dark:border-zinc-800 dark:bg-black/10">
                        <livewire:attendance-out-table :kodePegawai="$pegawai->kode_pegawai" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
