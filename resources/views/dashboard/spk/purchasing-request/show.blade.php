@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-2 lg:gap-4 rounded-xl bg-white p-2 shadow-md border-[1px] border-gray-200 dark:bg-dark-primary dark:shadow-none dark:border-gray-700 lg:p-6 w-full ">

        <div class="flex flex-row gap-2 lg:gap-4 items-center">

            <div>
                <x-button.link href="{{ route('purchasing-request.index') }}"
                    class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                    </x-slot>
                    Kembali
                </x-button.link>
            </div>

            <div class="w-full gap-0.5 p-2 lg:p-0 flex flex-col">
                <h3 class="text-lg dark:text-white font-semibold text-gray-800">Purchasing Request
                    {{ $data->nomor_order ?? 'N/A' }}
                </h3>
                <h4 class="uppercase text-sm font-semibold dark:text-white text-gray-800">
                    {{ $data->customer['nama_perusahaan' ?? 'N/A'] }}
                </h4>
                <p class="text-sm dark:text-gray-400 text-gray-600">
                    Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 lg:gap-4" wire:submit.prevent="assign">
            <div class="col-span-2">

            </div>

            {{-- @if(count($data) > 0) --}}
            <div class="col-span-2 relative max-w-full overflow-x-auto rounded-lg">
                <table class="min-w-max text-sm w-full text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 text-center py-3 w-fit">#</th>
                            <th scope="col" class="px-6 text-center py-3 w-[200px]">Kode Item</th>
                            <th scope="col" class="px-6 text-center py-3 w-[300px]">Nama Item</th>
                            <th scope="col" class="px-6 text-center py-3 w-[150px]">Jlh Brg</th>
                            <th scope="col" class="px-6 text-center py-3 ">Rencana Gudang Penerima</th>
                            <th scope="col" class="px-6 text-center py-3 ">Keterangan</th>
                        </tr>
                    </thead>


                    <tbody>
                        @forelse ($data->purchasingRequests as $index => $row)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 text-center ">
                                    <span>{{ $index + 1 ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $row->kode_item ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $row->nama_item ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $row->jumlah_item_dipesan ?? '-' }} {{  $row->satuan ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $row->lokasi_gudang_terima ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $row->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td colspan="6" class="px-6 py-4 text-center">Tidak ada data yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
@endsection
