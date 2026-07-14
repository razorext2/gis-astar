{{-- Goal: Render a premium interactive carousel for unverified attendance records, Livewire: Components\UnverifiedAttendance, Alpine: - --}}
<div>
    @if ($records->isNotEmpty())
        <div
            class="relative mb-4 w-full rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
            <div class="mb-4 flex items-center gap-3">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500 text-white shadow-lg shadow-amber-500/20">
                    <x-icons.exclamation-circle class="h-5 w-5" />
                </div>
                <div>
                    <h2 class="text-lg font-black tracking-tight text-zinc-900 dark:text-white">Butuh Verifikasi</h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Terdapat {{ $records->count() }} data absensi
                        {{ $type === 'in' ? 'masuk' : 'keluar' }} yang memerlukan verifikasi manual.</p>
                </div>
            </div>

            <!-- Horizontal Swipeable/Scrollable Carousel -->
            <div
                class="scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800 flex snap-x snap-mandatory flex-nowrap gap-4 overflow-x-auto pb-4">
                @foreach ($records as $row)
                    @php
                        $storage_path = "labels/{$row->pegawaiRelasi->kode_pegawai}/capturedImg/{$row->photoURL}.png";
                        $img_check = Storage::disk('public')->exists($storage_path);
                        $image_path = asset(sha1('libs') . '/' . $row->photoURL . '.png');
                        $no_image_path = asset('assets/img/noImage.webp');
                        $time = \Carbon\Carbon::parse($row->waktuori);
                    @endphp

                    <div wire:key="unverified-card-{{ $row->id }}"
                        class="group relative flex w-80 shrink-0 snap-start flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition-all duration-300 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-amber-900/50">

                        <!-- Top Half: Image & Date -->
                        <div class="relative h-36 w-full overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                            <img id="documentations"
                                data-url="{{ $img_check ? $image_path : $no_image_path }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105 cursor-pointer"
                                src="{{ $img_check ? $image_path : $no_image_path }}"
                                alt="{{ $row->pegawaiRelasi->full_name }}"
                                onerror="this.src='{{ asset('assets/img/noImage.webp') }}'">

                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent pointer-events-none">
                            </div>

                            <!-- Floating Similarity Badge -->
                            @if($row->distance !== null)
                                @php
                                    $similarity_val = (1 - round($row->distance, 2)) * 100;
                                @endphp
                                <span class="absolute left-3 top-3 rounded-full bg-emerald-600/90 border border-emerald-500/30 px-2 py-0.5 text-[10px] font-bold text-white backdrop-blur-md flex items-center gap-1 shadow-sm z-10">
                                    <x-icons.check-circle class="h-3 w-3 text-emerald-100" />
                                    Kemiripan {{ $similarity_val }}%
                                </span>
                            @endif

                            <!-- Floating Time badge -->
                            <span
                                class="absolute right-3 top-3 rounded-full bg-white/20 px-2 py-0.5 text-[10px] font-bold text-white backdrop-blur-md z-10">
                                {{ $row->timezone ?? 'WIB' }}
                            </span>

                            <!-- Floating Date & time text -->
                            <div class="absolute bottom-3 left-3 flex flex-col text-white">
                                <span
                                    class="text-xs font-bold leading-none text-white/80">{{ $time->locale('id')->isoFormat('dddd, D MMM') }}</span>
                                <span class="mt-1 text-lg font-black leading-none">{{ $time->format('H:i:s') }}</span>
                            </div>
                        </div>

                        <!-- Bottom Half: Employee details & actions -->
                        <div class="flex flex-1 flex-col justify-between gap-3 p-4">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h5 class="max-w-[160px] truncate text-sm font-bold text-zinc-900 dark:text-white"
                                        title="{{ $row->pegawaiRelasi->full_name }}">
                                        {{ $row->pegawaiRelasi->full_name }}
                                    </h5>
                                    <span
                                        class="font-mono text-[10px] font-semibold text-zinc-400 dark:text-zinc-500">ID:
                                        {{ $row->pegawaiRelasi->kode_pegawai }}</span>
                                </div>

                                <!-- Coordinates / Map Link -->
                                @if ($row->latitude && $row->longitude)
                                    <a class="inline-flex w-fit items-center gap-1 text-[10px] text-zinc-500 hover:text-blue-600 hover:underline dark:text-zinc-400 dark:hover:text-blue-400"
                                        href="https://www.google.com/maps/search/?api=1&query={{ $row->latitude }},{{ $row->longitude }}"
                                        target="_blank">
                                        <x-icons.map-pin class="h-3 w-3 text-zinc-400 dark:text-zinc-500" />
                                        <span>{{ round($row->latitude, 4) }}, {{ round($row->longitude, 4) }}</span>
                                    </a>
                                @endif

                                <!-- Keterangan / Note -->
                                @if ($row->keterangan)
                                    <p
                                        class="mt-1 line-clamp-1 border-l border-zinc-200 pl-1.5 text-[10px] italic leading-normal text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                        "{{ $row->keterangan }}"
                                    </p>
                                @endif
                            </div>

                            <!-- Actions verification buttons -->
                            <div class="mt-1 grid grid-cols-2 gap-2">
                                <x-button.danger wire:click="reject({{ $row->id }})"
                                    wire:confirm.prompt="Ketik TOLAK untuk menolak absensi {{ $row->pegawaiRelasi->nick_name ?? 'pegawai' }}.|TOLAK"
                                    class="w-full !px-2 !py-1.5 text-xs">
                                    <x-slot name="icon">
                                        <x-icons.close class="h-3.5 w-3.5" />
                                    </x-slot>
                                    Tolak
                                </x-button.danger>

                                <x-button.success wire:click="verify({{ $row->id }})"
                                    wire:confirm.prompt="Ketik SETUJU untuk menyetujui absensi {{ $row->pegawaiRelasi->nick_name ?? 'pegawai' }}.|SETUJU"
                                    class="w-full !px-2 !py-1.5 text-xs shadow-sm">
                                    <x-slot name="icon">
                                        <x-icons.check class="h-3.5 w-3.5" />
                                    </x-slot>
                                    Verifikasi
                                </x-button.success>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
