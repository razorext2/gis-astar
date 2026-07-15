<div class="flex flex-col gap-4">
    <h3 class="mt-2 text-xl font-semibold text-zinc-900 dark:text-white lg:text-2xl">Summary Pengajuan</h3>

    @if ($results->isNotEmpty())
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

            {{-- Card: Informasi Transaksi --}}
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <h3
                    class="flex items-center gap-2 border-b border-zinc-200 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.info-circle class="h-4 w-4 text-blue-500" /> Informasi Transaksi
                </h3>

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">No. Transaksi</span>
                        <span class="font-mono text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $results->first()->transaction_id ?? 'Transaksi tidak ditemukan' }}
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Kuartal /
                            Tahun</span>
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            Q{{ $results->first()->quartal }} {{ $results->first()->year }}
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Diredeem Oleh</span>
                        <span class="text-sm font-semibold capitalize text-zinc-900 dark:text-white">
                            {{ $results->first()->redeemedby->name ?? '-' }}
                        </span>
                    </div>

                    <div class="col-span-2 flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Periode Waktu</span>
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            {{ \Carbon\Carbon::parse($results->first()->from_date)->locale('id')->isoFormat('D MMMM Y') }}
                            <span class="mx-1 text-zinc-400">s/d</span>
                            {{ \Carbon\Carbon::parse($results->first()->to_date)->locale('id')->isoFormat('D MMMM Y') }}
                        </span>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Status</span>
                        <div>
                            @php
                                $statusMap = [
                                    0 => [
                                        'label' => 'Belum divalidasi',
                                        'color' =>
                                            'bg-zinc-50 text-zinc-700 ring-zinc-500/20 dark:bg-zinc-900/30 dark:text-zinc-400 dark:ring-zinc-700/30',
                                    ],
                                    1 => [
                                        'label' => 'Butuh konfirmasi',
                                        'color' =>
                                            'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-900/30 dark:text-amber-400 dark:ring-amber-500/30',
                                    ],
                                    2 => [
                                        'label' => 'Diteruskan ke HRD',
                                        'color' =>
                                            'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400 dark:ring-blue-500/30',
                                    ],
                                    3 => [
                                        'label' => 'Dikonfirmasi',
                                        'color' =>
                                            'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-900/30 dark:text-green-400 dark:ring-green-500/30',
                                    ],
                                    4 => [
                                        'label' => 'Ditolak',
                                        'color' =>
                                            'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-900/30 dark:text-red-400 dark:ring-red-500/30',
                                    ],
                                ];
                                $statusData = $statusMap[$results->first()->status] ?? [
                                    'label' => 'Status tidak diketahui',
                                    'color' => 'bg-zinc-50 text-zinc-700 ring-zinc-500/20',
                                ];
                            @endphp
                            <span
                                class="{{ $statusData['color'] }} mt-1 inline-flex items-center rounded-md px-2.5 py-1 text-xs font-medium ring-1 ring-inset">
                                {{ $statusData['label'] }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Total Poin
                            Redeem</span>
                        <span
                            class="mt-1 inline-flex w-fit items-center rounded-md bg-green-50 px-2.5 py-1 text-sm font-bold text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-500/30">
                            + {{ $results->sum('total_points') }} Poin
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card: Daftar Pegawai --}}
            <div
                class="flex flex-col gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:row-span-2"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <div
                    class="flex items-center gap-2 border-b border-zinc-200 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
                    <x-icons.users class="h-4 w-4 text-blue-500" /> Daftar Teknisi Terlibat
                </div>

                <div class="max-h-64 overflow-y-auto">
                    <table class="w-full whitespace-nowrap text-left text-sm">
                        <thead
                            class="sticky top-0 border-b border-zinc-200 text-xs text-zinc-500 dark:border-zinc-800 dark:text-zinc-400"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                            <tr>
                                <th class="pb-2 font-medium">Pegawai</th>
                                <th class="pb-2 text-right font-medium">Poin Terkumpul</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach ($results as $item)
                                <tr>
                                    <td class="py-3 pr-4">
                                        <p class="font-medium text-zinc-900 dark:text-white">
                                            {{ $item->pegawai->full_name ?? 'Pegawai belum terdaftar' }}
                                        </p>
                                        <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                                            Kode: {{ $item->kode_pegawai }}
                                        </p>
                                    </td>
                                    <td class="py-3 pl-4 text-right align-middle">
                                        <span class="font-semibold text-green-600 dark:text-green-400">
                                            {{ $item->total_points ?? 0 }} Poin
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Card: Call to Action --}}
            @if ($results->first()->status == 1)
                <div
                    class="flex flex-col items-center justify-between gap-4 rounded-xl border border-blue-200 bg-blue-50/50 p-4 dark:border-blue-900/30 dark:bg-blue-900/10 sm:flex-row">
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">Lanjutkan
                            Pengajuan</span>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">Transaksi ini akan diteruskan ke
                            tim HRD untuk diverifikasi.</span>
                    </div>
                    <x-button.primary class="w-full shrink-0 sm:w-auto"
                        wire:click="processRedeem('{{ $results->first()->transaction_id }}')"
                        wire:loading.attr="disabled" wire:target="processRedeem">
                        <x-slot name="icon">
                            <x-icons.angle-right wire:loading.remove wire:target="processRedeem"
                                class="icon h-5 w-5" />
                            <x-icons.loading wire:loading wire:target="processRedeem"
                                class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span wire:loading.remove wire:target="processRedeem">Kirim ke HRD</span>
                        <span wire:loading wire:target="processRedeem">Memproses...</span>
                    </x-button.primary>
                </div>
            @endif

        </div>
    @else
        <div class="py-8 text-center">
            <p class="text-zinc-500 dark:text-zinc-400">Tidak ada data ditemukan.</p>
            <a href="{{ route('points.redeem', ['step' => 1]) }}"
                class="mt-2 inline-block text-blue-500 hover:underline dark:text-blue-400">Kembali</a>
        </div>
    @endif
</div>
