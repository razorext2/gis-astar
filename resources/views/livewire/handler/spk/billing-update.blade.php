<div class="flex flex-col gap-6">
    {{-- Info Cust SPK --}}
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 shadow dark:border-zinc-800 dark:bg-zinc-800/30 dark:shadow-none lg:p-6">
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
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-blue-500">Nomor Tagihan (SR/FP)</p>
                <p class="font-bold text-blue-600 dark:text-blue-400">
                    {{ $spk_data->nomor_tagihan ?? 'Belum ada sinkronisasi.' }}</p>
            </div>
        </div>
    </div>

    @if (!$form->status_nomor_tagihan)
        <div
            class="rounded-xl border border-zinc-200 bg-white p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">
            <div class="mb-6 flex items-center gap-2 border-l-4 border-blue-500 pl-3">
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Cari Tagihan</h3>
                <span
                    class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30">
                    Sinkronisasi BSI
                </span>
            </div>

            <form class="flex w-full flex-col gap-6" wire:submit.prevent="search">
                <div class="space-y-4">
                    <div>
                        <x-input.select id="tipe_tagihan" name="tipe_tagihan" :labels="true" :textLabel="'Tipe Tagihan'"
                            :defaultOption="'Pilih tipe tagihan...'" :options="collect(config('spk-config.spk_tipe_tagihan'))
                                ->mapWithKeys(fn($row, $key) => [$key => $row['label']])
                                ->toArray()" wire:model.live="form.tipe_tagihan" disabled />

                        @error('form.tipe_tagihan')
                            <span class="mt-2 text-xs font-bold text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-input.basic id="nomor_tagihan" name="nomor_tagihan" wire:model="form.nomor_tagihan"
                            type="text" placeholder="Masukkan nomor SR spk..." :labels="true">
                            Nomor SR / FP
                        </x-input.basic>

                        @error('form.nomor_tagihan')
                            <span class="mt-2 text-xs font-bold text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div wire:show="form.nomor_tagihan_baru" wire:transition
                    class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 shadow-inner dark:border-zinc-800 dark:bg-zinc-800/50 lg:p-6">
                    <div class="mb-4 flex items-center gap-3">
                        <span
                            class="inline-flex rounded-full bg-indigo-100 px-2.5 py-0.5 text-[10px] font-bold tracking-wider text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                            REKAP PIUTANG (BSI)
                        </span>
                        <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-700"></div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div class="flex flex-col gap-4">
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">No. Tagihan
                                    (SR/FP)</p>
                                <p class="font-bold text-zinc-900 dark:text-white">{{ $form->nomor_tagihan ?? '-' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Customer
                                </p>
                                <p class="font-bold text-zinc-900 dark:text-white">{{ $form->nama_customer ?? '-' }}</p>
                            </div>
                        </div>

                        <div
                            class="flex flex-col gap-3 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Piutang</dt>
                                <dd class="text-lg font-bold text-zinc-900 dark:text-white">Rp
                                    {{ number_format($form->total_tagihan, 2, '.', ',') }}</dd>
                            </dl>
                            <dl
                                class="flex items-center justify-between gap-4 border-t border-dashed border-zinc-200 pt-3 dark:border-zinc-700">
                                <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Bayar</dt>
                                <dd class="font-bold text-zinc-700 dark:text-zinc-300">Rp
                                    {{ number_format($form->total_bayar, 2, '.', ',') }}</dd>
                            </dl>
                            <dl
                                class="flex items-center justify-between gap-4 border-t border-zinc-200 pt-3 dark:border-zinc-700">
                                <dt class="text-xs font-bold uppercase tracking-wider text-red-500">Sisa Piutang</dt>
                                <dd class="text-xl font-bold text-red-600 dark:text-red-400">Rp
                                    {{ number_format($form->sisa, 2, '.', ',') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-zinc-100 pt-6 dark:border-zinc-800">
                    <x-button.primary type="submit" id="search" class="!px-6">
                        <x-slot name="icon">
                            <x-icons.angle-right wire:loading.remove wire:target="search" class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="search" class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span wire:loading.remove wire:target="search">Cari Tagihan</span>
                        <span wire:loading wire:target="search">Memproses...</span>
                    </x-button.primary>

                    <x-button.success type="button" wire:show="form.nomor_tagihan_baru" wire:transition id="assign"
                        wire:click="assign">
                        <x-slot name="icon">
                            <x-icons.angle-right wire:loading.remove wire:target="assign" class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="assign" class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span wire:loading.remove wire:target="assign">Assign ke SPK</span>
                        <span wire:loading wire:target="assign">Memproses...</span>
                    </x-button.success>
                </div>
            </form>
        </div>
    @endif

    @if ($form->status_nomor_tagihan)
        <div
            class="rounded-xl border border-zinc-200 bg-white p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">
            <div class="mb-6 flex items-center gap-2 border-l-4 border-blue-500 pl-3">
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Riwayat Penagihan (BSI)</h3>
                <span
                    class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30">History</span>
            </div>

            <div class="space-y-4">
                @foreach ($this->histories as $index => $row)
                    <div
                        class="relative overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50 shadow-sm transition-all hover:border-zinc-300 dark:border-zinc-800 dark:bg-zinc-800/30 dark:hover:border-zinc-700">
                        <div
                            class="{{ $row->selisih > 0 ? 'bg-emerald-500' : 'bg-blue-500' }} absolute left-0 top-0 h-full w-1">
                        </div>
                        <div class="p-4 pl-5">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-bold text-zinc-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}
                                        </p>
                                        <span
                                            class="rounded-full bg-blue-500 px-2 py-0.5 text-[10px] font-bold text-white shadow-sm">
                                            {{ ucfirst($row->source ?? '-') }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                        Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('HH:mm:ss') }}
                                        @if ($row->updated_by)
                                            • Oleh: {{ $row->updatedBy?->name ?? '-' }}
                                        @endif
                                    </p>
                                </div>

                                <div class="w-full lg:w-1/2">
                                    <div
                                        class="space-y-2 rounded-xl border border-zinc-100 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-800/80">
                                        <dl class="flex items-center justify-between text-xs">
                                            <dt class="font-medium text-zinc-500 dark:text-zinc-400">Total Piutang</dt>
                                            <dd class="font-semibold text-zinc-900 dark:text-white">Rp
                                                {{ number_format($row->total_piutang, 2, '.', ',') }}</dd>
                                        </dl>
                                        <dl
                                            class="flex items-center justify-between border-t border-dashed border-zinc-100 pt-2 text-xs dark:border-zinc-700">
                                            <dt class="font-medium text-zinc-500 dark:text-zinc-400">Sisa Sebelumnya
                                            </dt>
                                            <dd class="font-semibold text-zinc-900 dark:text-white">Rp
                                                {{ number_format($row->sisa_piutang_sebelum, 2, '.', ',') }}</dd>
                                        </dl>
                                        <dl
                                            class="flex items-center justify-between border-t border-dashed border-zinc-100 pt-2 text-xs dark:border-zinc-700">
                                            <dt class="font-medium text-zinc-500 dark:text-zinc-400">Sisa Sesudah</dt>
                                            <dd class="font-semibold text-zinc-900 dark:text-white">Rp
                                                {{ number_format($row->sisa_piutang_sesudah, 2, '.', ',') }}</dd>
                                        </dl>
                                        <dl
                                            class="flex items-center justify-between border-t border-zinc-200 pt-3 text-sm dark:border-zinc-600">
                                            <dt class="font-bold text-emerald-500">Pembayaran</dt>
                                            <dd class="text-base font-bold text-emerald-600 dark:text-emerald-400">Rp
                                                {{ number_format($row->selisih, 2, '.', ',') }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-6">
                    {{ $this->histories->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
