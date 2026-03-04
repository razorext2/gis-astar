<div class="flex flex-col gap-2 p-2 lg:gap-4 lg:p-0">
    {{-- info cust spk --}}
    <div class="grid w-full grid-cols-2">
        <div
            class="col-span-2 rounded-t-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-tr-none">
            <p class="text-xs italic"> No. SPK </p>
            <p class="font-semibold">
                {{ $spk_data->nomor_order . ($spk_data->revision_count ? 'R' . str_pad($spk_data->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
            </p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-tr-xl">
            <p class="text-xs italic">Tanggal SPK Dibuat</p>
            <p class="font-semibold">
                {{ $spk_data->created_at }}
            </p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Nama Customer</p>
            <p class="font-semibold">
                {{ empty($spk_data->customer['nama_perusahaan']) ? '-' : $spk_data->customer['nama_perusahaan'] }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
            <p class="text-xs italic">Nama Penerima</p>
            <p class="font-semibold">
                {{ empty($spk_data->customer['contact_person']) ? '-' : $spk_data->customer['contact_person'] }}
            </p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:rounded-b-xl">
            <p class="text-xs italic">Nomor Tagihan</p>
            <p class="font-semibold"> {{ $spk_data->nomor_tagihan ?? 'Belum di assign.' }}</p>
        </div>
    </div>
    {{-- end info cust spk --}}

    @if (!$form->status_nomor_tagihan)
        <form class="flex w-full flex-col gap-2 lg:col-span-2 lg:gap-4" wire:submit.prevent="search">
            <div class="flex w-full gap-2 lg:gap-4">
                <div class="flex flex-col">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="tipe_tagihan">
                        Tipe Tagihan
                    </label>

                    <select
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="tipe_tagihan" name="tipe_tagihan" wire:model.live="form.tipe_tagihan" disabled>
                        <option value="">Pilih tipe tagihan...</option>
                        @foreach (config('spk-config.spk_tipe_tagihan') as $key => $row)
                            <option value="{{ $key }}">
                                {{ $row['label'] }}
                            </option>
                        @endforeach
                    </select>

                    @error('form.tipe_tagihan')
                        <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-1 flex-col">
                    <div>
                        <x-input.basic id="nomor_tagihan" name="nomor_tagihan" wire:model="form.nomor_tagihan"
                            type="text" placeholder="Masukkan nomor SR spk..." :labels="true">
                            Nomor SR
                        </x-input.basic>
                    </div>

                    @error('form.nomor_tagihan')
                        <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div wire:show="form.nomor_tagihan_baru" wire:transition class="relative mt-6 grid w-full grid-cols-2">
                <span
                    class="absolute -top-6 block rounded-t-lg border border-b-0 border-gray-200 bg-gray-50 px-2 py-0.5 text-sm font-medium text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    Rekap Piutang (BSI)
                </span>

                <div
                    class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
                    <p class="text-xs italic"> No. Tagihan (SR/FP) </p>
                    <p class="font-semibold"> {{ $form->nomor_tagihan ?? '-' }}</p>
                </div>

                <div
                    class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1">
                    <p class="text-xs italic">Nama Customer</p>
                    <p class="font-semibold"> {{ $form->nama_customer ?? '-' }}</p>
                </div>

                <div
                    class="col-span-2 rounded-b-xl border-[1px] border-gray-200 bg-gray-50 p-2 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white">

                    <dl class="items-center justify-between gap-4 sm:flex">
                        <dt class="mb-1 font-normal text-blue-500 dark:text-blue-400 sm:mb-0">Total Piutang</dt>
                        <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                            Rp. {{ number_format($form->total_tagihan, 2, '.', ',') }}
                        </dd>
                    </dl>

                    <dl class="items-center justify-between gap-4 sm:flex">
                        <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">Total Bayar</dt>
                        <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                            Rp. {{ number_format($form->total_bayar, 2, '.', ',') }}
                        </dd>
                    </dl>

                    <dl class="items-center justify-between gap-4 sm:flex">
                        <dt class="mb-1 font-normal text-red-500 dark:text-red-400 sm:mb-0">Sisa Piutang</dt>
                        <dd class="font-semibold text-gray-900 dark:text-white sm:text-end">
                            Rp. {{ number_format($form->sisa, 2, '.', ',') }}
                        </dd>
                    </dl>

                </div>
            </div>

            <div class="flex gap-2">
                <x-button.primary type="submit" id="search">
                    <span wire:loading.remove wire:target="search">Cari Tagihan</span>
                    <span wire:loading wire:target="search">Memproses...</span>
                </x-button.primary>

                <x-button.success type="button" wire:show="form.nomor_tagihan_baru" wire:transition id="assign"
                    wire:click="assign">
                    <span wire:loading.remove wire:target="assign">Assign</span>
                    <span wire:loading wire:target="assign">Memproses...</span>
                </x-button.success>
            </div>
        </form>
    @endif

    @if ($form->status_nomor_tagihan)
        <div class="w-full">
            <h3 class="mb-2 text-base font-medium text-gray-800 dark:text-white lg:mb-4">
                Riwayat Penagihan (BSI)
            </h3>

            <div
                class="flex w-full flex-col items-center justify-center gap-2 rounded-lg p-2 ring-1 ring-gray-200 dark:bg-gray-700 dark:ring-gray-600 lg:gap-4 lg:p-4">

                @foreach ($this->histories as $index => $row)
                    <div
                        class="flex w-full flex-col gap-2 border-b border-gray-200 pb-2 text-gray-800 dark:border-gray-600 dark:text-white">
                        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-8">
                            <div class="text-right text-xs lg:text-left">
                                <p>
                                    Pukul {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('hh:mm:ss') }}
                                </p>
                                <p>
                                    {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, DD MMM YYYY') }}
                                </p>
                            </div>

                            <div class="w-full">
                                <dl class="items-center justify-between gap-4 sm:flex">
                                    <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">
                                        Total Piutang
                                    </dt>
                                    <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                        Rp. {{ number_format($row->total_piutang, 2, '.', ',') }}
                                    </dd>
                                </dl>

                                <dl class="items-center justify-between gap-4 sm:flex">
                                    <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">
                                        Sisa Piutang Sebelumnya
                                    </dt>
                                    <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                        Rp. {{ number_format($row->sisa_piutang_sebelum, 2, '.', ',') }}
                                    </dd>
                                </dl>

                                <dl class="items-center justify-between gap-4 sm:flex">
                                    <dt class="mb-1 font-normal text-gray-500 dark:text-gray-400 sm:mb-0">
                                        Sisa Piutang Sesudah
                                    </dt>
                                    <dd class="font-medium text-gray-900 dark:text-white sm:text-end">
                                        Rp. {{ number_format($row->sisa_piutang_sesudah, 2, '.', ',') }}
                                    </dd>
                                </dl>

                                <dl class="items-center justify-between gap-4 sm:flex">
                                    <dt class="mb-1 font-normal text-green-500 sm:mb-0">
                                        Pembayaran
                                    </dt>
                                    <dd class="font-medium text-green-500 sm:text-end">
                                        Rp. {{ number_format($row->selisih, 2, '.', ',') }}
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="flex flex-row justify-between text-xs">
                            <span class="rounded-lg bg-blue-500 px-2 py-0.5 text-white">
                                {{ ucfirst($row->source ?? '-') }}
                            </span>
                            @if ($row->updated_by)
                                <p class="text-right italic">Oleh: {{ $row->updatedBy?->name ?? '-' }}</p>
                            @endif
                        </div>

                    </div>
                @endforeach

                {{ $this->histories->links() }}
            </div>

        </div>
    @endif
</div>
