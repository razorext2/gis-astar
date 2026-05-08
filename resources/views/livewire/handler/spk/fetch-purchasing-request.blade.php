<div
    class="space-y-4 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/50 dark:shadow-none lg:p-6">

    <div>
        <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-end">
            <div class="w-full flex-1">
                <x-input.basic id="nomor_pr" name="nomor_pr" :labels="true"
                    placeholder="Input nomor purchasing request dari BSI" wire:model.live="nomor_pr">
                    Nomor PR
                </x-input.basic>
            </div>

            <x-button.primary class="w-full sm:w-auto" wire:click="fetchPR">
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

    <div
        class="flex flex-col gap-4 rounded-lg border border-zinc-200 bg-white/60 p-4 shadow backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-800/50 lg:p-6">

        <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">
            Preview Item PR
        </h3>

        <div class="overflow-x-auto rounded-lg border border-zinc-200 shadow-sm dark:border-zinc-800">
            <table class="w-full text-left text-sm text-zinc-500 dark:text-zinc-400">
                <thead
                    class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                    <tr>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">#</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Kode Item</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Nama Item</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Jlh Brg</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Satuan</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Rencana Gudang Penerima</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($data as $index => $row)
                        <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span>{{ $index + 1 ?? '-' }}</span>
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
                            <td colspan="7" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
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

    @if (count($data_pr) > 0)
        <section class="flex flex-col gap-4">
            <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">
                Daftar PR yang akan di Assign
            </h3>

            <div class="grid grid-cols-1 gap-4">
                @foreach ($data_pr as $index => $row)
                    <div
                        class="flex flex-col gap-3 rounded-lg border border-zinc-200 bg-white/60 p-4 shadow backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-800/50">
                        <div class="flex items-center gap-2">
                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700 dark:bg-blue-900 dark:text-blue-200">
                                {{ $index + 1 }}
                            </span>
                            <span class="font-semibold text-zinc-900 dark:text-white">
                                {{ $row['nomor_pr'] }}
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
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Jlh Brg</th>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Satuan</th>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Rencana
                                            Gudang Penerima</th>
                                        <th scope="col" class="whitespace-nowrap px-6 py-3 text-center">Keterangan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                    @forelse ($row['data'] as $index => $itemRow)
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
                                                <span>{{ $itemRow['JumlahBarang'] ?? '-' }}</span>
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
                                                Silahkan cari nomor PR terlebih dahulu.
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

    <div class="flex w-full flex-row justify-end border-t border-zinc-200 pt-4 dark:border-zinc-800">
        <x-button.success id="assign-pr" wire:click="assign" type="button"
            wire:confirm.prompt="Anda yakin ingin assign PR untuk SPK ini? Periksa item yang akan di assign.\n\nJika sudah yakin, ketik ASSIGN untuk mengkonfirmasi.|ASSIGN">
            <x-slot name="icon">
                <x-icons.loading wire:loading wire:target="assign" class="h-4 w-4 animate-spin" />
                <x-icons.angle-right wire:loading.remove wire:target="assign" class="icon h-5 w-5" />
            </x-slot>

            <span wire:loading.remove wire:target="assign">Assign PR</span>
            <span wire:loading wire:target="assign">Menyimpan...</span>
        </x-button.success>
    </div>

</div>
