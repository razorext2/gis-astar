{{-- Goal: Current Leave List with Flight Board aesthetics, Livewire: CurrentLeaveList, Alpine: null --}}

<div class="flex flex-col gap-6">
    {{-- Search Toolbar --}}
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 sm:flex-row sm:items-center sm:justify-between md:p-5">
        <div class="relative w-full sm:w-96">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <x-icons.info class="h-4 w-4 text-zinc-400" />
            </div>
            <input type="text" wire:model.live="search"
                class="w-full rounded-xl border-zinc-200 bg-white/50 py-2.5 pl-11 text-sm transition-all focus:border-red-500 focus:ring-red-500 dark:border-zinc-800 dark:bg-dark-primary/50 dark:text-zinc-200"
                placeholder="Cari nama pegawai yang sedang cuti...">
        </div>
        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-500">
            <span class="flex h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span>
            Per Tanggal: {{ now()->format('d M Y') }}
        </div>
    </div>

    {{-- Flight Board List --}}
    <div class="flex flex-col gap-4">
        @forelse ($leaves as $leave)
            <div
                class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 backdrop-blur-xl transition-all hover:border-red-500/30 hover:shadow-xl hover:shadow-red-500/5 dark:border-zinc-800 dark:bg-dark-primary/60">
                <div class="flex flex-col md:flex-row">

                    {{-- Left Section: Employee Info --}}
                    <div
                        class="flex items-center gap-4 border-b border-zinc-100 p-5 dark:border-zinc-800 md:w-1/3 md:border-b-0 md:border-r">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-600 font-black text-white shadow-lg shadow-red-500/20">
                            {{ Str::substr($leave->user->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col overflow-hidden">
                            <h4 class="truncate font-black uppercase tracking-tight text-zinc-800 dark:text-zinc-100">
                                {{ $leave->user->name }}
                            </h4>
                            <span class="text-xs font-bold text-zinc-400">
                                {{ $leave->user->pegawai->kode_pegawai ?? '-' }}
                            </span>
                        </div>
                    </div>

                    {{-- Middle Section: The "Flight" Journey (Dates) --}}
                    <div class="flex flex-1 flex-col justify-center p-5 md:px-8">
                        <div class="flex items-center justify-between gap-4">
                            {{-- From --}}
                            <div class="flex flex-col">
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Mulai</span>
                                <span class="text-lg font-black text-zinc-700 dark:text-zinc-300">
                                    {{ $leave->start_date->format('d M Y') }}
                                </span>
                            </div>

                            {{-- Journey Line --}}
                            <div class="relative flex flex-1 flex-col items-center gap-1">
                                <div class="text-[10px] font-black uppercase tracking-tighter text-red-600">
                                    {{ $leave->total_days }} Hari
                                </div>
                                <div class="flex w-full items-center gap-2">
                                    <div class="h-0.5 flex-1 bg-zinc-200 dark:bg-zinc-800"></div>
                                    <x-icons.command class="h-4 w-4 text-red-600" />
                                    <div
                                        class="h-0.5 flex-1 border-t-2 border-dashed border-zinc-200 dark:border-zinc-800">
                                    </div>
                                </div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                                    {{ $leave->leaveType->name ?? 'Annual Leave' }}
                                </div>
                            </div>

                            {{-- To --}}
                            <div class="flex flex-col text-right">
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Selesai</span>
                                <span class="text-lg font-black text-zinc-700 dark:text-zinc-300">
                                    {{ $leave->end_date->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Right Section: Status --}}
                    <div class="flex items-center justify-center bg-zinc-50/50 p-5 dark:bg-white/5 md:w-48">
                        <div class="flex flex-col items-center gap-1">
                            @php
                                $isUpcoming = \Carbon\Carbon::parse($leave->start_date)
                                    ->startOfDay()
                                    ->gt(\Carbon\Carbon::today());
                            @endphp

                            @if ($isUpcoming)
                                <span
                                    class="rounded-lg bg-amber-100 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                    Upcoming
                                </span>
                                <span class="text-[9px] font-bold uppercase text-zinc-400">Status: Akan Cuti</span>
                            @else
                                <span
                                    class="rounded-lg bg-emerald-100 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    Sedang Cuti
                                </span>
                                <span class="text-[9px] font-bold uppercase text-zinc-400">Status: Aktif</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Bottom Description --}}
                <div
                    class="border-t border-zinc-100 bg-zinc-50/30 px-5 py-3 text-[11px] italic text-zinc-500 dark:border-zinc-800 dark:bg-dark-primary/30">
                    <span class="mr-2 font-bold uppercase not-italic tracking-tighter text-zinc-400">Alasan:</span>
                    "{{ $leave->reason ?? 'No description provided' }}"
                </div>
            </div>
        @empty
            <div
                class="flex flex-col items-center justify-center rounded-xl border border-dashed border-zinc-200 bg-white/60 py-20 text-center backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60">
                <div
                    class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-zinc-50 text-zinc-400 dark:bg-white/5">
                    <x-icons.command class="h-8 w-8" />
                </div>
                <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-200">Semua Pegawai Sedang Bertugas</h3>
                <p class="text-sm text-zinc-500">Tidak ada pegawai yang sedang cuti hari ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $leaves->links() }}
    </div>
</div>
