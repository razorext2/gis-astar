{{-- Goal: Detail view for HRD to review and approve/reject attendance inquiry, Livewire: App\Livewire\Handler\AttendanceInquiry\ApprovalCenterShow, Alpine: Toggle rejection reason view --}}
<div class="space-y-6" x-data="{ showRejectForm: false }">
    {{-- Header --}}
    <div
        class="flex items-center gap-3 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">
        <x-button.danger wire:navigate href="{{ route('attendance-inquiry.approval-center.index') }}"
            class="max-h-10 max-w-fit">
            <x-icons.angle-left class="h-5 w-5" />
        </x-button.danger>
        <div class="flex-1">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Tinjau Laporan Absensi</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Diajukan oleh {{ $inquiry->user->name ?? 'Karyawan' }}
                (ID: {{ $inquiry->kode_pegawai }})</p>
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
                {{ $inquiry->status_label }}
            </span>
        </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            {{-- Detail Fields --}}
            <div
                class="space-y-4 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Rincian Pengajuan</h3>

                <div class="grid grid-cols-2 gap-4 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Tipe Absen</span>
                        <p class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $inquiry->type_absen === 'in' ? 'Masuk (Clock In)' : 'Keluar (Clock Out)' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Status Kehadiran</span>
                        <p class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $inquiry->position_status_label }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Waktu Absen
                            (Tanggal/Jam)</span>
                        <p class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $inquiry->waktu_absen->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Nomor VT</span>
                        <p class="mt-0.5 font-mono text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $inquiry->no_vt ?: '-' }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    <span class="text-xs font-bold uppercase tracking-wider text-zinc-400">Keterangan Pengajuan</span>
                    <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">
                        {{ $inquiry->keterangan }}
                    </p>
                </div>
            </div>

            {{-- Bukti Foto --}}
            <div
                class="rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">
                <h3 class="mb-4 text-base font-bold text-zinc-900 dark:text-white">Lampiran Bukti Foto</h3>
                @if (!empty($inquiry->bukti))
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        @foreach ($inquiry->bukti as $path)
                            <div
                                class="group relative overflow-hidden rounded-lg border border-zinc-200 bg-zinc-50 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                                <img src="{{ asset('storage/' . $path) }}"
                                    class="h-32 w-full object-cover transition-transform duration-300 hover:scale-105"
                                    alt="Bukti Absensi"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank"
                                        class="rounded-lg bg-zinc-900/80 px-3 py-1.5 text-xs font-bold text-white">
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

            {{-- HRD Action Panel --}}
            @if ($inquiry->status === 'pending')
                <div
                    class="space-y-4 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">
                    <h3 class="text-base font-bold text-zinc-900 dark:text-white">Tindakan HRD</h3>

                    <div class="flex flex-wrap items-center gap-3">
                        <button wire:click="approve" wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition-all hover:bg-blue-700 disabled:opacity-50">
                            Setujui Laporan
                        </button>

                        <button type="button" @click="showRejectForm = !showRejectForm"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-zinc-200 bg-white px-6 py-2.5 text-sm font-semibold text-zinc-700 shadow-sm hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            Tolak Laporan
                        </button>
                    </div>

                    {{-- Rejection Form (Slide Down) --}}
                    <div x-show="showRejectForm" x-collapse
                        class="mt-4 space-y-3 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                        <label for="rejection_reason"
                            class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">Alasan Penolakan <span
                                class="text-red-500">*</span></label>
                        <textarea id="rejection_reason" wire:model.live="rejection_reason" rows="3"
                            placeholder="Masukkan alasan mengapa pengajuan ini ditolak..."
                            class="block w-full rounded-lg border-zinc-200 bg-white/50 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white"></textarea>
                        @error('rejection_reason')
                            <span class="block text-xs text-red-500">{{ $message }}</span>
                        @enderror

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showRejectForm = false"
                                class="text-sm font-semibold text-zinc-500 hover:text-zinc-600 dark:text-zinc-400">Batal</button>
                            <button type="button" wire:click="reject"
                                class="text-sm font-bold text-red-600 hover:text-red-500 dark:text-red-400">Kirim
                                Penolakan</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Geolocation Card --}}
        <div class="space-y-6">
            <div
                class="rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">
                <h3 class="mb-4 text-base font-bold text-zinc-900 dark:text-white">Lokasi</h3>

                @if ($inquiry->latitude && $inquiry->longitude)
                    <div class="space-y-4">
                        <div
                            class="aspect-video w-full overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-800">
                            <iframe class="h-full w-full border-0"
                                src="https://maps.google.com/maps?q={{ $inquiry->latitude }},{{ $inquiry->longitude }}&hl=id&z=15&t=m&output=embed"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <div class="space-y-1 text-xs text-zinc-500 dark:text-zinc-400">
                            <p>Latitude: <strong
                                    class="text-zinc-700 dark:text-zinc-200">{{ $inquiry->latitude }}</strong></p>
                            <p>Longitude: <strong
                                    class="text-zinc-700 dark:text-zinc-200">{{ $inquiry->longitude }}</strong></p>
                        </div>

                        <a href="https://www.google.com/maps/search/?api=1&query={{ $inquiry->latitude }},{{ $inquiry->longitude }}"
                            target="_blank"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <x-icons.map-pin class="h-4 w-4 text-red-500" /> Buka Google Maps
                        </a>
                    </div>
                @else
                    <div class="py-6 text-center text-zinc-500">
                        <x-icons.info-circle class="mx-auto mb-2 h-8 w-8 text-zinc-400" />
                        <p class="text-sm">Lokasi koordinat GPS tidak tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
