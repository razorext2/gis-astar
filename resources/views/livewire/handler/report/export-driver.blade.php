{{-- Goal: Custom view export Laporan Driver, Livewire: Handler\Report\ExportDriver, Alpine: None --}}
<div
    class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 md:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    <form wire:submit="export" class="flex flex-col gap-4 md:gap-6">

        {{-- Header Title --}}
        <div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Ekspor Laporan Driver</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Sesuaikan rentang tanggal, tipe tagihan, tipe kunjungan, driver, status validasi, status pengantaran, dan filter petugas untuk mengekspor data Driver.</p>
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
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- 1. Tipe Tagihan --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_tipe_tagihan">
                        Tipe Tagihan
                    </label>
                    <select id="report_tipe_tagihan" wire:model.live="tipeTagihan"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Tipe Tagihan</option>
                        <option value="idcnon">IDC Non PPN</option>
                        <option value="idcppn">IDC PPN</option>
                        <option value="idyppn">IDY PPN</option>
                    </select>
                </div>

                {{-- 2. Tipe Kunjungan --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_tipe_kunjungan">
                        Tipe Kunjungan
                    </label>
                    <select id="report_tipe_kunjungan" wire:model.live="tipeKunjungan"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Tipe Kunjungan</option>
                        <option value="ATRBRG">Antar Barang (SR)</option>
                        <option value="JPTBRG">Jemput Barang</option>
                        <option value="ATRTEK">Antar Teknisi</option>
                        <option value="JPTTEK">Jemput Teknisi</option>
                        <option value="DLL">Lain - Lain</option>
                    </select>
                </div>

                {{-- 3. Status Validasi --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_status">
                        Status Validasi
                    </label>
                    <select id="report_status" wire:model.live="status"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="0">Sedang Diajukan</option>
                        <option value="1">Disetujui</option>
                        <option value="2">Ditolak</option>
                        <option value="3">Perlu Diperbaiki</option>
                        <option value="4">Belum Di-assign</option>
                        <option value="5">Menunggu Update</option>
                    </select>
                </div>

                {{-- 4. Status Pengantaran --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_status_pengantaran">
                        Status Pengantaran
                    </label>
                    <select id="report_status_pengantaran" wire:model.live="statusPengantaran"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="1">Belum Diterima</option>
                        <option value="2">Sudah Diterima</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

        {{-- Driver Multiselect (Autocomplete) --}}
        <div class="relative" x-data="{ open: true }" @click.outside="open = false">
            <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="driver_search">
                Filter Driver (Multiselect)
            </label>
            <div class="relative flex items-center">
                <input id="driver_search" type="text" wire:model.live="driverSearchQuery" @focus="open = true"
                    placeholder="Ketik nama atau kode driver untuk menyaring..."
                    class="block w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-10 pr-4 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white" />
                <div class="pointer-events-none absolute left-3 flex items-center text-zinc-400 dark:text-zinc-500">
                    <x-icons.search class="h-5 w-5" />
                </div>
            </div>

            {{-- Autocomplete Dropdown --}}
            @if (!empty($this->driverSearchResults))
                <div x-show="open"
                    class="absolute left-0 right-0 z-[150] mt-1 max-h-60 overflow-y-auto rounded-xl border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-800 dark:bg-zinc-900">
                    @foreach ($this->driverSearchResults as $d)
                        <button type="button"
                            wire:click="selectDriver('{{ $d->kode_pegawai }}', '{{ addslashes($d->name) }}', {{ $d->is_active ? 'true' : 'false' }})"
                            @click="open = false"
                            class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-zinc-900 transition-colors hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-800">
                            <span class="mr-2 font-bold text-blue-600 dark:text-blue-400">#{{ $d->kode_pegawai }}</span>
                            <span>{{ $d->name }}</span>
                            @if (!$d->is_active)
                                <span class="ml-1.5 text-xs font-medium text-red-500 dark:text-red-400">(nonaktif)</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Selected Tags --}}
            @if (!empty($selectedDrivers))
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($selectedDrivers as $d)
                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:border-blue-800/60 dark:bg-blue-900/30 dark:text-blue-300">
                        <span>#{{ $d['kode_pegawai'] }} - {{ $d['name'] }}@if (!($d['is_active'] ?? true))<span class="ml-1 font-medium text-red-500 dark:text-red-400">(nonaktif)</span>@endif</span>
                            <button type="button" wire:click="removeDriver('{{ $d['kode_pegawai'] }}')"
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

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

        {{-- Assigner Multiselect (Autocomplete) --}}
        <div class="relative" x-data="{ open: true }" @click.outside="open = false">
            <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="assigner_search">
                Filter Di-assign Oleh (Multiselect)
            </label>
            <div class="relative flex items-center">
                <input id="assigner_search" type="text" wire:model.live="assignerSearchQuery" @focus="open = true"
                    placeholder="Ketik nama atau kode petugas untuk menyaring..."
                    class="block w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-10 pr-4 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white" />
                <div class="pointer-events-none absolute left-3 flex items-center text-zinc-400 dark:text-zinc-500">
                    <x-icons.search class="h-5 w-5" />
                </div>
            </div>

            {{-- Autocomplete Dropdown --}}
            @if (!empty($this->assignerSearchResults))
                <div x-show="open"
                    class="absolute left-0 right-0 z-[150] mt-1 max-h-60 overflow-y-auto rounded-xl border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-800 dark:bg-zinc-900">
                    @foreach ($this->assignerSearchResults as $a)
                        <button type="button"
                            wire:click="selectAssigner({{ $a->id }}, '{{ addslashes($a->name) }}', {{ $a->is_active ? 'true' : 'false' }})"
                            @click="open = false"
                            class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-zinc-900 transition-colors hover:bg-zinc-100 dark:text-white dark:hover:bg-zinc-800">
                            @if($a->kode_pegawai)
                                <span class="mr-2 font-bold text-blue-600 dark:text-blue-400">#{{ $a->kode_pegawai }}</span>
                            @endif
                            <span>{{ $a->name }}</span>
                            @if (!$a->is_active)
                                <span class="ml-1.5 text-xs font-medium text-red-500 dark:text-red-400">(nonaktif)</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Selected Tags --}}
            @if (!empty($selectedAssigners))
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($selectedAssigners as $a)
                        <span
                            class="inline-flex items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:border-blue-800/60 dark:bg-blue-900/30 dark:text-blue-300">
                            <span>{{ $a['name'] }}@if (!($a['is_active'] ?? true))<span class="ml-1 font-medium text-red-500 dark:text-red-400">(nonaktif)</span>@endif</span>
                            <button type="button" wire:click="removeAssigner({{ $a['id'] }})"
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

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

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

