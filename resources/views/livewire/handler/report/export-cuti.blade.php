{{-- Goal: Custom view export laporan cuti, Livewire: Handler\Report\ExportCuti, Alpine: Yes --}}
<div
    class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 md:p-6">
    <form wire:submit="export" class="flex flex-col gap-4 md:gap-6">

        {{-- Header Title --}}
        <div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Ekspor Laporan Cuti</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Sesuaikan rentang tanggal, pencarian pengaju cuti, role pengguna, dan status cuti untuk mengekspor data cuti.</p>
        </div>

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

        {{-- Quick Date Select --}}
        <div>
            <p class="mb-2 text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Periode</p>
            <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
                <x-button.primary class="!py-2 text-xs font-bold" wire:click="showDaily"
                    type="button">Harian</x-button.primary>
                <x-button.primary class="!py-2 text-xs font-bold" wire:click="showWeekly"
                    type="button">Mingguan</x-button.primary>
                <x-button.primary class="!py-2 text-xs font-bold" wire:click="showMonthly"
                    type="button">Bulanan</x-button.primary>
                <x-button.primary class="!py-2 text-xs font-bold" wire:click="showYearly"
                    type="button">Tahunan</x-button.primary>
            </div>
        </div>

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

        {{-- Manual Date Range --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="report_from_date">
                    Dari Tanggal
                </label>
                <input
                    class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white"
                    id="report_from_date" type="date" wire:model="fromDate" required />
                @error('fromDate')
                    <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="report_to_date">
                    Hingga Tanggal
                </label>
                <input
                    class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white"
                    id="report_to_date" type="date" wire:model="toDate" required />
                @error('toDate')
                    <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

        {{-- Standalone Filters Grid --}}
        <div>
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Parameter Filter Tambahan</p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                {{-- 1. Tipe Tanggal --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_date_type">
                        Tipe Filter Tanggal
                    </label>
                    <select id="report_date_type" wire:model.live="dateType"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="created_at">Tanggal Pengajuan (Created At)</option>
                        <option value="leave_date">Tanggal Cuti Diambil (Leave Date)</option>
                    </select>
                </div>

                {{-- 2. User Role --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="report_role">
                        Role Pengguna
                    </label>
                    <select id="report_role" wire:model.live="roleId"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- 3. Status Cuti --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_leave_status">
                        Status Cuti
                    </label>
                    <select id="report_leave_status" wire:model.live="leaveStatus"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="approved">Diterima / Disetujui</option>
                        <option value="rejected">Ditolak</option>
                        <option value="canceled">Dibatalkan</option>
                        <option value="pending_backup">Menunggu Personel Backup</option>
                        <option value="pending_spv">Menunggu Atasan Langsung</option>
                        <option value="pending_hrd">Menunggu HRD Department</option>
                        <option value="pending_management">Menunggu Management</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

        {{-- Pengaju Cuti Multiselect (Autocomplete) --}}
        <div class="relative" x-data="{ open: true }" @click.outside="open = false">
            <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="user_search">
                Filter Pengaju Cuti (Multiselect)
            </label>
            <div class="relative flex items-center">
                <input id="user_search" type="text" wire:model.live="userSearchQuery" @focus="open = true"
                    placeholder="Ketik nama atau kode pegawai untuk menyaring..."
                    class="block w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-10 pr-4 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white" />
                <div class="pointer-events-none absolute left-3 flex items-center text-zinc-400 dark:text-zinc-500">
                    <x-icons.search class="h-5 w-5" />
                </div>
            </div>

            {{-- Autocomplete Dropdown --}}
            @if (!empty($this->userSearchResults))
                <div x-show="open"
                    class="absolute left-0 right-0 z-[150] mt-1 max-h-60 overflow-y-auto rounded-xl border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-800 dark:bg-zinc-900">
                    @foreach ($this->userSearchResults as $u)
                        <button type="button"
                            wire:click="selectUser({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->kode_pegawai }}', {{ $u->is_active ? 'true' : 'false' }})"
                            @click="open = false"
                            class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-zinc-900 transition-colors hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-800">
                            @if ($u->kode_pegawai)
                                <span class="mr-2 font-bold text-blue-600 dark:text-blue-400">#{{ $u->kode_pegawai }}</span>
                            @endif
                            <span>{{ $u->name }}</span>
                            @if (!$u->is_active)
                                <span class="ml-1.5 text-xs font-medium text-red-500 dark:text-red-400">(nonaktif)</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Selected Tags --}}
            @if (!empty($selectedUsers))
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($selectedUsers as $u)
                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:border-blue-800/60 dark:bg-blue-900/30 dark:text-blue-300">
                            <span>
                                @if ($u['kode_pegawai'])
                                    #{{ $u['kode_pegawai'] }} - 
                                @endif
                                {{ $u['name'] }}@if (!($u['is_active'] ?? true))<span class="ml-1 font-medium text-red-500 dark:text-red-400">(nonaktif)</span>@endif
                            </span>
                            <button type="button" wire:click="removeUser({{ $u['id'] }})"
                                class="text-blue-500 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <x-button.success type="submit" wire:loading.attr="disabled" wire:target="export">
                <x-slot name="icon">
                    <x-icons.cloud-upload wire:loading.remove wire:target="export" class="h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="export" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="export">Proses Export</span>
                <span wire:loading wire:target="export">Memproses...</span>
            </x-button.success>
        </div>
    </form>
</div>
