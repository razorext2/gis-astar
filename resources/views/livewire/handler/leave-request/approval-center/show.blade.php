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
            <x-leave-request.detail-card :request="$request" :showApprovalRole="true" />
        </div>

        {{-- Right Column: Timeline & Actions --}}
        <div class="flex flex-col gap-6">
            {{-- Action Card --}}
            @if ($canApprove)
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
            @endif

            {{-- Timeline Card --}}
            <x-leave-request.timeline :request="$request" />
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
                        <label class="text-xs font-bold uppercase tracking-wider text-zinc-500">Alasan
                            Penolakan</label>
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
