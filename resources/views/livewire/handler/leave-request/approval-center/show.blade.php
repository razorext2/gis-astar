{{-- Goal: Detailed review and action interface for leave request approvals, Livewire: Handler.LeaveRequest.ApprovalCenter.Show, Alpine: true --}}

<div class="mt-4 flex flex-col gap-6" x-data="{ showRejectModal: false }">
    {{-- Header / Navigation --}}
    <div class="flex items-center gap-3">
        <x-button.danger wire:navigate href="{{ route('leave-request.approval-center.index') }}"
            class="max-h-10 max-w-fit">
            <x-icons.angle-left class="h-5 w-5" />
        </x-button.danger>
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
                        <x-button.primary wire:click="approve" class="w-full !py-4 text-lg">
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
                    <x-button.danger type="button" @click="showRejectModal = false" class="justify-center !py-3">
                        Batal
                    </x-button.danger>
                    <x-button.primary type="button" wire:click="reject" class="justify-center !py-3">
                        Tolak Sekarang
                    </x-button.primary>
                </div>
            </div>
        </div>
    </div>
</div>
