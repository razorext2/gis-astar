<div class="flex flex-col gap-4">

    <x-utils.accordion-item id="filter-bar" title="Filter Data Poin"
        description="Saring riwayat poin masuk berdasarkan berbagai kriteria" iconColor="zinc" :expanded="false">
        <x-slot name="icon">
            <x-icons.adjustment class="h-5 w-5" />
        </x-slot>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @can('technician-approve')
                <div>
                    <x-input.basic id="kodepegawai" maxlength="10" name="kodepegawai"
                        wire:model.live.throttle.150ms="kodepegawai" placeholder="Cari kode pegawai...">
                        Kode pegawai:
                    </x-input.basic>
                </div>

                <div>
                    <x-input.basic id="name" maxlength="30" name="name" wire:model.live.throttle.150ms="name"
                        placeholder="Cari nama pegawai...">
                        Nama pegawai:
                    </x-input.basic>
                </div>
            @endcan

            <div>
                <x-input.basic id="no_vt" maxlength="10" name="no_vt" wire:model.live.throttle.150ms="no_vt"
                    placeholder="Cari nomor kunjungan...">
                    Nomor kunjungan:
                </x-input.basic>
            </div>

            <div class="flex flex-col justify-end">
                <x-input.select id="is_redeemed" name="is_redeemed" wire:model.change="is_redeemed"
                    placeholder="Cari status redeem..." defaultOption="Semua" :options="['0' => 'Belum di redeem', '1' => 'Sudah di redeem']" :textLabel="__('Status redeem:')" />
            </div>

            <div>
                <x-input.basic type="date" id="from_date" name="from_date" wire:model.live="from_date"
                    placeholder="Cari tanggal awal...">
                    Tanggal awal:
                </x-input.basic>
            </div>

            <div>
                <x-input.basic type="date" id="to_date" name="to_date" wire:model.live="to_date"
                    placeholder="Cari tanggal akhir...">
                    Tanggal akhir:
                </x-input.basic>
            </div>
        </div>
    </x-utils.accordion-item>

    <div class="inline-flex flex-wrap gap-2 text-xs">
        @if (isset($kodepegawai))
            <p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
                Kode pegawai: <b class="text-green-500">{{ $kodepegawai }}</b>
            </p>
        @endif

        @if (isset($name))
            <p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
                Nama : <b class="text-green-500">{{ $name }}</b>
            </p>
        @endif

        @if (isset($no_vt))
            <p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
                No. VT: <b class="text-green-500">{{ $no_vt }}</b>
            </p>
        @endif

        @if (isset($is_redeemed))
            <p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
                Status: <b class="text-green-500">{{ $is_redeemed == 0 ? 'Belum di redeem' : 'Sudah di redeem' }}</b>
            </p>
        @endif

        @if (isset($from_date))
            <p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
                Dari: <b class="text-green-500">{{ $from_date }}</b>
            </p>
        @endif

        @if (isset($to_date))
            <p class="rounded-lg bg-gray-200 px-2 py-0.5 text-gray-500 dark:bg-gray-800 dark:text-gray-300">
                Sampai: <b class="text-green-500">{{ $to_date }}</b>
            </p>
        @endif
    </div>

    {{ $pointData->onEachSide(1)->links() }}

    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50 dark:shadow-none">
        <div
            class="flex items-center gap-2 border-b border-zinc-200 pb-3 text-sm font-semibold text-zinc-900 dark:border-zinc-800 dark:text-white">
            <x-icons.wallet class="h-4 w-4 text-blue-500" /> Riwayat Transaksi Poin
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left text-sm">
                <thead class="border-b border-zinc-200 text-xs text-zinc-500 dark:border-zinc-800 dark:text-zinc-400">
                    <tr>
                        <th class="pb-2 font-medium">Informasi Poin</th>
                        <th class="pb-2 font-medium">Pegawai</th>
                        <th class="pb-2 font-medium">Waktu Diperoleh</th>
                        <th class="pb-2 text-center font-medium">Status</th>
                        <th class="pb-2 text-right font-medium">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($pointData as $point)
                        <tr>
                            <td class="py-3 pr-4">
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    {{ auth()->user()->can('technician-approve') ? 'Mendapatkan poin' : 'Poin didapatkan' }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    Dari Laporan Kunjungan: <span
                                        class="font-medium text-zinc-900 dark:text-zinc-300">{{ $point->from_vt }}</span>
                                </p>
                            </td>
                            <td class="py-3 pr-4">
                                <p class="font-medium text-zinc-900 dark:text-white">
                                    {{ auth()->user()->can('technician-approve') ? $point->pegawai->full_name ?? 'Teknisi' : 'Anda' }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    Kode: {{ $point->kode_pegawai }}
                                </p>
                            </td>
                            <td class="py-3 pr-4">
                                <p class="text-zinc-900 dark:text-zinc-300">{{ $point->created_at->format('d M Y') }}
                                </p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $point->created_at->format('H:i') }} WIB</p>
                            </td>
                            <td class="py-3 text-center align-middle">
                                @php
                                    $statusMap = [
                                        0 => [
                                            'label' => 'Belum divalidasi',
                                            'color' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
                                        ],
                                        1 => [
                                            'label' => 'Butuh konfirmasi',
                                            'color' =>
                                                'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                        ],
                                        2 => [
                                            'label' => 'Diteruskan ke HRD',
                                            'color' =>
                                                'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        ],
                                        3 => [
                                            'label' => 'Dikonfirmasi',
                                            'color' =>
                                                'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        ],
                                        4 => [
                                            'label' => 'Ditolak',
                                            'color' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        ],
                                    ];

                                    $statusData = $statusMap[$point->redeemed_status] ?? [
                                        'label' => 'Status tidak diketahui',
                                        'color' => 'bg-zinc-100 text-zinc-700',
                                    ];
                                @endphp
                                <div class="flex flex-col items-center gap-1">
                                    @if ($point->is_redeemed)
                                        <span
                                            class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-900/20 dark:text-blue-400 dark:ring-blue-500/20">
                                            Sudah di redeem
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-md bg-zinc-50 px-2.5 py-1 text-xs font-medium text-zinc-600 ring-1 ring-inset ring-zinc-500/10 dark:bg-zinc-800/50 dark:text-zinc-400 dark:ring-zinc-500/20">
                                            Belum di redeem
                                        </span>
                                    @endif
                                    <span
                                        class="{{ $statusData['color'] }} ring-current/10 inline-flex items-center rounded-md px-2.5 py-1 text-xs font-medium ring-1 ring-inset">
                                        {{ $statusData['label'] }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 pl-4 text-right align-middle">
                                <span
                                    class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-xs font-bold text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/20 dark:text-green-400 dark:ring-green-500/20">
                                    + {{ $point->point }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                Data poin tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $pointData->onEachSide(1)->links() }}
        </div>
    </div>
</div>
