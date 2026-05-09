{{-- Goal: Leave balance filter, table, pagination & edit modal, Livewire: Handler.LeaveRequest.ManageBalances.Table, Alpine: true --}}
<div class="flex flex-col gap-6">

    {{-- Toolbar: Search + Year + Reset Massal --}}
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 bg-white/60 p-4 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60 sm:flex-row sm:items-center sm:justify-between md:p-5">
        {{-- Search --}}
        <div class="relative w-full sm:w-96">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <x-icons.search class="h-5 w-5 text-zinc-400" />
            </div>
            <input type="text" wire:model.live="search"
                class="block w-full rounded-xl border-zinc-200 bg-zinc-50/50 py-3 pl-11 pr-4 text-sm transition-all focus:border-red-500 focus:ring-red-500/50 dark:border-zinc-800 dark:bg-dark-primary/50 dark:text-white"
                placeholder="Cari nama atau kode pegawai...">
        </div>

        {{-- Year + Reset --}}
        <div class="flex shrink-0 items-center gap-3">
            <select wire:model.live="year"
                class="rounded-xl border border-zinc-200 bg-white/50 py-2.5 pl-3 pr-10 text-sm font-bold text-zinc-700 focus:ring-red-500/50 dark:border-zinc-800 dark:bg-dark-primary/50 dark:text-white">
                @for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="{{ $i }}">
                        Tahun {{ $i }}</option>
                @endfor
            </select>
            <x-button.primary wire:click="resetAll"
                wire:confirm="Hitung ulang semua saldo pegawai untuk tahun {{ $year }} sesuai masa kerja masing-masing?">
                <x-slot name="icon"><x-icons.clockwise class="h-4 w-4" /></x-slot>
                Reset Massal
            </x-button.primary>
        </div>
    </div>

    {{-- Table --}}
    <div
        class="overflow-hidden rounded-xl border border-zinc-200 bg-white/60 backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary/60">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr
                        class="bg-zinc-50/50 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:bg-white/5 dark:text-zinc-400">
                        <th class="px-6 py-4">Karyawan</th>
                        <th class="px-6 py-4 text-center">Join Date</th>
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
                                        <span class="font-bold text-zinc-900 dark:text-white">{{ $user->name }}</span>
                                        <span class="text-xs text-zinc-500">{{ $user->kode_pegawai }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-xs text-zinc-500">
                                {{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->locale('id')->isoFormat('DD MMM YYYY') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-medium">{{ $year }}</td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center rounded-xl bg-zinc-100 px-2 py-1 font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                    {{ $total }} Hari
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold text-red-600 dark:text-red-500">{{ $used }} Hari</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span
                                        class="text-lg font-black text-emerald-600 dark:text-emerald-500">{{ $remaining }}</span>
                                    <div class="h-1.5 w-16 overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-800">
                                        <div class="h-full bg-emerald-500 transition-all"
                                            style="width: {{ 100 - $percentage }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button wire:click="openHistory({{ $user->id }})"
                                        class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-500/10 text-blue-600 transition-all hover:bg-blue-500 hover:text-white"
                                        title="Riwayat Cuti">
                                        <x-icons.clock class="h-4 w-4" />
                                    </button>
                                    <button wire:click="openEdit({{ $user->id }})"
                                        class="flex h-8 w-8 items-center justify-center rounded-xl bg-red-500/10 text-red-600 transition-all hover:bg-red-500 hover:text-white"
                                        title="Edit Saldo">
                                        <x-icons.pen class="h-4 w-4" />
                                    </button>
                                    <button wire:click="resetBalance({{ $user->id }})"
                                        wire:confirm="Hitung ulang saldo cuti {{ $user->name }} sesuai masa kerjanya?"
                                        class="flex h-8 w-8 items-center justify-center rounded-xl bg-zinc-100 text-zinc-500 transition-all hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-400"
                                        title="Reset Saldo">
                                        <x-icons.clockwise class="h-4 w-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-zinc-500">
                                Tidak ada data karyawan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div>
        {{ $users->links() }}
    </div>

    {{-- Edit Balance Modal --}}
    <div x-data="{ open: @entangle('isEditOpen') }" x-show="open"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-900/60 p-4 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

        <div @click.away="open = false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="w-full max-w-md overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-dark-primary">

            <div class="flex items-center justify-between border-b border-zinc-100 p-6 dark:border-zinc-800">
                <div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Edit Saldo Cuti</h3>
                    <p class="mt-0.5 text-sm text-zinc-500">{{ $editUserName }} &mdash; Tahun {{ $year }}</p>
                </div>
                <button @click="open = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-icons.close class="h-5 w-5" />
                </button>
            </div>

            <form wire:submit.prevent="saveBalance" class="space-y-5 p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <x-input.basic type="number" id="editTotalQuota" name="editTotalQuota"
                            wire:model="editTotalQuota" :labels="true" min="0">
                            Total Kuota (Hari)
                        </x-input.basic>
                        @error('editTotalQuota')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <x-input.basic type="number" id="editUsedQuota" name="editUsedQuota"
                            wire:model="editUsedQuota" :labels="true" min="0">
                            Terpakai (Hari)
                        </x-input.basic>
                        @error('editUsedQuota')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Live preview --}}
                <div class="rounded-xl bg-zinc-50 p-4 dark:bg-white/5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-500">Sisa Cuti</span>
                        <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">
                            {{ max(0, $editTotalQuota - $editUsedQuota) }} Hari
                        </span>
                    </div>
                    @if ($editTotalQuota > 0)
                        <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-700">
                            <div class="h-full bg-emerald-500 transition-all"
                                style="width: {{ min(100, max(0, 100 - ($editUsedQuota / $editTotalQuota) * 100)) }}%">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="rounded-xl border border-zinc-200 px-5 py-2 text-sm font-bold text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-400">
                        Batal
                    </button>
                    <x-button.primary type="submit">
                        <x-slot name="icon"><x-icons.check class="h-4 w-4" /></x-slot>
                        Simpan
                    </x-button.primary>
                </div>
            </form>
        </div>
    </div>

    {{-- History Modal --}}
    <div x-data="{ open: @entangle('isHistoryOpen') }" x-show="open"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-900/60 p-4 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

        <div @click.away="open = false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="flex max-h-[85vh] w-full max-w-2xl flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-2xl dark:border-zinc-800 dark:bg-dark-primary">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between border-b border-zinc-100 p-5 dark:border-zinc-800">
                <div class="flex flex-col">
                    <h3 class="text-lg font-black text-zinc-800 dark:text-zinc-100">Riwayat Pengajuan</h3>
                    <p class="text-xs text-zinc-500">{{ $historyUserName }} - Tahun {{ $year }}</p>
                </div>
                <button @click="open = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                    <x-icons.close class="h-6 w-6" />
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="flex-1 overflow-y-auto p-5">
                @if (count($historyData) > 0)
                    <div class="space-y-4">
                        @foreach ($historyData as $item)
                            <div
                                class="group relative flex gap-4 rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 transition-all hover:border-blue-500/30 hover:bg-white dark:border-zinc-800 dark:bg-zinc-800/20 dark:hover:bg-zinc-800/40">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-white font-bold text-zinc-600 shadow-sm dark:bg-zinc-800 dark:text-zinc-400">
                                        {{ \Carbon\Carbon::parse($item['start_date'])->format('d') }}
                                    </div>
                                    <div class="text-[10px] font-bold uppercase text-zinc-400">
                                        {{ \Carbon\Carbon::parse($item['start_date'])->format('M') }}
                                    </div>
                                </div>
                                <div class="flex flex-1 flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-zinc-800 dark:text-zinc-200">
                                            {{ $item['leave_type']['name'] ?? 'Tipe Cuti' }}
                                        </span>
                                        @php
                                            $statusColor = match ($item['status']) {
                                                'approved'
                                                    => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                                                'rejected'
                                                    => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                                                default
                                                    => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                            };
                                        @endphp
                                        <span
                                            class="{{ $statusColor }} rounded-lg px-2 py-0.5 text-[10px] font-black uppercase tracking-wider">
                                            {{ $item['status'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-zinc-500">
                                        {{ \Carbon\Carbon::parse($item['start_date'])->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($item['end_date'])->format('d M Y') }}
                                        <span class="mx-1 text-zinc-300">|</span>
                                        <span
                                            class="font-bold text-zinc-700 dark:text-zinc-400">{{ $item['total_days'] }}
                                            Hari</span>
                                    </p>
                                    @if ($item['reason'])
                                        <p class="mt-1 text-xs italic text-zinc-400">"{{ $item['reason'] }}"</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div
                            class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                            <x-icons.clock class="h-8 w-8" />
                        </div>
                        <h4 class="font-bold text-zinc-800 dark:text-zinc-200">Belum ada riwayat</h4>
                        <p class="text-xs text-zinc-500">Karyawan ini belum mengajukan cuti di tahun
                            {{ $year }}.</p>
                    </div>
                @endif
            </div>

            {{-- Modal Footer --}}
            <div class="bg-zinc-50 p-4 text-right dark:bg-zinc-900/50">
                <button @click="open = false"
                    class="rounded-xl bg-zinc-200 px-6 py-2 text-xs font-bold text-zinc-700 transition-all hover:bg-zinc-300 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
