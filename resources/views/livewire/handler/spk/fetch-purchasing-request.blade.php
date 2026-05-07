<div class="grid grid-cols-2 gap-2 lg:gap-4">
    <div class="col-span-2">
        <div class="flex w-full flex-row items-center gap-2">
            <div class="w-full">
                <x-input.basic id="nomor_pr" name="nomor_pr" :labels="true"
                    placeholder="Input nomor purchasing request dari BSI" wire:model.live="nomor_pr">
                    Nomor PR
                </x-input.basic>
            </div>

            <x-button.primary class="self-end" wire:click="fetchPR">
                Fetch
            </x-button.primary>
        </div>

        @error('nomor_pr')
            <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div
        class="relative col-span-2 flex grid-cols-1 flex-col gap-2 rounded-lg border border-zinc-200 p-2 dark:border-zinc-800 lg:gap-4 lg:p-4">

        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="w-fit px-6 py-3 text-center">#</th>
                    <th scope="col" class="w-fit px-6 py-3 text-center">Kode Item</th>
                    <th scope="col" class="w-fit px-6 py-3 text-center">Nama Item</th>
                    <th scope="col" class="w-fit px-6 py-3 text-center">Jlh Brg</th>
                    <th scope="col" class="w-fit px-6 py-3 text-center">Satuan</th>
                    <th scope="col" class="w-fit px-6 py-3 text-center">Rencana Gudang Penerima</th>
                    <th scope="col" class="w-fit px-6 py-3 text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $row)
                    <tr
                        class="border-b border-zinc-200 bg-white/60 hover:bg-gray-50 dark:border-zinc-800 dark:bg-gray-800 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-center">
                            <span>{{ $index + 1 ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <x-input.basic id="nomor_item" name="nomor_item" value="{{ $row['KodeItem'] ?? '-' }}"
                                readonly :labels="false" />
                        </td>
                        <td class="px-6 py-4">
                            <x-input.basic id="nama_item" name="nama_item" value="{{ $row['NamaItem'] ?? '-' }}"
                                readonly :labels="false" />
                        </td>
                        <td class="px-6 py-4 text-center">
                            <x-input.basic id="jumlah_brg" name="jumlah_brg" value="{{ $row['JumlahBarang'] ?? '-' }}"
                                readonly :labels="false" />
                        </td>
                        <td class="px-6 py-4 text-center">
                            <x-input.basic id="satuan" name="satuan" value="{{ $row['Satuan'] ?? '-' }}" readonly
                                :labels="false" />
                        </td>
                        <td class="px-6 py-4 text-center">
                            <x-input.basic id="gudang" name="gudang"
                                value="{{ $row['RencanaGudangPenerimaan'] ?? '-' }}" readonly :labels="false" />
                        </td>
                        <td class="px-6 py-4">
                            <x-input.basic id="keterangan" name="keterangan"
                                value="{{ $row['KeteranganDetail'] ?? '-' }}" readonly :labels="false" />
                        </td>
                    </tr>
                @empty
                    <tr
                        class="border-b border-zinc-200 bg-white/60 hover:bg-gray-50 dark:border-zinc-800 dark:bg-gray-800 dark:hover:bg-gray-600">
                        <td colspan="7" class="px-6 py-4 text-center"> Silahkan cari nomor PR terlebih dahulu.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        <section class="grid w-full grid-cols-1 gap-2 lg:gap-4">
            <div class="flex w-full justify-end gap-x-2">
                <x-button.danger id="clear-pr" wire:click="clearPr" type="button">
                    Clear
                </x-button.danger>
                <x-button.primary id="add-pr" wire:click="addPr" type="button">
                    Tambah PR
                </x-button.primary>
            </div>

            @foreach ($data_pr as $index => $row)
                <div class="rounded-lg p-2 dark:bg-gray-600 lg:p-4">
                    <p class="mb-2 text-gray-800 dark:text-white">
                        <span class="me-2">{{ $index + 1 }}.</span> <span
                            class="font-semibold">{{ $row['nomor_pr'] }}</span>
                    </p>

                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="w-fit px-6 py-3 text-center">Kode Item</th>
                                <th scope="col" class="w-fit px-6 py-3 text-center">Nama Item</th>
                                <th scope="col" class="w-fit px-6 py-3 text-center">Jlh Brg</th>
                                <th scope="col" class="w-fit px-6 py-3 text-center">Satuan</th>
                                <th scope="col" class="w-fit px-6 py-3 text-center">Rencana Gudang Penerima</th>
                                <th scope="col" class="w-fit px-6 py-3 text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($row['data'] as $index => $row)
                                <tr
                                    class="border-b border-zinc-200 bg-white/60 hover:bg-gray-50 dark:border-zinc-800 dark:bg-gray-800 dark:hover:bg-gray-600">
                                    <td class="text-center">
                                        <p>{{ $row['KodeItem'] ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p>{{ $row['NamaItem'] ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ $row['JumlahBarang'] ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ $row['Satuan'] ?? '-' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ $row['RencanaGudangPenerimaan'] ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p>{{ $row['KeteranganDetail'] ?? '-' }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr
                                    class="border-b border-zinc-200 bg-white/60 hover:bg-gray-50 dark:border-zinc-800 dark:bg-gray-800 dark:hover:bg-gray-600">
                                    <td colspan="6" class="px-6 py-4 text-center"> Silahkan cari nomor PR
                                        terlebih dahulu.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            @endforeach
        </section>
    </div>

    <div class="col-span-2 flex w-full flex-row justify-end">
        <x-button.success id="assign-pr" wire:click="assign" type="button"
            wire:confirm.prompt="Anda yakin ingin assign PR untuk SPK ini? Periksa item yang akan di assign.\n\nJika sudah yakin, ketik ASSIGN untuk mengkonfirmasi.|ASSIGN">
            Assign PR
        </x-button.success>
    </div>
</div>
