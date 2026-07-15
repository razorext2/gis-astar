{{-- Goal: UI parent wrapper untuk assign/unassign nomor tagihan BSI ke SPK, Livewire: Update, Alpine: minimal --}}
<div class="flex flex-col gap-4">
    {{-- Info Cust SPK --}}
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 p-4 shadow dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">No. SPK</p>
                <p class="font-semibold text-zinc-900 dark:text-white">
                    {{ $spk_data->nomor_order . ($spk_data->revision_count ? 'R' . str_pad($spk_data->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Tanggal Dibuat</p>
                <p class="font-semibold text-zinc-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($spk_data->created_at)->isoFormat('DD MMM YYYY') }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Customer</p>
                <p class="font-semibold text-zinc-900 dark:text-white">
                    {{ empty($spk_data->customer['nama_perusahaan']) ? '-' : $spk_data->customer['nama_perusahaan'] }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Penerima</p>
                <p class="font-semibold text-zinc-900 dark:text-white">
                    {{ empty($spk_data->customer['contact_person']) ? '-' : $spk_data->customer['contact_person'] }}
                </p>
            </div>
        </div>

        <div
            class="mt-2 flex items-center gap-3 rounded-lg border border-blue-100 bg-blue-50/50 p-3 shadow-sm dark:border-blue-900/30 dark:bg-blue-900/10">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm dark:bg-zinc-800">
                <x-icons.file-invoice class="h-5 w-5 text-blue-500" />
            </div>
            <div class="flex-1">
                <p class="text-[10px] font-bold uppercase tracking-wider text-blue-500">Nomor Tagihan (SR)</p>
                <div class="flex items-center gap-2">
                    <p class="font-bold text-blue-600 dark:text-blue-400">
                        {{ $spk_data->nomor_tagihan ?? 'Belum ada sinkronisasi.' }}
                    </p>
                    @if ($spk_data->tipe_tagihan)
                        <span
                            class="rounded bg-blue-100 px-1.5 py-0.5 text-[9px] font-bold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                            {{ strtoupper($spk_data->tipe_tagihan) }}
                        </span>
                    @endif
                </div>
                @if ($status_nomor_tagihan)
                    @php
                        $latestSyncDetail = $this->histories->first()?->details->sortByDesc('id')->first();
                    @endphp
                    @if ($latestSyncDetail)
                        <p class="mt-0.5 text-[10px] text-zinc-400 dark:text-zinc-500">
                            Update terakhir:
                            {{ \Carbon\Carbon::parse($latestSyncDetail->checked_at)->isoFormat('dddd, DD MMM YYYY • HH:mm') }}
                        </p>
                    @endif
                @endif
            </div>

            @if ($status_nomor_tagihan && auth()->user()->can('spk-no-tagihan-unassign'))
                <x-button.danger id="unassign-trigger" wire:click="$set('showUnassignConfirm', true)">
                    <x-slot name="icon">
                        <x-icons.close class="h-3.5 w-3.5" />
                    </x-slot>
                    Unassign
                </x-button.danger>
            @endif
        </div>
    </div>

    {{-- Modal konfirmasi unassign --}}
    @if ($status_nomor_tagihan && auth()->user()->can('spk-no-tagihan-unassign'))
        <x-modal.base-modal show="showUnassignConfirm" title="Unassign Nomor Tagihan" subtitle="Konfirmasi unassign"
            :minimizeable="false" :showCloseButton="false" iconContainerClass="bg-red-500 shadow-red-500/20">
            <x-slot name="icon">
                <x-icons.close class="h-5 w-5" />
            </x-slot>

            <div class="flex flex-col gap-3">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                    Anda akan meng-unassign nomor SR
                    <span class="font-bold text-zinc-900 dark:text-white">{{ $spk_data->nomor_tagihan }}</span>
                    dari SPK ini.
                </p>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Status SPK akan kembali ke kondisi sebelum penagihan. Riwayat piutang yang sudah tercatat
                    tetap tersimpan.
                </p>
            </div>

            <x-slot name="footer">
                <x-button.secondary type="button" wire:click="$set('showUnassignConfirm', false)"
                    wire:loading.attr="disabled">
                    <x-slot name="icon">
                        <x-icons.close class="icon h-4 w-4" />
                    </x-slot>
                    Batal
                </x-button.secondary>

                <x-button.danger type="button" wire:click="unassign" wire:loading.attr="disabled"
                    wire:target="unassign">
                    <x-slot name="icon">
                        <x-icons.close wire:loading.remove wire:target="unassign" class="icon h-4 w-4" />
                        <x-icons.loading wire:loading wire:target="unassign" class="h-4 w-4 animate-spin" />
                    </x-slot>
                    <span wire:loading.remove wire:target="unassign">Ya, Unassign</span>
                    <span wire:loading wire:target="unassign">Memproses...</span>
                </x-button.danger>
            </x-slot>
        </x-modal.base-modal>
    @endif

    {{-- Conditional Child Component rendering under new subfolder namespace --}}
    @if ($status_nomor_tagihan)
        <livewire:handler.spk.billing.history :spk-data="$spk_data" />
    @else
        <livewire:handler.spk.billing.search :spk-data="$spk_data" />
        <livewire:handler.spk.billing.preview :spk-data="$spk_data" />
    @endif
</div>
