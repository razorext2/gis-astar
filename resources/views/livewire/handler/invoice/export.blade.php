{{-- Goal: Modal export data invoice dengan Alpine.js, Livewire: Handler\Invoice\Export, Alpine: show --}}
<div x-data="{ show: @entangle('showModal') }">
    <x-button.success id="export-invoice-button" @click="show = true">
        <x-slot name="icon">
            <x-icons.bookmark class="h-6 w-6 text-green-500 dark:text-white" />
        </x-slot>
        Export Invoice
    </x-button.success>

    <!-- Modal overlay -->
    <div x-show="show" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/65 p-4 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Modal box -->
        <div @click.away="show = false" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="flex w-full max-w-md flex-col gap-2 rounded-xl bg-white p-6 shadow-2xl ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800">

            <div class="mb-4 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white lg:text-2xl">
                    Export Data Invoice
                </h2>
                <button @click="show = false" type="button" class="text-gray-400 transition-colors hover:text-red-500">
                    <x-icons.close class="h-6 w-6" />
                </button>
            </div>

            <form wire:submit="export">
                <div class="flex w-full flex-col gap-4">
                    {{-- Quick Date Select --}}
                    <div class="grid grid-cols-2 gap-2">
                        <x-button.primary class="!py-1.5 text-xs" wire:click="showDaily"
                            type="button">Harian</x-button.primary>
                        <x-button.primary class="!py-1.5 text-xs" wire:click="showWeekly"
                            type="button">Mingguan</x-button.primary>
                        <x-button.primary class="!py-1.5 text-xs" wire:click="showMonthly"
                            type="button">Bulanan</x-button.primary>
                        <x-button.primary class="!py-1.5 text-xs" wire:click="showYearly"
                            type="button">Tahunan</x-button.primary>
                    </div>

                    {{-- Manual Date Range --}}
                    <div class="grid w-full grid-cols-2 gap-3">
                        <div>
                            <x-input.basic type="date" id="invoice_export_from_date" wire:model="fromDate"
                                name="invoice_export_from_date" required>
                                Dari tanggal
                            </x-input.basic>
                        </div>
                        <div>
                            <x-input.basic type="date" id="invoice_export_to_date" wire:model="toDate"
                                name="invoice_export_to_date" required>
                                Hingga tanggal
                            </x-input.basic>
                        </div>
                    </div>

                    {{-- Region Filter --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            for="invoice-export-region">
                            Wilayah
                        </label>
                        <select id="invoice-export-region" wire:model="region"
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            @foreach ($regions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('region')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tipe Tagihan Filter --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            for="invoice-export-tipe-tagihan">
                            Tipe Tagihan
                        </label>
                        <select id="invoice-export-tipe-tagihan" wire:model="tipeTagihan"
                            class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <option value="all">Semua Tipe</option>
                            <option value="idcppn">IDC PPN</option>
                            <option value="idyppn">IDY PPN</option>
                        </select>
                        @error('tipeTagihan')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                    <x-button.danger @click="show = false" type="button">
                        Batal
                    </x-button.danger>

                    <x-button.success type="submit">
                        <span wire:loading.remove wire:target="export">Proses Export</span>
                        <span wire:loading wire:target="export">Memproses...</span>
                    </x-button.success>
                </div>
            </form>
        </div>
    </div>
</div>
