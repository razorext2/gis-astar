{{-- Goal: Display today's check-in and check-out grids with unified date and role filters, Livewire: Handler\Attendance\Today, Alpine: - --}}
<div class="grid w-full grid-cols-1 gap-y-4">

    {{-- Unified Filter Bar --}}
    <div class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary sm:flex-row sm:items-center sm:justify-between md:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div>
            <h2 class="text-lg font-black tracking-tight text-zinc-900 dark:text-white">Filter Histori Kehadiran</h2>
            <p class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Pilih tanggal dan role untuk menyaring data
                masuk dan keluar</p>
        </div>

        <form wire:submit="applyFilter" class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
            <div class="relative w-full sm:w-52">
                <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                    <x-icons.search-alt class="h-4 w-4 text-zinc-400" />
                </div>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari nama pegawai..."
                    class="block w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-9 pr-9 text-sm font-medium text-zinc-900 transition-all placeholder:font-normal placeholder:text-zinc-400 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                @if ($search)
                    <button type="button" wire:click="$set('search', '')"
                        class="absolute inset-y-0 right-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <x-icons.close class="h-3.5 w-3.5" />
                    </button>
                @endif
            </div>
            <div class="w-full sm:w-44">
                <x-input.select wire:model="role" :labels="false" id="role-filter" name="role" :defaultOption="'Semua Role'"
                    placeholder="Pilih Role" :options="$this->roleOptions" />
            </div>
            <div class="w-full sm:w-44">
                <input type="date" wire:model="date"
                    class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-red-500 focus:ring-red-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
            </div>
            <div class="w-full sm:w-auto">
                <x-button.primary type="submit" class="w-full justify-center">
                    <x-slot name="icon">
                        <span wire:loading.remove wire:target="applyFilter">
                            <x-icons.search-alt class="h-4 w-4" />
                        </span>
                        <span wire:loading wire:target="applyFilter">
                            <x-icons.loading class="h-4 w-4 !text-white" />
                        </span>
                    </x-slot>
                    <span wire:loading.remove wire:target="applyFilter">Filter</span>
                    <span wire:loading wire:target="applyFilter">Memproses...</span>
                </x-button.primary>
            </div>
        </form>
    </div>

    <div class="flex flex-col gap-4">
        {{-- Absensi Masuk --}}
        <div class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary lg:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex items-center justify-between border-b border-zinc-200 pb-5 dark:border-zinc-800/50">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-lg shadow-emerald-500/20">
                        <x-icons.arrow-left-bracket class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Absensi Masuk</h2>
                        <p class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Daftar rekam kehadiran masuk staf
                        </p>
                    </div>
                </div>
                <div
                    class="flex items-center gap-2 rounded-2xl border border-emerald-100 bg-emerald-50/50 px-4 py-2 text-xs font-bold text-emerald-700 dark:border-emerald-900/30 dark:bg-emerald-950/20 dark:text-emerald-400">
                    <x-icons.check-circle class="h-3.5 w-3.5" />
                    <span>{{ $ins->total() }} Hadir</span>
                </div>
            </div>

            {{-- Check-in Grid --}}
            <div class="flex w-full flex-col" wire:poll.300s>
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                    @forelse ($ins as $row)
                        <div wire:key="in-{{ $row->id }}" x-data="{ loading: false }"
                            wire:click="openModal({{ $row->id }})" @click="loading = true"
                            x-on:attendance-modal-ready.window="loading = false"
                            :class="loading ? '!border-emerald-500 !shadow-lg dark:!border-emerald-500' : ''"
                            class="group relative flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition-all duration-300 hover:border-emerald-200 hover:bg-white hover:shadow-xl hover:shadow-emerald-500/5 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-emerald-900/50 lg:flex-row">

                            {{-- Foto --}}
                            <div class="relative h-44 w-full overflow-hidden lg:h-auto lg:w-44 lg:shrink-0">
                                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    src="{{ $row->photo_src }}" alt="{{ $row->pegawaiRelasi->full_name }}">
                            </div>

                            {{-- Info --}}
                            <div class="flex flex-1 flex-col justify-between gap-3 p-4">
                                <div>
                                    <div class="mb-1 flex items-start justify-between gap-2">
                                        <h5
                                            class="flex items-center gap-1.5 text-base font-black tracking-tight text-zinc-900 dark:text-white">
                                            {{ $row->pegawaiRelasi->full_name }}
                                            <x-dashboard.badge-inactive :is_active="$row->user?->is_active ?? true" />
                                        </h5>
                                        <span
                                            class="rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-bold text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                            {{ $row->timezone ?? 'WIB' }}
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center gap-1.5 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                        <x-icons.check-circle class="h-3.5 w-3.5" />
                                        <span>Check-in pukul {{ $row->parsed_time->format('H:i:s') }}</span>
                                    </div>
                                    @if ($row->late_duration)
                                        <div
                                            class="mt-1 flex items-center gap-1 text-xs font-medium text-amber-500 dark:text-amber-400">
                                            <x-icons.exclamation-circle class="h-3.5 w-3.5" />
                                            <span>Terlambat {{ $row->late_duration }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if ($row->keterangan)
                                    <div
                                        class="flex items-start gap-2 border-t border-zinc-200 pt-3 dark:border-zinc-800/50">
                                        <div class="mt-0.5 shrink-0">
                                            @if ($row->position_status == 1)
                                                <x-icons.exclamation-circle class="h-4 w-4 text-amber-500" />
                                            @elseif($row->position_status == 2)
                                                <x-icons.check-circle class="h-4 w-4 text-emerald-500" />
                                            @elseif($row->position_status == 3)
                                                <x-icons.minus-circle class="h-4 w-4 text-rose-500" />
                                            @else
                                                <x-icons.question-circle class="h-4 w-4 text-zinc-400" />
                                            @endif
                                        </div>
                                        <p class="line-clamp-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                            {{ $row->keterangan }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <div x-show="!loading"
                                    class="opacity-0 transition-all duration-300 group-hover:translate-x-1 group-hover:opacity-100">
                                    <x-icons.arrow-right class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                                </div>
                                <div x-show="loading">
                                    <x-icons.loading class="h-5 w-5 !text-emerald-600 dark:!text-emerald-400" />
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 px-4 py-14 text-center dark:border-zinc-800 md:px-0">
                            <div
                                class="mb-3 flex h-14 w-14 items-center justify-center rounded-xl bg-zinc-50 text-zinc-400 dark:bg-zinc-900">
                                <x-icons.question-circle class="h-7 w-7" />
                            </div>
                            <p class="text-base font-bold text-zinc-900 dark:text-white">Belum Ada Data</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Tidak ada rekam kehadiran masuk untuk
                                tanggal ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-2">
                    {{ $ins->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>

        {{-- Absensi Keluar --}}
        <div class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary md:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex items-center justify-between border-b border-zinc-200 pb-5 dark:border-zinc-800/50">
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-lg shadow-red-500/20">
                        <x-icons.arrow-right-bracket class="h-5 w-5" />
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Absensi Keluar</h2>
                        <p class="text-xs font-bold text-zinc-500 dark:text-zinc-400">Daftar rekam kehadiran keluar staf
                        </p>
                    </div>
                </div>
                <div
                    class="flex items-center gap-2 rounded-2xl border border-red-100 bg-red-50/50 px-4 py-2 text-xs font-bold text-red-700 dark:border-red-900/30 dark:bg-red-950/20 dark:text-red-400">
                    <x-icons.minus-circle class="h-3.5 w-3.5" />
                    <span>{{ $outs->total() }} Keluar</span>
                </div>
            </div>

            {{-- Check-out Grid --}}
            <div class="flex w-full flex-col" wire:poll.300s>
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                    @forelse ($outs as $row)
                        <div wire:key="out-{{ $row->id }}" x-data="{ loading: false }"
                            wire:click="openModalOut({{ $row->id }})" @click="loading = true"
                            x-on:attendance-modal-ready.window="loading = false"
                            :class="loading ? '!border-red-500 !shadow-lg dark:!border-red-500' : ''"
                            class="group relative flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition-all duration-300 hover:border-red-200 hover:bg-white hover:shadow-xl hover:shadow-red-500/5 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-red-900/50 lg:flex-row">

                            {{-- Foto --}}
                            <div class="relative h-44 w-full overflow-hidden lg:h-auto lg:w-44 lg:shrink-0">
                                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    src="{{ $row->photo_src }}" alt="{{ $row->pegawaiRelasi->full_name }}">
                            </div>

                            {{-- Info --}}
                            <div class="flex flex-1 flex-col justify-between gap-3 p-4">
                                <div>
                                    <div class="mb-1 flex items-start justify-between gap-2">
                                        <h5
                                            class="flex items-center gap-1.5 text-base font-black tracking-tight text-zinc-900 dark:text-white">
                                            {{ $row->pegawaiRelasi->full_name }}
                                            <x-dashboard.badge-inactive :is_active="$row->user?->is_active ?? true" />
                                        </h5>
                                        <span
                                            class="rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-bold text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                            {{ $row->timezone ?? 'WIB' }}
                                        </span>
                                    </div>
                                    <div
                                        class="flex items-center gap-1.5 text-xs font-medium text-red-600 dark:text-red-400">
                                        <x-icons.minus-circle class="h-3.5 w-3.5" />
                                        <span>Check-out pukul {{ $row->parsed_time->format('H:i:s') }}</span>
                                    </div>
                                </div>

                                @if ($row->keterangan)
                                    <div
                                        class="flex items-start gap-2 border-t border-zinc-200 pt-3 dark:border-zinc-800/50">
                                        <div class="mt-0.5 shrink-0">
                                            @if ($row->position_status == 1)
                                                <x-icons.exclamation-circle class="h-4 w-4 text-amber-500" />
                                            @elseif($row->position_status == 2)
                                                <x-icons.check-circle class="h-4 w-4 text-red-500" />
                                            @elseif($row->position_status == 3)
                                                <x-icons.minus-circle class="h-4 w-4 text-rose-500" />
                                            @else
                                                <x-icons.question-circle class="h-4 w-4 text-zinc-400" />
                                            @endif
                                        </div>
                                        <p class="line-clamp-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                            {{ $row->keterangan }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <div x-show="!loading"
                                    class="opacity-0 transition-all duration-300 group-hover:translate-x-1 group-hover:opacity-100">
                                    <x-icons.arrow-right class="h-5 w-5 text-red-600 dark:text-red-400" />
                                </div>
                                <div x-show="loading">
                                    <x-icons.loading class="h-5 w-5 !text-red-600 dark:!text-red-400" />
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-full flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 px-4 py-14 text-center dark:border-zinc-800 md:px-0">
                            <div
                                class="mb-3 flex h-14 w-14 items-center justify-center rounded-xl bg-zinc-50 text-zinc-400 dark:bg-zinc-900">
                                <x-icons.question-circle class="h-7 w-7" />
                            </div>
                            <p class="text-base font-bold text-zinc-900 dark:text-white">Belum Ada Data</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Tidak ada rekam kehadiran keluar untuk
                                tanggal ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-2">
                    {{ $outs->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
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
</div>
