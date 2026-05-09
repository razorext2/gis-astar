@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'dashboard'])

    <div class="flex flex-col">
        {{-- Greetings Section --}}
        <div class="mb-4">
            @livewire('utils.greetings')
        </div>

        <div class="mb-4 flex flex-col items-stretch lg:grid lg:grid-cols-3 lg:gap-x-4">

            <form id="attend-in" action="{{ route('attendanceIn.index') }}"></form>
            <form id="attend-out" action="{{ route('attendanceOut.index') }}"></form>

            <!-- Chart Section -->
            <div
                class="col-span-2 mb-4 flex h-full flex-col rounded-xl border border-zinc-200 bg-white/60 p-5 shadow-sm backdrop-blur-md transition-shadow hover:shadow-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none md:p-6 lg:mb-0">
                <div class="mb-5 flex items-start justify-between">
                    <div>
                        <p class="mb-1 text-3xl font-black tracking-tight text-zinc-900 dark:text-white">
                            {{ $yearNow }}
                        </p>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            Menampilkan data 7 hari kebelakang
                        </p>
                    </div>
                    <div
                        class="flex items-center rounded-lg bg-red-50 px-3 py-1 text-center text-sm font-bold text-red-700 dark:bg-red-700/10 dark:text-red-500">
                        {{ $formattedDateRange }}
                    </div>
                </div>

                {{-- Livewire Chart --}}
                <div class="relative h-[340px] w-full overflow-hidden px-1 py-4 lg:h-full lg:flex-1">
                    <livewire:chart.line />
                </div>

                <div class="mt-4 border-t border-zinc-200 pt-5 dark:border-zinc-800">
                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <x-button.primary form="attend-in" type="submit"
                            class="flex-1 justify-center bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 sm:flex-none">
                            <x-slot name="icon">
                                <x-icons.angle-right class="icon h-5 w-5 text-white" />
                            </x-slot>
                            Absen Masuk
                        </x-button.primary>

                        <x-button.danger form="attend-out" type="submit"
                            class="flex-1 justify-center !bg-red-700 text-white hover:!bg-red-800 dark:!bg-red-700 dark:hover:!bg-red-800 sm:flex-none">
                            <x-slot name="icon">
                                <x-icons.angle-left class="icon h-5 w-5 text-white" />
                            </x-slot>
                            Absen Keluar
                        </x-button.danger>
                    </div>
                </div>
            </div>
            <!-- End Chart Section -->

            <!-- Attendance Overview Section -->
            <livewire:dashboard.admin-attendance-overview />
            <!-- End Attendance Overview Section -->
        </div>
    </div>
@endsection
