@extends('dashboard.layoutsDash.app')
{{-- Goal: Show Purchasing Request details for a specific SPK, Livewire: handler.spk.unassign-purchasing-request, Alpine: - --}}
@section('content')
    <div class="relative space-y-4">

        {{-- Header Card --}}
        <div
            class="flex flex-col rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <x-button.danger href="{{ route('purchasing-request.index') }}" class="shrink-0" wire:navigate
                        id="back-button">
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>
                    
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Purchasing Request</h1>
                            <span
                                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ $spk->nomor_order . ($spk->revision_count ? 'R' . str_pad($spk->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                            </span>
                        </div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Customer Quick Info --}}
            <div
                class="mt-4 flex items-center gap-3 rounded-lg border border-zinc-100 bg-zinc-50/50 p-3 shadow dark:border-zinc-800/50 dark:bg-zinc-800/30">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm dark:bg-zinc-800">
                    <x-icons.office-building class="h-5 w-5 text-zinc-400" />
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Pelanggan / Perusahaan</p>
                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                        {{ $spk->customer['nama_perusahaan'] ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Main Content Card --}}
        <div
            class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            @if (!$spk->is_using_old_stock)
                @php
                    $groupedData = $is_multiple 
                        ? $data 
                        : (empty($data) ? [] : [$spk->nomor_purchasing_request ?? '-' => $data]);
                @endphp

                <div class="space-y-6">
                    <div class="mb-3 flex items-center gap-2 border-l-4 border-blue-500 pl-3">
                        <h3 class="text-base font-bold text-zinc-900 dark:text-white">Daftar Item PR</h3>
                        @if ($is_multiple)
                            <span
                                class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30">Multiple
                                PR</span>
                        @endif
                    </div>

                    @forelse ($groupedData as $nomorPr => $rows)
                        <div class="space-y-3">
                            {{-- PR Group Header --}}
                            <div class="flex items-center gap-2 rounded-lg bg-zinc-50 px-3 py-2 dark:bg-zinc-800/50">
                                <x-icons.file-invoice class="h-4 w-4 shrink-0 text-blue-500" />
                                <h4 class="font-bold text-zinc-900 dark:text-white">{{ $nomorPr }}</h4>
                                <span class="ml-auto text-xs text-zinc-400">{{ count($rows) }} item</span>
                            </div>

                            {{-- Desktop Table --}}
                            <div
                                class="hidden overflow-x-auto rounded-xl border border-zinc-200 shadow-sm dark:border-zinc-800 md:block">
                                <table class="w-full min-w-max text-left text-sm text-zinc-500 dark:text-zinc-400">
                                    <thead
                                        class="border-b border-zinc-200 bg-zinc-50 text-xs uppercase text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-center">#</th>
                                            <th scope="col" class="px-4 py-3 text-center">Kode Item</th>
                                            <th scope="col" class="px-4 py-3">Nama Item</th>
                                            <th scope="col" class="px-4 py-3 text-center">Jlh Brg</th>
                                            <th scope="col" class="px-4 py-3">Gudang Penerima</th>
                                            <th scope="col" class="px-4 py-3">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                        @foreach ($rows as $index => $row)
                                            <tr
                                                class="transition-colors hover:bg-zinc-50 dark:bg-transparent dark:hover:bg-zinc-800/50"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                                <td class="px-4 py-3 text-center text-xs font-medium text-zinc-500">
                                                    {{ $index + 1 }}</td>
                                                <td class="px-4 py-3 text-center">
                                                    <span
                                                        class="rounded bg-zinc-100 px-2 py-1 font-mono text-xs text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                        {{ $row->kode_item ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 font-medium text-zinc-900 dark:text-white">
                                                    {{ $row->nama_item ?? '-' }}</td>
                                                <td class="px-4 py-3 text-center">
                                                    <span
                                                        class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-600 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400">
                                                        {{ $row->jumlah_item_dipesan ?? '-' }} {{ $row->satuan ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300">
                                                    {{ $row->lokasi_gudang_terima ?? '-' }}</td>
                                                <td class="px-4 py-3 text-xs italic text-zinc-500">
                                                    {{ $row->keterangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile Cards --}}
                            <div class="space-y-3 md:hidden">
                                @foreach ($rows as $index => $row)
                                    <div
                                        class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                                        <div
                                            class="mb-3 flex items-center justify-between border-b border-zinc-100 pb-3 dark:border-zinc-800">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="text-xs font-bold text-zinc-400">#{{ $index + 1 }}</span>
                                                <span
                                                    class="rounded bg-zinc-100 px-2 py-0.5 font-mono text-[10px] font-bold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                    {{ $row->kode_item ?? '-' }}
                                                </span>
                                            </div>
                                            <span
                                                class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-bold text-blue-600 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900/30 dark:text-blue-400">
                                                {{ $row->jumlah_item_dipesan ?? '-' }} {{ $row->satuan ?? '-' }}
                                            </span>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3">
                                            <div>
                                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                    Nama Item</p>
                                                <p class="text-sm font-medium text-zinc-900 dark:text-white">
                                                    {{ $row->nama_item ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                    Gudang Penerima</p>
                                                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                                    {{ $row->lokasi_gudang_terima ?? '-' }}</p>
                                            </div>
                                            @if (!empty($row->keterangan))
                                                <div>
                                                    <p
                                                        class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">
                                                        Keterangan</p>
                                                    <p class="text-xs italic text-zinc-500 dark:text-zinc-400">
                                                        {{ $row->keterangan }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div
                            class="flex flex-col items-center justify-center rounded-xl border border-dashed border-zinc-300 py-12 dark:border-zinc-700">
                            <x-icons.file-invoice class="mb-2 h-10 w-10 text-zinc-300 dark:text-zinc-600" />
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Tidak ada data PR yang
                                ditemukan.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Action Footer --}}
                @can('purchasing-request-update')
                    @if (!is_null($spk->nomor_purchasing_request) || !is_null($spk->nomor_purchasing_request_json))
                        <div class="flex justify-end pt-6">
                            <livewire:handler.spk.unassign-purchasing-request :id="$spk->id" :nomorOrder="$spk->nomor_order" />
                        </div>
                    @endif
                @endcan
            @else
                {{-- Old Stock Notice --}}
                <div
                    class="flex flex-col items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50/50 py-12 text-center dark:border-emerald-900/30 dark:bg-emerald-900/10">
                    <div
                        class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                        <x-icons.check-circle class="h-10 w-10 text-emerald-500" />
                    </div>
                    <h4 class="text-base font-bold text-emerald-700 dark:text-emerald-400">Menggunakan Stok Gudang</h4>
                    <p class="mt-1 max-w-md text-sm font-medium text-emerald-600 dark:text-emerald-500">
                        SPK ini diproduksi menggunakan barang atau bahan baku sisa stok yang ada di gudang.
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection

