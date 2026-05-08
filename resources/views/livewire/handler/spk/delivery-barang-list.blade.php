<div class="space-y-4">
    <div class="flex items-center gap-2 border-l-4 border-blue-500 pl-3">
        <h3 class="text-base font-bold text-zinc-900 dark:text-white">Riwayat Pengiriman</h3>
        <span
            class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-900/30">Logistik
            Log</span>
    </div>

    <div id="delivery-history-content" class="grid w-full gap-2 lg:grid-cols-2 lg:gap-4">
        @forelse ($deliveries as $row)
            <div class="w-full">
                <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition-all hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900/50">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-100 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-zinc-800/30">
                        <div class="flex items-center gap-2">
                            <span class="rounded-full bg-zinc-200 px-2.5 py-0.5 font-mono text-[10px] font-bold tracking-wide text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                {{ $row->kode_kirim ?? 'N/A' }}
                            </span>
                            <span class="{{ $this->form->generateViaColor($row->via)['color'] }} rounded-full px-2.5 py-0.5 text-[10px] font-bold">
                                {{ $this->form->generateViaColor($row->via)['label'] }}
                            </span>
                        </div>
                        <span class="{{ $this->form->generateStatusColor($row->status_kirim)['color'] }} rounded-full px-2.5 py-0.5 text-[10px] font-bold shadow-sm ring-1 ring-inset">
                            {{ $this->form->generateStatusColor($row->status_kirim)['label'] }}
                        </span>
                    </div>

                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Tanggal Dibuat</p>
                                <p class="text-sm font-medium text-zinc-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                                </p>
                            </div>

                            @if ($row['via'] === 'laut')
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Partay</p>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ ucfirst($row->partay ?? 'N/A') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">No. Container</p>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ strtoupper($row->no_container ?? 'N/A') }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Kapal</p>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ ucfirst($row->nama_kapal ?? 'N/A') }}</p>
                                </div>
                            @else
                                @if ($row->voa === 'supir')
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nomor SR</p>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ ucfirst($row->nomor_sr ?? 'N/A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Kode Jari Supir</p>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ ucfirst($row->id_supir ?? 'N/A') }}</p>
                                    </div>
                                @endif
                                <div class="col-span-2">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Nama Supir</p>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ ucfirst($row->nama_supir ?? 'N/A') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">No. Telp Supir</p>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ ucfirst($row->no_telp_supir ?? 'N/A') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">No. Plat Kendaraan</p>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ strtoupper($row->no_plat ?? 'N/A') }}</p>
                                </div>
                            @endif

                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Est. Keberangkatan</p>
                                <p class="text-sm font-medium text-zinc-900 dark:text-white">
                                    {{ Carbon\Carbon::parse($row->etd)->locale('id')->isoFormat('D MMM YYYY') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Est. Tiba</p>
                                <p class="text-sm font-medium text-zinc-900 dark:text-white">
                                    {{ Carbon\Carbon::parse($row->eta)->locale('id')->isoFormat('D MMM YYYY') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Estimasi Berat</p>
                                <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ strtoupper($row->berat ?? 'N/A') }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Catatan</p>
                                <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ ucfirst($row->note ?? '-') }}</p>
                            </div>
                        </div>

                        @if ($row->via != 'supir')
                            <div class="mt-4 rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800/50">
                                <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-zinc-500">Daftar Barang (Packing List)</p>
                                <ul class="space-y-1 text-xs text-zinc-700 dark:text-zinc-300">
                                    @forelse ($row->product_details as $key => $barang)
                                        <li class="flex items-center gap-2 border-b border-zinc-200/50 pb-1 last:border-0 last:pb-0 dark:border-zinc-700/50">
                                            <span class="font-mono text-zinc-400">{{ $key + 1 }}.</span>
                                            <span class="flex-grow font-medium text-zinc-900 dark:text-white">{{ $barang['nama_barang'] ?? '-' }}</span>
                                            <span class="rounded-full bg-white px-2 py-0.5 font-bold ring-1 ring-inset ring-zinc-200 dark:bg-zinc-800 dark:ring-zinc-700">
                                                {{ $barang['qty_barang'] ?? 0 }} {{ $barang['satuan_barang'] ?? '' }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="italic text-zinc-400">Tidak ada barang yang dibawa.</li>
                                    @endforelse
                                </ul>
                            </div>
                        @endif

                        <div class="mt-4 flex items-center justify-end gap-2 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                            @if ($row->status_kirim == 0)
                                <x-button.secondary class="text-amber-600 ring-amber-200 hover:bg-amber-50 hover:text-amber-700 dark:text-amber-500 dark:ring-amber-900/50 dark:hover:bg-amber-900/20" type="button" wire:click="delayModal({{ $row->id }})">
                                    Delay?
                                </x-button.secondary>
                            @endif

                            <x-button.primary type="button" wire:click="detailModal({{ $row->id }})">
                                Cek Riwayat
                            </x-button.primary>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-2 rounded-xl border-2 border-dashed border-zinc-200 py-10 text-center dark:border-zinc-800">
                <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Belum ada riwayat pengiriman.</p>
            </div>
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
                    <div class="relative overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900/50">
                        <div class="absolute left-0 top-0 h-full w-1 {{ $row['status'] == 'Selesai' ? 'bg-emerald-500' : ($row['status'] == 'Delay' ? 'bg-amber-500' : 'bg-blue-500') }}"></div>
                        <div class="p-4 pl-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <span class="inline-flex items-center rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-bold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                        ID: {{ $row['id'] }}
                                    </span>
                                    <h4 class="mt-2 text-sm font-bold text-zinc-900 dark:text-white">{{ $row['status'] }}</h4>
                                    <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">{{ ucfirst($row['desc']) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Tanggal</p>
                                    <p class="text-xs font-semibold text-zinc-900 dark:text-white">
                                        {{ \Carbon\Carbon::parse($row['created_at'])->isoFormat('D MMM YYYY') }}
                                    </p>
                                    <p class="text-[10px] text-zinc-500">
                                        {{ \Carbon\Carbon::parse($row['created_at'])->isoFormat('HH:mm:ss') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-200 py-10 dark:border-zinc-800">
                        <x-icons.question-circle class="mb-2 h-8 w-8 text-zinc-400" />
                        <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Belum ada riwayat pengiriman.</p>
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
