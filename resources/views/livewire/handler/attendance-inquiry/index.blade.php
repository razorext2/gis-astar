{{-- Goal: List own attendance inquiries, Livewire: App\Livewire\Handler\AttendanceInquiry\Index, Alpine: - --}}
<div
    class="rounded-xl border border-zinc-200 p-4 shadow-sm dark:border-zinc-800 md:p-6 lg:p-8"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    {{-- Header --}}
    <div
        class="flex flex-col justify-between gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-xl font-bold text-zinc-900 dark:text-white lg:text-2xl">Laporan Absensi Saya</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Pengajuan perbaikan atau input manual absensi yang
                terlewat.</p>
        </div>
        <div>
            <x-button.primary href="{{ route('attendance-inquiry.my-inquiries.create') }}"
                class="px-5 transition-all hover:shadow-lg">
                <x-slot name="icon">
                    <x-icons.plus class="mr-2 h-4 w-4" />
                </x-slot>
                Buat Laporan Baru
            </x-button.primary>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center">
        <div class="flex-1">
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-icons.search class="h-4 w-4 text-zinc-400" />
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="block w-full rounded-lg border-zinc-200 bg-zinc-50/50 pl-10 text-sm text-zinc-900 placeholder-zinc-400 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white dark:placeholder-zinc-500"
                    placeholder="Cari berdasarkan keterangan atau nomor VT..." />
            </div>
        </div>
        <div class="w-full md:w-48">
            <select wire:model.live="filterStatus"
                class="block w-full rounded-lg border-zinc-200 bg-zinc-50/50 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
        @if ($search || $filterStatus)
            <button wire:click="resetFilters"
                class="text-sm font-semibold text-red-600 hover:text-red-500 dark:text-red-400">
                Reset Filter
            </button>
        @endif
    </div>

    {{-- Table / Cards list --}}
    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-500 dark:text-zinc-400">
                <thead
                    class="bg-zinc-50 text-xs font-bold uppercase tracking-wider text-zinc-700 dark:bg-zinc-800/50 dark:text-zinc-300">
                    <tr>
                        <th class="px-6 py-4">Waktu Absen</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status Rute</th>
                        <th class="px-6 py-4">No. VT</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    @forelse ($inquiries as $inquiry)
                        <tr wire:key="inquiry-{{ $inquiry->id }}"
                            class="transition-colors hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30">
                            <td class="whitespace-nowrap px-6 py-4 font-semibold text-zinc-900 dark:text-white">
                                {{ $inquiry->waktu_absen->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    class="{{ $inquiry->type_absen === 'in' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400' : 'bg-purple-50 text-purple-700 dark:bg-purple-900/20 dark:text-purple-400' }} inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-bold">
                                    {{ $inquiry->type_absen === 'in' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-700 dark:text-zinc-300">
                                {{ $inquiry->position_status_label }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-mono text-zinc-600 dark:text-zinc-400">
                                {{ $inquiry->no_vt ?: '-' }}
                            </td>
                            <td class="max-w-xs truncate px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                {{ $inquiry->keterangan }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @php
                                    $statusColor = match ($inquiry->status) {
                                        'approved'
                                            => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800',
                                        'rejected'
                                            => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800',
                                        default
                                            => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800',
                                    };
                                @endphp
                                <span
                                    class="{{ $statusColor }} inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-bold">
                                    {{ $inquiry->status_label }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <a href="{{ route('attendance-inquiry.my-inquiries.show', $inquiry->id) }}"
                                    wire:navigate
                                    class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                    <x-icons.eye class="mr-1 h-4 w-4" /> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <x-icons.info-circle class="h-8 w-8 text-zinc-400" />
                                    <span>Tidak ada data laporan absensi ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($inquiries->hasPages())
            <div class="border-t border-zinc-200 bg-zinc-50/50 px-6 py-4 dark:border-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
</div>
