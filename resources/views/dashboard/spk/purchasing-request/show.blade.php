@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-2 rounded-xl border-[1px] border-gray-200 bg-white p-2 shadow-md dark:border-gray-700 dark:bg-dark-primary dark:shadow-none lg:gap-4 lg:p-6">

        <div class="flex flex-row items-center gap-2 lg:gap-4">

            <div>
                <x-button.link href="{{ route('purchasing-request.index') }}"
                    class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white" wire:navigate id="back-button">
                    <x-slot name="icon">
                        <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                    </x-slot>
                    Kembali
                </x-button.link>
            </div>

            <div class="flex w-full flex-col gap-0.5 p-2 lg:p-0">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Purchasing Request
                    {{ $spk->nomor_order . ($spk->revision_count ? 'R' . str_pad($spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                </h3>
                <h4 class="text-sm font-semibold uppercase text-gray-800 dark:text-white">
                    {{ $spk->customer['nama_perusahaan' ?? 'N/A'] }}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
                </p>
            </div>
        </div>

        <div class="grid w-full gap-2 lg:gap-4">

            {{-- @if (count($data) > 0) --}}
            <div class="relative overflow-x-auto rounded-lg">

                @if ($is_multiple)
                    {{-- KALO NOMOR PR MULTIPLE --}}
                    @forelse ($data as $nomorPr => $rows)
                        <h4 class="mb-2 text-gray-800 dark:text-white">{{ $nomorPr }}</h4>
                        <table class="mb-2 w-full min-w-max text-left text-sm text-gray-500 dark:text-gray-400 lg:mb-4">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="w-fit px-6 py-3 text-center">#</th>
                                    <th scope="col" class="w-[200px] px-6 py-3 text-center">Kode Item</th>
                                    <th scope="col" class="w-[300px] px-6 py-3 text-center">Nama Item</th>
                                    <th scope="col" class="w-[150px] px-6 py-3 text-center">Jlh Brg</th>
                                    <th scope="col" class="px-6 py-3 text-center">Rencana Gudang Penerima</th>
                                    <th scope="col" class="px-6 py-3 text-center">Keterangan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($rows as $index => $row)
                                    <tr
                                        class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 text-center">
                                            <span>{{ $index + 1 ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $row->kode_item ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $row->nama_item ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $row->jumlah_item_dipesan ?? '-' }} {{ $row->satuan ?? '-' }}
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
                                        class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                        <td colspan="6" class="px-6 py-4 text-center">Tidak ada data yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @empty
                        <p
                            class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                            <span class="px-6 py-4 text-center">Tidak ada data yang ditemukan.</span>
                        </p>
                    @endforelse
                @else
                    {{-- KALO NOMOR PR SINGLE --}}
                    <table class="w-full min-w-max text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="w-fit px-6 py-3 text-center">#</th>
                                <th scope="col" class="w-[200px] px-6 py-3 text-center">Kode Item</th>
                                <th scope="col" class="w-[200px] px-6 py-3 text-center">Nomor Purchasing Request</th>
                                <th scope="col" class="w-[300px] px-6 py-3 text-center">Nama Item</th>
                                <th scope="col" class="w-[150px] px-6 py-3 text-center">Jlh Brg</th>
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
                                        {{ $row->nomor_purchasing_request ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $row->kode_item ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $row->nama_item ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $row->jumlah_item_dipesan ?? '-' }} {{ $row->satuan ?? '-' }}
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
                                    class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                    <td colspan="7" class="px-6 py-4 text-center">Tidak ada data yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif

            </div>

            @can('purchasing-request-update')
                @if (!is_null($spk->nomor_purchasing_request) || !is_null($spk->nomor_purchasing_request_json))
                    @livewire('handler.spk.unassign-purchasing-request', ['id' => $spk->id])
                @endif
            @endcan

        </div>
    </div>
@endsection
