<form class="grid grid-cols-2 gap-2 lg:gap-4" wire:submit.prevent="assign">
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

    {{-- @if (count($data) > 0) --}}
    <div class="relative col-span-2 max-w-full overflow-x-auto rounded-lg">
        <table class="min-w-max text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="w-fit px-6 py-3 text-center">#</th>
                    <th scope="col" class="w-[200px] px-6 py-3 text-center">Kode Item</th>
                    <th scope="col" class="w-[300px] px-6 py-3 text-center">Nama Item</th>
                    <th scope="col" class="w-[150px] px-6 py-3 text-center">Jlh Brg</th>
                    <th scope="col" class="w-[150px] px-6 py-3 text-center">Satuan</th>
                    <th scope="col" class="px-6 py-3 text-center">Rencana Gudang Penerima</th>
                    <th scope="col" class="px-6 py-3 text-center">Keterangan</th>
                </tr>
            </thead>


            <tbody>
                @forelse ($data as $index => $row)
                    <tr
                        class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
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
                        class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                        <td colspan="7" class="px-6 py-4 text-center">Tidak ada data yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="col-span-2 flex w-full flex-row justify-end">
        <x-button.primary id="assign-pr" type="submit">
            Assign PR
        </x-button.primary>
    </div>
    {{-- @endif --}}
</form>
