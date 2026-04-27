{{-- Goal: Manage Leave Balances interface, Livewire: Handler.LeaveRequest.ManageBalances.Index, Alpine: true --}}

<div class="mt-4 flex flex-col gap-6" x-data="{ activeTab: 'balances' }">
    {{-- Header Section --}}
    <div
        class="flex flex-col justify-between gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 sm:flex-row sm:items-center md:p-6">
        <div class="flex items-center gap-4">
            <div class="bg-red-500/10 text-red-500 flex h-14 w-14 items-center justify-center rounded-xl">
                <x-icons.user-group class="h-8 w-8" />
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Pengaturan Cuti</h1>
                <div class="flex items-center gap-2 mt-1">
                    <button @click="activeTab = 'balances'" :class="activeTab === 'balances' ? 'text-red-600 bg-red-50 dark:bg-red-900/20' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800'" class="px-3 py-1 rounded-lg text-xs font-bold transition-all">Kelola Saldo</button>
                    <button @click="activeTab = 'types'" :class="activeTab === 'types' ? 'text-red-600 bg-red-50 dark:bg-red-900/20' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800'" class="px-3 py-1 rounded-lg text-xs font-bold transition-all">Tipe Cuti</button>
                </div>
            </div>
        </div>
        
        <div x-show="activeTab === 'balances'" class="flex items-center gap-3">
            <div class="relative">
                <select wire:model.live="year"
                    class="focus:ring-red-500/50 rounded-xl border border-zinc-200 bg-white/50 py-2 pl-3 pr-10 text-sm font-bold dark:border-zinc-800 dark:bg-dark-primary/50 dark:text-white">
                    @for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}">Tahun {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <x-button.primary class="shadow-red-500/20 shadow-lg">
                <x-slot name="icon"><x-icons.clockwise class="h-4 w-4" /></x-slot>
                Reset Massal
            </x-button.primary>
        </div>

        <div x-show="activeTab === 'types'" class="flex items-center">
            <x-button.primary wire:click="openModal" class="shadow-red-500/20 shadow-lg">
                <x-slot name="icon"><x-icons.plus class="h-4 w-4" /></x-slot>
                Tambah Tipe Cuti
            </x-button.primary>
        </div>
    </div>

    {{-- Leave Types View --}}
    <div x-show="activeTab === 'types'" x-transition class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($leaveTypes as $type)
            <div class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white/60 p-6 backdrop-blur-xl transition-all hover:border-red-500/50 hover:shadow-lg dark:border-zinc-800 dark:bg-dark-primary/60">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-zinc-400">{{ $type->code }}</span>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $type->name }}</h3>
                    </div>
                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button wire:click="openModal({{ $type->id }})" class="p-1.5 rounded-lg bg-zinc-100 text-zinc-600 hover:bg-red-500 hover:text-white dark:bg-zinc-800 dark:text-zinc-400">
                            <x-icons.pen class="h-4 w-4" />
                        </button>
                        <button wire:confirm="Apakah Anda yakin ingin menghapus tipe cuti ini?" wire:click="deleteType({{ $type->id }})" class="p-1.5 rounded-lg bg-zinc-100 text-zinc-600 hover:bg-red-600 hover:text-white dark:bg-zinc-800 dark:text-zinc-400">
                            <x-icons.close class="h-4 w-4" />
                        </button>
                    </div>
                </div>
                
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-[10px] font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                        {{ $type->default_days ? $type->default_days . ' Hari' : 'Tanpa Batas' }}
                    </span>
                    @if($type->is_anual_deduction)
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-[10px] font-bold text-red-700 dark:bg-red-900/30 dark:text-red-400">
                            Potong Saldo
                        </span>
                    @endif
                    @if($type->requires_attachment)
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                            Wajib Lampiran
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Balances Table View --}}
    <div x-show="activeTab === 'balances'" x-transition
        class="flex flex-col gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 md:p-6">

        {{-- Search and Filter --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div class="relative w-full sm:w-96">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <x-icons.search class="h-5 w-5 text-zinc-400" />
                </div>
                <input type="text" wire:model.live="search"
                    class="focus:ring-red-500/50 focus:border-red-500 block w-full rounded-xl border-zinc-200 bg-zinc-50/50 py-3 pl-11 pr-4 text-sm transition-all dark:border-zinc-800 dark:bg-dark-primary/50 dark:text-white"
                    placeholder="Cari nama atau kode pegawai...">
            </div>
        </div>

        {{-- Balanced Table --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr
                            class="bg-zinc-50/50 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:bg-white/5 dark:text-zinc-400">
                            <th class="px-6 py-4">Karyawan</th>
                            <th class="px-6 py-4 text-center">Tahun</th>
                            <th class="px-6 py-4 text-center">Total Kuota</th>
                            <th class="px-6 py-4 text-center">Terpakai</th>
                            <th class="px-6 py-4 text-center">Sisa</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse ($users as $user)
                            @php
                                $balance = $user->leaveBalances->first();
                                $total = $balance ? $balance->total_quota : 0;
                                $used = $balance ? $balance->used_quota : 0;
                                $remaining = $total - $used;
                                $percentage = $total > 0 ? ($used / $total) * 100 : 0;
                            @endphp
                            <tr class="group transition-colors hover:bg-zinc-50/50 dark:hover:bg-white/5">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-zinc-100 font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                            {{ Str::substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="font-bold text-zinc-900 dark:text-white">{{ $user->name }}</span>
                                            <span class="text-xs text-zinc-500">{{ $user->kode_pegawai }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center font-medium">{{ $year }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-xl bg-zinc-100 px-2 py-1 font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ $total }} Hari
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-red-600 dark:text-red-500">{{ $used }}
                                        Hari</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <span
                                            class="text-lg font-black text-emerald-600 dark:text-emerald-500">{{ $remaining }}</span>
                                        <div
                                            class="h-1.5 w-16 overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800">
                                            <div class="h-full bg-emerald-500 transition-all"
                                                style="width: {{ 100 - $percentage }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            class="bg-red-500/10 text-red-600 hover:bg-red-500 flex h-8 w-8 items-center justify-center rounded-xl transition-all hover:text-white">
                                            <x-icons.pen class="h-4 w-4" />
                                        </button>
                                        <button
                                            class="flex h-8 w-8 items-center justify-center rounded-xl bg-zinc-100 text-zinc-500 transition-all hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-400">
                                            <x-icons.clockwise class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-zinc-500">
                                    Tidak ada data karyawan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    @include('livewire.handler.leave-request.manage-balances.leave-type-modal')
</div>
