{{-- Goal: Leave balance filter, table, pagination & edit modal, Livewire: Handler.LeaveRequest.ManageBalances.Table, Alpine: true --}}
<div class="flex flex-col gap-4">

    {{-- Toolbar: Search + Year + Reset Massal --}}
    <div
        class="flex flex-col gap-4 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800 sm:flex-row sm:items-center sm:justify-between md:p-5"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        {{-- Search --}}
        <div class="relative w-full sm:w-96">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <x-icons.search class="h-5 w-5 text-zinc-400" />
            </div>
            <input type="text" wire:model.live="search"
                class="block w-full rounded-xl border-zinc-200 bg-zinc-50/50 py-3 pl-11 pr-4 text-sm transition-all focus:border-red-500 focus:ring-red-500/50 dark:border-zinc-800 dark:text-white"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'"
                placeholder="Cari nama atau kode pegawai...">
        </div>

        {{-- Year + Reset --}}
        <div class="flex shrink-0 items-center gap-3">
            <select wire:model.live="year"
                class="rounded-xl border border-zinc-200 py-2.5 pl-3 pr-10 text-sm font-bold text-zinc-700 focus:ring-red-500/50 dark:border-zinc-800 dark:text-white"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                @for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                    <option class="bg-white text-zinc-900 dark:bg-zinc-800 dark:text-white" value="{{ $i }}">
                        Tahun {{ $i }}</option>
                @endfor
            </select>
            <x-button.primary wire:click="openResetModal">
                <x-slot name="icon"><x-icons.clockwise class="h-4 w-4" /></x-slot>
                Reset Massal
            </x-button.primary>
        </div>
    </div>

    {{-- Table --}}
    <div
        class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr
                        class="bg-zinc-50/50 text-xs font-bold uppercase tracking-wider text-zinc-500 dark: dark:text-zinc-400"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
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
                        <tr class="group transition-colors hover:bg-zinc-50/50 dark:hover:"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
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

    {{-- Edit Saldo Modal --}}
    <x-modal.base-modal :show="'isEditOpen'" :title="'Edit Saldo Cuti'" :subtitle="$editUserName . ' — Tahun ' . $year" maxWidth="md">
        <x-slot name="icon">
            <x-icons.pen class="h-5 w-5" />
        </x-slot>

        <form wire:submit.prevent="saveBalance" class="space-y-5">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <x-input.basic type="number" id="editTotalQuota" name="editTotalQuota" wire:model="editTotalQuota"
                        :labels="true" min="0">
                        Total Kuota (Hari)
                    </x-input.basic>
                    @error('editTotalQuota')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <x-input.basic type="number" id="editUsedQuota" name="editUsedQuota" wire:model="editUsedQuota"
                        :labels="true" min="0">
                        Terpakai (Hari)
                    </x-input.basic>
                    @error('editUsedQuota')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Live preview --}}
            <div class="rounded-xl bg-zinc-50 p-4 dark:"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
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

            <div class="flex justify-end gap-3 pt-2">
                <x-button.secondary @click="open = false">
                    Batal
                </x-button.secondary>
                <x-button.primary type="submit">
                    <x-slot name="icon"><x-icons.check class="h-4 w-4" /></x-slot>
                    Simpan
                </x-button.primary>
            </div>
        </form>
    </x-modal.base-modal>

    {{-- History Modal --}}
    <x-modal.base-modal :show="'isHistoryOpen'" :title="'Riwayat Pengajuan'" :subtitle="$historyUserName . ' — Tahun ' . $year" maxWidth="2xl">
        <x-slot name="icon">
            <x-icons.clock class="h-5 w-5" />
        </x-slot>

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
                                        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
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
                                <span class="font-bold text-zinc-700 dark:text-zinc-400">{{ $item['total_days'] }}
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

        <x-slot name="footer">
            <x-button.secondary @click="open = false">
                Tutup
            </x-button.secondary>
        </x-slot>
    </x-modal.base-modal>

    {{-- Reset Filter Modal --}}
    <x-modal.base-modal :show="'isResetFilterOpen'" :title="'Reset Saldo Cuti'" :subtitle="'Tahun ' . $year" maxWidth="lg">
        <x-slot name="icon">
            <x-icons.clockwise class="h-5 w-5" />
        </x-slot>

        <div x-data="{ mode: @entangle('resetMode') }" class="space-y-5">
            {{-- Mode Tabs --}}
            <div class="flex gap-2 rounded-xl bg-zinc-100 p-1 dark:bg-zinc-800">
                <button type="button" @click="mode = 'all'; $wire.set('resetMode', 'all')"
                    :class="mode === 'all' ? 'bg-white shadow text-blue-600 dark:bg-zinc-700 dark:text-blue-400' :
                        'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                    class="flex-1 rounded-lg px-3 py-2 text-xs font-bold transition-all">
                    <x-icons.users class="mx-auto mb-1 h-4 w-4" />
                    Semua Pegawai
                </button>
                <button type="button" @click="mode = 'role'; $wire.set('resetMode', 'role')"
                    :class="mode === 'role' ? 'bg-white shadow text-blue-600 dark:bg-zinc-700 dark:text-blue-400' :
                        'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                    class="flex-1 rounded-lg px-3 py-2 text-xs font-bold transition-all">
                    <x-icons.user-group class="mx-auto mb-1 h-4 w-4" />
                    Berdasarkan Role
                </button>
                <button type="button" @click="mode = 'users'; $wire.set('resetMode', 'users')"
                    :class="mode === 'users' ? 'bg-white shadow text-blue-600 dark:bg-zinc-700 dark:text-blue-400' :
                        'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                    class="flex-1 rounded-lg px-3 py-2 text-xs font-bold transition-all">
                    <x-icons.user class="mx-auto mb-1 h-4 w-4" />
                    Pilih User
                </button>
            </div>

            {{-- Mode: All --}}
            <div x-show="mode === 'all'" x-cloak>
                <div class="flex items-center gap-3 rounded-xl bg-blue-50 p-4 dark:bg-blue-500/10">
                    <x-icons.info-circle class="h-5 w-5 shrink-0 text-blue-500" />
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        Semua pegawai aktif akan direset saldo cutinya sesuai masa kerja.
                        Pegawai yang sudah memiliki riwayat pemakaian akan dilewati.
                    </p>
                </div>
            </div>

            {{-- Mode: Role (Multi-select) --}}
            <div x-show="mode === 'role'" x-cloak class="space-y-3">
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300">Pilih Role</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($this->roles as $role)
                        <label wire:key="role-{{ $role->id }}"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border px-3 py-2 text-sm font-medium transition-all"
                            :class="$wire.resetSelectedRoleIds.includes('{{ $role->id }}') ?
                                'border-blue-500 bg-blue-50 text-blue-700 dark:border-blue-500 dark:bg-blue-500/20 dark:text-blue-300' :
                                'border-zinc-200 bg-white text-zinc-600 hover:border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-600'">
                            <input type="checkbox" value="{{ $role->id }}"
                                wire:model.live="resetSelectedRoleIds" class="hidden">
                            <x-icons.check class="h-3.5 w-3.5"
                                x-show="$wire.resetSelectedRoleIds.includes('{{ $role->id }}')" x-cloak />
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>
                <div class="flex items-center gap-3 rounded-xl bg-amber-50 p-3 dark:bg-amber-500/10">
                    <x-icons.info-circle class="h-4 w-4 shrink-0 text-amber-500" />
                    <p class="text-xs text-amber-700 dark:text-amber-300">
                        Pegawai yang memiliki salah satu role terpilih akan direset.
                    </p>
                </div>
            </div>

            {{-- Mode: Users (Multi-select) --}}
            <div x-show="mode === 'users'" x-cloak class="space-y-3">
                <label class="block text-sm font-bold text-zinc-700 dark:text-zinc-300">Cari & Pilih User</label>

                {{-- Selected Users Pills --}}
                @if (count($resetSelectedUsers) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach ($resetSelectedUsers as $su)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-lg bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                                {{ $su['name'] }}
                                <button type="button" wire:click="removeResetUser({{ $su['id'] }})"
                                    class="rounded-full p-0.5 transition-colors hover:bg-blue-200 dark:hover:bg-blue-500/30">
                                    <x-icons.close class="h-3 w-3" />
                                </button>
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Search Input --}}
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <x-icons.search class="h-4 w-4 text-zinc-400" />
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="resetUserSearchQuery"
                        class="block w-full rounded-xl border-zinc-200 bg-zinc-50/50 py-3 pl-10 pr-4 text-sm transition-all focus:border-blue-500 focus:ring-blue-500/50 dark:border-zinc-800 dark:text-white"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'"
                        placeholder="Ketik nama atau kode pegawai...">
                </div>

                {{-- Search Results Dropdown --}}
                @if (count($this->resetUserSearchResults) > 0)
                    <div
                        class="max-h-48 space-y-1 overflow-y-auto rounded-xl border border-zinc-200 bg-white p-2 dark:border-zinc-700 dark:bg-zinc-800">
                        @foreach ($this->resetUserSearchResults as $result)
                            <button type="button"
                                wire:click="selectResetUser({{ $result->id }}, '{{ addslashes($result->name) }}', '{{ $result->kode_pegawai }}')"
                                class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-left text-sm transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-xs font-bold text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400">
                                    {{ Str::substr($result->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span
                                        class="font-bold text-zinc-800 dark:text-zinc-200">{{ $result->name }}</span>
                                    <span class="text-xs text-zinc-400">{{ $result->kode_pegawai }}</span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                @elseif (strlen($resetUserSearchQuery) >= 1)
                    <p class="py-2 text-center text-xs text-zinc-400">Tidak ada hasil ditemukan.</p>
                @endif
            </div>
        </div>

        <x-slot name="footer">
            <x-button.secondary type="button" @click="open = false">
                Batal
            </x-button.secondary>
            <x-button.primary wire:click="resetByFilter"
                wire:confirm="Yakin ingin mereset saldo cuti untuk tahun {{ $year }}? Pegawai dengan riwayat pemakaian akan dilewati.">
                <x-slot name="icon"><x-icons.clockwise class="h-4 w-4" /></x-slot>
                Reset Sekarang
            </x-button.primary>
        </x-slot>
    </x-modal.base-modal>
</div>
