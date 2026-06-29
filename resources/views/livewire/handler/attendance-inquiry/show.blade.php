{{-- Goal: Display own attendance inquiry detail, Livewire: App\Livewire\Handler\AttendanceInquiry\Show, Alpine: - --}}
<div class="space-y-6">
    {{-- Header --}}
<<<<<<< HEAD
    <div
        class="flex items-center gap-3 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60">
        <x-button.danger wire:navigate href="{{ route('attendance-inquiry.my-inquiries.index') }}"
            class="max-h-10 max-w-fit">
            <x-icons.angle-left class="h-5 w-5" />
        </x-button.danger>
        <div class="flex-1">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Detail Laporan Absensi</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Diajukan pada
                {{ $inquiry->created_at->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}</p>
        </div>
        <div>
            @php
                $statusColor = match ($inquiry->status) {
                    'approved'
                        => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800',
                    'rejected'
                        => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800',
                    default
                        => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800',
                };
            @endphp
            <span class="{{ $statusColor }} inline-flex items-center rounded-lg border px-4 py-1.5 text-sm font-bold">
=======
    <div class="flex items-center gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60">
        <a href="{{ route('attendance-inquiry.my-inquiries.index') }}" wire:navigate class="rounded-lg border border-zinc-200 p-2 text-zinc-600 hover:bg-zinc-50 dark:border-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-800">
            <x-icons.arrow-left class="h-5 w-5" />
        </a>
        <div class="flex-1">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">Detail Laporan Absensi</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Diajukan pada {{ $inquiry->created_at->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}</p>
        </div>
        <div>
            @php
                $statusColor = match($inquiry->status) {
                    'approved' => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800',
                    'rejected' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800',
                    default => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800',
                };
            @endphp
            <span class="inline-flex items-center rounded-lg border px-4 py-1.5 text-sm font-bold {{ $statusColor }}">
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                {{ $inquiry->status_label }}
            </span>
        </div>
    </div>

    {{-- Rejection Warning Card --}}
    @if ($inquiry->status === 'rejected')
<<<<<<< HEAD
        <div
            class="rounded-xl border border-red-200 bg-red-50/50 p-4 text-red-800 dark:border-red-800 dark:bg-red-900/10 dark:text-red-400">
            <div class="flex gap-3">
                <x-icons.exclamation-circle class="h-5 w-5 flex-shrink-0" />
                <div>
                    <h4 class="text-sm font-bold">Pengajuan Laporan Absensi Ditolak</h4>
                    <p class="mt-1 text-xs font-semibold">Alasan penolakan:</p>
                    <p class="mt-0.5 text-sm">{{ $inquiry->rejection_reason }}</p>
                    <p class="mt-2 text-[10px] text-zinc-400">Ditolak oleh {{ $inquiry->actedByUser->name ?? 'HRD' }}
                        pada {{ $inquiry->acted_at->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}</p>
=======
        <div class="rounded-xl border border-red-200 bg-red-50/50 p-4 text-red-800 dark:border-red-800 dark:bg-red-900/10 dark:text-red-400">
            <div class="flex gap-3">
                <x-icons.exclamation-circle class="h-5 w-5 flex-shrink-0" />
                <div>
                    <h4 class="font-bold text-sm">Pengajuan Laporan Absensi Ditolak</h4>
                    <p class="mt-1 text-xs font-semibold">Alasan penolakan:</p>
                    <p class="text-sm mt-0.5">{{ $inquiry->rejection_reason }}</p>
                    <p class="text-[10px] text-zinc-400 mt-2">Ditolak oleh {{ $inquiry->actedByUser->name ?? 'HRD' }} pada {{ $inquiry->acted_at->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}</p>
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                </div>
            </div>
        </div>
    @endif

    {{-- Approval Info Card --}}
    @if ($inquiry->status === 'approved')
<<<<<<< HEAD
        <div
            class="rounded-xl border border-green-200 bg-green-50/50 p-4 text-green-800 dark:border-green-800 dark:bg-green-900/10 dark:text-green-400">
            <div class="flex gap-3">
                <x-icons.check-circle class="h-5 w-5 flex-shrink-0" />
                <div>
                    <h4 class="text-sm font-bold">Pengajuan Laporan Absensi Disetujui</h4>
                    <p class="mt-0.5 text-sm">Absensi telah berhasil ditambahkan ke riwayat kehadiran Anda.</p>
                    <p class="mt-2 text-[10px] text-zinc-400">Disetujui oleh {{ $inquiry->actedByUser->name ?? 'HRD' }}
                        pada {{ $inquiry->acted_at->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}</p>
=======
        <div class="rounded-xl border border-green-200 bg-green-50/50 p-4 text-green-800 dark:border-green-800 dark:bg-green-900/10 dark:text-green-400">
            <div class="flex gap-3">
                <x-icons.check-circle class="h-5 w-5 flex-shrink-0" />
                <div>
                    <h4 class="font-bold text-sm">Pengajuan Laporan Absensi Disetujui</h4>
                    <p class="text-sm mt-0.5">Absensi telah berhasil ditambahkan ke riwayat kehadiran Anda.</p>
                    <p class="text-[10px] text-zinc-400 mt-2">Disetujui oleh {{ $inquiry->actedByUser->name ?? 'HRD' }} pada {{ $inquiry->acted_at->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}</p>
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                </div>
            </div>
        </div>
    @endif

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
<<<<<<< HEAD
        <div class="space-y-6 lg:col-span-2">
            {{-- Detail Fields --}}
            <div
                class="space-y-4 rounded-xl border border-zinc-200 bg-white/60 p-5 dark:border-zinc-800 dark:bg-zinc-900/60">
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Rincian Pengajuan</h3>

                <div class="grid grid-cols-2 gap-4 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Tipe Absen</span>
                        <p class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-white">
=======
        <div class="lg:col-span-2 space-y-6">
            {{-- Detail Fields --}}
            <div class="rounded-xl border border-zinc-200 bg-white/60 p-5 dark:border-zinc-800 dark:bg-zinc-900/60 space-y-4">
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Rincian Pengajuan</h3>
                
                <div class="grid grid-cols-2 gap-4 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Tipe Absen</span>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white mt-0.5">
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                            {{ $inquiry->type_absen === 'in' ? 'Masuk (Clock In)' : 'Keluar (Clock Out)' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Status Kehadiran</span>
<<<<<<< HEAD
                        <p class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-white">
=======
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white mt-0.5">
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                            {{ $inquiry->position_status_label }}
                        </p>
                    </div>
                    <div>
<<<<<<< HEAD
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Waktu Absen
                            (Tanggal/Jam)</span>
                        <p class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-white">
=======
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Waktu Absen (Tanggal/Jam)</span>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white mt-0.5">
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                            {{ $inquiry->waktu_absen->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Nomor VT</span>
<<<<<<< HEAD
                        <p class="mt-0.5 font-mono text-sm font-semibold text-zinc-900 dark:text-white">
=======
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white mt-0.5 font-mono">
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                            {{ $inquiry->no_vt ?: '-' }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Keterangan Pengajuan</span>
<<<<<<< HEAD
                    <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">
=======
                    <p class="text-sm text-zinc-700 dark:text-zinc-300 mt-1 whitespace-pre-line leading-relaxed">
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                        {{ $inquiry->keterangan }}
                    </p>
                </div>
            </div>

            {{-- Bukti Foto --}}
            <div class="rounded-xl border border-zinc-200 bg-white/60 p-5 dark:border-zinc-800 dark:bg-zinc-900/60">
<<<<<<< HEAD
                <h3 class="mb-4 text-base font-bold text-zinc-900 dark:text-white">Lampiran Bukti Foto</h3>
                @if (!empty($inquiry->bukti))
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        @foreach ($inquiry->bukti as $path)
                            <div
                                class="group relative overflow-hidden rounded-lg border border-zinc-200 bg-zinc-50 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                                <img src="{{ asset('storage/' . $path) }}"
                                    class="h-32 w-full object-cover transition-transform duration-300 hover:scale-105"
                                    alt="Bukti Absensi">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank"
                                        class="rounded-lg bg-zinc-900/80 px-3 py-1.5 text-xs font-bold text-white">
=======
                <h3 class="text-base font-bold text-zinc-900 dark:text-white mb-4">Lampiran Bukti Foto</h3>
                @if(!empty($inquiry->bukti))
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        @foreach ($inquiry->bukti as $path)
                            <div class="group relative rounded-lg border border-zinc-200 overflow-hidden bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 shadow-sm">
                                <img src="{{ asset('storage/'.$path) }}" class="h-32 w-full object-cover transition-transform duration-300 hover:scale-105" alt="Bukti Absensi">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <a href="{{ asset('storage/'.$path) }}" target="_blank" class="text-white text-xs font-bold bg-zinc-900/80 px-3 py-1.5 rounded-lg">
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                                        Perbesar
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-500">Tidak ada lampiran bukti foto.</p>
                @endif
            </div>
        </div>

        {{-- Geolocation Card --}}
        <div class="space-y-6">
            <div class="rounded-xl border border-zinc-200 bg-white/60 p-5 dark:border-zinc-800 dark:bg-zinc-900/60">
<<<<<<< HEAD
                <h3 class="mb-4 text-base font-bold text-zinc-900 dark:text-white">Lokasi</h3>

                @if ($inquiry->latitude && $inquiry->longitude)
                    <div class="space-y-4">
                        <div
                            class="aspect-video w-full overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-800">
                            <iframe class="h-full w-full border-0"
=======
                <h3 class="text-base font-bold text-zinc-900 dark:text-white mb-4">Titik Geokordinat</h3>
                
                @if ($inquiry->latitude && $inquiry->longitude)
                    <div class="space-y-4">
                        <div class="aspect-video w-full rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-800">
                            <iframe 
                                class="w-full h-full border-0"
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                                src="https://maps.google.com/maps?q={{ $inquiry->latitude }},{{ $inquiry->longitude }}&hl=id&z=15&t=m&output=embed"
                                allowfullscreen>
                            </iframe>
                        </div>
<<<<<<< HEAD

                        <div class="space-y-1 text-xs text-zinc-500 dark:text-zinc-400">
                            <p>Latitude: <strong
                                    class="text-zinc-700 dark:text-zinc-200">{{ $inquiry->latitude }}</strong></p>
                            <p>Longitude: <strong
                                    class="text-zinc-700 dark:text-zinc-200">{{ $inquiry->longitude }}</strong></p>
                        </div>

                        <a href="https://www.google.com/maps/search/?api=1&query={{ $inquiry->latitude }},{{ $inquiry->longitude }}"
                            target="_blank"
=======
                        
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 space-y-1">
                            <p>Latitude: <strong class="text-zinc-700 dark:text-zinc-200">{{ $inquiry->latitude }}</strong></p>
                            <p>Longitude: <strong class="text-zinc-700 dark:text-zinc-200">{{ $inquiry->longitude }}</strong></p>
                        </div>

                        <a href="https://www.google.com/maps/search/?api=1&query={{ $inquiry->latitude }},{{ $inquiry->longitude }}" target="_blank"
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <x-icons.map-pin class="h-4 w-4 text-red-500" /> Buka Google Maps
                        </a>
                    </div>
                @else
<<<<<<< HEAD
                    <div class="py-6 text-center text-zinc-500">
                        <x-icons.info-circle class="mx-auto mb-2 h-8 w-8 text-zinc-400" />
=======
                    <div class="text-center py-6 text-zinc-500">
                        <x-icons.info-circle class="mx-auto h-8 w-8 text-zinc-400 mb-2" />
>>>>>>> bcd561e0 (initial version dari inquiry absen)
                        <p class="text-sm">Lokasi koordinat GPS tidak tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
