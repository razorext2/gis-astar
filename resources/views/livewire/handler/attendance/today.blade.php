{{-- Goal: Display today's check-in grid with status filters, Livewire: Handler\Attendance\Today, Alpine: - --}}
<div class="grid w-full grid-cols-1 gap-y-6">

    {{-- Filter Bar --}}
    <div class="flex w-full flex-col items-center gap-3 sm:flex-row">
        <div class="grid w-full grid-cols-1 gap-3 sm:grid-cols-2">
            <x-input.select wire:model.live="role" :labels="false" id="role-in" name="role" :defaultOption="'Semua Role'"
                placeholder="Pilih Role" :options="$this->roleOptions" />

            <input type="date" wire:model.live="date"
                class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-emerald-500 focus:ring-emerald-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
        </div>

        <div
            class="hidden shrink-0 items-center gap-2 rounded-2xl border border-emerald-100 bg-emerald-50/50 px-4 py-2 text-xs font-bold text-emerald-700 dark:border-emerald-900/30 dark:bg-emerald-950/20 dark:text-emerald-400 sm:flex">
            <x-icons.check-circle class="h-3.5 w-3.5" />
            <span>{{ $data->total() }} Hadir</span>
        </div>
    </div>

    {{-- Attendance Grid --}}
    <div class="flex w-full flex-col gap-6" wire:poll.300s>
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            @forelse ($data as $row)
                @php
                    $storage_path = "labels/{$row->pegawaiRelasi->kode_pegawai}/capturedImg/{$row->photoURL}.png";
                    $img_check = Storage::disk('public')->exists($storage_path);
                    $image_path = asset(sha1('libs') . '/' . $row->photoURL . '.png');
                    $no_image_path = asset('assets/img/noImage.webp');
                @endphp

                <div wire:click="openModal({{ $row->id }})"
                    class="group relative flex cursor-pointer flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition-all duration-300 hover:border-emerald-200 hover:bg-white hover:shadow-xl hover:shadow-emerald-500/5 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-emerald-900/50 lg:flex-row">

                    {{-- Foto --}}
                    <div class="relative h-44 w-full overflow-hidden lg:h-auto lg:w-44 lg:shrink-0">
                        <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            src="{{ $img_check ? $image_path : $no_image_path }}"
                            alt="{{ $row->pegawaiRelasi->full_name }}"
                            onerror="this.src='{{ asset('assets/img/noImage.webp') }}'">
                    </div>

                    {{-- Info --}}
                    <div class="flex flex-1 flex-col justify-between gap-3 p-4">
                        <div>
                            <div class="mb-1 flex items-start justify-between gap-2">
                                <h5 class="text-base font-black tracking-tight text-zinc-900 dark:text-white flex items-center gap-1.5">
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
                                <span>Check-in pukul {{ \Carbon\Carbon::parse($row->waktuori)->format('H:i:s') }}</span>
                            </div>
                        </div>

                        @if ($row->keterangan)
                            <div class="flex items-start gap-2 border-t border-zinc-200 pt-3 dark:border-zinc-800/50">
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

                    <div
                        class="absolute right-3 top-1/2 -translate-y-1/2 opacity-0 transition-all duration-300 group-hover:translate-x-1 group-hover:opacity-100">
                        <x-icons.arrow-right class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-zinc-200 py-14 dark:border-zinc-800">
                    <div
                        class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-zinc-50 text-zinc-400 dark:bg-zinc-900">
                        <x-icons.question-circle class="h-7 w-7" />
                    </div>
                    <p class="text-base font-bold text-zinc-900 dark:text-white">Belum Ada Data</p>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Tidak ada rekam kehadiran untuk tanggal ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-2">
            {{ $data->links() }}
        </div>
    </div>

    {{-- Detail Modal --}}
    <x-modal.base-modal show="showModal" title="Detail Check-In"
        subtitle="{{ $attendance ? $attendance->created_at->format('d/m/Y H:i:s') : '' }}"
        iconContainerClass="bg-emerald-600 shadow-emerald-500/20" maxWidth="xl">
        <x-slot name="icon">
            <x-icons.check-circle class="h-5 w-5" />
        </x-slot>

        @if ($showModal && $attendance)
            <div class="flex flex-col gap-5">
                {{-- Identitas --}}
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800">
                        <img src="{{ asset(sha1('libs') . '/' . $attendance->photoURL . '.png') }}"
                            class="h-full w-full object-cover" onerror="this.src='{{ asset('assets/img/noImage.webp') }}'">
                    </div>
                    <div>
                        <a href="{{ route('pegawai.detail', $attendance->pegawaiRelasi->id) }}" target="_blank"
                            class="group flex items-center gap-1.5 text-lg font-bold text-zinc-900 hover:text-emerald-600 dark:text-white dark:hover:text-emerald-400">
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
                                <x-icons.check-circle class="h-5 w-5 text-emerald-500" />
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
                    <img src="{{ asset(sha1('libs') . '/' . $attendance->photoURL . '.png') }}" class="w-full object-cover"
                        style="height: 280px;" onerror="this.src='{{ asset('assets/img/noImage.webp') }}'">
                    <div class="absolute inset-0 flex items-end bg-gradient-to-t from-zinc-900/60 to-transparent p-4">
                        <span class="rounded-lg bg-white/20 px-3 py-1 text-xs font-bold text-white backdrop-blur-md">Foto
                            Check-In</span>
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
                            class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950/30 dark:text-emerald-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="flex flex-1 flex-col gap-1">
                            <p class="text-xs font-semibold leading-relaxed text-zinc-700 dark:text-zinc-300">
                                {{ $address }}</p>
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                    target="_blank"
                                    class="flex items-center gap-1 text-xs font-bold text-emerald-600 hover:underline dark:text-emerald-400">
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
