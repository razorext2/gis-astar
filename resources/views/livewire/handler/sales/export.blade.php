<div>
    <x-button.success id="export-button" wire:click="$set('showModal', true)">
        <x-slot name="icon">
            <x-icons.bookmark class="h-6 w-6 text-green-500 dark:text-white" />
        </x-slot>
        Export Data
    </x-button.success>

    <!-- Modal overlay -->

    <div wire:show="showModal" wire:transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
        @if ($showModal)
            <!-- Modal box -->
            <div
                class="flex max-w-md flex-col gap-2 rounded-xl bg-white p-6 shadow-2xl dark:bg-gray-800 md:w-1/2 xl:w-1/3">
                <h2 class="mb-4 text-center text-2xl font-semibold text-gray-900 dark:text-white lg:text-3xl">
                    Export Data
                </h2>

                <form wire:submit="export">
                    <div class="flex w-full flex-col gap-2 md:gap-4">
                        <div class="flex justify-between gap-2">
                            <x-button.primary wire:click="showDaily">Harian</x-button.primary>
                            <x-button.primary wire:click="showWeekly">Mingguan</x-button.primary>
                            <x-button.primary wire:click="showMonthly">Bulanan</x-button.primary>
                            <x-button.primary wire:click="showYearly">Tahunan</x-button.primary>
                        </div>
                        <div class="grid w-full grid-cols-2 gap-2 md:gap-4">
                            <div>
                                <x-input.basic type="date" id="from_date" wire:model="fromDate" name="from_date">
                                    Dari tanggal
                                </x-input.basic>
                            </div>
                            <div>
                                <x-input.basic type="date" id="to_date" wire:model="toDate" name="to_date">
                                    Hingga tanggal
                                </x-input.basic>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="roles">
                                Pilih data yg mau diekspor
                            </label>
                            @php
                                $roles = [];
                                if (auth()->user()->can('sales-export-all')) {
                                    $roles['All'] = 'Semua';
                                }
                                if (auth()->user()->can('sales-export-medan')) {
                                    $roles['Sales'] = 'Sales Medan';
                                }
                                if (auth()->user()->can('sales-export-jkt')) {
                                    $roles['Sales-JKT'] = 'Sales Jakarta';
                                }
                                if (auth()->user()->can('sales-export-pku')) {
                                    $roles['Sales-PKU'] = 'Sales Pekanbaru';
                                }
                                if (auth()->user()->can('sales-export-idy')) {
                                    $roles['Sales-IDY'] = 'Sales Indodaya';
                                }
                                if (auth()->user()->can('sales-export-kurir-bank')) {
                                    $roles['Kurir-Bank'] = 'Kurir Bank';
                                }
                            @endphp
                            <x-filter.filter-input-select id="roles" wire:model="role" name="roles"
                                :options="$roles" default-option="Filter by roles" />
                        </div>

                        <div>
                            <label for="sales" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Pilih nama sales
                            </label>
                            <select
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                wire:model="sales">
                                <option value="">Semua</option>
                                @foreach ($salesData as $row)
                                    <option value="{{ $row->kode_pegawai }}">({{ $row->kode_pegawai }})
                                        {{ $row->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-2">
                        <x-button.success type="submit">
                            <span wire:loading.remove> Proses </span>
                            <span wire:loading> Proses... </span>
                        </x-button.success>
                        <x-button.primary wire:click="$set('showModal', false)">Batal</x-button.primary>
                    </div>
                </form>

            </div>
        @endif
    </div>
</div>
