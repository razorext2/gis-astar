<div class="mt-4 flex flex-col gap-6">

    {{-- Header Section --}}
    <div
        class="flex flex-col justify-between gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 sm:flex-row sm:items-center lg:p-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Daftar Pengajuan Cuti</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pantau status pengajuan cuti dan riwayat ketidakhadiran
                Anda.</p>
        </div>
        <div class="flex shrink-0">
            <x-button.primary wire:navigate href="{{ route('leave-request.my-requests.create') }}">
                <x-slot name="icon">
                    <x-icons.plus class="h-5 w-5 transition-transform group-hover:rotate-90" />
                </x-slot>
                Buat Pengajuan
            </x-button.primary>
        </div>
    </div>

    <div
        class="flex flex-col gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
        {{-- Tabs Section --}}
        @if (auth()->user()->can('leave-list-all'))
            <div class="flex items-center gap-2 overflow-x-auto border-b border-zinc-100 dark:border-zinc-800">
                <button wire:click="setTab('own')"
                    class="{{ $activeTab === 'own' ? 'text-primary' : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }} group relative px-4 py-3 text-sm font-bold transition-all duration-200">
                    <span>Pengajuan Saya</span>
                    @if ($activeTab === 'own')
                        <div
                            class="absolute bottom-0 left-0 h-0.5 w-full bg-primary shadow-[0_0_8px_rgba(239,68,68,0.5)]">
                        </div>
                    @endif
                </button>
                <button wire:click="setTab('all')"
                    class="{{ $activeTab === 'all' ? 'text-primary' : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }} group relative px-4 py-3 text-sm font-bold transition-all duration-200">
                    <span>Semua Pengajuan</span>
                    @if ($activeTab === 'all')
                        <div
                            class="absolute bottom-0 left-0 h-0.5 w-full bg-primary shadow-[0_0_8px_rgba(239,68,68,0.5)]">
                        </div>
                    @endif
                </button>
            </div>
        @endif

        {{-- Search and Filter Bar --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center">
            @if (auth()->user()->can('leave-list-all') && $activeTab == 'all')
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-icons.search-alt class="h-5 w-5 text-zinc-400" />
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="block w-full rounded-xl border-zinc-200 bg-zinc-50 py-2.5 pl-10 text-sm focus:border-primary focus:ring-primary dark:border-zinc-800 dark:bg-white/5 dark:text-white"
                        placeholder="Cari nama, kode pegawai, atau alasan...">
                </div>
            @endif

            <div class="flex flex-wrap items-center gap-3">
                <select wire:model.live="filterStatus"
                    class="rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-700 focus:border-primary focus:ring-primary dark:border-zinc-800 dark:bg-white/5 dark:text-white">
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="">Semua Status
                    </option>
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="pending_backup">
                        Menunggu Backup</option>
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="pending_spv">Menunggu
                        SPV</option>
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="pending_hrd">Menunggu
                        HRD</option>
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="pending_management">
                        Menunggu Management</option>
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="approved">Disetujui
                    </option>
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="rejected">Ditolak
                    </option>
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="canceled">Dibatalkan
                    </option>
                </select>

                <select wire:model.live="filterLeaveType"
                    class="rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-700 focus:border-primary focus:ring-primary dark:border-zinc-800 dark:bg-white/5 dark:text-white">
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="">Semua Tipe
                        Cuti</option>
                    @foreach ($leaveTypes as $type)
                        <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white"
                            value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>

                @if ($search || $filterStatus || $filterLeaveType)
                    <button wire:click="resetFilters"
                        class="text-sm font-bold text-red-600 transition-colors hover:text-red-700">
                        Reset Filter
                    </button>
                @endif
            </div>
        </div>
    </div>

    {{-- Main List --}}
    <div class="grid gap-4 lg:gap-6">
        @forelse ($leaveRequests as $request)
            <div wire:key="request-{{ $request->id }}"
                class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-xl transition-all duration-300 hover:border-red-500/30 hover:shadow-lg hover:shadow-primary/5 dark:border-zinc-800 dark:bg-dark-primary/60 dark:hover:bg-dark-primary/80 lg:p-6">

                {{-- Decorative Blob --}}
                <div
                    class="absolute -right-10 -top-10 z-0 h-40 w-40 rounded-full bg-primary/5 opacity-0 blur-3xl transition-opacity duration-500 group-hover:opacity-100">
                </div>

                <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-xl bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white">
                            <span class="text-xs font-bold uppercase">{{ $request->start_date->format('M') }}</span>
                            <span class="text-xl font-black">{{ $request->start_date->format('d') }}</span>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-lg font-bold leading-tight text-gray-900 dark:text-white">
                                {{ $request->leaveType->name ?? 'Tipe Cuti Tidak Diketahui' }}</h3>

                            @if ($activeTab === 'all')
                                <div class="mt-1 flex items-center gap-2">
                                    <span
                                        class="rounded bg-zinc-100 px-1.5 py-0.5 text-[10px] font-black text-zinc-600 dark:bg-white/10 dark:text-zinc-400">
                                        {{ $request->user->pegawai->kode_pegawai ?? '-' }}
                                    </span>
                                    <p
                                        class="text-xs font-bold uppercase tracking-tighter text-zinc-600 dark:text-zinc-400">
                                        {{ $request->user->name ?? '-' }}
                                        <span
                                            class="ml-1 font-normal lowercase text-zinc-400">({{ $request->user->pegawai->jabatanRelasi->nama_jabatan ?? 'Staf' }})</span>
                                    </p>
                                </div>
                            @endif

                            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                                {{ $request->start_date->format('d M Y') }} -
                                {{ $request->end_date->format('d M Y') }}
                                <span class="mx-1 text-gray-300">•</span>
                                <span class="font-medium text-primary">{{ $request->total_days }} Hari</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col items-start gap-3 sm:items-end sm:gap-2">
                        @php
                            $statusConfig = [
                                'pending_backup' => [
                                    'label' => 'Menunggu Backup',
                                    'class' =>
                                        'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300',
                                ],
                                'pending_spv' => [
                                    'label' => 'Menunggu SPV',
                                    'class' =>
                                        'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300',
                                ],
                                'pending_hrd' => [
                                    'label' => 'Menunggu HRD',
                                    'class' =>
                                        'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300',
                                ],
                                'pending_management' => [
                                    'label' => 'Menunggu Management',
                                    'class' =>
                                        'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
                                ],
                                'approved' => [
                                    'label' => 'Disetujui',
                                    'class' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
                                ],
                                'rejected' => [
                                    'label' => 'Ditolak',
                                    'class' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                ],
                                'cancelled' => [
                                    'label' => 'Dibatalkan',
                                    'class' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                ],
                                'canceled' => [
                                    'label' => 'Dibatalkan',
                                    'class' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                ],
                            ][$request->status] ?? [
                                'label' => $request->status,
                                'class' => 'bg-gray-100 text-gray-700',
                            ];
                        @endphp

                        <span
                            class="{{ $statusConfig['class'] }} inline-flex items-center rounded-full px-3 py-1 text-xs font-bold">
                            <span class="mr-1.5 h-1.5 w-1.5 animate-pulse rounded-full bg-current"></span>
                            {{ $statusConfig['label'] }}
                        </span>

                        <div class="flex gap-2">
                            <x-button.link wire:navigate
                                href="{{ route('leave-request.my-requests.show', $request->id) }}"
                                class="!px-3 !py-1 text-sm font-semibold">
                                Detail
                            </x-button.link>
                            @if (in_array($request->status, ['pending_backup', 'pending_spv']))
                                <x-button.link wire:navigate
                                    href="{{ route('leave-request.my-requests.edit', $request->id) }}"
                                    class="!px-3 !py-1 text-sm font-semibold">
                                    Edit
                                </x-button.link>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Reason Snippet --}}
                <div
                    class="mt-4 rounded-xl bg-gray-50/50 p-3 text-sm italic text-gray-600 dark:bg-white/5 dark:text-gray-400">
                    "{{ Str::limit($request->reason, 100) }}"
                </div>
            </div>
        @empty
            <div
                class="flex flex-col items-center justify-center rounded-xl border border-zinc-200 bg-white/50 py-16 backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/50">
                <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                    <x-icons.envelope class="h-10 w-10 text-gray-300 dark:text-gray-600" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Belum Ada Pengajuan</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Anda belum pernah membuat pengajuan cuti.</p>
                <x-button.primary wire:navigate href="{{ route('leave-request.my-requests.create') }}" class="mt-6">
                    Buat Sekarang
                </x-button.primary>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $leaveRequests->links() }}
    </div>
</div>
