<div>
    {{-- ==================== RESCHEDULE MODAL ==================== --}}
    <x-modal.base-modal show="showRescheduleModal" title="Reschedule Tagihan" subtitle="Ubah Tanggal Penagihan"
        iconContainerClass="bg-amber-600 shadow-amber-500/20">
        <x-slot name="icon">
            <x-icons.date class="h-5 w-5" />
        </x-slot>

        @if ($showRescheduleModal)
            <div class="flex flex-col gap-6">
                {{-- Info Pegawai --}}
                <div class="flex items-start gap-3 rounded-xl bg-zinc-50 p-4 dark:bg-zinc-800/50">
                    <div class="mt-1 shrink-0">
                        <x-icons.info class="h-5 w-5 text-zinc-400" />
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Pegawai</p>
                        <p class="text-sm font-bold text-zinc-900 dark:text-white">
                            {{ $collectData?->pegawaiRelasi?->full_name ?? 'N/A' }}
                        </p>
                        <div class="mt-2 border-t border-zinc-200 pt-2 dark:border-zinc-700">
                            <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Tanggal Saat Ini
                            </p>
                            <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                                {{ $collectData?->assign_date ? \Carbon\Carbon::parse($collectData->assign_date)->locale('id')->isoFormat('D MMMM YYYY') : 'Belum dijadwalkan' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Input --}}
                <div class="w-full">
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="new_assign_date">
                        Tanggal Baru <span class="text-red-500">*</span>
                    </label>
                    <input
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-amber-500 focus:ring-amber-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white"
                        id="new_assign_date" type="date" wire:model="new_assign_date" />
                    @error('new_assign_date')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endif

        <x-slot name="footer">
            <x-button.secondary @click="open = false">
                Batal
            </x-button.secondary>
            <x-button.success wire:click="confirmReschedule" wire:loading.attr="disabled"
                wire:target="confirmReschedule">
                <x-slot name="icon">
                    <x-icons.check class="h-4 w-4" />
                </x-slot>
                <span wire:loading.remove wire:target="confirmReschedule">Simpan Reschedule</span>
                <span wire:loading wire:target="confirmReschedule">Menyimpan...</span>
            </x-button.success>
        </x-slot>
    </x-modal.base-modal>

    {{-- ==================== CHANGE COLLECTOR MODAL ==================== --}}
    <x-modal.base-modal show="showChangeCollectorModal" title="Ganti Kolektor" subtitle="Alihkan Tagihan Ke Kolektor Lain"
        iconContainerClass="bg-blue-600 shadow-blue-500/20" maxWidth="lg">
        <x-slot name="icon">
            <x-icons.users class="h-5 w-5" />
        </x-slot>

        @if ($showChangeCollectorModal)
            <div class="flex flex-col gap-6">
                {{-- Kolektor saat ini --}}
                <div class="flex items-start gap-3 rounded-xl bg-zinc-50 p-4 dark:bg-zinc-800/50">
                    <div class="mt-1 shrink-0">
                        <x-icons.user class="h-5 w-5 text-zinc-400" />
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Kolektor Saat Ini</p>
                        <p class="text-sm font-bold text-zinc-900 dark:text-white">
                            {{ $collectData?->pegawaiRelasi?->full_name ?? 'Tidak ada' }}
                        </p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $collectData?->kode_pegawai ?? '-' }}
                        </p>
                    </div>
                </div>

                {{-- Search kolektor baru --}}
                <div class="relative">
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white">
                        Cari Kolektor Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center">
                            <x-icons.search class="h-4 w-4 text-zinc-400" />
                        </div>
                        <input
                            class="block w-full rounded-xl border border-zinc-200 bg-white py-2.5 pl-11 pr-4 text-sm font-medium text-zinc-900 transition-all focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white"
                            id="search_collector" placeholder="Cari nama atau kode pegawai..." type="text"
                            wire:model.live.debounce.400ms="search_collector" autocomplete="off" />
                    </div>

                    {{-- Dropdown hasil pencarian --}}
                    @if (count($collectors) > 0)
                        <div
                            class="absolute left-0 right-0 top-full z-10 mt-2 max-h-52 overflow-y-auto rounded-xl border border-zinc-200 bg-white shadow-xl dark:border-zinc-800 dark:bg-zinc-900">
                            @foreach ($collectors as $collector)
                                <button
                                    class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800"
                                    type="button"
                                    wire:click="selectCollector('{{ $collector['kode_pegawai'] }}', '{{ addslashes($collector['full_name']) }}')"
                                    wire:key="collector-{{ $collector['kode_pegawai'] }}">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-xs font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                        {{ strtoupper(substr($collector['full_name'], 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="font-bold text-zinc-900 dark:text-white">
                                            {{ $collector['full_name'] }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $collector['kode_pegawai'] }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @error('new_kode_pegawai')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kolektor terpilih --}}
                @if ($new_kode_pegawai && $selected_collector_name)
                    <div
                        class="flex items-center gap-3 rounded-xl border border-blue-200 bg-blue-50/50 p-4 dark:border-blue-800/50 dark:bg-blue-900/20">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-sm font-bold text-white shadow-lg shadow-blue-500/20">
                            {{ strtoupper(substr($selected_collector_name, 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm font-bold text-blue-900 dark:text-blue-200">
                                {{ $selected_collector_name }}</p>
                            <p class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                {{ $new_kode_pegawai }}</p>
                        </div>
                        <div class="ml-auto flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white">
                            <x-icons.check class="h-3 w-3" />
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <x-slot name="footer">
            <x-button.secondary wire:click="resetModals">
                Batal
            </x-button.secondary>

            <x-button.primary wire:click="confirmChangeCollector" wire:loading.attr="disabled"
                wire:target="confirmChangeCollector">
                <x-slot name="icon">
                    <x-icons.check class="h-4 w-4" />
                </x-slot>
                <span wire:loading.remove wire:target="confirmChangeCollector">Ganti Kolektor</span>
                <span wire:loading wire:target="confirmChangeCollector">Mengalihkan...</span>
            </x-button.primary>
        </x-slot>
    </x-modal.base-modal>
</div>
