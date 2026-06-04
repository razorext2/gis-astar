{{-- Goal: Modal export data sales dengan Alpine.js untuk performa tinggi, Livewire: Handler\Sales\Export, Alpine: show --}}
<div>
    <x-button.success id="export-button" wire:click="$set('showModal', true)">
        <x-slot name="icon">
            <x-icons.bookmark class="h-6 w-6 text-green-500 dark:text-white" />
        </x-slot>
        Export Data
    </x-button.success>

    <x-modal.base-modal show="showModal" title="Export Data Sales"
        subtitle="Download data laporan sales dalam format excel"
        iconContainerClass="bg-emerald-600 shadow-emerald-500/20" maxWidth="md">
        <x-slot name="icon">
            <x-icons.bookmark class="h-5 w-5" />
        </x-slot>

        <form id="form-export-sales" wire:submit="export">
            <div class="flex w-full flex-col gap-5">
                {{-- Quick Date Select --}}
                <div class="grid grid-cols-2 gap-2">
                    <x-button.primary class="!py-1.5 text-xs" wire:click="showDaily" type="button">
                        Harian
                    </x-button.primary>
                    <x-button.primary class="!py-1.5 text-xs" wire:click="showWeekly" type="button">
                        Mingguan
                    </x-button.primary>
                    <x-button.primary class="!py-1.5 text-xs" wire:click="showMonthly" type="button">
                        Bulanan
                    </x-button.primary>
                    <x-button.primary class="!py-1.5 text-xs" wire:click="showYearly" type="button">
                        Tahunan
                    </x-button.primary>
                </div>

                {{-- Manual Date Range --}}
                <div class="grid w-full grid-cols-2 gap-3">
                    <div>
                        <x-input.basic type="date" id="from_date" wire:model="fromDate" name="from_date" required>
                            Dari tanggal
                        </x-input.basic>
                    </div>
                    <div>
                        <x-input.basic type="date" id="to_date" wire:model="toDate" name="to_date" required>
                            Hingga tanggal
                        </x-input.basic>
                    </div>
                </div>

                {{-- Role Filter --}}
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300" for="roles">
                        Wilayah / Divisi
                    </label>
                    <x-filter.filter-input-select id="export-roles" wire:model.live="role" name="export_roles"
                        :options="$roles" default-option="Filter by roles" />
                    @error('role')
                        <span class="mt-1 block text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Specific Sales Filter --}}
                <div class="flex flex-col gap-1">
                    <label for="sales" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Nama Sales (Opsional)
                    </label>
                    <select id="sales"
                        class="block w-full rounded-lg border border-zinc-200 bg-zinc-50 p-2.5 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-white dark:placeholder-zinc-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        wire:model="sales">
                        <option value="">Semua Sales</option>
                        @foreach ($salesData as $row)
                            <option value="{{ $row->kode_pegawai }}">
                                [{{ $row->kode_pegawai }}] {{ $row->name }} {{ !$row->is_active ? '(Nonaktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <x-slot name="footer">
            <x-button.secondary @click="open = false" type="button">
                Batal
            </x-button.secondary>

            <x-button.success type="submit" form="form-export-sales" wire:loading.attr="disabled" wire:target="export">
                <x-slot name="icon">
                    <x-icons.angle-right wire:loading.remove wire:target="export" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="export" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="export">Proses Export</span>
                <span wire:loading wire:target="export">Memproses...</span>
            </x-button.success>
        </x-slot>
    </x-modal.base-modal>
</div>
