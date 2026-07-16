{{-- Goal: Edit PR — fetch new PR + edit/delete existing items, Livewire: App\Livewire\Handler\Spk\EditPurchasingRequest, Alpine: accordion per section --}}
<div class="space-y-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

    {{-- ─── Preview Modal (Nomor Order) ──────────────────────────────────────── --}}
    <x-modal.base-modal show="showOrderPreview" maxWidth="4xl" title="Preview Data PR dari Nomor Order"
        subtitle="Data diambil berdasarkan KeteranganDetail = Nomor Order">
        <x-slot name="icon">
            <x-icons.file-invoice class="h-5 w-5" />
        </x-slot>

        @if (!empty($orderPreviewData))
            <div class="space-y-4">
                <div class="flex items-center justify-between gap-2 border-b border-zinc-200 pb-3 dark:border-zinc-800">
                    <span
                        class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                        {{ count($orderPreviewData) }} item ditemukan
                    </span>
                    <label
                        class="flex cursor-pointer items-center gap-2 text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                        <input type="checkbox" wire:click="toggleSelectAllOrder"
                            class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                            {{ count($selectedOrderItems) === count($orderPreviewData) && count($orderPreviewData) > 0 ? 'checked' : '' }}>
                        Pilih Semua
                    </label>
                </div>

                @php $grouped = collect($orderPreviewData)->groupBy('NomorPermintaanBeli'); @endphp

                @foreach ($grouped as $nomorPr => $items)
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 rounded-lg bg-zinc-50 px-3 py-2 dark:bg-zinc-800/50">
                            <x-icons.file-invoice class="h-4 w-4 shrink-0 text-blue-500" />
                            <span class="font-bold text-zinc-900 dark:text-white">{{ $nomorPr }}</span>
                            <span class="ml-auto text-xs text-zinc-400">{{ count($items) }} item</span>
                        </div>

                        {{-- Desktop Table --}}
                        <div
                            class="hidden overflow-x-auto rounded-lg border border-zinc-200 shadow-sm dark:border-zinc-800 md:block">
                            <table class="w-full min-w-max text-left text-sm text-zinc-500 dark:text-zinc-400">
                                <thead
                                    class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                                    <tr>
                                        <th scope="col" class="w-10 px-3 py-2 text-center">Pilih</th>
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
                                        <tr class="transition-colors hover:bg-zinc-50 dark:bg-transparent dark:hover:bg-zinc-800/50"
                                            x-bind:class="dynamicBg ?
                                                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                                                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                            <td class="px-3 py-2 text-center">
                                                <input type="checkbox" wire:model.live="selectedOrderItems"
                                                    value="{{ $item['original_index'] }}"
                                                    class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800">
                                            </td>
                                            <td class="px-3 py-2 text-center text-xs font-medium text-zinc-500">
                                                {{ $index + 1 }}</td>
                                            <td class="px-3 py-2 text-center">
                                                <span
                                                    class="rounded bg-zinc-100 px-2 py-1 font-mono text-xs text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                    {{ $item['KodeItem'] ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 font-medium text-zinc-900 dark:text-white">
                                                {{ $item['NamaItem'] ?? '-' }}</td>
                                            <td class="px-3 py-2 text-center">
                                                <span
                                                    class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-600 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400">
                                                    {{ $item['JumlahBarang'] ?? '-' }}
                                                    {{ $item['Satuan'] ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $item['RencanaGudangPenerimaan'] ?? '-' }}</td>
                                            <td class="px-3 py-2 text-xs italic text-zinc-500">
                                                {{ $item['KeteranganDetail'] ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Cards --}}
                        <div class="space-y-2 md:hidden">
                            @foreach ($items as $index => $item)
                                <div class="rounded-lg border border-zinc-200 bg-white p-3 shadow-sm dark:border-zinc-800"
                                    x-bind:class="dynamicBg ?
                                        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                                        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                    <div
                                        class="mb-2 flex items-center justify-between border-b border-zinc-100 pb-2 dark:border-zinc-800">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" wire:model.live="selectedOrderItems"
                                                value="{{ $item['original_index'] }}"
                                                class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800">
                                            <span class="text-xs font-bold text-zinc-400">#{{ $index + 1 }}</span>
                                            <span
                                                class="rounded bg-zinc-100 px-2 py-0.5 font-mono text-[10px] font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                {{ $item['KodeItem'] ?? '-' }}
                                            </span>
                                        </div>
                                        <span
                                            class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-600 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ $item['JumlahBarang'] ?? '-' }} {{ $item['Satuan'] ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 gap-2">
                                        <div>
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                Nama Item</p>
                                            <p class="text-sm font-medium text-zinc-900 dark:text-white">
                                                {{ $item['NamaItem'] ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                Gudang Penerima</p>
                                            <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $item['RencanaGudangPenerimaan'] ?? '-' }}</p>
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
            <x-button.secondary id="cancel-order-preview-button" class="w-fit" type="button"
                wire:click="cancelOrderPreview" wire:loading.attr="disabled">
                <x-slot name="icon">
                    <x-icons.close class="icon h-5 w-5" />
                </x-slot>
                Cancel
            </x-button.secondary>

            <x-button.primary id="process-add-order-button" class="w-fit" type="button"
                wire:click="processAddByNomorOrder" wire:loading.attr="disabled" wire:target="processAddByNomorOrder">
                <x-slot name="icon">
                    <x-icons.loading wire:loading wire:target="processAddByNomorOrder" class="h-4 w-4 animate-spin" />
                    <x-icons.plus wire:loading.remove wire:target="processAddByNomorOrder" class="icon h-5 w-5" />
                </x-slot>
                <span wire:loading.remove wire:target="processAddByNomorOrder">Tambahkan ke Daftar</span>
                <span wire:loading wire:target="processAddByNomorOrder">Memproses...</span>
            </x-button.primary>
        </x-slot>
    </x-modal.base-modal>

    {{-- ─── Section 1: Fetch PR Baru ─────────────────────────────────────────── --}}
    <div class="space-y-3">
        <div class="flex items-center gap-2 border-l-4 border-blue-500 pl-3">
            <h3 class="text-base font-bold text-zinc-900 dark:text-white">Tambah PR Baru</h3>
            <span
                class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                Opsional
            </span>
        </div>
        <p class="text-xs text-zinc-500 dark:text-zinc-400">
            Fetch dan tambahkan item PR baru ke SPK ini.
        </p>
    </div>

    {{-- ─── Accordion Container ─────────────────────────────────────────────── --}}
    <div
        class="divide-y divide-zinc-200 overflow-hidden rounded-xl border border-zinc-200 dark:divide-zinc-800 dark:border-zinc-800">

        {{-- ── Panel 1 : Fetch by Nomor PR ───────────────────────────────────── --}}
        <div x-data="{ open: false }">
            {{-- Header --}}
            <button type="button" @click="open = !open"
                class="flex w-full items-center gap-3 bg-zinc-50/80 px-5 py-4 text-left transition-colors hover:bg-zinc-100/80 dark:bg-zinc-800/50 dark:hover:bg-zinc-800">
                <span
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                    <x-icons.search class="h-4 w-4" />
                </span>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">Fetch via Nomor PR</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cari item PR berdasarkan nomor purchasing
                        request dari BSI</p>
                </div>
                <x-icons.chevron-down-filled class="h-4 w-4 shrink-0 text-zinc-400 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            {{-- Body --}}
            <div x-show="open" x-collapse class="space-y-4 p-5"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <div>
                    <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-end">
                        <div class="w-full flex-1">
                            <x-input.basic id="nomor_pr" name="nomor_pr" :labels="true"
                                placeholder="Input nomor purchasing request dari BSI" wire:model.live="nomor_pr">
                                Nomor PR
                            </x-input.basic>
                        </div>

                        <x-button.primary class="w-full sm:w-auto" wire:click="fetchPR" wire:loading.attr="disabled"
                            wire:target="fetchPR">
                            <x-slot name="icon">
                                <x-icons.search wire:loading.remove wire:target="fetchPR" class="h-4 w-4" />
                                <x-icons.loading wire:loading wire:target="fetchPR" class="h-4 w-4 animate-spin" />
                            </x-slot>
                            <span wire:loading.remove wire:target="fetchPR">Fetch Data</span>
                            <span wire:loading wire:target="fetchPR">Mencari...</span>
                        </x-button.primary>
                    </div>

                    @error('nomor_pr')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Preview Table --}}
                <div class="overflow-x-auto rounded-lg border border-zinc-200 shadow-sm dark:border-zinc-800">
                    <table class="w-full text-left text-sm text-zinc-500 dark:text-zinc-400">
                        <thead
                            class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                            <tr>
                                <th scope="col" class="w-10 whitespace-nowrap px-6 py-3 text-center">
                                    <input type="checkbox" wire:click="toggleSelectAllPr"
                                        class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800"
                                        {{ count($selectedPrItems) === count($data) && count($data) > 0 ? 'checked' : '' }}>
                                </th>
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">#</th>
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Kode Item</th>
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Nama Item</th>
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Jlh Brg</th>
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Satuan</th>
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Rencana Gudang
                                    Penerima</th>
                                <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            @forelse ($data as $index => $row)
                                <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        <input type="checkbox" wire:model.live="selectedPrItems"
                                            value="{{ $index }}"
                                            class="h-4 w-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800">
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        <span>{{ $index + 1 }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        <span
                                            class="font-medium text-zinc-900 dark:text-white">{{ $row['KodeItem'] ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="font-medium text-zinc-900 dark:text-white">{{ $row['NamaItem'] ?? '-' }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        <span>{{ $row['JumlahBarang'] ?? '-' }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        <span>{{ $row['Satuan'] ?? '-' }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        <span>{{ $row['RencanaGudangPenerimaan'] ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span>{{ $row['KeteranganDetail'] ?? '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white dark:bg-transparent">
                                    <td colspan="8" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                        Silahkan cari nomor PR terlebih dahulu.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex w-full justify-end gap-2 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                    <x-button.danger id="clear-pr" wire:click="clearPr" type="button">
                        Clear
                    </x-button.danger>
                    <x-button.primary id="add-pr" wire:click="addPr" type="button">
                        Tambah PR
                    </x-button.primary>
                </div>
            </div>
        </div>

        {{-- ── Panel 2 : Fetch by Nomor Order ────────────────────────────────── --}}
        <div x-data="{ open: false }">
            {{-- Header --}}
            <button type="button" @click="open = !open"
                class="flex w-full items-center gap-3 bg-zinc-50/80 px-5 py-4 text-left transition-colors hover:bg-zinc-100/80 dark:bg-zinc-800/50 dark:hover:bg-zinc-800">
                <span
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300">
                    <x-icons.file-invoice class="h-4 w-4" />
                </span>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">Fetch via Nomor Order</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cari semua PR berdasarkan KeteranganDetail =
                        nomor order SPK</p>
                </div>
                <x-icons.chevron-down-filled class="h-4 w-4 shrink-0 text-zinc-400 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            {{-- Body --}}
            <div x-show="open" x-collapse class="space-y-4 p-5"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-end">
                    <div class="w-full flex-1">
                        <x-input.basic id="nomor_order" name="nomor_order" :labels="true"
                            placeholder="Masukkan nomor order SPK" wire:model.live="nomor_order">
                            Nomor Order
                        </x-input.basic>
                    </div>

                    <x-button.primary class="w-full sm:w-auto" wire:click="fetchByNomorOrder"
                        wire:loading.attr="disabled" wire:target="fetchByNomorOrder">
                        <x-slot name="icon">
                            <x-icons.search wire:loading.remove wire:target="fetchByNomorOrder" class="h-4 w-4" />
                            <x-icons.loading wire:loading wire:target="fetchByNomorOrder"
                                class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span wire:loading.remove wire:target="fetchByNomorOrder">Fetch by Order</span>
                        <span wire:loading wire:target="fetchByNomorOrder">Mencari...</span>
                    </x-button.primary>
                </div>

                @error('nomor_order')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- ── Panel 3 : Fetch by Nomor PO ───────────────────────────────────── --}}
        <div x-data="{ open: false }">
            {{-- Header --}}
            <button type="button" @click="open = !open"
                class="flex w-full items-center gap-3 bg-zinc-50/80 px-5 py-4 text-left transition-colors hover:bg-zinc-100/80 dark:bg-zinc-800/50 dark:hover:bg-zinc-800">
                <span
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                    <x-icons.receipt class="h-4 w-4" />
                </span>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-zinc-900 dark:text-white">Fetch via Nomor PO</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cari item PR berdasarkan nomor PO (purchasing
                        order) dari BSI</p>
                </div>
                <x-icons.chevron-down-filled class="h-4 w-4 shrink-0 text-zinc-400 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            {{-- Body --}}
            <div x-show="open" x-collapse class="space-y-4 p-5"
                x-bind:class="dynamicBg ?
                    'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                    'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-end">
                    <div class="w-full flex-1">
                        <x-input.basic id="nomor_po" name="nomor_po" :labels="true"
                            placeholder="Masukkan nomor PO" wire:model.live="nomor_po">
                            Nomor PO
                        </x-input.basic>
                    </div>

                    <x-button.primary class="w-full sm:w-auto" wire:click="fetchByNomorPO"
                        wire:loading.attr="disabled" wire:target="fetchByNomorPO">
                        <x-slot name="icon">
                            <x-icons.search wire:loading.remove wire:target="fetchByNomorPO" class="h-4 w-4" />
                            <x-icons.loading wire:loading wire:target="fetchByNomorPO" class="h-4 w-4 animate-spin" />
                        </x-slot>
                        <span wire:loading.remove wire:target="fetchByNomorPO">Fetch by PO</span>
                        <span wire:loading wire:target="fetchByNomorPO">Mencari...</span>
                    </x-button.primary>
                </div>

                @error('nomor_po')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    {{-- ─── Daftar PR Baru yang Akan di Assign ──────────────────────────────── --}}
    @if (count($data_pr) > 0)
        <section class="flex flex-col gap-4">
            <div class="flex items-center gap-2 border-l-4 border-emerald-500 pl-3">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">
                    Daftar PR Baru yang Akan di Assign
                </h3>
                <span
                    class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                    {{ count($data_pr) }} PR
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @foreach ($data_pr as $index => $row)
                    <div class="flex flex-col gap-3 rounded-lg border border-zinc-200 p-4 shadow dark:border-zinc-800"
                        x-bind:class="dynamicBg ?
                            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        <div class="flex items-center gap-2">
                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200">
                                {{ $index + 1 }}
                            </span>
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                {{ $row['nomor_pr'] }}
                            </span>
                            <span
                                class="ml-auto rounded-full bg-zinc-100 px-2 py-0.5 text-xs text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                {{ count($row['data']) }} item
                            </span>
                        </div>

                        <div class="overflow-x-auto rounded-md border border-zinc-200 dark:border-zinc-800">
                            <table class="w-full text-left text-sm text-zinc-500 dark:text-zinc-400">
                                <thead
                                    class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Kode Item
                                        </th>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Nama Item
                                        </th>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Jlh Brg
                                        </th>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Satuan</th>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Rencana
                                            Gudang Penerima</th>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Keterangan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                    @forelse ($row['data'] as $itemIndex => $itemRow)
                                        <tr
                                            class="bg-white transition-colors hover:bg-zinc-50 dark:bg-transparent dark:hover:bg-zinc-700/50">
                                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                                <span
                                                    class="font-medium text-zinc-900 dark:text-white">{{ $itemRow['KodeItem'] ?? '-' }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="font-medium text-zinc-900 dark:text-white">{{ $itemRow['NamaItem'] ?? '-' }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                                <input type="number" min="0" step="1"
                                                    wire:model.live="data_pr.{{ $index }}.data.{{ $itemIndex }}.JumlahBarang"
                                                    class="w-20 rounded-md border border-zinc-300 bg-white px-2 py-1 text-center text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                                <span>{{ $itemRow['Satuan'] ?? '-' }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                                <span>{{ $itemRow['RencanaGudangPenerimaan'] ?? '-' }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span>{{ $itemRow['KeteranganDetail'] ?? '-' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="bg-white dark:bg-transparent">
                                            <td colspan="6"
                                                class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                                Tidak ada item.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ─── Section 2: Daftar PR yang Sudah di Assign (Editable) ─────────── --}}
    @if (count($existingPrItems) > 0)
        <section class="flex flex-col gap-4">
            <div class="flex items-center gap-2 border-l-4 border-amber-500 pl-3">
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">
                    PR yang Sudah di Assign
                </h3>
                <span
                    class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                    {{ count($existingPrItems) }} item
                </span>
            </div>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                Edit nilai setiap item atau hapus item yang tidak diperlukan.
            </p>

            @php
                $groupedExisting = collect($existingPrItems)->groupBy('nomor_purchasing_request');
            @endphp

            <div class="grid grid-cols-1 gap-4">
                @foreach ($groupedExisting as $nomorPr => $items)
                    <div class="flex flex-col gap-3 rounded-lg border border-zinc-200 p-4 shadow dark:border-zinc-800"
                        x-bind:class="dynamicBg ?
                            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        {{-- PR Group Header --}}
                        <div class="flex items-center gap-2">
                            <x-icons.file-invoice class="h-4 w-4 shrink-0 text-amber-500" />
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                {{ $nomorPr ?? 'N/A' }}
                            </span>
                            <span
                                class="ml-auto rounded-full bg-zinc-100 px-2 py-0.5 text-xs text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                {{ count($items) }} item
                            </span>
                        </div>

                        {{-- Desktop Table --}}
                        <div
                            class="hidden overflow-x-auto rounded-md border border-zinc-200 dark:border-zinc-800 md:block">
                            <table class="w-full min-w-max text-left text-sm text-zinc-500 dark:text-zinc-400">
                                <thead
                                    class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                                    <tr>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">#</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Kode Item
                                        </th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3">Nama Item</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Jlh Brg
                                        </th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Qty</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Satuan</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3">Gudang Penerima</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3">Keterangan</th>
                                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                    @foreach ($items as $itemIndex => $item)
                                        @php
                                            // Cari index dari existingPrItems (flat array) berdasarkan id
                                            $flatIndex = collect($existingPrItems)->search(
                                                fn($i) => $i['id'] === $item['id'],
                                            );
                                        @endphp
                                        <tr wire:key="existing-{{ $item['id'] }}"
                                            class="transition-colors hover:bg-zinc-50 dark:bg-transparent dark:hover:bg-zinc-800/50"
                                            x-bind:class="dynamicBg ?
                                                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                                                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                            <td
                                                class="whitespace-nowrap px-4 py-3 text-center text-xs font-medium text-zinc-500">
                                                {{ $itemIndex + 1 }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                                <span
                                                    class="rounded bg-zinc-100 px-2 py-1 font-mono text-xs text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                    {{ $item['kode_item'] ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.nama_item"
                                                    class="w-full min-w-[150px] rounded-md border border-zinc-300 bg-white px-2 py-1 text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                                <input type="number" min="0" step="1"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.jumlah_item_dipesan"
                                                    class="w-20 rounded-md border border-zinc-300 bg-white px-2 py-1 text-center text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                                <input type="number" min="0" step="1"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.qty"
                                                    class="w-20 rounded-md border border-zinc-300 bg-white px-2 py-1 text-center text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                                <input type="text"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.satuan"
                                                    class="w-20 rounded-md border border-zinc-300 bg-white px-2 py-1 text-center text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.lokasi_gudang_terima"
                                                    class="w-full min-w-[120px] rounded-md border border-zinc-300 bg-white px-2 py-1 text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.keterangan"
                                                    class="w-full min-w-[120px] rounded-md border border-zinc-300 bg-white px-2 py-1 text-sm text-zinc-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 text-center">
                                                <button type="button"
                                                    wire:click="deleteExistingItem('{{ $item['id'] }}')"
                                                    wire:confirm="Anda yakin ingin menghapus item {{ $item['kode_item'] }}?"
                                                    wire:loading.attr="disabled"
                                                    wire:target="deleteExistingItem('{{ $item['id'] }}')"
                                                    class="inline-flex items-center justify-center rounded-md p-1.5 text-red-500 transition-colors hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/20">
                                                    <x-icons.loading wire:loading
                                                        wire:target="deleteExistingItem('{{ $item['id'] }}')"
                                                        class="h-4 w-4 animate-spin" />
                                                    <x-icons.trash wire:loading.remove
                                                        wire:target="deleteExistingItem('{{ $item['id'] }}')"
                                                        class="h-4 w-4" />
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Cards --}}
                        <div class="space-y-3 md:hidden">
                            @foreach ($items as $itemIndex => $item)
                                @php
                                    $flatIndex = collect($existingPrItems)->search(fn($i) => $i['id'] === $item['id']);
                                @endphp
                                <div wire:key="existing-mobile-{{ $item['id'] }}"
                                    class="rounded-lg border border-zinc-200 bg-white p-3 shadow-sm dark:border-zinc-800"
                                    x-bind:class="dynamicBg ?
                                        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                                        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                    <div
                                        class="mb-3 flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-zinc-400">#{{ $itemIndex + 1 }}</span>
                                            <span
                                                class="rounded bg-zinc-100 px-2 py-0.5 font-mono text-[10px] font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                {{ $item['kode_item'] ?? '-' }}
                                            </span>
                                        </div>
                                        <button type="button" wire:click="deleteExistingItem('{{ $item['id'] }}')"
                                            wire:confirm="Anda yakin ingin menghapus item {{ $item['kode_item'] }}?"
                                            class="inline-flex items-center rounded-md p-1 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                                            <x-icons.trash class="h-4 w-4" />
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 gap-3">
                                        <div>
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                Nama Item</p>
                                            <input type="text"
                                                wire:model.blur="existingPrItems.{{ $flatIndex }}.nama_item"
                                                class="mt-1 w-full rounded-md border border-zinc-300 bg-white px-2 py-1 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                        </div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <div>
                                                <p
                                                    class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                    Jlh Brg</p>
                                                <input type="number" min="0"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.jumlah_item_dipesan"
                                                    class="mt-1 w-full rounded-md border border-zinc-300 bg-white px-2 py-1 text-center text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </div>
                                            <div>
                                                <p
                                                    class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                    Qty</p>
                                                <input type="number" min="0"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.qty"
                                                    class="mt-1 w-full rounded-md border border-zinc-300 bg-white px-2 py-1 text-center text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </div>
                                            <div>
                                                <p
                                                    class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                    Satuan</p>
                                                <input type="text"
                                                    wire:model.blur="existingPrItems.{{ $flatIndex }}.satuan"
                                                    class="mt-1 w-full rounded-md border border-zinc-300 bg-white px-2 py-1 text-center text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                Gudang Penerima</p>
                                            <input type="text"
                                                wire:model.blur="existingPrItems.{{ $flatIndex }}.lokasi_gudang_terima"
                                                class="mt-1 w-full rounded-md border border-zinc-300 bg-white px-2 py-1 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                Keterangan</p>
                                            <input type="text"
                                                wire:model.blur="existingPrItems.{{ $flatIndex }}.keterangan"
                                                class="mt-1 w-full rounded-md border border-zinc-300 bg-white px-2 py-1 text-sm text-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @else
        <div
            class="flex flex-col items-center justify-center rounded-xl border border-dashed border-zinc-300 py-12 dark:border-zinc-700">
            <x-icons.file-invoice class="mb-2 h-10 w-10 text-zinc-300 dark:text-zinc-600" />
            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Tidak ada item PR yang sudah di-assign.
            </p>
        </div>
    @endif

    {{-- ─── Footer Action ───────────────────────────────────────────────────── --}}
    <div class="flex w-full flex-row justify-end gap-3 border-t border-zinc-200 pt-4 dark:border-zinc-800">
        <x-button.secondary id="cancel-edit-pr" href="{{ route('purchasing-request.show', $spk_id) }}" wire:navigate>
            <x-slot name="icon">
                <x-icons.close class="icon h-5 w-5" />
            </x-slot>
            Batal
        </x-button.secondary>

        <x-button.primary id="save-changes-pr" wire:click="saveChanges" type="button"
            wire:confirm.prompt="Anda yakin ingin menyimpan perubahan PR? Data PR yang diedit akan diupdate dan PR baru akan ditambahkan.\n\nJika sudah yakin, ketik SIMPAN untuk mengkonfirmasi.|SIMPAN"
            wire:loading.attr="disabled" wire:target="saveChanges">
            <x-slot name="icon">
                <x-icons.loading wire:loading wire:target="saveChanges" class="h-4 w-4 animate-spin" />
                <x-icons.check wire:loading.remove wire:target="saveChanges" class="icon h-5 w-5" />
            </x-slot>
            <span wire:loading.remove wire:target="saveChanges">Simpan Perubahan</span>
            <span wire:loading wire:target="saveChanges">Menyimpan...</span>
        </x-button.primary>
    </div>

</div>
