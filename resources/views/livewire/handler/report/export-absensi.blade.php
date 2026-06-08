{{-- Goal: Custom view export laporan absensi, Livewire: Handler\Report\ExportAbsensi, Alpine: Yes --}}
<div
    class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 md:p-6">
    <form wire:submit="export" class="flex flex-col gap-4 md:gap-6">

        {{-- Header Title --}}
        <div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Ekspor Laporan Absensi</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Sesuaikan rentang tanggal, pencarian pegawai, tipe
                absensi, dan parameter tambahan untuk mengekspor data absensi.</p>
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
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Parameter
                Filter Tambahan</p>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- 1. Tipe Absensi --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_attendance_type">
                        Tipe Absensi
                    </label>
                    <select id="report_attendance_type" wire:model.live="attendanceType"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="masuk">Absen Masuk (Check-In)</option>
                        <option value="keluar">Absen Keluar (Check-Out)</option>
                        <option value="semua">Semua (Masuk & Keluar)</option>
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

                {{-- 3. Position Status --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_position_status">
                        Status Lokasi
                    </label>
                    <select id="report_position_status" wire:model.live="positionStatus"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Lokasi</option>
                        <option value="1">Dalam Perjalanan</option>
                        <option value="2">Stand By</option>
                        <option value="3">Onsite</option>
                    </select>
                </div>

                {{-- 4. Verification Status --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_verified_status">
                        Status Verifikasi
                    </label>
                    <select id="report_verified_status" wire:model.live="verifiedStatus"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="1">Terverifikasi</option>
                        <option value="0">Belum Terverifikasi</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

        {{-- Pegawai Multiselect (Autocomplete) --}}
        <div class="relative" x-data="{ open: true }" @click.outside="open = false">
            <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="pegawai_search">
                Filter Pegawai (Multiselect)
            </label>
            <div class="relative flex items-center">
                <input id="pegawai_search" type="text" wire:model.live="pegawaiSearchQuery" @focus="open = true"
                    placeholder="Ketik nama atau kode pegawai untuk menyaring..."
                    class="block w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-10 pr-4 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white" />
                <div class="pointer-events-none absolute left-3 flex items-center text-zinc-400 dark:text-zinc-500">
                    <x-icons.search class="h-5 w-5" />
                </div>
            </div>

            {{-- Autocomplete Dropdown --}}
            @if (!empty($this->pegawaiSearchResults))
                <div x-show="open"
                    class="absolute left-0 right-0 z-[150] mt-1 max-h-60 overflow-y-auto rounded-xl border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-800 dark:bg-zinc-900">
                    @foreach ($this->pegawaiSearchResults as $p)
                        <button type="button"
                            wire:click="selectPegawai({{ $p->kode_pegawai }}, '{{ addslashes($p->full_name) }}', {{ $p->is_active ? 'true' : 'false' }})"
                            @click="open = false"
                            class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-zinc-900 transition-colors hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-800">
                            <span class="mr-2 font-bold text-blue-600 dark:text-blue-400">#{{ $p->kode_pegawai }}</span>
                            <span>{{ $p->full_name }}</span>
                            @if (!$p->is_active)
                                <span class="ml-1.5 text-xs font-medium text-red-500 dark:text-red-400">(nonaktif)</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Selected Tags --}}
            @if (!empty($selectedPegawai))
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($selectedPegawai as $p)
                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:border-blue-800/60 dark:bg-blue-900/30 dark:text-blue-300">
                            <span>#{{ $p['kode_pegawai'] }} - {{ $p['full_name'] }}@if (!($p['is_active'] ?? true))<span class="ml-1 font-medium text-red-500 dark:text-red-400">(nonaktif)</span>@endif</span>
                            <button type="button" wire:click="removePegawai({{ $p['kode_pegawai'] }})"
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
