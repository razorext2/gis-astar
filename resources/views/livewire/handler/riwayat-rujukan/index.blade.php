{{-- Goal: Riwayat Rujukan — tabel lengkap dengan filter, stat cards, dan pagination --}}
<div class="flex flex-col gap-4">

    {{-- ───── Filter Card ───── --}}
    <div
        class="dark:bg-dark-primary rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800">

        {{-- Filter Inputs --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

            {{-- 1. Cari --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Cari Pasien / No. Rujukan</label>
                <div class="relative">
                    <input wire:model.live.debounce.400ms="search" type="text"
                        placeholder="Nama pasien atau no. rujukan..."
                        class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 pl-9 pr-3 text-xs text-zinc-800 placeholder-zinc-400 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:placeholder-zinc-500 dark:focus:bg-zinc-900">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                        <x-icons.search class="h-3.5 w-3.5" />
                    </div>
                </div>
            </div>

            {{-- 2. Tanggal --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Tanggal Rujukan</label>
                <div class="flex items-center gap-1.5">
                    <input wire:model="dateFrom" type="date"
                        class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-2.5 text-xs text-zinc-800 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                    <span class="shrink-0 text-xs text-zinc-400">–</span>
                    <input wire:model="dateTo" type="date"
                        class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-2.5 text-xs text-zinc-800 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                </div>
            </div>

            {{-- 3. Rumah Sakit --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Rumah Sakit Rujukan</label>
                <select wire:model="rumahSakitId"
                    class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs text-zinc-800 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900 [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                    <option value="">Semua Rumah Sakit</option>
                    @foreach ($rumahSakitList as $rs)
                        <option value="{{ $rs->id_rumah_sakit }}">{{ $rs->nama_rumah_sakit }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 4. Status --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Status Rujukan</label>
                <select wire:model="status"
                    class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs text-zinc-800 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900 [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                    <option value="">Semua Status</option>
                    @foreach ($statusOptions as $s)
                        <option value="{{ $s->value }}">{{ $s->label() }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Action Buttons --}}
        <div class="mt-4 flex justify-end gap-2">
            <button wire:click="resetFilter" type="button"
                class="inline-flex h-9 items-center gap-1.5 rounded-xl border border-zinc-200/80 bg-white px-4 text-xs font-semibold text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-800/80 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                <x-icons.refresh class="h-3.5 w-3.5" />
                Reset Filter
            </button>
            <button wire:click="applyFilter" type="button"
                class="inline-flex h-9 items-center gap-1.5 rounded-xl bg-blue-600 px-4 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600">
                <x-icons.search class="h-3.5 w-3.5" />
                Terapkan Filter
            </button>
        </div>

    </div>

    {{-- ───── Stat Cards ───── --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        {{-- Total Rujukan --}}
        <div
            class="dark:bg-dark-primary flex items-center gap-3.5 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-950/40">
                <x-icons.clipboard-list class="h-5 w-5 text-blue-600 dark:text-blue-400" />
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">Total Rujukan</p>
                <p class="text-2xl font-extrabold leading-tight text-zinc-900 dark:text-white">
                    {{ number_format($statsTotal) }}</p>
                <p class="text-[11px] text-zinc-400">Semua rujukan</p>
            </div>
        </div>

        {{-- Selesai --}}
        <div
            class="dark:bg-dark-primary flex items-center gap-3.5 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800">
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/40">
                <x-icons.check-circle class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">Selesai</p>
                <p class="text-2xl font-extrabold leading-tight text-zinc-900 dark:text-white">
                    {{ number_format($statsSelesai) }}</p>
                @if ($statsTotal > 0)
                    <p class="text-[11px] text-zinc-400">{{ number_format(($statsSelesai / $statsTotal) * 100, 2) }}%
                        dari
                        total</p>
                @else
                    <p class="text-[11px] text-zinc-400">0% dari total</p>
                @endif
            </div>
        </div>

        {{-- Proses --}}
        <div
            class="dark:bg-dark-primary flex items-center gap-3.5 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800">
            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-950/40">
                <x-icons.clock class="h-5 w-5 text-amber-600 dark:text-amber-400" />
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">Proses</p>
                <p class="text-2xl font-extrabold leading-tight text-zinc-900 dark:text-white">
                    {{ number_format($statsProses) }}</p>
                @if ($statsTotal > 0)
                    <p class="text-[11px] text-zinc-400">{{ number_format(($statsProses / $statsTotal) * 100, 2) }}%
                        dari
                        total</p>
                @else
                    <p class="text-[11px] text-zinc-400">0% dari total</p>
                @endif
            </div>
        </div>

        {{-- Dibatalkan --}}
        <div
            class="dark:bg-dark-primary flex items-center gap-3.5 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 dark:bg-red-950/40">
                <x-icons.close class="h-5 w-5 text-red-600 dark:text-red-400" />
            </div>
            <div class="min-w-0">
                <p class="text-xs font-medium text-zinc-400 dark:text-zinc-500">Dibatalkan</p>
                <p class="text-2xl font-extrabold leading-tight text-zinc-900 dark:text-white">
                    {{ number_format($statsDitolak) }}</p>
                @if ($statsTotal > 0)
                    <p class="text-[11px] text-zinc-400">{{ number_format(($statsDitolak / $statsTotal) * 100, 2) }}%
                        dari total</p>
                @else
                    <p class="text-[11px] text-zinc-400">0% dari total</p>
                @endif
            </div>
        </div>

    </div>

    {{-- ───── Table Card ───── --}}
    <div class="dark:bg-dark-primary rounded-2xl border border-zinc-200/80 bg-white shadow-sm dark:border-zinc-800">

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-zinc-700 dark:text-zinc-300">
                <thead
                    class="border-b border-zinc-200/80 bg-zinc-50/80 text-[11px] font-semibold uppercase tracking-wider text-zinc-500 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-zinc-400">
                    <tr>
                        <th class="w-10 px-4 py-3.5 text-center">No.</th>
                        <th class="px-4 py-3.5">No. Rujukan</th>
                        <th class="px-4 py-3.5">Pasien</th>
                        <th class="px-4 py-3.5">Tanggal Rujukan</th>
                        {{-- <th class="px-4 py-3.5">Alamat Pasien</th> --}}
                        <th class="px-4 py-3.5">Rumah Sakit Rujukan</th>
                        <th class="w-24 px-4 py-3.5 text-center">Jarak (km)</th>
                        <th class="w-28 px-4 py-3.5 text-center">Waktu Tempuh</th>
                        <th class="w-24 px-4 py-3.5 text-center">Status</th>
                        <th class="w-20 px-4 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200/80 dark:divide-zinc-700/80">

                    @forelse ($rujukanList as $item)
                        @php
                            $statusColor = match ($item->status) {
                                \App\Enums\StatusRujukan::Selesai
                                    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                                \App\Enums\StatusRujukan::Disetujui
                                    => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                                \App\Enums\StatusRujukan::Ditolak
                                    => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                default => 'bg-zinc-100 text-zinc-600 dark:bg-zinc-700/60 dark:text-zinc-300',
                            };
                        @endphp
                        <tr class="transition-colors hover:bg-zinc-50/80 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3.5 text-center font-semibold text-zinc-400">
                                {{ ($rujukanList->currentPage() - 1) * $rujukanList->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-xs font-semibold text-blue-600 dark:text-blue-400">
                                {{ $item->no_rujukan }}
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="font-semibold text-zinc-900 dark:text-white">
                                    {{ $item->pasien?->nama ?? '-' }}</p>
                                <p class="text-[11px] text-zinc-400">{{ $item->pasien?->no_rm ?? '' }}</p>
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $item->tanggal_rujukan?->locale('id')->isoFormat('DD/MM/YYYY') ?? '-' }}
                                </p>
                                <p class="text-[11px] text-zinc-400">
                                    {{ $item->tanggal_rujukan?->format('H:i') ?? '' }}
                                </p>
                            </td>
                            {{-- <td class="px-4 py-3.5">
                                <p class="font-medium text-zinc-700 dark:text-zinc-300">
                                    {{ $item->pasien?->alamat ?? '-' }}
                                </p>
                            </td> --}}
                            <td class="px-4 py-3.5 font-semibold text-zinc-900 dark:text-white">
                                {{ $item->rumahSakit?->nama_rumah_sakit ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-center font-medium text-zinc-700 dark:text-zinc-300">
                                @if ($item->detailRujukan?->jarak)
                                    {{ number_format($item->detailRujukan->jarak, 1, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-center font-medium text-zinc-700 dark:text-zinc-300">
                                @if ($item->detailRujukan?->waktu_tempuh)
                                    {{ $item->detailRujukan->waktu_tempuh }} menit
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span
                                    class="{{ $statusColor }} inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold">
                                    {{ $item->status->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <a href="{{ route('rujukan.show', $item->id_rujukan) }}" wire:navigate
                                    class="inline-flex items-center gap-1 rounded-lg border border-zinc-200/80 bg-white px-2.5 py-1 text-[11px] font-semibold text-zinc-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 dark:border-zinc-700/80 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:border-blue-600 dark:hover:bg-blue-900/20 dark:hover:text-blue-300">
                                    <x-icons.eye class="h-3 w-3" />
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800">
                                        <x-icons.clipboard-list class="h-7 w-7 text-zinc-400" />
                                    </div>
                                    <p class="font-semibold text-zinc-500 dark:text-zinc-400">Tidak ada data rujukan
                                    </p>
                                    <p class="text-xs text-zinc-400">Coba ubah filter pencarian Anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Footer: Info + Pagination --}}
        @if ($rujukanList->hasPages() || $rujukanList->total() > 0)
            <div
                class="flex flex-col items-center justify-between gap-3 border-t border-zinc-200/60 px-4 py-3.5 sm:flex-row dark:border-zinc-800/80">

                {{-- Info --}}
                <p class="text-xs text-zinc-400">
                    Menampilkan
                    <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $rujukanList->firstItem() ?? 0 }}
                        – {{ $rujukanList->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $rujukanList->total() }}</span>
                    data
                </p>

                {{-- Pagination --}}
                @if ($rujukanList->hasPages())
                    <div class="flex items-center gap-1">
                        {{-- Prev --}}
                        @if ($rujukanList->onFirstPage())
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200/80 text-zinc-300 dark:border-zinc-700/80 dark:text-zinc-600">
                                <x-icons.chevron-left class="h-3.5 w-3.5" />
                            </span>
                        @else
                            <button wire:click="previousPage"
                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200/80 text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700/80 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                <x-icons.chevron-left class="h-3.5 w-3.5" />
                            </button>
                        @endif

                        {{-- Page numbers --}}
                        @foreach ($rujukanList->getUrlRange(max(1, $rujukanList->currentPage() - 2), min($rujukanList->lastPage(), $rujukanList->currentPage() + 2)) as $page => $url)
                            @if ($page === $rujukanList->currentPage())
                                <span
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }})"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200/80 text-xs font-medium text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700/80 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        {{-- Ellipsis + Last page --}}
                        @if ($rujukanList->currentPage() + 2 < $rujukanList->lastPage())
                            <span class="flex h-8 w-8 items-center justify-center text-xs text-zinc-400">…</span>
                            <button wire:click="gotoPage({{ $rujukanList->lastPage() }})"
                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200/80 text-xs font-medium text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700/80 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                {{ $rujukanList->lastPage() }}
                            </button>
                        @endif

                        {{-- Next --}}
                        @if ($rujukanList->hasMorePages())
                            <button wire:click="nextPage"
                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200/80 text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700/80 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                <x-icons.chevron-right class="h-3.5 w-3.5" />
                            </button>
                        @else
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200/80 text-zinc-300 dark:border-zinc-700/80 dark:text-zinc-600">
                                <x-icons.chevron-right class="h-3.5 w-3.5" />
                            </span>
                        @endif
                    </div>
                @endif

            </div>
        @endif

    </div>

</div>
