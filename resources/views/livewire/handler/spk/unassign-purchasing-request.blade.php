{{-- Goal: UI for unassign & update PR, Livewire: UnassignPurchasingRequest, Alpine: none --}}
<div class="flex w-full flex-col gap-4">

    {{-- Preview Modal --}}
    <x-modal.base-modal show="showPreview" maxWidth="4xl" title="Preview Data PR dari API"
        subtitle="Data diambil berdasarkan nomor order">
        <x-slot name="icon">
            <x-icons.file-invoice class="h-5 w-5" />
        </x-slot>

        @if (!empty($previewData))
            <div class="space-y-4">
                {{-- Item Count Badge --}}
                <div class="flex items-center gap-2">
                    <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                        {{ count($previewData) }} item ditemukan
                    </span>
                </div>

                {{-- Grouped by NomorPermintaanBeli --}}
                @php
                    $grouped = collect($previewData)->groupBy('NomorPermintaanBeli');
                @endphp

                @foreach ($grouped as $nomorPr => $items)
                    <div class="space-y-2">
                        {{-- PR Group Header --}}
                        <div class="flex items-center gap-2 rounded-lg bg-zinc-50 px-3 py-2 dark:bg-zinc-800/50">
                            <x-icons.file-invoice class="h-4 w-4 shrink-0 text-blue-500" />
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $nomorPr }}</span>
                            <span class="ml-auto text-xs text-zinc-400">{{ count($items) }} item</span>
                        </div>

                        {{-- Desktop Table --}}
                        <div class="hidden overflow-x-auto rounded-lg border border-zinc-200 shadow-sm dark:border-zinc-800 md:block">
                            <table class="w-full min-w-max text-left text-sm text-zinc-500 dark:text-zinc-400">
                                <thead class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                                    <tr>
                                        <th scope="col" class="px-3 py-2 text-center">#</th>
                                        <th scope="col" class="px-3 py-2 text-center">Kode Item</th>
                                        <th scope="col" class="px-3 py-2">Nama Item</th>
                                        <th scope="col" class="px-3 py-2 text-center">Jlh Brg</th>
                                        <th scope="col" class="px-3 py-2">Gudang Penerima</th>
                                        <th scope="col" class="px-3 py-2">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                    @foreach ($items as $index => $item)
                                        <tr class="bg-white/40 transition-colors hover:bg-zinc-50 dark:bg-transparent dark:hover:bg-zinc-800/50">
                                            <td class="px-3 py-2 text-center text-xs font-medium text-zinc-500">{{ $index + 1 }}</td>
                                            <td class="px-3 py-2 text-center">
                                                <span class="rounded bg-zinc-100 px-2 py-1 font-mono text-xs text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                    {{ $item['KodeItem'] ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 font-medium text-zinc-900 dark:text-white">{{ $item['NamaItem'] ?? '-' }}</td>
                                            <td class="px-3 py-2 text-center">
                                                <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-600 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400">
                                                    {{ $item['JumlahBarang'] ?? '-' }} {{ $item['Satuan'] ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300">{{ $item['RencanaGudangPenerimaan'] ?? '-' }}</td>
                                            <td class="px-3 py-2 text-xs italic text-zinc-500">{{ $item['KeteranganDetail'] ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Cards --}}
                        <div class="space-y-2 md:hidden">
                            @foreach ($items as $index => $item)
                                <div class="rounded-lg border border-zinc-200 bg-white p-3 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50">
                                    <div class="mb-2 flex items-center justify-between border-b border-zinc-100 pb-2 dark:border-zinc-800">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-zinc-400">#{{ $index + 1 }}</span>
                                            <span class="rounded bg-zinc-100 px-2 py-0.5 font-mono text-[10px] font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                {{ $item['KodeItem'] ?? '-' }}
                                            </span>
                                        </div>
                                        <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-600 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ $item['JumlahBarang'] ?? '-' }} {{ $item['Satuan'] ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 gap-2">
                                        <div>
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Item</p>
                                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $item['NamaItem'] ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Gudang Penerima</p>
                                            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $item['RencanaGudangPenerimaan'] ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <x-slot name="footer">
            <x-button.secondary id="cancel-preview-button" class="w-fit" type="button" wire:click="cancelPreview"
                wire:loading.attr="disabled">
                <x-slot name="icon">
                    <x-icons.close class="icon h-5 w-5" />
                </x-slot>
                Cancel
            </x-button.secondary>

            <x-button.primary id="process-update-button" class="w-fit" type="button" wire:click="processUpdate"
                wire:loading.attr="disabled" wire:target="processUpdate">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="processUpdate" class="h-4 w-4 animate-spin" />
                    <x-icons.check wire:loading.remove wire:target="processUpdate" class="icon h-5 w-5" />
                </x-slot>

                <span wire:loading.remove wire:target="processUpdate">Proses</span>
                <span wire:loading wire:target="processUpdate">Memproses...</span>
            </x-button.primary>
        </x-slot>
    </x-modal.base-modal>

    {{-- Action Buttons Row --}}
    <div class="flex flex-col justify-between gap-2 lg:flex-row lg:items-center lg:gap-4">
        {{-- update pr berdasarkan no spk --}}
        <div class="space-y-2">
            <p class="text-gray-800 dark:text-white">
                Update PR berdasarkan nomor SPK
            </p>

            <x-button.primary id="update-button" class="w-fit" type="button" wire:click="update"
                wire:loading.attr="disabled" wire:target="update">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="update" class="h-4 w-4 animate-spin" />
                    <x-icons.plus wire:loading.remove wire:target="update" class="icon h-5 w-5" />
                </x-slot>

                <span wire:loading.remove wire:target="update">Update PR</span>
                <span wire:loading wire:target="update">Fetching...</span>
            </x-button.primary>
        </div>

        {{-- unassign PR --}}
        <div class="space-y-2">
            <p class="text-gray-800 dark:text-white">
                Nomor Purchasing Request salah atau bermasalah?
            </p>

            <x-button.danger id="unassign-button" class="w-fit" type="button" wire:click="unassign"
                wire:confirm.prompt="Anda yakin ingin unassign PR untuk SPK ini? PR yang sudah di unassign akan terhapus didatabase.\n\nJika yakin, ketik UNASSIGN untuk mengkonfirmasi.|UNASSIGN"
                wire:loading.attr="disabled" wire:target="unassign">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="unassign" class="h-4 w-4 animate-spin" />
                    <x-icons.trash wire:loading.remove wire:target="unassign" class="icon h-5 w-5" />
                </x-slot>

                <span wire:loading.remove wire:target="unassign">Unassign PR</span>
                <span wire:loading wire:target="unassign">Menghapus...</span>
            </x-button.danger>
        </div>
    </div>
</div>
