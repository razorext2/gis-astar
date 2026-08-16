{{-- Goal: Halaman Laporan Pasien & Riwayat Rujukan dengan Multi-Tab, KPI Cards, Filter, CSV Export, dan Print Layout --}}
<div class="flex flex-col gap-5"
    x-on:open-print-window.window="window.open($event.detail.url, '_blank')">

    {{-- ───── Header & Toolbar (Screen Only) ───── --}}
    <div class="print:hidden rounded-2xl border border-zinc-200/80 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary"
        x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark backdrop-blur-md' : 'bg-white dark:bg-dark-primary'">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Laporan & Rekapitulasi Data</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    Ekspor data dan cetak laporan resmi untuk data Pasien serta Riwayat Rujukan medis.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" wire:click="openPrint" wire:loading.attr="disabled" wire:target="openPrint"
                    class="inline-flex items-center gap-2 rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-zinc-700">
                    <x-icons.receipt wire:loading.remove wire:target="openPrint" class="h-4 w-4 text-zinc-500" />
                    <x-icons.loading wire:loading wire:target="openPrint" class="h-4 w-4 animate-spin" />
                    <span wire:loading.remove wire:target="openPrint">Cetak Laporan</span>
                    <span wire:loading wire:target="openPrint">Membuka...</span>
                </button>

                @if ($activeTab === 'rujukan')
                    <x-button.success wire:click="exportRujukanCsv" wire:loading.attr="disabled" wire:target="exportRujukanCsv">
                        <x-slot name="icon">
                            <x-icons.file-excel wire:loading.remove wire:target="exportRujukanCsv" class="h-4 w-4" />
                            <x-icons.loading wire:loading wire:target="exportRujukanCsv" class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span wire:loading.remove wire:target="exportRujukanCsv">Ekspor CSV Rujukan</span>
                        <span wire:loading wire:target="exportRujukanCsv">Mengekspor...</span>
                    </x-button.success>
                @else
                    <x-button.success wire:click="exportPasienCsv" wire:loading.attr="disabled" wire:target="exportPasienCsv">
                        <x-slot name="icon">
                            <x-icons.file-excel wire:loading.remove wire:target="exportPasienCsv" class="h-4 w-4" />
                            <x-icons.loading wire:loading wire:target="exportPasienCsv" class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span wire:loading.remove wire:target="exportPasienCsv">Ekspor CSV Pasien</span>
                        <span wire:loading wire:target="exportPasienCsv">Mengekspor...</span>
                    </x-button.success>
                @endif
            </div>
        </div>

        {{-- Tab Switcher --}}
        <div class="mt-5 flex border-b border-zinc-200 dark:border-zinc-800">
            <button type="button" wire:click="setTab('rujukan')"
                class="flex items-center gap-2 border-b-2 px-4 py-2.5 text-sm font-semibold transition {{ $activeTab === 'rujukan' ? 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400' : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                <x-icons.truck class="h-4 w-4" />
                <span>Laporan Riwayat Rujukan</span>
                @if(isset($rujukanMetrics['total']))
                    <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
                        {{ number_format($rujukanMetrics['total']) }}
                    </span>
                @endif
            </button>

            <button type="button" wire:click="setTab('pasien')"
                class="flex items-center gap-2 border-b-2 px-4 py-2.5 text-sm font-semibold transition {{ $activeTab === 'pasien' ? 'border-emerald-600 text-emerald-600 dark:border-emerald-400 dark:text-emerald-400' : 'border-transparent text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                <x-icons.users class="h-4 w-4" />
                <span>Laporan Data Pasien</span>
                @if(isset($pasienMetrics['total']))
                    <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-bold text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                        {{ number_format($pasienMetrics['total']) }}
                    </span>
                @endif
            </button>
        </div>
    </div>

    {{-- ───── KOP CETAK LAPORAN (Khusus Mode Print) ───── --}}
    <div class="hidden print:block border-b-2 border-zinc-900 pb-4 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold uppercase tracking-wider text-black">SISTEM RUJUKAN MEDIS GIS-ASTAR</h1>
                <p class="text-xs text-zinc-600">Dokumen Laporan Resmi & Rekapitulasi Pelayanan</p>
            </div>
            <div class="text-right text-xs text-zinc-600">
                <p>Dicetak pada: <strong>{{ now()->translatedFormat('d F Y H:i') }}</strong></p>
                <p>Kategori: <strong>{{ $activeTab === 'rujukan' ? 'Laporan Riwayat Rujukan' : 'Laporan Data Pasien' }}</strong></p>
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- TAB 1: LAPORAN RIWAYAT RUJUKAN                                           --}}
    {{-- ========================================================================= --}}
    @if ($activeTab === 'rujukan')

        {{-- KPI Summary Cards --}}
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6 print:grid-cols-6">
            {{-- Total Rujukan --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400">
                        <x-icons.truck class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Total Rujukan</p>
                        <p class="text-lg font-bold text-zinc-800 dark:text-white">{{ number_format($rujukanMetrics['total'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Disetujui --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400">
                        <x-icons.check-circle class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Disetujui</p>
                        <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($rujukanMetrics['disetujui'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Selesai --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-600 dark:bg-teal-950/40 dark:text-teal-400">
                        <x-icons.badge-check class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Selesai</p>
                        <p class="text-lg font-bold text-teal-600 dark:text-teal-400">{{ number_format($rujukanMetrics['selesai'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Pending --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400">
                        <x-icons.clock class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Pending</p>
                        <p class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ number_format($rujukanMetrics['pending'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Ditolak --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-950/40 dark:text-red-400">
                        <x-icons.close class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Ditolak</p>
                        <p class="text-lg font-bold text-red-600 dark:text-red-400">{{ number_format($rujukanMetrics['ditolak'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Jarak & Biaya --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-950/40 dark:text-purple-400">
                        <x-icons.map-pin class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Total Jarak</p>
                        <p class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ $rujukanMetrics['total_jarak'] ?? 0 }} <span class="text-xs font-normal">km</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Card (Screen Only) --}}
        <div class="print:hidden rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800 dark:bg-dark-primary">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
                {{-- 1. Search --}}
                <div class="space-y-1.5 lg:col-span-2">
                    <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Cari Rujukan / Pasien / RS</label>
                    <div class="relative">
                        <input wire:model.live.debounce.300ms="rujukanSearch" type="text"
                            placeholder="Ketik No. Rujukan, Nama Pasien, NIK, atau Nama RS..."
                            class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 pl-9 pr-3 text-xs text-zinc-800 placeholder-zinc-400 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:placeholder-zinc-500 dark:focus:bg-zinc-900">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                            <x-icons.search class="h-3.5 w-3.5" />
                        </div>
                    </div>
                </div>

                {{-- 2. Periode Tanggal --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Periode Tanggal</label>
                    <div class="flex items-center gap-1.5">
                        <input wire:model.live="rujukanDateFrom" type="date"
                            class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-2.5 text-xs text-zinc-800 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                        <span class="shrink-0 text-xs text-zinc-400">–</span>
                        <input wire:model.live="rujukanDateTo" type="date"
                            class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-2.5 text-xs text-zinc-800 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                    </div>
                </div>

                {{-- 3. RS Tujuan --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">RS Tujuan</label>
                    <select wire:model.live="rujukanRsId"
                        class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs text-zinc-800 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900 [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                        <option value="">Semua RS</option>
                        @foreach ($rumahSakitList as $rs)
                            <option value="{{ $rs->id_rumah_sakit }}">{{ $rs->nama_rumah_sakit }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 4. Status & Reset --}}
                <div class="flex items-end gap-2">
                    <div class="flex-1 space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Status</label>
                        <select wire:model.live="rujukanStatus"
                            class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs text-zinc-800 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900 [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                            <option value="">Semua Status</option>
                            @foreach ($statusOptions as $s)
                                <option value="{{ $s->value }}">{{ $s->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" wire:click="resetRujukanFilter" title="Reset Filter"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-zinc-300/80 bg-zinc-50/50 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:hover:text-white">
                        <x-icons.refresh class="h-4 w-4" />
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabel Laporan Rujukan --}}
        <div class="overflow-hidden rounded-2xl border border-zinc-200/80 bg-white shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="border-b border-zinc-200/80 bg-zinc-50/60 uppercase tracking-wider text-zinc-500 dark:border-zinc-800 dark:bg-zinc-800/40 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">No. Rujukan</th>
                            <th class="px-4 py-3 font-semibold">Tgl Rujukan</th>
                            <th class="px-4 py-3 font-semibold">Nama Pasien / NIK</th>
                            <th class="px-4 py-3 font-semibold">RS Tujuan</th>
                            <th class="px-4 py-3 font-semibold text-right">Jarak (km)</th>
                            <th class="px-4 py-3 font-semibold text-right">Estimasi Biaya</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Dokter Perujuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @forelse ($rujukanData as $index => $row)
                            <tr class="transition hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20">
                                <td class="px-4 py-3 text-zinc-400">
                                    {{ $rujukanData->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-blue-600 dark:text-blue-400">
                                    {{ $row->no_rujukan }}
                                </td>
                                <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">
                                    {{ $row->tanggal_rujukan ? $row->tanggal_rujukan->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-zinc-800 dark:text-white">{{ $row->pasien?->nama ?? '-' }}</p>
                                    <p class="text-[11px] text-zinc-400">{{ $row->pasien?->nik ?? '-' }} • RM: {{ $row->pasien?->no_rm ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3 text-zinc-700 dark:text-zinc-200">
                                    {{ $row->rumahSakit?->nama_rumah_sakit ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-purple-600 dark:text-purple-400">
                                    {{ $row->detailRujukan?->jarak ? number_format($row->detailRujukan->jarak, 2).' km' : '-' }}
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-emerald-600 dark:text-emerald-400">
                                    {{ $row->detailRujukan?->estimasi_biaya ? 'Rp '.number_format($row->detailRujukan->estimasi_biaya, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $badgeStyles = [
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-900/50',
                                            'disetujui' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-900/50',
                                            'ditolak' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/40 dark:text-red-400 dark:border-red-900/50',
                                            'selesai' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950/40 dark:text-blue-400 dark:border-blue-900/50',
                                        ];
                                        $style = $badgeStyles[$row->status?->value ?? 'pending'] ?? 'bg-zinc-50 text-zinc-700 border-zinc-200';
                                    @endphp
                                    <span class="inline-flex items-center rounded-lg border px-2 py-0.5 text-[11px] font-semibold {{ $style }}">
                                        {{ $row->status?->label() ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">
                                    {{ $row->user?->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-zinc-400">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800">
                                        <x-icons.search class="h-6 w-6 text-zinc-400" />
                                    </div>
                                    <p class="mt-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tidak ada data rujukan ditemukan</p>
                                    <p class="text-xs text-zinc-400">Coba ubah kriteria filter pencarian atau tanggal.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (Screen Only) --}}
            @if ($rujukanData && $rujukanData->hasPages())
                <div class="print:hidden border-t border-zinc-200/80 p-4 dark:border-zinc-800">
                    {{ $rujukanData->links() }}
                </div>
            @endif
        </div>

    {{-- ========================================================================= --}}
    {{-- TAB 2: LAPORAN DATA PASIEN                                               --}}
    {{-- ========================================================================= --}}
    @elseif ($activeTab === 'pasien')

        {{-- KPI Summary Cards --}}
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-5 print:grid-cols-5">
            {{-- Total Pasien --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400">
                        <x-icons.users class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Total Pasien</p>
                        <p class="text-lg font-bold text-zinc-800 dark:text-white">{{ number_format($pasienMetrics['total'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Laki-laki --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-950/40 dark:text-sky-400">
                        <x-icons.user class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Laki-laki</p>
                        <p class="text-lg font-bold text-sky-600 dark:text-sky-400">{{ number_format($pasienMetrics['laki_laki'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Perempuan --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-pink-50 text-pink-600 dark:bg-pink-950/40 dark:text-pink-400">
                        <x-icons.user-circle class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Perempuan</p>
                        <p class="text-lg font-bold text-pink-600 dark:text-pink-400">{{ number_format($pasienMetrics['perempuan'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Ada Titik GPS --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400">
                        <x-icons.map-pin class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Titik GPS Ada</p>
                        <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($pasienMetrics['berkoordinat'] ?? 0) }}</p>
                    </div>
                </div>
            </div>

            {{-- Tanpa Titik GPS --}}
            <div class="rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-950/40 dark:text-amber-400">
                        <x-icons.exclamation-circle class="h-5 w-5" />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-400">Tanpa GPS</p>
                        <p class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ number_format($pasienMetrics['tanpa_koordinat'] ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Card (Screen Only) --}}
        <div class="print:hidden rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-sm sm:p-5 dark:border-zinc-800 dark:bg-dark-primary">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
                {{-- 1. Search --}}
                <div class="space-y-1.5 lg:col-span-2">
                    <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Cari Pasien (Nama / NIK / No. RM / Alamat)</label>
                    <div class="relative">
                        <input wire:model.live.debounce.300ms="pasienSearch" type="text"
                            placeholder="Ketik Nama, NIK, No. RM, atau Alamat..."
                            class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 pl-9 pr-3 text-xs text-zinc-800 placeholder-zinc-400 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:placeholder-zinc-500 dark:focus:bg-zinc-900">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                            <x-icons.search class="h-3.5 w-3.5" />
                        </div>
                    </div>
                </div>

                {{-- 2. Periode Pendaftaran --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Tgl Pendaftaran</label>
                    <div class="flex items-center gap-1.5">
                        <input wire:model.live="pasienDateFrom" type="date"
                            class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-2.5 text-xs text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                        <span class="shrink-0 text-xs text-zinc-400">–</span>
                        <input wire:model.live="pasienDateTo" type="date"
                            class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-2.5 text-xs text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900">
                    </div>
                </div>

                {{-- 3. Jenis Kelamin --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Jenis Kelamin</label>
                    <select wire:model.live="pasienGender"
                        class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900 [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                        <option value="">Semua Gender</option>
                        @foreach ($genderOptions as $g)
                            <option value="{{ $g->value }}">{{ $g->label() }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 4. Status Koordinat & Reset --}}
                <div class="flex items-end gap-2">
                    <div class="flex-1 space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Status Koordinat GPS</label>
                        <select wire:model.live="pasienCoordStatus"
                            class="h-9 w-full rounded-xl border border-zinc-300/80 bg-zinc-50/50 px-3 text-xs text-zinc-800 transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20 dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-white dark:focus:bg-zinc-900 [&>option]:dark:bg-zinc-800 [&>option]:dark:text-white">
                            <option value="">Semua Pasien</option>
                            <option value="with">Sudah Ada GPS</option>
                            <option value="without">Belum Ada GPS</option>
                        </select>
                    </div>

                    <button type="button" wire:click="resetPasienFilter" title="Reset Filter"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-zinc-300/80 bg-zinc-50/50 text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700 dark:hover:text-white">
                        <x-icons.refresh class="h-4 w-4" />
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabel Laporan Pasien --}}
        <div class="overflow-hidden rounded-2xl border border-zinc-200/80 bg-white shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="border-b border-zinc-200/80 bg-zinc-50/60 uppercase tracking-wider text-zinc-500 dark:border-zinc-800 dark:bg-zinc-800/40 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">No. RM / NIK</th>
                            <th class="px-4 py-3 font-semibold">Nama Pasien</th>
                            <th class="px-4 py-3 font-semibold">Gender</th>
                            <th class="px-4 py-3 font-semibold">Tgl Lahir</th>
                            <th class="px-4 py-3 font-semibold">No. Telepon</th>
                            <th class="px-4 py-3 font-semibold">Alamat</th>
                            <th class="px-4 py-3 font-semibold">Koordinat GPS</th>
                            <th class="px-4 py-3 font-semibold text-center">Jml Rujukan</th>
                            <th class="px-4 py-3 font-semibold">Tgl Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @forelse ($pasienData as $index => $p)
                            <tr class="transition hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20">
                                <td class="px-4 py-3 text-zinc-400">
                                    {{ $pasienData->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-emerald-600 dark:text-emerald-400">RM: {{ $p->no_rm ?? '-' }}</p>
                                    <p class="text-[11px] text-zinc-400">NIK: {{ $p->nik ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3 font-semibold text-zinc-800 dark:text-white">
                                    {{ $p->nama }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[11px] font-medium {{ $p->jenis_kelamin?->value === 'laki_laki' ? 'bg-sky-50 text-sky-700 dark:bg-sky-950/40 dark:text-sky-300' : 'bg-pink-50 text-pink-700 dark:bg-pink-950/40 dark:text-pink-300' }}">
                                        {{ $p->jenis_kelamin?->label() ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">
                                    {{ $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-zinc-600 dark:text-zinc-300">
                                    {{ $p->no_telepon ?? '-' }}
                                </td>
                                <td class="max-w-[200px] truncate px-4 py-3 text-zinc-600 dark:text-zinc-400" title="{{ $p->alamat }}">
                                    {{ $p->alamat ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($p->hasCoordinates())
                                        <span class="font-mono text-[11px] text-emerald-600 dark:text-emerald-400">
                                            {{ round($p->latitude, 4) }}, {{ round($p->longitude, 4) }}
                                        </span>
                                    @else
                                        <span class="rounded bg-zinc-100 px-1.5 py-0.5 text-[10px] text-zinc-400 dark:bg-zinc-800">
                                            Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-block rounded-full bg-blue-50 px-2 py-0.5 font-bold text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
                                        {{ $p->rujukan_count ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">
                                    {{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-12 text-center text-zinc-400">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-zinc-100 dark:bg-zinc-800">
                                        <x-icons.search class="h-6 w-6 text-zinc-400" />
                                    </div>
                                    <p class="mt-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300">Tidak ada data pasien ditemukan</p>
                                    <p class="text-xs text-zinc-400">Coba ubah kata kunci pencarian atau filter gender/koordinat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (Screen Only) --}}
            @if ($pasienData && $pasienData->hasPages())
                <div class="print:hidden border-t border-zinc-200/80 p-4 dark:border-zinc-800">
                    {{ $pasienData->links() }}
                </div>
            @endif
        </div>

    @endif

</div>
