<div class="mb-16 flex flex-col text-gray-800 dark:text-white">

    <div
        class="relative grid grid-cols-2 rounded-t-xl bg-white p-2 ring-1 ring-gray-200 transition-all duration-500 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 md:p-4 lg:p-6">

        <div class="col-span-2 mb-4 flex w-full flex-row items-center justify-between">
            <div class="w-full">
                <h1 class="text-lg font-semibold"> Detail Invoice </h1>
            </div>

            @can('invoice-add')
                <div class="max-w-xs">
                    <x-button.link wire:navigate class="w-fit ring-1 ring-green-700 dark:bg-green-800 dark:text-white"
                        href="{{ route($routePrefix . '.addDetails', $id) }}">
                        <x-slot name="icon">
                            <x-icons.angle-right class="h-6 w-6 text-green-500 dark:text-white" />
                        </x-slot>
                        Update
                    </x-button.link>
                </div>
            @endcan

        </div>

        <div
            class="col-span-2 rounded-t-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-tr-none">
            <p class="text-xs italic">Nomor BTT </p>
            <p class="font-semibold"> {{ $invoice->nomor_btt }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-tr-xl">
            <p class="text-xs italic">Tanggal BTT Dibuat</p>
            <p class="font-semibold"> {{ $invoice->tgl_btt }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Nomor Faktur Pajak </p>
            <p class="font-semibold"> {{ $invoice->no_faktur_pajak }} <span
                    class="rounded-lg bg-green-500 px-2 py-0.5 text-xs uppercase text-white">
                    {{ $invoice->tipe_tagihan ?? 'Tidak diketahui' }} </span></p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Tanggal Invoice </p>
            <p class="font-semibold"> {{ $invoice->tgl_invoice }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Nomor Piutang </p>
            <p class="font-semibold"> {{ $invoice->no_piutang }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Nomor Penjualan </p>
            <p class="font-semibold"> {{ $invoice->no_penjualan }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Nama Customer </p>
            <p class="font-semibold"> {{ $invoice->nama_customer }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Tipe Invoice </p>
            <p class="font-semibold"> {{ $invoice->tipe_invoice }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Status Pengiriman </p>
            <p class="font-semibold">
                @php
                    $delivery_status = match ($invoice->status_pengiriman) {
                        '0' => 'Belum Dikirim',
                        '1' => 'Sedang Dalam Pengiriman',
                        '2' => 'Sudah Diterima',
                        '3' => 'Belum Diterima',
                        default => 'Tidak Diketahui',
                    };
                @endphp
                {{ $delivery_status }}
            </p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Status Terbaru </p>
            <p class="font-semibold"> {{ $invoice->status_terbaru }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-bl-xl">
            <p class="text-xs italic">Ditambah Oleh </p>
            <p class="font-semibold"> {{ $invoice->addedBy->name }}</p>
            <p class="text-sm">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y h:i:s') }}</p>
        </div>

        <div
            class="col-span-2 rounded-b-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-bl-none">
            <p class="text-xs italic">Terakhir Diupdate Oleh </p>
            <p class="font-semibold"> {{ $invoice->latestUpdateBy->name }}</p>
            <p class="text-sm">{{ \Carbon\Carbon::parse($invoice->updated_at)->format('d M Y h:i:s') }}</p>
        </div>

    </div>

    <div
        class="flex flex-col gap-4 rounded-b-xl bg-white p-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:text-white dark:shadow-none dark:ring-gray-700 lg:p-6">

        <div class="w-fit items-center justify-between self-end">
            <x-input.select id="sort" name="sort" wire:model.live="sort" :defaultOption="'Urutkan'" :options="[
                'desc' => 'Terbaru',
                'asc' => 'Terlama',
            ]" />
        </div>

        @forelse ($invoice->details as $detail)
            <div
                class="flex flex-row gap-2 border-b-[1px] border-gray-200 p-2 transition-all duration-500 ease-in-out hover:scale-[0.99] hover:bg-gray-50 dark:border-gray-700 dark:ring-gray-700 hover:dark:bg-dark-secondary lg:gap-6 lg:p-6">

                <div class="grow-0">
                    <x-icons.check-circle class="h-12 w-12 text-green-500" />
                </div>

                <div class="flex grow flex-col gap-1">
                    <div class="flex w-full flex-col justify-between gap-1 lg:flex-row">
                        <p class="text-xs md:text-sm">
                            <span class="font-semibold">No. Faktur :</span>
                            <span class="text-green-500">{{ $invoice->no_faktur_pajak ?? '-' }}</span>
                        </p>
                        <p class="text-xs md:text-sm">
                            <span class="font-semibold">No. BTT :</span>
                            <span class="text-green-500">{{ $invoice->nomor_btt ?? '-' }}</span>
                        </p>
                    </div>

                    <p class="my-4 text-sm md:text-base">"{{ $detail->status }}"</p>

                    {{-- informasi pengiriman --}}
                    @if (!empty($detail->informasi_pengiriman))
                        <div class="flex flex-col gap-1 border-t-[1px] border-gray-400 pt-2">
                            <h3 class="text-base font-semibold">Informasi Pengiriman: </h3>

                            <p>[Resi] {{ $detail->informasi_pengiriman['resi'] ?? '-' }}</p>
                            <p>[Tujuan] {{ $detail->informasi_pengiriman['tujuan'] ?? '-' }}</p>
                        </div>

                        @livewire('handler.invoice.fetch-resi', ['resi' => $detail->informasi_pengiriman['resi'] ?? '0'])
                    @endif

                    @if (!empty($detail->documentations))
                        <div class="flex flex-col">
                            <h3 class="text-base font-semibold">Dokumentasi: </h3>

                            <div class="relative flex w-full flex-row gap-2 overflow-x-auto py-2">
                                @foreach ($detail->documentations as $documentation)
                                    <img class="h-28 w-28 rounded-xl object-cover" id="documentations"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                        data-url="{{ asset('storage/' . $documentation['path_file']) }}"
                                        src="{{ asset('storage/' . $documentation['path_file']) }}" alt=""
                                        onclick="javascript:void(0)" loading="lazy">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <p class="w-full text-xs lg:text-right lg:text-sm">Oleh: {{ $detail->addedBy->name }}</p>

                </div>

                <div class="flex grow-0 flex-col text-right text-xs md:text-sm xl:text-base">
                    <p>{{ \Carbon\Carbon::parse($detail->created_at)->format('d M Y') }}</p>
                    <p>{{ \Carbon\Carbon::parse($detail->created_at)->format('H:i:s') }}</p>
                </div>

            </div>

        @empty
            <p class="items-center py-4 text-center text-red-500">
                Belum ada riwayat.
            </p>
        @endforelse
    </div>
</div>
