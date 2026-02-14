{{-- riwayat pengiriman --}}
<div id="delivery-history-section" class="flex w-full flex-col gap-2 lg:gap-4">
    <div id="delivery-history-header">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white lg:text-lg">
            Riwayat Pengiriman
        </h3>

        <p class="text-base text-gray-600 dark:text-gray-400">
            Berikut ini adalah riwayat pengiriman SPK ini:
        </p>
    </div>

    <div id="delivery-history-content" class="grid w-full gap-2 lg:grid-cols-2 lg:gap-4">
        @forelse ($deliveries as $row)
            <div class="w-full">
                <div
                    class="mb-2 rounded-lg border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 sm:space-y-2 lg:mb-4">

                    <div class="flex items-center gap-x-2">
                        <span class="rounded bg-gray-400 px-2 py-0.5 text-xs font-semibold text-gray-800">
                            {{ $row->kode_kirim ?? 'N/A' }}
                        </span>

                        <span
                            class="{{ $this->generateViaColor($row->via)['color'] }} rounded px-2 py-0.5 text-xs font-semibold">
                            {{ $this->generateViaColor($row->via)['label'] }}
                        </span>

                        <span
                            class="{{ $this->generateStatusColor($row->status_kirim)['color'] }} rounded px-2 py-0.5 text-xs font-semibold">
                            {{ $this->generateStatusColor($row->status_kirim)['label'] }}
                        </span>
                    </div>

                    <dl class="items-center justify-between gap-4 sm:flex">
                        <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Tanggal</dt>
                        <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                            {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                        </dd>
                    </dl>

                    @if ($row['via'] === 'laut')
                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Partay</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ ucfirst($row->partay ?? 'N/A') }}
                            </dd>
                        </dl>

                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">No. Container</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ strtoupper($row->no_container ?? 'N/A') }}
                            </dd>
                        </dl>

                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Nama Kapal</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ ucfirst($row->nama_kapal ?? 'N/A') }}
                            </dd>
                        </dl>
                    @else
                        @if ($row->voa === 'supir')
                            <dl class="items-center justify-between gap-4 sm:flex">
                                <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Nomor SR</dt>
                                <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                    {{ ucfirst($row->nomor_sr ?? 'N/A') }}
                                </dd>
                            </dl>

                            <dl class="items-center justify-between gap-4 sm:flex">
                                <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Kode Jari Supir
                                </dt>
                                <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                    {{ ucfirst($row->id_supir ?? 'N/A') }}
                                </dd>
                            </dl>
                        @endif

                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Nama Supir</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ ucfirst($row->nama_supir ?? 'N/A') }}
                            </dd>
                        </dl>

                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">No. Telp Supir</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ ucfirst($row->no_telp_supir ?? 'N/A') }}
                            </dd>
                        </dl>

                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">No. Plat Kendaraan
                            </dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ strtoupper($row->no_plat ?? 'N/A') }}
                            </dd>
                        </dl>
                    @endif

                    <dl class="items-center justify-between gap-4 sm:flex">
                        <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Estimasi Berat Barang</dt>
                        <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                            {{ strtoupper($row->berat ?? 'N/A') }}
                        </dd>
                    </dl>

                    <dl class="items-center justify-between gap-4 sm:flex">
                        <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Estimasi Waktu Kirim</dt>
                        <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                            {{ Carbon\Carbon::parse($row->etd)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </dd>
                    </dl>

                    <dl class="items-center justify-between gap-4 sm:flex">
                        <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Estimasi Waktu Tiba</dt>
                        <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                            {{ Carbon\Carbon::parse($row->eta)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </dd>
                    </dl>

                    <dl class="items-center justify-between gap-4 sm:flex">
                        <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Catatan</dt>
                        <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                            {{ ucfirst($row->note ?? 'N/A') }}
                        </dd>
                    </dl>

                    @if ($row->via != 'supir')
                        <div class="flex w-fit flex-col gap-1">
                            <p class="text-center font-semibold text-gray-800 dark:text-white">
                                Barang yang dibawa
                            </p>
                            <ul class="text-gray-600 dark:text-white">
                                @foreach ($row->product_details as $key => $barang)
                                    <li class="flex gap-x-2">
                                        <span>{{ $key + 1 }}. </span>
                                        <span>
                                            {{ $barang['nama_barang'] ?? '-' }}
                                            ({{ $barang['qty_barang'] ?? 0 }}
                                            {{ $barang['satuan_barang'] ?? '' }})
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-2 flex items-center justify-end space-x-2 lg:space-x-4">
                        <button type="button" wire:click="detailModal({{ $row->id }})"
                            class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Cek Riwayat Pengiriman
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <p class="col-span-2 text-center text-sm italic text-red-500">Belum ada riwayat pengiriman.</p>
        @endforelse
    </div>

    {{ $deliveries->links(data: ['scrollTo' => '#delivery-history-section']) }}

    <div id="laporan-fondasi-modal" wire:show="showDetailModal" wire:transition.duration.300ms
        class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-70 py-8">
        @if ($showDetailModal)
            <div class="relative mx-4 my-6 flex w-full flex-col gap-1 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary md:w-2/3 md:gap-2 lg:w-1/2 xl:w-2/5"
                style="max-height: calc(100vh - 6rem);">

                <button class="absolute right-2 top-2" type="button" wire:click="$set('showDetailModal', false)">
                    <x-icons.close class="h-6 w-6 text-red-600 hover:text-red-800" />
                </button>

                <h2
                    class="mb-2 flex items-center gap-x-2 text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                    Riwayat Pengiriman <span
                        class="rounded bg-gray-400 px-2 py-0.5 text-xs font-semibold text-gray-800">
                        {{ $row->kode_kirim ?? 'N/A' }}
                    </span>
                </h2>

                @forelse($modalData->history as $row)
                    <div
                        class="mb-2 rounded-lg border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 sm:space-y-2 lg:mb-4">

                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">ID Riwayat</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ $row['id'] }}
                            </dd>
                        </dl>
                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Status Pengiriman</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ $row['status'] }}
                            </dd>
                        </dl>
                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Keterangan</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ ucfirst($row['desc']) }}
                            </dd>
                        </dl>
                        <dl class="items-center justify-between gap-4 sm:flex">
                            <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Tanggal</dt>
                            <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                {{ \Carbon\Carbon::parse($row['created_at'])->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                            </dd>
                        </dl>
                    </div>
                @empty
                    <div
                        class="mb-2 rounded-lg border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 sm:space-y-2 lg:mb-4">
                        <p class="font-semibold text-gray-800 dark:text-white">Belum ada riwayat pengiriman.</p>
                    </div>
                @endforelse

                @can('spk-validate-pengiriman')
                    <div class="mx-auto flex w-fit justify-end gap-x-2">
                        @if ($modalData->status_kirim != 1)
                            <x-button.success id="delivery-btn-done" wire:click="deliveryArrivedConfirmation"
                                wire:confirm.prompt="Apakah anda yakin ingin menyelesaikan pengiriman ini?\nKetik YA untuk mengkonfirmasi|YA"
                                type="button">
                                Konfirmasi Pengiriman Selesai
                            </x-button.success>

                            {{-- <x-button.danger id="delivery-btn-done" type="button">
                                Pengiriman Mengalami Delay
                            </x-button.danger> --}}
                        @endif
                    </div>
                @endcan

            </div>
        @endif
    </div>
</div>
{{-- end riwayat pengiriman --}}
