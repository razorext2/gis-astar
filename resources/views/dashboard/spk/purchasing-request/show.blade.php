@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="mb-16 space-y-6 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none lg:p-8">

        {{-- Header Section --}}
        <div class="flex items-center gap-4">
            <x-button.danger href="{{ route('purchasing-request.index') }}" class="max-h-10 max-w-fit" wire:navigate
                id="back-button">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div class="flex w-full flex-col gap-0.5">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Purchasing Request
                    {{ $spk->nomor_order . ($spk->revision_count ? 'R' . str_pad($spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                </h3>
                <h4 class="text-sm font-semibold uppercase text-zinc-600 dark:text-zinc-400">
                    {{ $spk->customer['nama_perusahaan' ?? 'N/A'] }}
                </h4>
                <p class="text-xs text-zinc-500 dark:text-zinc-500">
                    Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
                </p>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="grid w-full gap-6">

            @if (!$spk->is_using_old_stock)
                <div class="space-y-6">
                    @if ($is_multiple)
                        {{-- MULTIPLE PR --}}
                        @forelse ($data as $nomorPr => $rows)
                            <div class="space-y-3">
                                <div class="flex items-center gap-2 px-1">
                                    <x-icons.file-invoice class="h-4 w-4 text-blue-500" />
                                    <h4 class="font-bold text-zinc-900 dark:text-white">{{ $nomorPr }}</h4>
                                </div>

                                <div
                                    class="overflow-x-auto rounded-lg border border-zinc-200 shadow-sm dark:border-zinc-800">
                                    <table class="w-full min-w-max text-left text-sm text-zinc-500 dark:text-zinc-400">
                                        <thead
                                            class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-center">#</th>
                                                <th scope="col" class="px-6 py-3 text-center">Kode Item</th>
                                                <th scope="col" class="px-6 py-3">Nama Item</th>
                                                <th scope="col" class="px-6 py-3 text-center">Jlh Brg</th>
                                                <th scope="col" class="px-6 py-3">Gudang Penerima</th>
                                                <th scope="col" class="px-6 py-3">Keterangan</th>
                                            </tr>
                                        </thead>

                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                            @foreach ($rows as $index => $row)
                                                <tr
                                                    class="bg-white/40 transition-colors hover:bg-zinc-50 dark:bg-transparent dark:hover:bg-zinc-800/50">
                                                    <td class="px-6 py-4 text-center font-medium">{{ $index + 1 }}</td>
                                                    <td class="px-6 py-4 text-center">
                                                        <span
                                                            class="rounded bg-zinc-100 px-2 py-1 font-mono text-xs text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                            {{ $row->kode_item ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">
                                                        {{ $row->nama_item ?? '-' }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-center font-semibold text-blue-600 dark:text-blue-400">
                                                        {{ $row->jumlah_item_dipesan ?? '-' }} {{ $row->satuan ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $row->lokasi_gudang_terima ?? '-' }}
                                                    </td>
                                                    <td class="px-6 py-4 text-xs italic">
                                                        {{ $row->keterangan ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div
                                class="flex flex-col items-center justify-center rounded-lg border border-dashed border-zinc-300 py-12 dark:border-zinc-700">
                                <x-icons.file-invoice class="mb-2 h-10 w-10 text-zinc-300 dark:text-zinc-600" />
                                <p class="text-zinc-500 dark:text-zinc-400">Tidak ada data PR yang ditemukan.</p>
                            </div>
                        @endforelse
                    @else
                        {{-- SINGLE PR --}}
                        <div class="overflow-x-auto rounded-lg border border-zinc-200 shadow-sm dark:border-zinc-800">
                            <table class="w-full min-w-max text-left text-sm text-zinc-500 dark:text-zinc-400">
                                <thead
                                    class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-center">#</th>
                                        <th scope="col" class="px-6 py-3 text-center">Nomor PR</th>
                                        <th scope="col" class="px-6 py-3 text-center">Kode Item</th>
                                        <th scope="col" class="px-6 py-3">Nama Item</th>
                                        <th scope="col" class="px-6 py-3 text-center">Jlh Brg</th>
                                        <th scope="col" class="px-6 py-3">Gudang Penerima</th>
                                        <th scope="col" class="px-6 py-3">Keterangan</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                    @forelse ($data as $index => $row)
                                        <tr
                                            class="bg-white/40 transition-colors hover:bg-zinc-50 dark:bg-transparent dark:hover:bg-zinc-800/50">
                                            <td class="px-6 py-4 text-center font-medium">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-center font-bold text-zinc-900 dark:text-white">
                                                {{ $row->nomor_purchasing_request ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="rounded bg-zinc-100 px-2 py-1 font-mono text-xs text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                    {{ $row->kode_item ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">
                                                {{ $row->nama_item ?? '-' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 text-center font-semibold text-blue-600 dark:text-blue-400">
                                                {{ $row->jumlah_item_dipesan ?? '-' }} {{ $row->satuan ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $row->lokasi_gudang_terima ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-xs italic">
                                                {{ $row->keterangan ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7"
                                                class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                                Tidak ada data Purchasing Request yang ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- Action Footer --}}
                @can('purchasing-request-update')
                    @if (!is_null($spk->nomor_purchasing_request) || !is_null($spk->nomor_purchasing_request_json))
                        <div class="flex justify-end border-t border-zinc-200 pt-6 dark:border-zinc-800">
                            @livewire('handler.spk.unassign-purchasing-request', ['id' => $spk->id])
                        </div>
                    @endif
                @endcan
            @else
                <div
                    class="flex flex-col items-center justify-center rounded-xl bg-green-50/50 py-12 text-center dark:bg-green-900/10">
                    <x-icons.check-circle class="mb-3 h-12 w-12 text-green-500" />
                    <p class="max-w-md text-lg font-medium text-green-700 dark:text-green-400">
                        SPK ini diproduksi menggunakan barang atau bahan baku sisa stok yang ada di gudang.
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection
