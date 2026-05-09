<div
    class="bg-white/60/70 rounded-2xl border border-zinc-200 p-4 backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">Jadwal Kamu
                </p>
            </div>
            <h2 class="text-base font-semibold text-zinc-700 dark:text-zinc-300">
                {{ $getDay }}, {{ now()->translatedFormat('d F Y') }}
            </h2>
        </div>
        <div class="flex items-end gap-2">
            @if ($getJadwal)
                <p class="text-3xl font-black tabular-nums tracking-tight text-zinc-900 dark:text-white lg:text-4xl">
                    {{ $getJadwal->jam_masuk }}
                </p>
                <span class="mb-1 text-sm font-medium text-zinc-400 dark:text-zinc-500">–</span>
                <p class="text-3xl font-black tabular-nums tracking-tight text-zinc-900 dark:text-white lg:text-4xl">
                    {{ $getJadwal->jam_keluar }}
                </p>
            @else
                <p class="text-lg font-medium italic text-zinc-400 dark:text-zinc-500">Tidak ada jadwal hari ini.</p>
            @endif
        </div>
    </div>
</div>
