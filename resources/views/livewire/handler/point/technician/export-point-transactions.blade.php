<div>
    <div class="mt-4 flex items-center justify-end">
        <x-button.primary class="w-fit" wire:click="export">
            <x-slot name="icon">
                <x-icons.bookmark class="icon h-6 w-6" />
            </x-slot>
            Export
        </x-button.primary>
    </div>

    <x-modal.base-modal show="showModal" id="preview-export" title="Preview Data"
        subtitle="Rincian Export Poin" maxWidth="2xl" iconContainerClass="bg-blue-600 shadow-blue-500/20">
        <x-slot name="icon">
            <x-icons.info-circle class="h-5 w-5" />
        </x-slot>

        <div class="flex max-h-96 w-full flex-col gap-4 overflow-y-auto p-1">
            @foreach ($data ?? [] as $row)
                <div class="flex flex-col rounded-xl border border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-zinc-900/50">
                    
                    {{-- Header: Teknisi & Periode --}}
                    <div class="flex flex-col gap-2 border-b border-zinc-200 pb-3 dark:border-zinc-800 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <span class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Nama Teknisi</span>
                            <span class="block font-semibold text-zinc-900 dark:text-white">{{ $row->pegawai->full_name ?? 'Teknisi belum terdaftar' }}</span>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Periode</span>
                            <span class="block text-sm font-medium text-zinc-900 dark:text-zinc-300">
                                {{ Carbon\Carbon::parse($row->from_date)->isoFormat('MMM YYYY') }} -
                                {{ Carbon\Carbon::parse($row->to_date)->isoFormat('MMM YYYY') }}
                            </span>
                        </div>
                    </div>

                    {{-- Body: Rincian Poin --}}
                    <div class="py-3">
                        <span class="mb-2 block text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Rincian Rute & Poin</span>
                        <div class="flex flex-col gap-2 max-h-40 overflow-y-auto pr-1">
                            @foreach ($row->point as $point)
                                <div class="flex items-center justify-between rounded-lg border border-zinc-100 bg-white/60 px-3 py-2 shadow-sm dark:border-zinc-800 dark:bg-zinc-800/60">
                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $point->from_vt }}</span>
                                    <span class="text-sm font-bold text-green-600 dark:text-green-400">+ {{ $point->point }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Footer: Total & Redeemed By --}}
                    <div class="flex items-center justify-between border-t border-zinc-200 pt-3 dark:border-zinc-800">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Redeemed By</span>
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $row->redeemedby->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Total Poin</span>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $row->total_points }} Poin</span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <x-slot name="footer">
            <x-button.danger wire:click="$set('showModal', false)">Batal</x-button.danger>
            <x-button.success wire:click="process" wire:loading.attr="disabled" wire:target="process">
                <x-slot name="icon">
                    <x-icons.bookmark wire:loading.remove wire:target="process" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="process" class="h-4 w-4 animate-spin" />
                </x-slot>
                <span wire:loading.remove wire:target="process">Proses Export</span>
                <span wire:loading wire:target="process">Memproses...</span>
            </x-button.success>
        </x-slot>
    </x-modal.base-modal>
</div>
