{{-- Goal: Modal export data invoice dengan Alpine.js, Livewire: Handler\Invoice\Export, Alpine: show --}}
<div x-data="{ show: @entangle('showModal') }">
    <x-button.success id="export-invoice-button" @click="show = true">
        <x-slot name="icon">
            <x-icons.bookmark class="h-6 w-6 text-green-500 dark:text-white" />
        </x-slot>
        Export Invoice
    </x-button.success>

    {{-- Modal --}}
    {{-- Modal --}}
    <x-modal.base-modal show="showModal" title="Export Data Invoice" subtitle="Unduh Laporan Invoice"
        iconContainerClass="bg-green-600 shadow-green-500/20">
        <x-slot name="icon">
            <x-icons.bookmark class="h-5 w-5" />
        </x-slot>

        <form wire:submit="export">
            <div class="flex flex-col gap-6">
                {{-- Quick Date Select --}}
                <div class="grid grid-cols-2 gap-2">
                    <x-button.primary class="!py-2 text-xs font-bold" wire:click="showDaily"
                        type="button">Harian</x-button.primary>
                    <x-button.primary class="!py-2 text-xs font-bold" wire:click="showWeekly"
                        type="button">Mingguan</x-button.primary>
                    <x-button.primary class="!py-2 text-xs font-bold" wire:click="showMonthly"
                        type="button">Bulanan</x-button.primary>
                    <x-button.primary class="!py-2 text-xs font-bold" wire:click="showYearly"
                        type="button">Tahunan</x-button.primary>
                </div>

                <div class="h-px w-full bg-zinc-200 dark:bg-zinc-800"></div>

                {{-- Manual Date Range --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                            for="invoice_export_from_date">
                            Dari Tanggal
                        </label>
                        <input
                            class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-green-500 focus:ring-green-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white"
                            id="invoice_export_from_date" type="date" wire:model="fromDate" required />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                            for="invoice_export_to_date">
                            Hingga Tanggal
                        </label>
                        <input
                            class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-green-500 focus:ring-green-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white"
                            id="invoice_export_to_date" type="date" wire:model="toDate" required />
                    </div>
                </div>

                {{-- Region Filter --}}
                <div class="w-full">
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="invoice-export-region">
                        Wilayah
                    </label>
                    <select id="invoice-export-region" wire:model="region"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-green-500 focus:ring-green-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        @foreach ($regions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('region')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tipe Tagihan Filter --}}
                <div class="w-full">
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white"
                        for="invoice-export-tipe-tagihan">
                        Tipe Tagihan
                    </label>
                    <select id="invoice-export-tipe-tagihan" wire:model="tipeTagihan"
                        class="block w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-medium text-zinc-900 transition-all focus:border-green-500 focus:ring-green-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                        <option value="all">Semua Tipe</option>
                        <option value="idcppn">IDC PPN</option>
                        <option value="idyppn">IDY PPN</option>
                    </select>
                    @error('tipeTagihan')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t border-zinc-200 bg-zinc-50 -mx-6 -mb-6 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">
                <x-button.secondary @click="open = false" type="button">
                    Batal
                </x-button.secondary>

                <x-button.success type="submit" wire:loading.attr="disabled" wire:target="export">
                    <x-slot name="icon">
                        <x-icons.cloud-upload class="h-4 w-4" />
                    </x-slot>
                    <span wire:loading.remove wire:target="export">Proses Export</span>
                    <span wire:loading wire:target="export">Memproses...</span>
                </x-button.success>
            </div>
        </form>
    </x-modal.base-modal>
</div>
