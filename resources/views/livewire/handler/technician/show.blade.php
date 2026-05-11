{{-- Goal: Tampilkan detail laporan teknisi dengan desain informatif, Livewire: Handler\Technician\Show, Alpine: modal alasan (deny/revisi) --}}
<div class="space-y-4">

    {{-- ===== HEADER CARD: Info Kunjungan & Status ===== --}}
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">

        {{-- Top row: No VT + Status badge + Action buttons --}}
        <div
            class="flex flex-col justify-between gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800 sm:flex-row sm:items-start">
            <div class="flex flex-col gap-2">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">
                        {{ $report->no_vt }}
                    </h2>

                    @php
                        $statusBadge = match ($report->status) {
                            0 => [
                                'text' => 'Butuh Konfirmasi',
                                'class' =>
                                    'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-900/20 dark:text-amber-400 dark:ring-amber-500/30',
                            ],
                            1 => [
                                'text' => 'Diterima',
                                'class' =>
                                    'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-500/30',
                            ],
                            2 => [
                                'text' => 'Butuh Revisi',
                                'class' =>
                                    'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-500/30',
                            ],
                            3 => [
                                'text' => 'Ditolak',
                                'class' =>
                                    'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-500/30',
                            ],
                            4 => [
                                'text' => 'Draft',
                                'class' =>
                                    'bg-zinc-50 text-zinc-700 ring-zinc-600/20 dark:bg-zinc-900/20 dark:text-zinc-400 dark:ring-zinc-500/30',
                            ],
                            default => [
                                'text' => 'Tidak Diketahui',
                                'class' =>
                                    'bg-zinc-50 text-zinc-700 ring-zinc-600/20 dark:bg-zinc-900/20 dark:text-zinc-400 dark:ring-zinc-500/30',
                            ],
                        };
                    @endphp

                    <span class="{{ $statusBadge['class'] }} rounded-lg px-2.5 py-1 text-xs font-semibold ring-1">
                        {{ $statusBadge['text'] }}
                    </span>
                </div>

                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    ID Permintaan: <span
                        class="font-medium text-zinc-700 dark:text-zinc-300">{{ $report->id_permintaan }}</span>
                    &nbsp;·&nbsp;
                    Tanggal Kunjungan: <span
                        class="font-medium text-zinc-700 dark:text-zinc-300">{{ \Carbon\Carbon::parse($report->visit_date)->locale('id')->isoFormat('D MMMM Y') }}</span>
                </p>

                @if ($report->notes && in_array($report->status, [2, 3]))
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                        <span class="font-semibold">Catatan:</span> {{ $report->notes }}
                    </p>
                @endif
            </div>

            {{-- Action Buttons (hanya status=0 dan punya permission) --}}
            @can('technician-approve')
                @if ($report->status === 0)
                    <div class="flex shrink-0 flex-wrap gap-2">
                        {{-- Konfirmasi --}}
                        <x-button.success id="btn-confirm" wire:click="confirm"
                            wire:confirm.prompt="Konfirmasi laporan ini? Data akan disinkronkan ke server.\n\nKetik YA untuk melanjutkan.|YA"
                            wire:loading.attr="disabled" wire:target="confirm">
                            <x-slot name="icon">
                                <x-icons.check-circle wire:loading.remove wire:target="confirm" class="h-5 w-5" />
                                <x-icons.loading wire:loading wire:target="confirm" class="h-4 w-4 animate-spin" />
                            </x-slot>
                            <span wire:loading.remove wire:target="confirm">Konfirmasi</span>
                            <span wire:loading wire:target="confirm">Memproses...</span>
                        </x-button.success>

                        {{-- Minta Revisi --}}
                        <x-button.primary id="btn-revision" wire:click="openReasonModal('revision')"
                            wire:loading.attr="disabled" wire:target="openReasonModal">
                            <x-slot name="icon">
                                <x-icons.angle-right class="h-5 w-5" />
                            </x-slot>
                            Minta Revisi
                        </x-button.primary>

                        {{-- Tolak --}}
                        {{-- <x-button.danger id="btn-deny" wire:click="openReasonModal('deny')" wire:loading.attr="disabled"
                            wire:target="openReasonModal">
                            <x-slot name="icon">
                                <x-icons.trash-bin class="h-5 w-5" />
                            </x-slot>
                            Tolak
                        </x-button.danger> --}}
                    </div>
                @endif
            @endcan
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- Card: Info Teknisi --}}
            <div
                class="flex flex-col gap-3 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.user class="h-4 w-4 text-blue-500" /> Informasi Teknisi
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Kode Pegawai</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->kode_pegawai }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nama Teknisi</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $report->pegawai->full_name ?? 'Belum terdaftar di sistem.' }}
                        </span>
                    </div>
                    <div class="col-span-2 flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nomor Telepon</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $report->pegawai->no_telp ?? '-' }}
                        </span>
                    </div>
                    <div class="col-span-2 flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Waktu Update Laporan</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($report->updated_at)->locale('id')->isoFormat('HH:mm:ss, DD MMMM YYYY') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card: Info Customer --}}
            <div
                class="flex flex-col gap-3 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.users class="h-4 w-4 text-blue-500" /> Informasi Customer
                </h3>
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Nama / Contact</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->customer_contact }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Alamat</span>
                        <span class="text-sm font-medium leading-relaxed text-zinc-700 dark:text-zinc-300">
                            {{ $report->customer_address }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card: Spesifikasi Timbangan --}}
            <div
                class="flex flex-col gap-3 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 md:col-span-2">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.archive class="h-4 w-4 text-blue-500" /> Spesifikasi Timbangan
                </h3>
                <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Jenis Timbangan</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->weight_type ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Ukuran</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->size ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Kapasitas</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->capacity ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tipe Junctionbox</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->junction_type ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tipe Indikator</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->indicator_type ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">SN Indikator</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->indicator_sn ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tipe Loadcell</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->loadcell_type ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">SN Loadcell</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->loadcell_sn ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Jumlah Loadcell</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->loadcell_qty ?: '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Card: Rincian Pekerjaan --}}
            <div
                class="flex flex-col gap-3 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.clipboard class="h-4 w-4 text-blue-500" /> Rincian Pekerjaan
                </h3>
                <pre
                    class="max-h-60 overflow-y-auto whitespace-pre-wrap rounded-lg bg-zinc-50 p-3 text-sm leading-relaxed text-zinc-700 dark:bg-zinc-800/50 dark:text-zinc-300">{{ $report->job_detail }}</pre>
            </div>

            {{-- Card: Update Pekerjaan --}}
            <div
                class="flex flex-col gap-3 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.rectangle-list class="h-4 w-4 text-blue-500" /> Update Pekerjaan
                </h3>
                <pre
                    class="max-h-60 overflow-y-auto whitespace-pre-wrap rounded-lg bg-zinc-50 p-3 text-sm leading-relaxed text-zinc-700 dark:bg-zinc-800/50 dark:text-zinc-300">{{ $report->job_update }}</pre>
            </div>

            {{-- Card: Dokumentasi --}}
            <div
                class="flex flex-col gap-3 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 md:col-span-2">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.cloud-upload class="h-4 w-4 text-blue-500" /> Dokumentasi
                </h3>

                @if ($report->photo_collects->isNotEmpty())
                    <div class="flex flex-wrap gap-3" id="captured-images">
                        @foreach ($report->photo_collects as $photo)
                            @php $ext = strtolower(pathinfo($photo->photourl, PATHINFO_EXTENSION)); @endphp

                            @if ($ext === 'pdf')
                                <a href="{{ url('/storage/technician/' . $photo->photourl) }}" target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-4 py-2 text-sm font-medium text-blue-600 transition hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-blue-400 dark:hover:bg-zinc-700">
                                    <x-icons.clipboard class="h-4 w-4" />
                                    Lihat Dokumen PDF
                                </a>
                            @elseif (in_array($ext, ['png', 'jpg', 'jpeg']))
                                <div class="flex-shrink-0">
                                    <img id="documentations"
                                        class="h-36 w-36 cursor-pointer rounded-xl object-cover ring-1 ring-zinc-200 transition duration-300 ease-in-out hover:scale-105 dark:ring-zinc-700"
                                        src="{{ asset($photo->photourl) }}" data-url="{{ asset($photo->photourl) }}"
                                        alt="Dokumentasi kunjungan"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                        onclick="javascript:void(0)" loading="lazy">
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Tidak ada dokumentasi tersedia.</p>
                @endif
            </div>

            {{-- Card: Status Validasi & Revisi --}}
            <div
                class="flex flex-col gap-3 rounded-xl border border-zinc-100 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 md:col-span-2">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.check-circle class="h-4 w-4 text-blue-500" /> Riwayat Validasi
                </h3>
                <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Status</span>
                        <span
                            class="{{ $statusBadge['class'] }} mt-1 w-fit rounded-lg px-2.5 py-1 text-xs font-semibold ring-1">
                            {{ $statusBadge['text'] }}
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Divalidasi Oleh</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->user->name ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tanggal Validasi</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $report->validate_at ? \Carbon\Carbon::parse($report->validate_at)->locale('id')->isoFormat('D MMMM Y, HH:mm') : '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Catatan Validasi</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->notes ?? '-' }}</span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Total Revisi</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->total_revision }}
                            kali</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Direvisi Oleh</span>
                        <span
                            class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $report->revised_by->name ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tanggal Revisi</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $report->revised_at ? \Carbon\Carbon::parse($report->revised_at)->locale('id')->isoFormat('D MMMM Y, HH:mm') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== MODAL: Alasan Tolak / Revisi ===== --}}
    <x-modal.base-modal show="showReasonModal" :title="$actionType === 'deny' ? 'Alasan Penolakan' : 'Alasan Revisi'" :subtitle="$actionType === 'deny' ? 'Berikan alasan yang jelas mengapa laporan ini ditolak.' : 'Jelaskan apa yang perlu diperbaiki oleh teknisi.'">

        <x-slot name="icon">
            <x-icons.clipboard class="h-5 w-5" />
        </x-slot>

        <div class="space-y-2">
            <x-input.textarea id="reason-input" name="reason" wire:model="reason" :placeholder="$actionType === 'deny' ? 'Cth: Data tidak sesuai dengan kondisi lapangan...' : 'Cth: Mohon lengkapi dokumentasi foto...'" rows="4"
                :labels="false" />
            @error('reason')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <x-slot name="footer">
            <x-button.danger id="btn-close-modal" type="button" wire:click="$set('showReasonModal', false)">
                Batal
            </x-button.danger>
            <x-button.primary id="btn-submit-reason" type="button" wire:click="submitReason"
                wire:loading.attr="disabled" wire:target="submitReason">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="submitReason" class="h-4 w-4 animate-spin" />
                    <x-icons.angle-right wire:loading.remove wire:target="submitReason" class="h-5 w-5" />
                </x-slot>
                <span wire:loading.remove wire:target="submitReason">
                    {{ $actionType === 'deny' ? 'Tolak Laporan' : 'Kirim Revisi' }}
                </span>
                <span wire:loading wire:target="submitReason">Memproses...</span>
            </x-button.primary>
        </x-slot>
    </x-modal.base-modal>
</div>
