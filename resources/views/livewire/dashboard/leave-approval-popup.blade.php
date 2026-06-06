{{-- Goal: Popup notifikasi approval cuti di dashboard, Livewire: Dashboard.LeaveApprovalPopup, Alpine: localStorage dismiss per sesi --}}

<div x-data="{
    dismissedForSession: false,
    sessionKey: 'leave_popup_dismissed_{{ auth()->id() }}_{{ session()->getId() }}',
    init() {
        this.dismissedForSession = localStorage.getItem(this.sessionKey) === '1';
        if (this.dismissedForSession || !$wire.hasPending) {
            return;
        }
        setTimeout(() => { $wire.set('showPopup', true); }, 800);
    },
    dismissForSession() {
        localStorage.setItem(this.sessionKey, '1');
        this.dismissedForSession = true;
        $wire.dismiss();
    }
}">
    @if ($currentRequest)
        <x-modal.base-modal :show="'showPopup'" title="Permintaan Persetujuan Cuti"
            subtitle="Pengajuan ini membutuhkan keputusan Anda" iconContainerClass="bg-amber-500 shadow-amber-500/20"
            maxWidth="lg">
            <x-slot name="icon">
                <x-icons.clipboard-check class="h-5 w-5 text-white" />
            </x-slot>

            {{-- Navigation bar: counter + arrow prev/next --}}
            @if ($totalPending > 1)
                <div class="mb-4 flex items-center justify-between rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 dark:border-amber-500/20 dark:bg-amber-500/10">
                    <div class="flex items-center gap-2">
                        <x-icons.info-circle class="h-4 w-4 shrink-0 text-amber-500" />
                        <span class="text-xs font-bold text-amber-700 dark:text-amber-400">
                            Pengajuan <span class="font-black">{{ $currentIndex + 1 }}</span> dari <span class="font-black">{{ $totalPending }}</span>
                        </span>
                    </div>
                    <div class="flex items-center gap-1">
                        <button
                            wire:click="previous"
                            @class([
                                'flex h-7 w-7 items-center justify-center rounded-lg border transition-all',
                                'border-zinc-200 text-zinc-400 hover:border-zinc-300 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-500 dark:hover:bg-zinc-800' => $currentIndex > 0,
                                'cursor-not-allowed border-zinc-100 text-zinc-300 dark:border-zinc-800 dark:text-zinc-700' => $currentIndex === 0,
                            ])
                            @disabled($currentIndex === 0)
                            wire:loading.attr="disabled"
                        >
                            <x-icons.chevron-left class="h-4 w-4" />
                        </button>
                        <button
                            wire:click="next"
                            @class([
                                'flex h-7 w-7 items-center justify-center rounded-lg border transition-all',
                                'border-zinc-200 text-zinc-400 hover:border-zinc-300 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-500 dark:hover:bg-zinc-800' => $currentIndex < $totalPending - 1,
                                'cursor-not-allowed border-zinc-100 text-zinc-300 dark:border-zinc-800 dark:text-zinc-700' => $currentIndex >= $totalPending - 1,
                            ])
                            @disabled($currentIndex >= $totalPending - 1)
                            wire:loading.attr="disabled"
                        >
                            <x-icons.chevron-right class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            @endif

            {{-- Approval Role Badge --}}
            <div class="mb-5 flex items-center gap-2">
                <div class="h-2 w-2 animate-pulse rounded-full bg-amber-500"></div>
                <span class="text-xs font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                    Peran Anda:
                </span>
                <span
                    class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-[10px] font-black uppercase tracking-tighter text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                    {{ $currentRequest->approval_role_label }}
                </span>
            </div>

            {{-- Applicant Info --}}
            <div
                class="mb-4 flex items-center gap-4 rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-white/5">
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-red-100 text-xl font-black text-red-600 dark:bg-red-900/30 dark:text-red-400">
                    {{ collect(explode(' ', $currentRequest->user->name))->map(fn($n) => \Str::substr($n, 0, 1))->take(2)->implode('') }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-base font-bold text-zinc-900 dark:text-white">
                        {{ $currentRequest->user->name }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        {{ $currentRequest->user->pegawai?->jabatanRelasi?->nama_jabatan ?? '-' }}
                        @if ($currentRequest->user->pegawai?->jabatanRelasi?->divisionRelasi?->nama_divisi)
                            · {{ $currentRequest->user->pegawai->jabatanRelasi->divisionRelasi->nama_divisi }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Leave Details Grid --}}
            <div class="mb-4 grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1 rounded-xl border border-zinc-200 p-3 dark:border-zinc-800">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Tipe Cuti</p>
                    <p class="text-sm font-bold text-zinc-900 dark:text-white">
                        {{ $currentRequest->leaveType?->name ?? '-' }}</p>
                </div>
                <div class="flex flex-col gap-1 rounded-xl border border-zinc-200 p-3 dark:border-zinc-800">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Durasi</p>
                    <p class="text-sm font-bold text-zinc-900 dark:text-white">
                        {{ $currentRequest->total_days }} <span class="text-xs font-normal text-zinc-500">hari
                            kerja</span>
                    </p>
                </div>
                <div class="col-span-2 flex flex-col gap-1 rounded-xl border border-zinc-200 p-3 dark:border-zinc-800">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Periode</p>
                    <p class="text-sm font-bold text-zinc-900 dark:text-white">
                        {{ $currentRequest->start_date->format('d M Y') }}
                        <span class="mx-1.5 text-zinc-400">→</span>
                        {{ $currentRequest->end_date->format('d M Y') }}
                    </p>
                </div>
            </div>

            {{-- Reason --}}
            <div class="mb-5 rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-white/5">
                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-zinc-400">Alasan / Keperluan</p>
                <p class="text-sm italic text-zinc-700 dark:text-zinc-300">"{{ $currentRequest->reason }}"</p>
            </div>

            {{-- Don't show again for session checkbox --}}
            <div class="flex items-center gap-2 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                <input type="checkbox" id="dismiss-popup-session"
                    class="h-4 w-4 cursor-pointer rounded border-zinc-300 text-red-600 dark:border-zinc-700"
                    @change="if ($event.target.checked) dismissForSession()">
                <label for="dismiss-popup-session" class="cursor-pointer text-xs text-zinc-500 dark:text-zinc-400">
                    Jangan tampilkan lagi untuk sesi ini
                </label>
            </div>

            <x-slot name="footer">
                <x-button.primary wire:navigate
                    href="{{ route('leave-request.approval-center.show', $currentRequest->id) }}"
                    class="w-full justify-center">
                    <x-slot name="icon">
                        <x-icons.eye class="h-4 w-4" />
                    </x-slot>
                    Lihat Detail
                </x-button.primary>
            </x-slot>
        </x-modal.base-modal>
    @endif
</div>
