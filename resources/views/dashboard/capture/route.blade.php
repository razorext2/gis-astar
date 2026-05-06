@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative overflow-hidden rounded-xl bg-white/60 p-4 text-zinc-900 shadow-2xl ring-1 ring-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:text-white dark:ring-zinc-800 md:p-6"
        id="Scan" data-aos="fade-up">

        {{-- Background Decoration --}}
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-red-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"></div>

        <div class="relative grid grid-cols-1 gap-4">
            {{-- Unified Header --}}
            <div
                class="flex flex-col items-start justify-between gap-4 rounded-xl bg-zinc-100 p-4 ring-1 ring-zinc-200 dark:bg-zinc-800/50 dark:ring-zinc-800 md:flex-row md:items-center">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white shadow-sm dark:bg-zinc-800">
                        <x-icons.map-pin class="h-6 w-6 text-red-500" />
                    </div>
                    <div>
                        <h2 class="text-lg font-black uppercase tracking-tight dark:text-white">Absensi Khusus Rute</h2>
                        <p class="text-[10px] font-bold tracking-widest text-zinc-400">Absensi untuk staff
                            lapangan atau yang sedang bertugas di luar kantor</p>
                    </div>
                </div>

                <div
                    class="flex items-center gap-3 rounded-lg bg-white/50 px-3 py-1.5 ring-1 ring-zinc-200 dark:bg-zinc-900/50 dark:ring-zinc-700">
                    <x-icons.info class="h-4 w-4 text-amber-500" />
                    <div class="flex flex-col">
                        <span class="text-[9px] font-bold uppercase tracking-tighter text-zinc-400">Current Timezone</span>
                        <span class="text-xs font-black text-zinc-700 dark:text-white" id="timezone_js">Detecting...</span>
                    </div>
                </div>
            </div>

            {{-- Livewire Content --}}
            <div class="relative">
                @livewire('handler.attendance.route')
            </div>
        </div>
    </div>

    <script>
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById('timezone_js').textContent = timezone;
    </script>
@endsection
