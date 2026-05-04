<div>
    {{-- ==================== RESCHEDULE MODAL ==================== --}}
    <div wire:show="showRescheduleModal" wire:transition.duration.300ms
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/65 p-4 backdrop-blur-sm">
        @if ($showRescheduleModal)
            <div
                class="flex w-full flex-col gap-3 rounded-xl bg-white/60 p-4 shadow-2xl border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:border-zinc-800 md:w-1/2 md:gap-4 md:p-6 lg:w-2/5 xl:w-1/3">

                {{-- Header --}}
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900">
                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Reschedule Tagihan</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Ubah tanggal penagihan untuk
                            <span class="font-medium text-gray-700 dark:text-gray-200">
                                {{ $collectData?->pegawaiRelasi?->full_name ?? 'N/A' }}
                            </span>
                        </p>
                    </div>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-800">

                {{-- Tanggal saat ini --}}
                <div class="rounded-xl bg-gray-50 p-3 dark:bg-gray-800">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal saat ini</p>
                    <p class="mt-0.5 text-sm font-semibold text-gray-800 dark:text-white">
                        {{ $collectData?->assign_date ? \Carbon\Carbon::parse($collectData->assign_date)->locale('id')->isoFormat('D MMMM YYYY') : 'Belum dijadwalkan' }}
                    </p>
                </div>

                {{-- Input tanggal baru --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        for="new_assign_date">
                        Tanggal Baru <span class="text-red-500">*</span>
                    </label>
                    <input
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-800 dark:bg-gray-800 dark:text-white dark:focus:border-blue-400"
                        id="new_assign_date" type="date" wire:model="new_assign_date" />
                    @error('new_assign_date')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-2 pt-1">
                    <x-button.secondary type="button" wire:click="resetModals" id="cancelRescheduleBtn">
                        Batal
                    </x-button.secondary>
                    <x-button.success type="button" wire:click="confirmReschedule" id="confirmRescheduleBtn"
                        wire:loading.attr="disabled" wire:target="confirmReschedule">
                        <x-slot name="icon">
                            <x-icons.check class="h-4 w-4" />
                        </x-slot>
                        <span wire:loading.remove wire:target="confirmReschedule">Simpan Reschedule</span>
                        <span wire:loading wire:target="confirmReschedule">Menyimpan...</span>
                    </x-button.success>
                </div>
            </div>
        @endif
    </div>

    {{-- ==================== CHANGE COLLECTOR MODAL ==================== --}}
    <div wire:show="showChangeCollectorModal" wire:transition.duration.300ms
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/65 backdrop-blur-sm">
        @if ($showChangeCollectorModal)
            <div
                class="flex w-full flex-col gap-3 rounded-xl bg-white/60 p-4 shadow-2xl border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:border-zinc-800 md:w-1/2 md:gap-4 md:p-6 lg:w-2/5 xl:w-1/3">

                {{-- Header --}}
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                        <x-icons.users class="h-5 w-5 text-blue-600 dark:text-blue-300" />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Ganti Kolektor</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Alihkan tagihan ke kolektor lain
                        </p>
                    </div>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-800">

                {{-- Kolektor saat ini --}}
                <div class="rounded-xl bg-gray-50 p-3 dark:bg-gray-800">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Kolektor saat ini</p>
                    <p class="mt-0.5 text-sm font-semibold text-gray-800 dark:text-white">
                        {{ $collectData?->pegawaiRelasi?->full_name ?? 'Tidak ada' }}
                        <span
                            class="ml-1 text-xs font-normal text-gray-500">({{ $collectData?->kode_pegawai ?? '-' }})</span>
                    </p>
                </div>

                {{-- Search kolektor baru --}}
                <div class="relative">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Cari Kolektor Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <x-icons.search class="h-4 w-4 text-gray-400" />
                        </div>
                        <input
                            class="block w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-9 pr-3 text-sm text-gray-900 shadow-sm transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-800 dark:bg-gray-800 dark:text-white dark:focus:border-blue-400"
                            id="search_collector" placeholder="Cari nama atau kode pegawai..." type="text"
                            wire:model.live.debounce.400ms="search_collector" autocomplete="off" />
                    </div>

                    {{-- Dropdown hasil pencarian --}}
                    @if (count($collectors) > 0)
                        <div
                            class="absolute left-0 right-0 top-full z-10 mt-1 max-h-52 overflow-y-auto rounded-xl border border-zinc-200 bg-white shadow-lg dark:border-zinc-800 dark:bg-gray-800">
                            @foreach ($collectors as $collector)
                                <button
                                    class="flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition-colors hover:bg-blue-50 dark:hover:bg-gray-700"
                                    type="button"
                                    wire:click="selectCollector('{{ $collector['kode_pegawai'] }}', '{{ addslashes($collector['full_name']) }}')"
                                    wire:key="collector-{{ $collector['kode_pegawai'] }}">
                                    <div
                                        class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-600 dark:bg-blue-900 dark:text-blue-300">
                                        {{ strtoupper(substr($collector['full_name'], 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            {{ $collector['full_name'] }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $collector['kode_pegawai'] }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @error('new_kode_pegawai')
                        <span class="mt-1 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kolektor terpilih --}}
                @if ($new_kode_pegawai && $selected_collector_name)
                    <div
                        class="flex items-center gap-3 rounded-xl border border-blue-200 bg-blue-50 p-3 dark:border-blue-700 dark:bg-blue-900/30">
                        <div
                            class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-blue-200 text-sm font-bold text-blue-700 dark:bg-blue-800 dark:text-blue-300">
                            {{ strtoupper(substr($selected_collector_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                {{ $selected_collector_name }}</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">{{ $new_kode_pegawai }}</p>
                        </div>
                        <x-icons.check class="ml-auto h-4 w-4 text-blue-500" />
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex justify-end gap-2 pt-1">
                    <x-button.secondary wire:click="resetModals" id="cancelChangeCollectorBtn">
                        Batal
                    </x-button.secondary>

                    <x-button.primary wire:click="confirmChangeCollector" id="confirmChangeCollectorBtn"
                        wire:loading.attr="disabled" wire:target="confirmChangeCollector">
                        <x-slot name="icon">
                            <x-icons.clock class="h-4 w-4" />
                        </x-slot>
                        <span wire:loading.remove wire:target="confirmChangeCollector">Ganti Kolektor</span>
                        <span wire:loading wire:target="confirmChangeCollector">Mengalihkan...</span>
                    </x-button.primary>
                </div>
            </div>
        @endif
    </div>
</div>
