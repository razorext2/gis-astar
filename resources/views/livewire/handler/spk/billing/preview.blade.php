{{-- Goal: Tampilan pratinjau tagihan BSI dan tombol assign, Livewire: Preview, Alpine: scroll to rekap --}}
<div
    x-on:scroll-to-rekap.window="
        $nextTick(() => {
            const el = document.getElementById('rekap-piutang-section');
            if (el) { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
        })
    ">
    @if ($nomor_tagihan_baru)
        <div id="rekap-piutang-section"
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
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">No. Tagihan (SR)</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $nomor_tagihan ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Customer</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $nama_customer ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Penerima</p>
                        <p class="font-bold text-zinc-900 dark:text-white">{{ $customer_contact ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    {{-- Ringkasan nilai dari fetchSR* --}}
                    <div
                        class="flex flex-col gap-3 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Nilai dari SR</p>

                        <dl class="flex items-center justify-between gap-4">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">SubTotal</dt>
                            <dd class="font-bold text-zinc-900 dark:text-white">Rp
                                {{ number_format($subtotal, 2, '.', ',') }}</dd>
                        </dl>
                        <dl
                            class="flex items-center justify-between gap-4 border-t border-dashed border-zinc-200 pt-3 dark:border-zinc-700">
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total (inc. DP/PPN)</dt>
                            <dd class="font-bold text-zinc-900 dark:text-white">Rp
                                {{ number_format($total, 2, '.', ',') }}</dd>
                        </dl>

                        {{-- Pilihan acuan jumlah piutang --}}
                        <div
                            class="mt-1 rounded-lg border border-blue-200 bg-blue-50/60 p-3 dark:border-blue-900/30 dark:bg-blue-900/10">
                            <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-blue-500">Gunakan
                                sebagai acuan tagihan</p>
                            <div class="flex items-center gap-4">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" wire:model.live="jumlah_piutang_field"
                                        value="subtotal"
                                        class="h-4 w-4 cursor-pointer text-blue-600 focus:ring-blue-500 dark:border-zinc-600" />
                                    <span
                                        class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">SubTotal</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" wire:model.live="jumlah_piutang_field" value="total"
                                        class="h-4 w-4 cursor-pointer text-blue-600 focus:ring-blue-500 dark:border-zinc-600" />
                                    <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Total</span>
                                </label>
                            </div>
                            <p class="mt-2 text-[10px] text-zinc-400">
                                Dipilih:
                                <span class="font-bold text-blue-600 dark:text-blue-400">
                                    Rp {{ number_format($jumlah_piutang, 2, '.', ',') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Perbandingan total sisa --}}
                    @if (count($sisaItems) > 0)
                        @php $hasDpItems = collect($sisaItems)->where('is_dp', true)->isNotEmpty(); @endphp
                        <div
                            class="flex flex-col gap-3 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Perbandingan
                                Piutang (BSI)</p>
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Acuan Jumlah Piutang
                                </dt>
                                <dd class="font-bold text-zinc-700 dark:text-zinc-300">Rp
                                    {{ number_format($jumlah_piutang, 2, '.', ',') }}</dd>
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
                                    {{ number_format($total_bayar, 2, '.', ',') }}</dd>
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
            @if (count($sisaItems) > 0)
                <div class="mt-6">
                    <div class="mb-3 flex items-center gap-2">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                            Detail Tagihan ({{ count($sisaItems) }} baris)
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
                                @foreach ($sisaItems as $index => $item)
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
                                        Rp {{ number_format($jumlah_piutang, 2, '.', ',') }}</td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-zinc-900 dark:text-white">
                                        Rp {{ number_format($total_bayar, 2, '.', ',') }}</td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-red-600 dark:text-red-400">
                                        Rp {{ number_format($totalSisaDihitung, 2, '.', ',') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div
                        class="flex items-center justify-end gap-3 border-t border-zinc-100 pt-6 dark:border-zinc-800">
                        <x-button.success type="button"
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
</div>
