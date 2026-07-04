{{-- Goal: UI assign/unassign nomor tagihan BSI ke SPK dan tampilkan riwayat piutang, Livewire: BillingUpdate, Alpine: minimal (wire:show, wire:transition) --}}
<div class="flex flex-col gap-4 lg:gap-6">
    {{-- Info Cust SPK --}}
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">
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
                <p class="text-[10px] font-bold uppercase tracking-wider text-blue-500">Nomor Tagihan (SR/FP)</p>
                <p class="font-bold text-blue-600 dark:text-blue-400">
                    {{ $spk_data->nomor_tagihan ?? 'Belum ada sinkronisasi.' }}</p>
            </div>

            @if ($form->status_nomor_tagihan && auth()->user()->can('spk-no-tagihan-unassign'))
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
    @if ($form->status_nomor_tagihan && auth()->user()->can('spk-no-tagihan-unassign'))
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

    @if (!$form->status_nomor_tagihan)
        <div
            class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 lg:p-6">
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

                <div class="flex items-center justify-end gap-3 border-t border-zinc-100 pt-6 dark:border-zinc-800">
                    <x-button.secondary type="button" id="clear-search" wire:show="form.nomor_tagihan_baru"
                        wire:transition wire:click="clearSearch" wire:loading.attr="disabled" wire:target="clearSearch">
                        <x-slot name="icon">
                            <x-icons.close class="icon h-4 w-4" />
                        </x-slot>
                        Batal
                    </x-button.secondary>

                    <x-button.primary type="submit" id="search" class="!px-6" wire:loading.attr="disabled"
                        wire:target="search">
                        <x-slot name="icon">
                            <x-icons.angle-right wire:loading.remove wire:target="search" class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="search" class="h-4 w-4 animate-spin" />
                        </x-slot>

                        <span wire:loading.remove wire:target="search">Cari Tagihan</span>
                        <span wire:loading wire:target="search">Memproses...</span>
                    </x-button.primary>
                </div>
            </form>
        </div>

        <div wire:show="form.nomor_tagihan_baru" wire:transition
            class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-inner backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
            <div class="mb-4 flex flex-wrap items-center gap-3">
                <span
                    class="inline-flex rounded-full bg-indigo-100 px-2.5 py-0.5 text-[10px] font-bold tracking-wider text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                    REKAP PIUTANG (BSI)
                </span>
                <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-700"></div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="flex flex-col gap-4">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">No. Tagihan (SR/FP)</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $form->nomor_tagihan ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Customer</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $form->nama_customer ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Penerima</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $form->customer_contact ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    {{-- Ringkasan nilai dari fetchSR* --}}
                    <div
                        class="flex flex-col gap-3 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Nilai dari SR/FP</p>

                        <dl class="flex items-center justify-between gap-4">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">SubTotal</dt>
                            <dd class="font-bold text-zinc-900 dark:text-white">Rp
                                {{ number_format($form->subtotal, 2, '.', ',') }}</dd>
                        </dl>
                        <dl
                            class="flex items-center justify-between gap-4 border-t border-dashed border-zinc-200 pt-3 dark:border-zinc-700">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total (inc. DP/PPN)</dt>
                            <dd class="font-bold text-zinc-900 dark:text-white">Rp
                                {{ number_format($form->total, 2, '.', ',') }}</dd>
                        </dl>

                        {{-- Pilihan acuan jumlah piutang --}}
                        <div
                            class="mt-1 rounded-lg border border-blue-200 bg-blue-50/60 p-3 dark:border-blue-900/30 dark:bg-blue-900/10">
                            <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-blue-500">Gunakan
                                sebagai acuan tagihan</p>
                            <div class="flex items-center gap-4">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" wire:model.live="form.jumlah_piutang_field"
                                        value="subtotal"
                                        class="h-4 w-4 cursor-pointer text-blue-600 focus:ring-blue-500 dark:border-zinc-600" />
                                    <span
                                        class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">SubTotal</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" wire:model.live="form.jumlah_piutang_field" value="total"
                                        class="h-4 w-4 cursor-pointer text-blue-600 focus:ring-blue-500 dark:border-zinc-600" />
                                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Total</span>
                                </label>
                            </div>
                            <p class="mt-2 text-[10px] text-zinc-400">
                                Dipilih:
                                <span class="font-bold text-blue-600 dark:text-blue-400">
                                    Rp {{ number_format($form->jumlah_piutang, 2, '.', ',') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Perbandingan total sisa --}}
                    @if (count($form->sisaItems) > 0)
                        @php $hasDpItems = collect($form->sisaItems)->where('is_dp', true)->isNotEmpty(); @endphp
                        <div
                            class="flex flex-col gap-3 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Perbandingan
                                Piutang (BSI)</p>
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Acuan Jumlah Piutang
                                </dt>
                                <dd class="font-bold text-zinc-700 dark:text-zinc-300">Rp
                                    {{ number_format($form->jumlah_piutang, 2, '.', ',') }}</dd>
                            </dl>
                            <dl
                                class="flex items-center justify-between gap-4 border-t border-dashed border-zinc-200 pt-3 dark:border-zinc-700">
                                <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                                    Total Bayar
                                    @if ($hasDpItems)
                                        <span
                                            class="ml-1 rounded-full bg-amber-100 px-1.5 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                            Sudah Include DP
                                        </span>
                                    @endif
                                </dt>
                                <dd class="font-bold text-zinc-700 dark:text-zinc-300">Rp
                                    {{ number_format($form->total_bayar, 2, '.', ',') }}</dd>
                            </dl>
                            <dl
                                class="flex items-center justify-between gap-4 border-t border-zinc-200 pt-3 dark:border-zinc-700">
                                <dt class="text-xs font-bold uppercase tracking-wider text-red-500">
                                    Total Sisa (Dihitung)</dt>
                                <dd class="text-xl font-bold text-red-600 dark:text-red-400">Rp
                                    {{ number_format($totalSisaDihitung, 2, '.', ',') }}</dd>
                            </dl>
                            <dl
                                class="flex items-center justify-between gap-4 border-t border-dashed border-zinc-200 pt-3 dark:border-zinc-700">
                                <dt class="text-xs font-bold uppercase tracking-wider text-zinc-500">
                                    @if ($hasDpItems)
                                        DP Dibayar
                                    @else
                                        Selisih (Acuan vs Sisa)
                                    @endif
                                </dt>
                                <dd
                                    class="{{ $totalSelisih == 0 ? 'text-emerald-600 dark:text-emerald-400' : ($hasDpItems ? 'text-amber-600 dark:text-amber-400' : 'text-amber-600 dark:text-amber-400') }} font-bold">
                                    @if ($hasDpItems)
                                        Rp {{ number_format($totalDpPaid, 2, '.', ',') }}
                                    @elseif ($totalSelisih == 0)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            ✓ Lunas / Sesuai
                                        </span>
                                    @else
                                        Rp {{ number_format(abs($totalSelisih), 2, '.', ',') }}
                                        <span
                                            class="ml-1 inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[10px] text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                                            Ada Selisih
                                        </span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tabel Detail Baris Piutang BSI --}}
            @if (count($form->sisaItems) > 0)
                <div class="mt-6">
                    <div class="mb-3 flex items-center gap-2">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                            Detail Tagihan ({{ count($form->sisaItems) }} baris)
                        </p>
                        <span
                            class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                            Centang "Tandai DP" jika baris ini adalah pembayaran DP
                        </span>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-zinc-200 bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800">
                                    <th
                                        class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                        #</th>
                                    <th
                                        class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                        No. Piutang</th>
                                    <th
                                        class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                        Nama Customer</th>
                                    <th
                                        class="px-4 py-3 text-right text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                        Jumlah Piutang</th>
                                    <th
                                        class="px-4 py-3 text-right text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                        Total Bayar</th>
                                    <th
                                        class="px-4 py-3 text-right text-[10px] font-bold uppercase tracking-wider text-red-500">
                                        Sisa Piutang</th>
                                    <th
                                        class="px-4 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">
                                        Tandai DP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 bg-white dark:divide-zinc-800 dark:bg-zinc-900">
                                @foreach ($form->sisaItems as $index => $item)
                                    @php $isDp = (bool) ($item['is_dp'] ?? false); @endphp
                                    <tr wire:key="sisa-item-{{ $index }}"
                                        class="{{ $isDp ? 'bg-amber-50/50 dark:bg-amber-900/10' : '' }} transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                        <td class="px-4 py-3 text-xs font-semibold text-zinc-400 dark:text-zinc-500">
                                            {{ $index + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="font-mono text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                                                    {{ $item['NomorPiutang'] ?? '-' }}
                                                </span>
                                                @if ($isDp)
                                                    <span
                                                        class="rounded-full bg-amber-100 px-1.5 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">DP</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-zinc-900 dark:text-white">
                                            {{ $item['NamaCustomer'] ?? '-' }}</td>
                                        <td
                                            class="{{ $isDp ? 'text-zinc-400 line-through dark:text-zinc-600' : 'text-zinc-700 dark:text-zinc-300' }} px-4 py-3 text-right font-semibold">
                                            Rp
                                            {{ number_format((float) ($item['JumlahPiutang'] ?? 0), 2, '.', ',') }}
                                        </td>
                                        <td
                                            class="{{ $isDp ? 'text-zinc-400 line-through dark:text-zinc-600' : 'text-zinc-700 dark:text-zinc-300' }} px-4 py-3 text-right font-semibold">
                                            Rp
                                            {{ number_format((float) ($item['TotalBayar'] ?? 0), 2, '.', ',') }}
                                        </td>
                                        <td
                                            class="{{ $isDp ? 'text-zinc-400 line-through dark:text-zinc-600' : 'text-red-600 dark:text-red-400' }} px-4 py-3 text-right font-bold">
                                            Rp
                                            {{ number_format((float) ($item['SisaPiutang'] ?? 0), 2, '.', ',') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button type="button" wire:click="toggleSisaItemDp({{ $index }})"
                                                wire:loading.attr="disabled"
                                                wire:target="toggleSisaItemDp({{ $index }})"
                                                title="{{ $isDp ? 'Hapus tanda DP' : 'Tandai sebagai DP' }}"
                                                class="{{ $isDp ? 'border-amber-400 bg-amber-400 text-white dark:border-amber-500 dark:bg-amber-500' : 'border-zinc-300 bg-white text-zinc-400 hover:border-amber-400 hover:text-amber-500 dark:border-zinc-600 dark:bg-zinc-800 dark:hover:border-amber-500' }} inline-flex h-6 w-6 items-center justify-center rounded-md border transition-colors">
                                                <x-icons.loading wire:loading
                                                    wire:target="toggleSisaItemDp({{ $index }})"
                                                    class="h-3 w-3 animate-spin" />
                                                <svg wire:loading.remove
                                                    wire:target="toggleSisaItemDp({{ $index }})"
                                                    class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr
                                    class="border-t-2 border-zinc-300 bg-zinc-50 dark:border-zinc-600 dark:bg-zinc-800/80">
                                    <td colspan="3"
                                        class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-300">
                                        Total (Aktif)</td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-zinc-900 dark:text-white">
                                        Rp {{ number_format($form->jumlah_piutang, 2, '.', ',') }}</td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-zinc-900 dark:text-white">
                                        Rp {{ number_format($form->total_bayar, 2, '.', ',') }}</td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-red-600 dark:text-red-400">
                                        Rp {{ number_format($totalSisaDihitung, 2, '.', ',') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div
                        class="flex items-center justify-end gap-3 border-t border-zinc-100 pt-6 dark:border-zinc-800">
                        <x-button.success type="button" wire:show="form.nomor_tagihan_baru" wire:transition
                            id="assign" wire:click="assign" wire:loading.attr="disabled" wire:target="assign">
                            <x-slot name="icon">
                                <x-icons.angle-right wire:loading.remove wire:target="assign" class="icon h-5 w-5" />
                                <x-icons.loading wire:loading wire:target="assign" class="h-4 w-4 animate-spin" />
                            </x-slot>

                            <span wire:loading.remove wire:target="assign">Assign ke SPK</span>
                            <span wire:loading wire:target="assign">Memproses...</span>
                        </x-button.success>
                    </div>
                </div>
            @endif

        </div>
    @endif

    @if ($form->status_nomor_tagihan)
        {{-- <div
            class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6"> --}}
        <div class="">
            <div
                class="flex items-center gap-2 rounded-xl rounded-b-none border border-b-0 border-blue-500 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Riwayat Penagihan (BSI)</h3>
                <span
                    class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30">History</span>
            </div>

            @forelse ($this->histories as $history)
                <div
                    class="rounded-xl rounded-t-none border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
                    {{-- Header SR --}}
                    <div
                        class="mb-4 flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 pb-3 dark:border-zinc-800">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-500">
                                    No. SR: <span
                                        class="font-mono text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ $history->nomor_sr }}</span>
                                </h4>
                                <span
                                    class="rounded-full bg-blue-500 px-2 py-0.5 text-[10px] font-bold text-white shadow-sm">
                                    {{ ucfirst($history->source ?? '-') }}
                                </span>
                            </div>
                            <p class="text-[10px] text-zinc-400">
                                {{ \Carbon\Carbon::parse($history->created_at)->isoFormat('dddd, DD MMM YYYY • HH:mm') }}
                                @if ($history->updated_by)
                                    • Oleh: {{ $history->updatedBy?->name ?? '-' }}
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-3 text-right">
                            {{-- <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">SubTotal
                                    </p>
                                    <p class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Rp
                                        {{ number_format($history->subtotal, 2, '.', ',') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Total</p>
                                    <p class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Rp
                                        {{ number_format($history->total, 2, '.', ',') }}</p>
                                </div> --}}
                            <div
                                class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 dark:border-blue-900/30 dark:bg-blue-900/10">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-blue-500">Acuan
                                    ({{ strtoupper($history->jumlah_piutang_field) }})
                                </p>
                                <p class="text-sm font-bold text-blue-700 dark:text-blue-300">Rp
                                    {{ number_format($history->jumlah_piutang, 2, '.', ',') }}</p>
                            </div>
                            <div
                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 dark:border-red-900/30 dark:bg-red-900/10">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-red-500">Sisa Piutang
                                </p>
                                <p class="text-sm font-bold text-red-700 dark:text-red-300">Rp
                                    {{ number_format($history->sisa_piutang_total, 2, '.', ',') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Detail per NomorPiutang --}}
                    @if ($history->details->isNotEmpty())
                        @php
                            $groupedDetails = $history->details->groupBy('nomor_piutang');
                        @endphp
                        <div class="space-y-6">
                            @foreach ($groupedDetails as $nomorPiutang => $group)
                                @php
                                    $latestDetail = $group->sortByDesc('id')->first();
                                @endphp

                                <div
                                    class="space-y-2 rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-700 dark:bg-zinc-800/30">
                                    <!-- Header Table: Info Invoice -->
                                    <div
                                        class="flex flex-wrap items-center justify-between gap-2 border-b border-zinc-200 pb-3 dark:border-zinc-700">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-mono text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                                {{ $nomorPiutang }}
                                            </span>

                                            @if ($latestDetail->is_dp)
                                                <span
                                                    class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">DP</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                            Nilai Tagihan Pada Invoice Ini: <span
                                                class="font-bold text-zinc-800 dark:text-zinc-200">Rp
                                                {{ number_format($latestDetail->jumlah_piutang, 2, '.', ',') }}</span>
                                        </div>
                                    </div>

                                    <!-- Table Pembayaran untuk Invoice ini -->
                                    <div
                                        class="overflow-x-auto rounded-lg border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                                        <table class="w-full text-xs">
                                            <thead>
                                                <tr
                                                    class="border-b border-zinc-200 bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800">
                                                    <th
                                                        class="px-3 py-2 text-left text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                        Tanggal / Source</th>
                                                    <th
                                                        class="px-3 py-2 text-right text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                        Pembayaran</th>
                                                    <th
                                                        class="px-3 py-2 text-right text-[10px] font-bold uppercase tracking-wider text-red-500">
                                                        Sisa Piutang</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">

                                                @php
                                                    $firstData = $group->first();
                                                @endphp

                                                <tr wire:key="detail-first-{{ $firstData->id }}"
                                                    class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                                                    <td class="px-3 py-2.5">
                                                        <span class="font-medium text-zinc-700 dark:text-zinc-300">
                                                            {{ \Carbon\Carbon::parse($firstData->checked_at)->isoFormat('DD MMM YYYY') }}
                                                        </span>
                                                        <span
                                                            class="ml-1.5 rounded bg-zinc-100 px-1 py-0.5 text-[9px] text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                                            {{ ucfirst($firstData->source) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2.5 text-right font-semibold"> - </td>
                                                    <td
                                                        class="{{ $firstData->is_dp ? 'text-zinc-400 line-through dark:text-zinc-600' : 'text-red-600 dark:text-red-400' }} px-3 py-2.5 text-right font-bold">
                                                        Rp {{ number_format($firstData->jumlah_piutang, 2, '.', ',') }}
                                                    </td>
                                                </tr>

                                                @foreach ($group->sortBy('id') as $detail)
                                                    @php
                                                        $paymentAmount = is_null($detail->sisa_sebelum)
                                                            ? $detail->total_bayar
                                                            : $detail->sisa_sebelum - $detail->sisa_piutang;
                                                    @endphp
                                                    <tr wire:key="detail-{{ $detail->id }}"
                                                        class="{{ $detail->is_dp ? 'bg-amber-50/20 dark:bg-amber-900/5' : '' }} transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                                                        <td class="px-3 py-2.5">
                                                            <span class="font-medium text-zinc-700 dark:text-zinc-300">
                                                                {{ \Carbon\Carbon::parse($detail->checked_at)->isoFormat('DD MMM YYYY') }}
                                                            </span>
                                                            <span
                                                                class="ml-1.5 rounded bg-zinc-100 px-1 py-0.5 text-[9px] text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                                                {{ ucfirst($detail->source) }}
                                                            </span>
                                                            @if ($detail->is_dp)
                                                                <span
                                                                    class="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-[9px] font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">DP</span>
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="{{ $detail->is_dp ? 'text-zinc-400 line-through dark:text-zinc-600' : 'text-green-600 dark:text-green-400' }} px-3 py-2.5 text-right font-semibold">
                                                            - Rp {{ number_format($paymentAmount, 2, '.', ',') }}
                                                        </td>
                                                        <td
                                                            class="{{ $detail->is_dp ? 'text-zinc-400 line-through dark:text-zinc-600' : 'text-red-600 dark:text-red-400' }} px-3 py-2.5 text-right font-bold">
                                                            Rp
                                                            {{ number_format($detail->sisa_piutang, 2, '.', ',') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Summary footer overall (Aktif) -->
                            @php
                                $activeLatestDetails = $groupedDetails
                                    ->map(fn($group) => $group->sortByDesc('id')->first())
                                    ->where('is_dp', false);
                            @endphp

                            <div
                                class="rounded-lg border border-zinc-200 bg-zinc-100 p-3 text-xs font-bold text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div>Total Tagihan</div>
                                    <div class="flex items-center gap-6">
                                        <div>Total Piutang: <span class="text-zinc-950 dark:text-white">Rp
                                                {{ number_format($history->jumlah_piutang, 2, '.', ',') }}</span>
                                        </div>
                                        <div>Total Dibayar: <span class="text-green-600 dark:text-green-400">Rp
                                                {{ number_format($activeLatestDetails->sum('total_bayar'), 2, '.', ',') }}</span>
                                        </div>
                                        <div>Sisa: <span class="text-red-600 dark:text-red-400">Rp
                                                {{ number_format($history->jumlah_piutang - $activeLatestDetails->sum('total_bayar'), 2, '.', ',') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-zinc-400 dark:text-zinc-500">Tidak ada detail invoice.</p>
                    @endif
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Belum ada riwayat penagihan.</p>
                </div>
            @endforelse
        </div>
        {{-- </div> --}}
    @endif
</div>
