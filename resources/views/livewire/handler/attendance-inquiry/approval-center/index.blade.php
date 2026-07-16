{{-- Goal: List all employee attendance inquiries for HRD, Livewire: App\Livewire\Handler\AttendanceInquiry\ApprovalCenterIndex, Alpine: - --}}
<div class="rounded-xl border border-zinc-200 p-4 shadow-sm dark:border-zinc-800 md:p-6 lg:p-8"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    {{-- Header --}}
    <div class="border-b border-zinc-200 pb-4 dark:border-zinc-800">
        <h2 class="text-xl font-bold text-zinc-900 dark:text-white lg:text-2xl">Persetujuan Laporan Absensi</h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">Verifikasi dan setujui permintaan koreksi/input manual
            absensi karyawan.</p>
    </div>

    {{-- Tabs --}}
    <div class="mt-6 border-b border-zinc-200 dark:border-zinc-800">
        <ul class="-mb-px flex flex-wrap text-center text-sm font-medium">
            <li class="mr-2">
                <button wire:click="setTab('pending')"
                    class="{{ $activeTab === 'pending' ? 'border-blue-600 text-blue-600 font-bold dark:border-blue-500 dark:text-blue-500' : 'border-transparent text-zinc-500 hover:text-zinc-600 hover:border-zinc-300 dark:text-zinc-400' }} inline-block rounded-t-lg border-b-2 p-4 transition-all duration-150">
                    Menunggu Verifikasi
                </button>
            </li>
            <li class="mr-2">
                <button wire:click="setTab('approved')"
                    class="{{ $activeTab === 'approved' ? 'border-blue-600 text-blue-600 font-bold dark:border-blue-500 dark:text-blue-500' : 'border-transparent text-zinc-500 hover:text-zinc-600 hover:border-zinc-300 dark:text-zinc-400' }} inline-block rounded-t-lg border-b-2 p-4 transition-all duration-150">
                    Disetujui
                </button>
            </li>
            <li class="mr-2">
                <button wire:click="setTab('rejected')"
                    class="{{ $activeTab === 'rejected' ? 'border-blue-600 text-blue-600 font-bold dark:border-blue-500 dark:text-blue-500' : 'border-transparent text-zinc-500 hover:text-zinc-600 hover:border-zinc-300 dark:text-zinc-400' }} inline-block rounded-t-lg border-b-2 p-4 transition-all duration-150">
                    Ditolak
                </button>
            </li>
        </ul>
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
                    placeholder="Cari nama karyawan, kode pegawai, atau no. VT..." />
            </div>
        </div>
        <div class="w-full md:w-48">
            <select wire:model.live="filterType"
                class="block w-full rounded-lg border-zinc-200 bg-zinc-50/50 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white">
                <option value="">Semua Tipe</option>
                <option value="in">Masuk (Clock In)</option>
                <option value="out">Keluar (Clock Out)</option>
            </select>
        </div>
        @if ($search || $filterType)
            <button wire:click="resetFilters"
                class="text-sm font-semibold text-red-600 hover:text-red-500 dark:text-red-400">
                Reset Filter
            </button>
        @endif
    </div>

    {{-- Table --}}
    <div class="mt-6 overflow-hidden rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-zinc-500 dark:text-zinc-400">
                <thead
                    class="bg-zinc-50 text-xs font-bold uppercase tracking-wider text-zinc-700 dark:bg-zinc-800/50 dark:text-zinc-300">
                    <tr>
                        <th class="px-6 py-4">Karyawan</th>
                        <th class="px-6 py-4">Waktu Absen</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status Rute</th>
                        <th class="px-6 py-4">No. VT</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800"
                    x-bind:class="dynamicBg ?
                        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    @forelse ($inquiries as $inquiry)
                        <tr wire:key="approval-{{ $inquiry->id }}"
                            class="transition-colors hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span
                                        class="font-bold text-zinc-900 dark:text-white">{{ $inquiry->user->name ?? 'Karyawan' }}</span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">ID:
                                        {{ $inquiry->kode_pegawai }}</span>
                                </div>
                            </td>
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
                                <a href="{{ route('attendance-inquiry.approval-center.show', $inquiry->id) }}"
                                    wire:navigate
                                    class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                    Detail / Tinjau
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <x-icons.info-circle class="h-8 w-8 text-zinc-400" />
                                    <span>Tidak ada pengajuan laporan absensi untuk diverifikasi.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($inquiries->hasPages())
            <div class="border-t border-zinc-200 bg-zinc-50/50 px-6 py-4 dark:border-zinc-800"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
</div>
