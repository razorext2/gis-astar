{{-- Goal: Redesign Invoice Detail UI with industrial glassmorphism, Livewire: Handler\Invoice\Show, Alpine: Modal handling --}}
@php
    $deliveryStatus = match ($invoice->status_pengiriman) {
        '0' => ['label' => 'Belum Dikirim', 'class' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300'],
        '1' => [
            'label' => 'Dalam Pengiriman',
            'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        ],
        '2' => [
            'label' => 'Sudah Diterima',
            'class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        ],
        '3' => ['label' => 'Belum Diterima', 'class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'],
        default => [
            'label' => 'Tidak Diketahui',
            'class' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300',
        ],
    };
@endphp

<div class="mb-16 space-y-4">
    {{-- Header Info Card --}}
    <div
        class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none lg:p-6">

        <div class="mb-6 flex flex-col gap-4 sm:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Detail Invoice</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Informasi lengkap rincian dan riwayat invoice</p>
            </div>

            @can('invoice-add')
                <x-button.primary wire:navigate href="{{ route($routePrefix . '.addDetails', $id) }}" class="w-fit">
                    <x-slot name="icon">
                        <x-icons.plus class="h-4 w-4" />
                    </x-slot>
                    Update Detail
                </x-button.primary>
            @endcan
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            {{-- Row 1 --}}
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Nomor BTT</p>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $invoice->nomor_btt }}</p>
                <p class="text-[10px] text-zinc-400">{{ $invoice->tgl_btt }}</p>
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Faktur Pajak
                </p>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $invoice->no_faktur_pajak }}</p>
                <span
                    class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-medium text-green-800 dark:bg-green-900/30 dark:text-green-300">
                    {{ $invoice->tipe_tagihan ?? 'N/A' }}
                </span>
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Nama Customer
                </p>
                <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $invoice->nama_customer }}</p>
            </div>

            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status
                    Pengiriman</p>
                <div>
                    <span
                        class="{{ $deliveryStatus['class'] }} inline-flex items-center rounded-lg px-3 py-1 text-sm font-bold">
                        {{ $deliveryStatus['label'] }}
                    </span>
                </div>
            </div>
        </div>

        <hr class="my-6 border-zinc-200 dark:border-zinc-800">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4">
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Tanggal Invoice
                </p>
                <p class="font-semibold text-zinc-900 dark:text-white">{{ $invoice->tgl_invoice }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">No. Piutang</p>
                <p class="font-semibold text-zinc-900 dark:text-white">{{ $invoice->no_piutang }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">No. Penjualan
                </p>
                <p class="font-semibold text-zinc-900 dark:text-white">{{ $invoice->no_penjualan }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Tipe Invoice
                </p>
                <p class="font-semibold text-zinc-900 dark:text-white">{{ $invoice->tipe_invoice }}</p>
            </div>
        </div>

        <hr class="my-6 border-zinc-200 dark:border-zinc-800">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                    <x-icons.user class="h-5 w-5" />
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Ditambah Oleh</p>
                    <p class="font-semibold text-zinc-900 dark:text-white">{{ $invoice->addedBy->name }}</p>
                    <p class="text-[10px] text-zinc-400">
                        {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                    <x-icons.clock class="h-5 w-5 text-blue-500" />
                </div>
                <div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Update Terakhir</p>
                    <p class="font-semibold text-zinc-900 dark:text-white">{{ $invoice->latestUpdateBy->name }}</p>
                    <p class="text-[10px] text-zinc-400">
                        {{ \Carbon\Carbon::parse($invoice->updated_at)->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="flex flex-col">
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Status Terbaru</p>
                <p class="font-bold text-blue-600 dark:text-blue-400">{{ $invoice->status_terbaru }}</p>
            </div>
        </div>
    </div>

    {{-- History Section --}}
    <div
        class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none lg:p-6">
        <div class="mb-6 flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
            <h3 class="flex items-center gap-2 text-lg font-bold text-zinc-900 dark:text-white">
                <x-icons.clock class="h-5 w-5 text-indigo-500" />
                Riwayat Invoice
            </h3>
            <div class="w-fit">
                <x-input.select id="sort" name="sort" wire:model.live="sort" :defaultOption="'Urutkan'"
                    :options="[
                        'desc' => 'Terbaru',
                        'asc' => 'Terlama',
                    ]" />
            </div>
        </div>

        <div class="space-y-4">
            @forelse ($invoice->details as $detail)
                <div wire:key="detail-{{ $detail->id }}" class="relative flex gap-4">
                    {{-- Timeline Line --}}
                    @if (!$loop->last)
                        <div class="absolute left-6 top-10 h-full w-px bg-zinc-200 dark:bg-zinc-800"></div>
                    @endif

                    <div
                        class="relative z-10 flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <x-icons.check-circle class="h-6 w-6 text-green-500" />
                    </div>

                    <div
                        class="min-w-0 flex-1 rounded-xl border border-zinc-200 bg-white/40 p-4 transition-all hover:bg-white/60 dark:border-zinc-800 dark:bg-zinc-900/40 dark:hover:bg-zinc-900/60">
                        <div class="mb-2 flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                            <p class="text-sm font-bold text-zinc-900 dark:text-white">
                                "{{ $detail->status }}"
                            </p>
                            <div class="flex items-center gap-2 text-xs text-zinc-400">
                                <span>{{ \Carbon\Carbon::parse($detail->created_at)->format('d M Y') }}</span>
                                <span class="h-1 w-1 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                                <span>{{ \Carbon\Carbon::parse($detail->created_at)->format('H:i:s') }}</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            {{-- Shipment info --}}
                            @if (!empty($detail->informasi_pengiriman))
                                <div
                                    class="rounded-lg border border-zinc-100 bg-zinc-50/50 p-3 dark:border-zinc-800 dark:bg-zinc-800/30">
                                    <h4
                                        class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                        <x-icons.truck class="h-3 w-3" />
                                        Informasi Pengiriman
                                    </h4>
                                    <div class="space-y-1 text-sm text-zinc-700 dark:text-zinc-300">
                                        <div class="flex justify-between gap-2">
                                            <span class="shrink-0 text-zinc-400">No. Resi:</span>
                                            <span
                                                class="break-all text-right font-mono font-bold">{{ $detail->informasi_pengiriman['resi'] ?? '-' }}</span>
                                        </div>
                                        <div class="flex justify-between gap-2">
                                            <span class="shrink-0 text-zinc-400">Tujuan:</span>
                                            <span
                                                class="text-right">{{ $detail->informasi_pengiriman['tujuan'] ?? '-' }}</span>
                                        </div>
                                    </div>

                                    @if (!empty($detail->informasi_pengiriman['resi']))
                                        <div class="mt-3 border-t border-zinc-100 pt-2 dark:border-zinc-800">
                                            @livewire('handler.invoice.fetch-resi', ['resi' => $detail->informasi_pengiriman['resi'] ?? '0'], key('resi-' . $detail->id))
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Documentation --}}
                            @if (!empty($detail->documentations))
                                <div
                                    class="rounded-lg border border-zinc-100 bg-zinc-50/50 p-3 dark:border-zinc-800 dark:bg-zinc-800/30">
                                    <h4
                                        class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                        <x-icons.camera class="h-3 w-3" />
                                        Dokumentasi
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($detail->documentations as $documentation)
                                            <img class="h-20 w-20 cursor-pointer rounded-lg object-cover transition-transform hover:scale-105"
                                                id="documentations"
                                                onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                                data-url="{{ asset('storage/' . $documentation['path_file']) }}"
                                                src="{{ asset('storage/' . $documentation['path_file']) }}"
                                                alt="Dokumentasi" loading="lazy">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 flex items-center justify-end text-xs text-zinc-400">
                            <span class="flex items-center gap-1">
                                <x-icons.user class="h-3 w-3" />
                                {{ $detail->addedBy->name }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="mb-4 rounded-full bg-zinc-100 p-4 dark:bg-zinc-800">
                        <x-icons.exclamation-circle class="h-8 w-8 text-zinc-400" />
                    </div>
                    <p class="text-zinc-500 dark:text-zinc-400">Belum ada riwayat perubahan untuk invoice ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
