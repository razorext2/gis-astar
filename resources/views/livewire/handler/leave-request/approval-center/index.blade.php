{{-- Goal: Approval Center interface for processing leave requests, Livewire: Handler.LeaveRequest.ApprovalCenter.Index, Alpine: false --}}

<div class="mt-4 flex flex-col gap-6">
    {{-- Header Section --}}
    <div
        class="flex flex-col justify-between gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 sm:flex-row sm:items-center md:p-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Pusat Persetujuan Cuti</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Tinjau dan proses pengajuan cuti dari anggota tim Anda.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span
                class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700 dark:bg-red-900/30 dark:text-red-400">
                {{ $pendingApprovals->count() }} Menunggu Tindakan
            </span>
        </div>
    </div>

    <div
        class="flex flex-col gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 lg:p-6">
        {{-- Tabs Section --}}
        <div class="flex items-center gap-2 overflow-x-auto border-b border-zinc-100 dark:border-zinc-800">
            <button wire:click="setTab('pending')"
                class="{{ $activeTab === 'pending' ? 'text-primary' : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }} group relative px-4 py-3 text-sm font-bold transition-all duration-200">
                <span>Antrean</span>
                @if ($activeTab === 'pending')
                    <div class="absolute bottom-0 left-0 h-0.5 w-full bg-primary shadow-[0_0_8px_rgba(239,68,68,0.5)]">
                    </div>
                @endif
            </button>
            @if (auth()->user()->can('leave-view-all'))
                <button wire:click="setTab('all')"
                    class="{{ $activeTab === 'all' ? 'text-primary' : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }} group relative px-4 py-3 text-sm font-bold transition-all duration-200">
                    <span>Semua Data</span>
                    @if ($activeTab === 'all')
                        <div
                            class="absolute bottom-0 left-0 h-0.5 w-full bg-primary shadow-[0_0_8px_rgba(239,68,68,0.5)]">
                        </div>
                    @endif
                </button>
            @endif
        </div>

        {{-- Search and Filter Bar --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center">
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-icons.search-alt class="h-5 w-5 text-zinc-400" />
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="block w-full rounded-xl border-zinc-200 bg-zinc-50 py-2.5 pl-10 text-sm focus:border-primary focus:ring-primary dark:border-zinc-800 dark:bg-white/5 dark:text-white"
                    placeholder="Cari nama, kode pegawai, atau alasan...">
            </div>

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

    {{-- Approval List --}}
    <div class="grid gap-4 lg:gap-6">
        @forelse ($pendingApprovals as $request)
            <div wire:key="approval-{{ $request->id }}"
                class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-xl transition-all duration-300 hover:border-red-500/50 hover:shadow-lg dark:border-zinc-800 dark:bg-dark-primary/60 dark:hover:bg-dark-primary/80 lg:p-6">

                {{-- Hover Accent --}}
                <div
                    class="absolute inset-y-0 left-0 w-1 bg-red-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                </div>

                <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        {{-- Avatar / Initials --}}
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-100 text-lg font-black text-red-600 dark:bg-red-900/40 dark:text-red-400">
                            {{ collect(explode(' ', $request->user->name ?? 'User'))->map(fn($n) => Str::substr($n, 0, 1))->take(2)->implode('') }}
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-lg font-bold leading-tight text-zinc-900 dark:text-white">
                                {{ $request->user->name ?? 'User Unknown' }}
                            </h3>
                            <div
                                class="mt-1 flex flex-wrap items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                                <span
                                    class="font-mono text-xs">{{ $request->user->pegawai->kode_pegawai ?? '-' }}</span>
                                <span>•</span>
                                <span
                                    class="font-medium text-red-600 dark:text-red-500">{{ $request->leaveType->name ?? 'Tipe Cuti' }}</span>

                                @if ($request->approval_role_label && $activeTab === 'pending')
                                    <span>•</span>
                                    <span
                                        class="flex items-center gap-1 rounded-full bg-primary/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-primary dark:bg-primary/20">
                                        <x-icons.user-circle class="h-3 w-3" />
                                        {{ $request->approval_role_label }}
                                    </span>
                                @endif

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
                                            'label' => 'Selesai',
                                            'class' =>
                                                'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
                                        ],
                                        'rejected' => [
                                            'label' => 'Ditolak',
                                            'class' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                                        ],
                                        'canceled' => [
                                            'label' => 'Dibatalkan',
                                            'class' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                        ],
                                        'cancelled' => [
                                            'label' => 'Dibatalkan',
                                            'class' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                        ],
                                    ][$request->status] ?? [
                                        'label' => $request->status,
                                        'class' => 'bg-gray-100 text-gray-700',
                                    ];
                                @endphp

                                <span>•</span>
                                <span
                                    class="{{ $statusConfig['class'] }} flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider">
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-start gap-4 sm:items-end sm:gap-2">
                        <div class="flex items-center gap-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            <x-icons.calendar class="h-4 w-4" />
                            {{ $request->start_date->format('d M') }} - {{ $request->end_date->format('d M Y') }}
                            <span
                                class="ml-2 rounded-xl bg-gray-100 px-2 py-0.5 text-xs text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                {{ $request->total_days }} Hari
                            </span>
                        </div>

                        <div class="flex w-full gap-2 sm:w-auto">
                            <x-button.primary wire:navigate
                                href="{{ route('leave-request.approval-center.show', $request->id) }}"
                                class="!px-4 !py-1.5 text-sm">
                                Proses
                            </x-button.primary>
                            <x-button.link wire:navigate
                                href="{{ route('leave-request.approval-center.show', $request->id) }}"
                                class="!px-3 !py-1 text-sm">
                                Detail
                            </x-button.link>
                        </div>
                    </div>
                </div>

                {{-- Reason Snippet --}}
                <div
                    class="mt-4 rounded-xl bg-gray-50/50 p-3 text-sm italic text-gray-600 dark:bg-white/5 dark:text-gray-400">
                    "{{ Str::limit($request->reason, 120) }}"
                </div>
            </div>
        @empty
            <div
                class="flex flex-col items-center justify-center rounded-xl border border-zinc-200 bg-white/50 py-16 backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/50">
                <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                    <x-icons.check class="h-10 w-10 text-zinc-300 dark:text-zinc-600" />
                </div>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Tidak Ada Data</h3>
                <p class="mt-1 text-zinc-500 dark:text-zinc-400">Tidak ada pengajuan yang sesuai dengan kriteria filter
                    Anda.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $pendingApprovals->links() }}
    </div>
</div>
