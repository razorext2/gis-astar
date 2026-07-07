{{-- Goal: Tampilkan riwayat tagihan dan sisa piutang BSI yang sudah di-assign, Livewire: History, Alpine: minimal --}}
<div class="">
    <div
        class="flex items-center gap-2 rounded-xl rounded-b-none border border-b-0 border-blue-500 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
        <h3 class="text-base font-bold text-zinc-900 dark:text-white">Riwayat Penagihan (BSI)</h3>
        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30">History</span>
    </div>

    @forelse ($this->histories as $history)
        <div
            class="rounded-xl rounded-t-none border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
            {{-- Header SR --}}
            <div
                class="mb-4 flex flex-wrap items-center justify-between gap-3 border-b border-zinc-200 pb-3 dark:border-zinc-800">
                <div class="flex flex-col gap-1">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-500">
                        No. SR: <span
                            class="font-mono text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ $history->nomor_sr }}</span>
                    </h4>

                    <div>
                        <p class="text-[10px] text-zinc-400">
                            Ditambahkan:
                            {{ \Carbon\Carbon::parse($history->created_at)->isoFormat('dddd, DD MMM YYYY • HH:mm') }}
                        </p>

                        @if ($history->updated_by)
                            <p class="text-[10px] text-zinc-400">
                                Oleh: {{ $history->updatedBy?->name ?? '-' }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3 text-right">
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
                <div class="space-y-4">
                    @foreach ($history->groupedDetails() as $nomorPiutang => $item)
                        @php
                            $group = $item['group'];
                            $latestDetail = $item['latestDetail'];
                            $totalInvoicePaid = $item['totalInvoicePaid'];
                        @endphp

                        <div
                            class="space-y-2 rounded-xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-700 dark:bg-zinc-800/30">
                            <!-- Header Table: Info Invoice -->
                            <div
                                class="flex flex-wrap items-center justify-between gap-2 border-b border-zinc-200 pb-3 dark:border-zinc-700">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-mono text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                        Nomor Piutang: {{ $nomorPiutang }}
                                    </span>

                                    @if ($latestDetail->is_dp)
                                        <span
                                            class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">DP</span>
                                    @endif

                                    @if ($latestDetail->sisa_piutang <= 0)
                                        <span
                                            class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">LUNAS</span>
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
                                                    {{ \Carbon\Carbon::parse($firstData->checked_at)->isoFormat(' HH:mm, DD MMM YYYY') }}
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

                                        @foreach ($group as $detail)
                                            @php
                                                $paymentAmount = is_null($detail->sisa_sebelum)
                                                    ? $detail->total_bayar
                                                    : $detail->sisa_sebelum - $detail->sisa_piutang;
                                            @endphp
                                            <tr wire:key="detail-{{ $detail->id }}"
                                                class="{{ $detail->is_dp ? 'bg-amber-50/20 dark:bg-amber-900/5' : '' }} transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/30">
                                                <td class="px-3 py-2.5">
                                                    <span class="font-medium text-zinc-700 dark:text-zinc-300">
                                                        {{ \Carbon\Carbon::parse($detail->checked_at)->isoFormat('HH:mm, DD MMM YYYY') }}
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

                                    <tfoot>
                                        <tr
                                            class="bg-zinc-100 font-bold text-zinc-900 dark:bg-zinc-800 dark:text-white">
                                            <td
                                                class="px-3 py-2 text-left text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                Total
                                            </td>
                                            <td
                                                class="px-3 py-2 text-right font-semibold text-green-600 dark:text-green-400">
                                                Rp {{ number_format($totalInvoicePaid, 2, '.', ',') }}
                                            </td>
                                            <td
                                                class="px-3 py-2 text-right font-bold text-red-600 dark:text-red-400">
                                                Rp
                                                {{ number_format($latestDetail->sisa_piutang, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endforeach

                    <!-- Summary footer overall (Aktif) -->
                    @php
                        $activeLatestDetails = $history->groupedDetails()
                            ->map(fn($item) => $item['latestDetail'])
                            ->where('is_dp', false);
                    @endphp

                    <div
                        class="text-zinc-850 w-full gap-4 space-y-2 rounded-xl border border-zinc-200 bg-zinc-50 p-4 text-xs font-bold dark:border-zinc-700 dark:bg-zinc-800/40 dark:text-zinc-200 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-zinc-500 dark:text-zinc-400">Total Piutang</span>
                            <span class="text-zinc-900 dark:text-white">
                                Rp {{ number_format($history->jumlah_piutang, 2, '.', ',') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-zinc-500 dark:text-zinc-400">Pembayaran</span>
                            <span class="text-green-600 dark:text-green-400">
                                - Rp
                                {{ number_format($activeLatestDetails->sum('total_bayar'), 2, '.', ',') }}
                            </span>
                        </div>
                        <div
                            class="flex items-center justify-between gap-4 border-t border-zinc-200 pt-2 dark:border-zinc-700">
                            <span class="text-zinc-800 dark:text-zinc-200">Sisa</span>
                            @php
                                $sisaTagihan =
                                    $history->jumlah_piutang - $activeLatestDetails->sum('total_bayar');
                            @endphp
                            <span class="flex items-center gap-1.5 text-sm font-extrabold">
                                <span
                                    class="{{ $sisaTagihan <= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                                    Rp {{ number_format($sisaTagihan, 2, '.', ',') }}
                                </span>
                                @if ($sisaTagihan <= 0)
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        LUNAS
                                    </span>
                                @endif
                            </span>
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
