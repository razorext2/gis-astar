{{-- Goal: Render attendance detail modal, Livewire: Handler\Attendance\Today, Alpine: - --}}
<x-modal.base-modal show="showModal" title="{{ $isModalOut ? 'Detail Check-Out' : 'Detail Check-In' }}"
    subtitle="{{ $attendance ? \Carbon\Carbon::parse($attendance->created_at)->format('d/m/Y H:i:s') : '' }}"
    iconContainerClass="{{ $isModalOut ? 'bg-red-600 shadow-red-500/20' : 'bg-emerald-600 shadow-emerald-500/20' }}"
    maxWidth="xl">
    <x-slot name="icon">
        @if ($isModalOut)
            <x-icons.minus-circle class="h-5 w-5" />
        @else
            <x-icons.check-circle class="h-5 w-5" />
        @endif
    </x-slot>

    @if ($showModal && $attendance)
        <div class="flex flex-col gap-5">
            {{-- Identitas --}}
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800">
                    <img src="{{ $attendance->photo_src }}" class="h-full w-full object-cover">
                </div>
                <div>
                    <a href="{{ route('pegawai.detail', $attendance->pegawaiRelasi->id) }}" target="_blank"
                        class="{{ $isModalOut ? 'hover:text-red-600 dark:hover:text-red-400' : 'hover:text-emerald-600 dark:hover:text-emerald-400' }} group flex items-center gap-1.5 text-lg font-bold text-zinc-900 dark:text-white">
                        {{ $attendance->pegawaiRelasi->full_name }}
                        <x-dashboard.badge-inactive :is_active="$attendance->user?->is_active ?? true" />
                        <x-icons.arrow-right
                            class="h-4 w-4 -rotate-45 opacity-0 transition-all group-hover:opacity-100" />
                    </a>
                    <span class="text-xs font-bold text-zinc-500">ID:
                        {{ $attendance->pegawaiRelasi->kode_pegawai }}</span>
                </div>
            </div>

            {{-- Keterangan & Status --}}
            @if ($attendance->keterangan)
                <div class="flex items-start gap-3 rounded-2xl bg-zinc-50 p-4 dark:bg-zinc-800/50">
                    <div class="mt-0.5 shrink-0">
                        @if ($attendance->position_status == 1)
                            <x-icons.exclamation-circle class="h-5 w-5 text-amber-500" />
                        @elseif($attendance->position_status == 2)
                            <x-icons.check-circle
                                class="{{ $isModalOut ? 'text-red-500' : 'text-emerald-500' }} h-5 w-5" />
                        @elseif($attendance->position_status == 3)
                            <x-icons.minus-circle class="h-5 w-5 text-rose-500" />
                        @else
                            <x-icons.question-circle class="h-5 w-5 text-zinc-400" />
                        @endif
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Status & Keterangan
                        </p>
                        <p class="text-sm font-semibold leading-relaxed text-zinc-700 dark:text-zinc-300">
                            {{ $attendance->keterangan }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Foto Presensi --}}
            <div class="relative overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800">
                <img src="{{ $attendance->photo_src }}" class="w-full object-cover" style="height: 280px;">
                <div class="absolute inset-0 flex items-end bg-gradient-to-t from-zinc-900/60 to-transparent p-4">
                    <span class="rounded-lg px-3 py-1 text-xs font-bold text-gray-800 dark:text-white"
                        x-bind:class="dynamicBg ?
                            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' :
                            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        Foto {{ $isModalOut ? 'Absen Keluar' : 'Absen Masuk' }}
                    </span>
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="flex flex-col gap-3">
                {{-- Map Embed - Google Maps Satellite --}}
                <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-800">
                    <iframe
                        src="https://maps.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}&z=18&t=k&output=embed"
                        class="w-full" style="height: 220px; border: none;" loading="lazy" allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                {{-- Address + Link --}}
                <div class="flex items-start gap-3 rounded-2xl bg-zinc-50 p-4 dark:bg-zinc-800/50">
                    <div
                        class="{{ $isModalOut ? 'bg-red-50 text-red-600 dark:bg-red-950/30 dark:text-red-400' : 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400' }} mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg">
                        <x-icons.map-pin class="h-4 w-4" />
                    </div>
                    <div class="flex flex-1 flex-col gap-1">
                        <p class="text-xs font-semibold leading-relaxed text-zinc-700 dark:text-zinc-300">
                            {{ $address }}</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                target="_blank"
                                class="{{ $isModalOut ? 'text-red-600 hover:underline dark:text-red-400' : 'text-emerald-600 hover:underline dark:text-emerald-400' }} flex items-center gap-1 text-xs font-bold">
                                Buka di Google Maps <x-icons.arrow-right class="h-3 w-3 -rotate-45" />
                            </a>
                            <span class="text-[10px] font-medium text-zinc-400">{{ $attendance->latitude }},
                                {{ $attendance->longitude }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-slot name="footer">
        <x-button.primary class="w-full justify-center" @click="open = false">
            Tutup Detail
        </x-button.primary>
    </x-slot>
</x-modal.base-modal>
