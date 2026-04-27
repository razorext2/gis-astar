{{-- Goal: Manage Leave Balances interface, Livewire: Handler.LeaveRequest.ManageBalances.Index, Alpine: false --}}

<div class="mt-4 flex flex-col gap-6">
    {{-- Header Section --}}
    <div
        class="flex flex-col justify-between gap-4 rounded-2xl border border-gray-200 bg-white/60 p-4 backdrop-blur-xl dark:border-gray-700 dark:bg-dark-primary/60 sm:flex-row sm:items-center md:p-6">
        <div class="flex items-center gap-4">
            <div class="bg-primary/10 text-primary flex h-14 w-14 items-center justify-center rounded-2xl">
                <x-icons.user-group class="h-8 w-8" />
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Kelola Saldo Cuti</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Atur jatah dan pantau penggunaan cuti seluruh
                    karyawan.
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative">
                <select wire:model.live="year"
                    class="focus:ring-primary/50 rounded-xl border border-gray-200 bg-white/50 py-2 pl-3 pr-10 text-sm font-bold dark:border-gray-700 dark:bg-dark-primary/50 dark:text-white">
                    @for ($i = date('Y') - 2; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}">Tahun {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <x-button.primary class="shadow-primary/20 shadow-lg">
                <x-slot name="icon"><x-icons.plus class="h-4 w-4" /></x-slot>
                Reset Massal
            </x-button.primary>
        </div>
    </div>

    {{-- Main Container --}}
    <div
        class="flex flex-col gap-6 rounded-2xl border border-gray-200 bg-white/60 p-4 backdrop-blur-xl dark:border-gray-700 dark:bg-dark-primary/60 md:p-6">

        {{-- Search and Filter --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div class="relative w-full sm:w-96">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <x-icons.search class="h-5 w-5 text-gray-400" />
                </div>
                <input type="text" wire:model.live="search"
                    class="focus:ring-primary/50 focus:border-primary block w-full rounded-2xl border-gray-200 bg-gray-50/50 py-3 pl-11 pr-4 text-sm transition-all dark:border-gray-700 dark:bg-dark-primary/50 dark:text-white"
                    placeholder="Cari nama atau kode pegawai...">
            </div>
        </div>

        {{-- Balanced Table --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr
                            class="bg-gray-50/50 text-xs font-bold uppercase tracking-wider text-gray-500 dark:bg-white/5 dark:text-gray-400">
                            <th class="px-6 py-4">Karyawan</th>
                            <th class="px-6 py-4 text-center">Tahun</th>
                            <th class="px-6 py-4 text-center">Total Kuota</th>
                            <th class="px-6 py-4 text-center">Terpakai</th>
                            <th class="px-6 py-4 text-center">Sisa</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($users as $user)
                            @php
                                $balance = $user->leaveBalances->first();
                                $total = $balance ? $balance->total_quota : 0;
                                $used = $balance ? $balance->used_quota : 0;
                                $remaining = $total - $used;
                                $percentage = $total > 0 ? ($used / $total) * 100 : 0;
                            @endphp
                            <tr class="group transition-colors hover:bg-gray-50/50 dark:hover:bg-white/5">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 font-bold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                            {{ Str::substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $user->kode_pegawai }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center font-medium">{{ $year }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-lg bg-gray-100 px-2 py-1 font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">
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
                                            class="h-1.5 w-16 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                                            <div class="h-full bg-emerald-500 transition-all"
                                                style="width: {{ 100 - $percentage }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            class="bg-primary/10 text-primary hover:bg-primary flex h-8 w-8 items-center justify-center rounded-lg transition-all hover:text-white">
                                            <x-icons.pen class="h-4 w-4" />
                                        </button>
                                        <button
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition-all hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400">
                                            <x-icons.clockwise class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
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
</div>
