<div class="grid w-full grid-cols-1 gap-y-6">

    {{-- Filter Bar --}}
    <div class="flex w-full flex-col items-center gap-3 sm:flex-row">
        <div class="grid w-full grid-cols-1 gap-3 sm:grid-cols-2">
            <x-input.select wire:model.live="role" :labels="false" id="role-out" name="role"
                :defaultOption="'Semua Role'" placeholder="Pilih Role" :options="$this->roleOptions" />

            <input type="date" wire:model.live="date"
                class="block w-full rounded-xl border border-zinc-200 bg-white/50 px-4 py-2.5 text-sm font-medium text-zinc-900 backdrop-blur-sm transition-all focus:border-red-500 focus:ring-red-500 dark:border-zinc-800 dark:bg-zinc-900/50 dark:text-white">
        </div>

        <div class="hidden shrink-0 items-center gap-2 rounded-2xl border border-red-100 bg-red-50/50 px-4 py-2 text-xs font-bold text-red-700 dark:border-red-900/30 dark:bg-red-950/20 dark:text-red-400 sm:flex">
            <x-icons.minus-circle class="h-3.5 w-3.5" />
            <span>{{ $data->total() }} Check-Out</span>
        </div>
    </div>

    {{-- Attendance Out Grid --}}
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
                    class="group relative flex cursor-pointer flex-col overflow-hidden rounded-3xl border border-zinc-200 bg-white/70 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-red-200 hover:bg-white hover:shadow-xl hover:shadow-red-500/5 dark:border-zinc-800 dark:bg-zinc-900/70 dark:hover:border-red-900/50 dark:hover:bg-zinc-900 lg:flex-row">

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
                                <h5 class="text-base font-black tracking-tight text-zinc-900 dark:text-white">
                                    {{ $row->pegawaiRelasi->full_name }}
                                </h5>
                                <span class="rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-bold text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                    {{ $row->timezone ?? 'WIB' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs font-medium text-red-600 dark:text-red-400">
                                <x-icons.minus-circle class="h-3.5 w-3.5" />
                                <span>Check-out pukul {{ \Carbon\Carbon::parse($row->waktuori)->format('H:i:s') }}</span>
                            </div>
                        </div>

                        @if ($row->keterangan)
                            <div class="flex items-start gap-2 border-t border-zinc-100 pt-3 dark:border-zinc-800/50">
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

                    <div class="absolute right-3 top-1/2 -translate-y-1/2 opacity-0 transition-all duration-300 group-hover:translate-x-1 group-hover:opacity-100">
                        <x-icons.arrow-right class="h-5 w-5 text-red-600 dark:text-red-400" />
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-zinc-200 py-14 dark:border-zinc-800">
                    <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-zinc-50 text-zinc-400 dark:bg-zinc-900">
                        <x-icons.question-circle class="h-7 w-7" />
                    </div>
                    <p class="text-base font-bold text-zinc-900 dark:text-white">Belum Ada Data</p>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Tidak ada rekam keluar untuk tanggal ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-2">
            {{ $data->links() }}
        </div>
    </div>

    {{-- Detail Modal --}}
    <template x-teleport="body">
        <div x-data="{ show: @entangle('showModalOut') }" x-show="show"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 backdrop-blur-md"
            style="background-color: rgba(9,9,11,0.65);"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click.self="show = false" x-cloak>

            <div x-show="show"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="relative flex w-full max-w-xl flex-col rounded-3xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-zinc-950">

                @if ($showModalOut && $attendance)
                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-zinc-100 p-5 dark:border-zinc-800/50">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-600 text-white shadow-lg shadow-red-500/20">
                                <x-icons.minus-circle class="h-5 w-5" />
                            </div>
                            <div>
                                <h2 class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">Detail Check-Out</h2>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                                    {{ $attendance->created_at->format('d/m/Y H:i:s') }}
                                </p>
                            </div>
                        </div>
                        <button @click="show = false" class="rounded-full p-2 text-zinc-400 hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-900 dark:hover:text-white">
                            <x-icons.close class="h-5 w-5" />
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 flex-1 overflow-y-auto p-6" style="max-height: 70vh;">
                        <div class="flex flex-col gap-5">
                            {{-- Identitas --}}
                            <div class="flex items-center gap-4">
                                <div class="h-14 w-14 overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-900">
                                    <img src="{{ asset(sha1('libs') . '/' . $attendance->photoURL . '.png') }}"
                                        class="h-full w-full object-cover"
                                        onerror="this.src='{{ asset('assets/img/noImage.webp') }}'">
                                </div>
                                <div>
                                    <a href="{{ route('pegawai.detail', $attendance->pegawaiRelasi->id) }}" target="_blank"
                                        class="group flex items-center gap-1.5 text-lg font-black text-zinc-900 hover:text-red-600 dark:text-white dark:hover:text-red-400">
                                        {{ $attendance->pegawaiRelasi->full_name }}
                                        <x-icons.arrow-right class="h-4 w-4 -rotate-45 opacity-0 transition-all group-hover:opacity-100" />
                                    </a>
                                    <span class="text-xs font-bold text-zinc-500">ID: {{ $attendance->pegawaiRelasi->kode_pegawai }}</span>
                                </div>
                            </div>

                            {{-- Foto Presensi --}}
                            <div class="relative overflow-hidden rounded-2xl border border-zinc-100 dark:border-zinc-800">
                                <img src="{{ asset(sha1('libs') . '/' . $attendance->photoURL . '.png') }}"
                                    class="w-full object-cover" style="height: 280px;"
                                    onerror="this.src='{{ asset('assets/img/noImage.webp') }}'">
                                <div class="absolute inset-0 flex items-end bg-gradient-to-t from-zinc-900/50 to-transparent p-4">
                                    <span class="rounded-lg bg-white/20 px-3 py-1 text-xs font-bold text-white backdrop-blur-md">Foto Check-Out</span>
                                </div>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex flex-col gap-3">
                                {{-- Map Embed - Google Maps Satellite --}}
                                <div class="overflow-hidden rounded-2xl border border-zinc-100 dark:border-zinc-800">
                                    <iframe
                                        src="https://maps.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}&z=18&t=k&output=embed"
                                        class="w-full"
                                        style="height: 220px; border: none;"
                                        loading="lazy"
                                        allowfullscreen
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>

                                {{-- Address + Link --}}
                                <div class="flex items-start gap-3 rounded-2xl bg-zinc-50/50 p-3 dark:bg-zinc-900/30">
                                    <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-950/30 dark:text-red-400">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-1 flex-col gap-1">
                                        <p class="text-xs font-bold leading-relaxed text-zinc-700 dark:text-zinc-300">{{ $address }}</p>
                                        <div class="flex flex-wrap items-center gap-3">
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                                target="_blank" class="flex items-center gap-1 text-xs font-bold text-red-600 hover:underline dark:text-red-400">
                                                Buka di Google Maps <x-icons.arrow-right class="h-3 w-3 -rotate-45" />
                                            </a>
                                            <span class="text-[10px] text-zinc-400">{{ $attendance->latitude }}, {{ $attendance->longitude }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800/50 dark:bg-zinc-950/20">
                        <x-button.primary class="w-full justify-center" wire:click="set('showModalOut', false)">
                            Tutup Detail
                        </x-button.primary>
                    </div>
                @endif
            </div>
        </div>
    </template>
</div>
