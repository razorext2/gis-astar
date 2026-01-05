<div class="flex flex-col gap-2 p-2 lg:gap-4 lg:p-0">
    <h3 class="col-span-2 text-base font-semibold text-gray-800 dark:text-white"> Info Cust. SPK </h3>

    {{-- info cust spk --}}
    <div class="grid w-full grid-cols-2">
        <div
            class="col-span-2 rounded-t-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-tr-none">
            <p class="text-xs italic"> No. SPK </p>
            <p class="font-semibold"> {{ $spk_data->nomor_order ?? '-' }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-tr-xl">
            <p class="text-xs italic">Nama Customer</p>
            <p class="font-semibold"> {{ $spk_data->customer['nama_perusahaan'] ?? '-' }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-bl-xl">
            <p class="text-xs italic">Nama Penerima</p>
            <p class="font-semibold"> {{ $spk_data->customer['contact_person'] ?? '-' }}</p>
        </div>

        <div
            class="col-span-2 border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-br-xl">
            <p class="text-xs italic">Nomor Tagihan</p>
            <p class="font-semibold"> {{ $spk_data->nomor_tagihan ?? 'Belum di assign.' }}</p>
        </div>
    </div>
    {{-- end info cust spk --}}

    @if (!$status_nomor_tagihan)
        <form class="flex w-full flex-col gap-2 lg:col-span-2 lg:gap-4" wire:submit.prevent="search">
            <div class="flex flex-col">
                <x-input.select id="tipe_tagihan" name="tipe_tagihan" :defaultOption="'Pilih tipe tagihan'" :options="[
                    'idcppn' => 'IDC PPN',
                    'idcnonppn' => 'IDC Non PPN',
                    'idyppn' => 'IDY PPN',
                ]"
                    wire:model="tipe_tagihan" :labels="true" :textLabel="'Tipe tagihan'" />
                @error('tipe_tagihan')
                    <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <div>
                    <x-input.basic id="nomor_tagihan" name="nomor_tagihan" wire:model="nomor_tagihan" type="text"
                        placeholder="Masukkan 8 digit terakhir nomor tagihan (FP) atau nomor SR" :labels="true">
                        Nomor Tagihan
                    </x-input.basic>
                </div>

                <span class="mt-0.5 text-xs italic text-green-500">
                    PPN = 8 digit akhir no faktur; Non PPN = gunakan nomor SR.
                </span>

                @error('nomor_tagihan')
                    <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-2">
                <x-button.primary type="submit" id="search">
                    <span wire:loading.remove wire:target="search">Cari Tagihan</span>
                    <span wire:loading wire:target="search">Memproses...</span>
                </x-button.primary>

                <x-button.danger type="button" wire:click="clear" id="clear">
                    <span wire:loading.remove wire:target="clear">Hapus</span>
                    <span wire:loading wire:target="clear">Memproses...</span>
                </x-button.danger>
            </div>
        </form>


        <div wire:show="nomor_tagihan_baru" wire:transition class="grid w-full grid-cols-2">
            <div
                class="rounded-lb-none col-span-2 rounded-t-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-l-xl lg:rounded-tr-none">
                <p class="text-xs italic"> No. Tagihan (SR/FP) </p>
                <p class="font-semibold"> {{ $nomor_tagihan_baru ?? '-' }}</p>
            </div>

            <div
                class="col-span-2 rounded-b-xl border-[1px] border-gray-200 bg-gray-50 p-2.5 text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white lg:col-span-1 lg:rounded-r-xl lg:rounded-bl-none">
                <p class="text-xs italic">Nama Customer</p>
                <p class="font-semibold"> {{ $nama_customer ?? '-' }}</p>
            </div>
        </div>

        <div wire:show="nomor_tagihan_baru" wire:transition class="col-span-2 flex w-full justify-end">
            <x-button.primary type="button" class="" id="assign" wire:click="assign">
                <span wire:loading.remove wire:target="assign">Assign</span>
                <span wire:loading wire:target="assign">Memproses...</span>
            </x-button.primary>
        </div>
    @endif

    @if ($status_nomor_tagihan)
        <div class="grid grid-cols-2 gap-2 text-white">
            <x-button.link class="z-0 bg-green-600" id="invoiceBtn"
                href="{{ route('invoice.show', $spk_data->invoice->id) }}">
                Lihat History Invoice
            </x-button.link>



            <x-button.link class="z-0 bg-green-600" id="penagihanBtn"
                href="{{ route('invoice.show', $spk_data->invoice->id) }}">
                Lihat History Penagihan
            </x-button.link>
        </div>
    @endif
</div>
