{{-- riwayat pengiriman --}}
<div id="delivery-history-section" class="flex w-full flex-col gap-2 lg:gap-4">
    <div id="delivery-history-header">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white lg:text-lg">
            Riwayat Pengiriman
        </h3>

        <p class="text-sm text-gray-600 dark:text-gray-400">
            Berikut ini adalah riwayat pengiriman SPK ini:
        </p>
    </div>

    <div id="delivery-history-content" class="grid w-full gap-2 lg:grid-cols-2 lg:gap-4">
        @forelse ($deliveries as $row)
            <div class="w-full">
                <div
                    class="mb-2 rounded-lg border border-zinc-200 bg-gray-50 p-4 dark:border-zinc-800 dark:bg-gray-800 sm:space-y-2 lg:mb-4">

                    <div class="flex items-center gap-x-2">
                        <span class="rounded bg-gray-400 px-2 py-0.5 text-xs font-semibold text-gray-800">
                            {{ $row->kode_kirim ?? 'N/A' }}
                        </span>

                        <span
                            class="{{ $this->form->generateViaColor($row->via)['color'] }} rounded px-2 py-0.5 text-xs font-semibold">
                            {{ $this->form->generateViaColor($row->via)['label'] }}
                        </span>

                        <span
                            class="{{ $this->form->generateStatusColor($row->status_kirim)['color'] }} rounded px-2 py-0.5 text-xs font-semibold">
                            {{ $this->form->generateStatusColor($row->status_kirim)['label'] }}
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
                        <div class="flex w-full flex-col gap-1">
                            <p class="font-semibold text-gray-800 dark:text-white">
                                Barang yang dibawa:
                            </p>
                            <ul class="text-gray-600 dark:text-white">
                                @forelse ($row->product_details as $key => $barang)
                                    <li class="flex gap-x-2">
                                        <span>{{ $key + 1 }}. </span>
                                        <span>
                                            {{ $barang['nama_barang'] ?? '-' }}
                                            ({{ $barang['qty_barang'] ?? 0 }}
                                            {{ $barang['satuan_barang'] ?? '' }})
                                        </span>
                                    </li>
                                @empty
                                    <li class="text-sm">
                                        Tidak ada barang yang dibawa.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    @endif

                    <div class="mt-2 flex items-center justify-between space-x-2 lg:space-x-4">
                        @if ($row->status_kirim == 0)
                            <x-button.primary
                                class="bg-yellow-600 text-white ring-yellow-700 hover:bg-yellow-800 dark:bg-yellow-700 dark:ring-yellow-700 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800"
                                type="button" wire:click="delayModal({{ $row->id }})">
                                Delay?
                            </x-button.primary>
                        @endif

                        <x-button.primary
                            class="bg-blue-700 text-white hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button" wire:click="detailModal({{ $row->id }})">
                            Cek Riwayat
                        </x-button.primary>
                    </div>
                </div>

            </div>
        @empty
            <p class="col-span-2 text-center text-sm italic text-red-500">Belum ada riwayat pengiriman.</p>
        @endforelse
    </div>

    {{ $deliveries->links(data: ['scrollTo' => '#delivery-history-section']) }}

    {{-- modal detail pengiriman --}}
    <x-modal.base-modal show="showDetailModal" title="Riwayat Pengiriman"
        subtitle="{{ $showDetailModal && $modalData ? $modalData->kode_kirim : '' }}"
        iconContainerClass="bg-blue-600 shadow-blue-500/20" maxWidth="lg">
        <x-slot name="icon">
            <x-icons.truck class="h-5 w-5" />
        </x-slot>

        @if ($showDetailModal && $modalData)
            <div class="flex flex-col gap-3">
                @php
                    $histories = collect($modalData->history)
                        ->sortByDesc(fn($item) => \Carbon\Carbon::parse($item['created_at']))
                        ->values()
                        ->toArray();
                @endphp

                @forelse ($histories as $row)
                    <div
                        class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-800/50">
                        <dl class="flex items-center justify-between gap-4 py-1">
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">ID Riwayat</dt>
                            <dd class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $row['id'] }}</dd>
                        </dl>
                        <dl class="flex items-center justify-between gap-4 py-1">
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Status Pengiriman</dt>
                            <dd class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                {{ $row['status'] }}</dd>
                        </dl>
                        <dl class="flex items-center justify-between gap-4 py-1">
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Keterangan</dt>
                            <dd class="text-sm font-semibold text-zinc-900 dark:text-white">{{ ucfirst($row['desc']) }}
                            </dd>
                        </dl>
                        <dl class="flex items-center justify-between gap-4 py-1">
                            <dt class="text-xs font-medium text-blue-500 dark:text-blue-400">Tanggal Dibuat</dt>
                            <dd class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                {{ \Carbon\Carbon::parse($row['created_at'])->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                            </dd>
                        </dl>
                    </div>
                @empty
                    <div
                        class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 py-10 dark:border-zinc-800">
                        <x-icons.question-circle class="mb-2 h-8 w-8 text-zinc-400" />
                        <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Belum ada riwayat pengiriman.
                        </p>
                    </div>
                @endforelse
            </div>
        @endif

        @can('spk-validate-pengiriman')
            @if ($showDetailModal && $modalData && ($modalData->status_kirim == 0 || $modalData->status_kirim == 2))
                <x-slot name="footer">
                    <x-button.secondary @click="open = false">Tutup</x-button.secondary>
                    @if ($modalData->status_kirim == 0)
                        <x-button.success id="delivery-btn-done" wire:click="deliveryArrivedConfirmation"
                            wire:confirm.prompt="Apakah anda yakin ingin menyelesaikan pengiriman ini?\nKetik YA untuk mengkonfirmasi|YA"
                            type="button">
                            Pengiriman Selesai
                        </x-button.success>
                    @endif
                    @if ($modalData->status_kirim == 2)
                        <x-button.primary id="continue-btn-done" wire:click="continueAfterDelayConfirmation" type="button">
                            Pengiriman Dilanjutkan?
                        </x-button.primary>
                    @endif
                </x-slot>
            @endif
        @endcan
    </x-modal.base-modal>
    {{-- end modal detail pengiriman --}}

    {{-- modal delayed --}}
    <x-modal.base-modal show="showDelayedModal" title="Konfirmasi Delay Pengiriman"
        subtitle="{{ $showDelayedModal && $modalData ? $modalData->kode_kirim : '' }}"
        iconContainerClass="bg-amber-600 shadow-amber-500/20" maxWidth="lg">
        <x-slot name="icon">
            <x-icons.clock class="h-5 w-5" />
        </x-slot>

        @if ($showDelayedModal && $modalData)
            <form id="form-delay-pengiriman" wire:submit.prevent="delayDelivery({{ $modalData->id }})"
                class="flex flex-col gap-5">

                <div class="rounded-xl bg-amber-50 px-4 py-3 dark:bg-amber-950/20">
                    <p class="text-sm font-semibold text-amber-800 dark:text-amber-300">
                        Pengiriman <span class="font-black">{{ $modalData->kode_kirim }}</span> mengalami delay?
                    </p>
                </div>

                <div class="w-full">
                    <x-input.textarea id="reason" :labels="true" :textLabel="'Alasan Delay'" name="reason"
                        wire:model="delayed_reason"
                        placeholder="Tuliskan alasan kenapa pengiriman mengalami delay..." />
                    @error('delayed_reason')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <label class="mb-2 block text-sm font-bold text-zinc-900 dark:text-white" for="delayed_eta">
                        Estimasi Tanggal Tiba
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4">
                            <x-icons.date class="h-4 w-4 text-zinc-400" />
                        </div>
                        <input id="delayed_eta" name="delayed_eta" wire:model="delayed_eta" type="date"
                            class="block w-full rounded-xl border border-zinc-200 bg-white/60 py-2.5 pr-4 ps-11 text-sm font-medium text-zinc-900 transition-all focus:border-amber-500 focus:ring-amber-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white">
                    </div>
                    @error('delayed_eta')
                        <span class="mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        @endif

        <x-slot name="footer">
            <x-button.secondary @click="open = false">Batal</x-button.secondary>
            <x-button.primary type="submit" form="form-delay-pengiriman" name="submit-delay">
                Konfirmasi
            </x-button.primary>
        </x-slot>
    </x-modal.base-modal>
    {{-- end modal delayed --}}
</div>
{{-- end riwayat pengiriman --}}
