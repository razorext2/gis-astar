{{-- Goal: Detailed review and action interface for leave request approvals, Livewire: Handler.LeaveRequest.ApprovalCenter.Show, Alpine: true --}}

<div class="mt-4 flex flex-col gap-6" x-data="{ showRejectModal: false }">
    {{-- Header / Navigation --}}
    <div class="flex items-center gap-3">
        <x-button.link wire:navigate href="{{ route('leave-request.approval-center.index') }}"
            class="group rounded-full bg-white/50 !p-2 ring-1 ring-zinc-200 dark:bg-white/5 dark:ring-white/10">
            <x-icons.chevron-left class="h-5 w-5 text-zinc-500 transition-colors group-hover:text-red-500" />
        </x-button.link>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Detail Persetujuan</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Tinjau informasi lengkap sebelum memberikan keputusan.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Left Column: Request Details --}}
        <div class="flex flex-col gap-6 lg:col-span-2">
            {{-- Applicant Info Card --}}
            <div
                class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary">
                <div class="bg-zinc-50/50 p-4 dark:bg-white/5">
                    <h2 class="flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-zinc-500">
                        <x-icons.user-circle class="h-4 w-4" />
                        Informasi Pemohon
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                        <div
                            class="flex h-20 w-20 shrink-0 items-center justify-center rounded-xl bg-red-100 text-3xl font-black text-red-600 dark:bg-red-900/30 dark:text-red-400">
                            {{ collect(explode(' ', $request->user->name))->map(fn($n) => Str::substr($n, 0, 1))->take(2)->implode('') }}
                        </div>
                        <div class="flex flex-col gap-1">
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $request->user->name }}</h3>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-zinc-500">
                                <span class="flex items-center gap-1.5">
                                    <span
                                        class="font-mono font-bold text-zinc-700 dark:text-zinc-300">{{ $request->user->kode_pegawai }}</span>
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <x-icons.briefcase class="h-4 w-4" />
                                    {{ $request->user->pegawai->jabatanRelasi->nama_jabatan ?? '-' }}
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <x-icons.landmark class="h-4 w-4" />
                                    {{ $request->user->pegawai->jabatanRelasi->divisionRelasi->nama_divisi ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leave Info Card --}}
            <div
                class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-1 rounded-full bg-red-600"></div>
                        <h2 class="text-lg font-bold text-zinc-800 dark:text-white">Detail Pengajuan</h2>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                        {{ $request->approval_role }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div class="flex flex-col gap-4">
                        <div class="space-y-1">
                            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Tipe Cuti</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">
                                {{ $request->leaveType->name ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Waktu Pelaksanaan</p>
                            <div class="flex items-center gap-3">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Dari</span>
                                    <span
                                        class="font-bold text-zinc-900 dark:text-white">{{ $request->start_date->format('d M Y') }}</span>
                                </div>
                                <x-icons.arrow-right class="h-4 w-4 text-zinc-300" />
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Sampai</span>
                                    <span
                                        class="font-bold text-zinc-900 dark:text-white">{{ $request->end_date->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="space-y-1">
                            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Total Durasi</p>
                            <p class="text-3xl font-black text-red-600 dark:text-red-500">
                                {{ $request->total_days }} <span
                                    class="text-sm font-bold uppercase tracking-tight">Hari Kerja</span>
                            </p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Personel Backup</p>
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-xl bg-zinc-100 text-xs font-bold dark:bg-zinc-800">
                                    {{ Str::substr($request->backupPerson->name, 0, 1) }}
                                </div>
                                <span
                                    class="font-bold text-zinc-900 dark:text-white">{{ $request->backupPerson->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 space-y-2">
                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Alasan / Keperluan</p>
                    <div
                        class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 text-zinc-700 dark:border-white/5 dark:bg-white/5 dark:text-zinc-300">
                        "{{ $request->reason }}"
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Timeline & Actions --}}
        <div class="flex flex-col gap-6">
            {{-- Action Card --}}
            <div
                class="rounded-xl border-2 border-red-500/20 bg-white p-6 shadow-md backdrop-blur-xl dark:bg-dark-primary">
                <h3 class="mb-4 text-lg font-extrabold text-zinc-800 dark:text-white">Butuh Keputusan Anda</h3>

                <div class="mb-6 space-y-4">
                    <x-button.primary wire:click="approve" class="w-full !py-4 text-lg shadow-lg shadow-red-500/20">
                        <x-slot name="icon"><x-icons.check class="h-6 w-6" /></x-slot>
                        Setujui Sekarang
                    </x-button.primary>

                    <button @click="showRejectModal = true"
                        class="flex w-full items-center justify-center gap-2 rounded-xl border border-zinc-200 py-3 text-sm font-bold text-zinc-600 transition-all hover:bg-zinc-50 active:scale-95 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-white/5">
                        <x-icons.close class="h-5 w-5 text-red-500" />
                        Tolak Pengajuan
                    </button>
                </div>

                <p class="text-center text-[10px] uppercase tracking-widest text-zinc-400">
                    Tindakan ini akan tercatat dalam log riwayat.
                </p>
            </div>

            {{-- Timeline Card --}}
            <div
                class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary">
                <h3 class="mb-6 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-zinc-400">
                    <x-icons.clockwise class="h-4 w-4" />
                    Riwayat Persetujuan
                </h3>

                <div class="relative space-y-6">
                    <div class="absolute left-[15px] top-2 h-[calc(100%-16px)] w-0.5 bg-zinc-100 dark:bg-zinc-800">
                    </div>

                    @foreach ($request->histories as $history)
                        <div class="relative flex gap-4">
                            <div @class([
                                'relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2',
                                'border-green-500 bg-green-50 text-green-600 dark:bg-green-900/30' =>
                                    $history->status !== 'pending_spv',
                                'border-amber-500 bg-amber-50 text-amber-600 animate-pulse dark:bg-amber-900/30' =>
                                    $history->status === 'pending_spv',
                            ])>
                                @if ($history->status !== 'pending_spv')
                                    <x-icons.check class="h-4 w-4" />
                                @else
                                    <x-icons.clock class="h-4 w-4" />
                                @endif
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-bold text-zinc-900 dark:text-white">{{ $history->description }}
                                </p>
                                <div class="flex items-center gap-2 text-[10px] font-medium text-zinc-500">
                                    <span>{{ $history->actedByUser->name ?? '-' }}</span>
                                    <span>•</span>
                                    <span>{{ $history->created_at->diffForHumans() }}</span>
                                </div>
                                @if ($history->note)
                                    <p
                                        class="mt-1 rounded-xl bg-zinc-50 px-3 py-1.5 text-xs italic text-zinc-600 dark:bg-white/5 dark:text-zinc-400">
                                        "{{ $history->note }}"
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal (Alpine) --}}
    <div x-show="showRejectModal"
        class="fixed inset-0 z-[200] flex items-center justify-center bg-zinc-900/60 p-4 backdrop-blur-sm" x-cloak>
        <div @click.away="showRejectModal = false"
            class="w-full max-w-md scale-100 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-dark-primary">
            <div class="p-6">
                <h3 class="text-center text-xl font-bold text-zinc-900 dark:text-white">Tolak Pengajuan?</h3>
                <p class="mt-2 text-center text-sm text-zinc-500">Silakan berikan alasan penolakan agar pemohon dapat
                    mengetahuinya.</p>

                <div class="mt-6 space-y-4 text-left">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-bold uppercase tracking-wider text-zinc-500">Alasan Penolakan</label>
                        <textarea wire:model="note" rows="3"
                            class="w-full rounded-xl border border-zinc-200 p-4 text-sm focus:ring-red-500/20 dark:border-zinc-800 dark:bg-zinc-800 dark:text-white"
                            placeholder="Contoh: Kuota tim pada tanggal tersebut sudah penuh..."></textarea>
                        @error('note')
                            <span class="text-xs font-bold text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-3">
                    <button @click="showRejectModal = false"
                        class="rounded-xl border border-zinc-200 py-3 text-sm font-bold text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400">
                        Batal
                    </button>
                    <button wire:click="reject"
                        class="rounded-xl bg-red-600 py-3 text-sm font-bold text-white shadow-lg shadow-red-500/20 transition-all hover:bg-red-700">
                        Tolak Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
