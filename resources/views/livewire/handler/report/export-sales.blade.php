{{-- Goal: Custom view export Laporan Sales, Livewire: Handler\Report\ExportSales, Alpine: None --}}
<div
    class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 md:p-6">
    <form wire:submit="export" class="flex flex-col gap-4 md:gap-6">

        {{-- Header Title --}}
        <div>
            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Ekspor Laporan Sales</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Sesuaikan rentang tanggal, sales, status validasi, status order customer, dan filter petugas untuk mengekspor data Sales.</p>
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
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                {{-- 1. Sales --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_kode_pegawai">
                        Sales
                    </label>
                    <select id="report_kode_pegawai" wire:model.live="kodePegawai"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Sales</option>
                        @foreach ($users->filter(fn($u) => !empty($u->kode_pegawai)) as $user)
                            <option value="{{ $user->kode_pegawai }}">{{ $user->name }} ({{ $user->kode_pegawai }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- 2. Status Validasi --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_status">
                        Status Validasi
                    </label>
                    <select id="report_status" wire:model.live="status"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="0">Sedang diajukan</option>
                        <option value="1">Disetujui</option>
                        <option value="2">Ditolak</option>
                    </select>
                </div>

                {{-- 3. Customer Melakukan Order --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="report_customer_make_order">
                        Customer Melakukan Order?
                    </label>
                    <select id="report_customer_make_order" wire:model.live="customerMakeOrder"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua</option>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

        {{-- Dynamic Filter (Petugas) --}}
        @if (count($filterOptions) > 0)
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="report_filter_by">
                        Filter Berdasarkan
                    </label>
                    <select id="report_filter_by" wire:model.live="filterBy"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="">Semua (Tanpa Filter Petugas)</option>
                        @foreach ($filterOptions as $key => $option)
                            <option value="{{ $key }}">{{ $option['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($this->filterBy)
                    <div>
                        <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                            for="report_filter_value">
                            Pilih {{ $filterOptions[$this->filterBy]['label'] ?? 'Nilai' }}
                        </label>
                        <select id="report_filter_value" wire:model="filterValue"
                            class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                            <option value="">Pilih...</option>
                            @foreach ($users as $user)
                                @php
                                    $useKode =
                                        ($filterOptions[$this->filterBy]['value_type'] ?? null) === 'kode_pegawai' ||
                                        $this->filterBy === 'kode_pegawai';
                                    $optionValue = $useKode ? $user->kode_pegawai : $user->id;
                                @endphp
                                <option value="{{ $optionValue }}">
                                    {{ $user->name }} {{ $user->kode_pegawai ? "($user->kode_pegawai)" : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        @endif

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
