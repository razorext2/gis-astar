@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
        <header class="flex items-center">

            <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('collect-task.index') }}" wire:navigate>
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Tambah Surat Jalan (SR)') }}
            </h2>

        </header>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Silahkan sesuaikan data dibawah ini dengan data
            yang benar.</p>

        <form class="mt-4" id="collect-task" method="POST">
            @csrf
            <div class="mb-4 grid grid-cols-2 gap-6 sm:mb-5 sm:gap-6">

                <div class="col-span-2 w-full">
                    <x-input.w-button id="no_sr" name="no_sr" placeholder="SR-XXXXXX">
                        <x-slot name="buttonLabel">
                            Search
                        </x-slot>
                        <x-slot name="textLabel">
                            No. SR
                        </x-slot>
                    </x-input.w-button>

                    <div class="mt-2 hidden text-sm text-red-500" id="alert-no_sr"></div>
                </div>

                <div class="w-full">
                    <x-input.select id="sr_type" name="sr_type" :options="[
                        'TTT' => 'Tanda Terima Tagihan',
                        'TTST' => 'Tanda Terima Sertifikat Tera',
                        'AT' => 'Ambil Tagihan',
                        'ABL' => 'Antar Bon Lunas',
                    ]" default-option="Pilih tipe SR">
                        <x-slot name="textLabel">
                            Tipe SR
                        </x-slot>
                    </x-input.select>
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-sr_type"></div>
                </div>

                <div class="w-full">

                    <x-input.date id="sr_date" name="sr_date"
                        placeholder="{{ Carbon\Carbon::now()->isoFormat('YYYY-MM-DD') }}" required>
                        Tanggal SR
                    </x-input.date>

                    <div class="mt-2 hidden text-sm text-red-500" id="alert-sr_date"></div>
                </div>

                <div class="col-span-2 w-full">
                    <x-input.basic id="customer_name" name="customer_name" placeholder="PT XXX" required readonly>
                        Nama Customer
                    </x-input.basic>
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-customer_name"></div>
                </div>

                <div class="col-span-2 w-full">
                    <x-input.basic id="customer_recipient" name="customer_recipient" placeholder="Bp. Samsudin" required
                        readonly>
                        Nama Penerima
                    </x-input.basic>
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-customer_recipient"></div>
                </div>

                <div class="col-span-2 w-full">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                        for="customer_address">Alamat
                        Customer</label>
                    <x-input.textarea :labels="false" id="customer_address" name="customer_address"
                        placeholder="Jl. XXX, XXX, XXX" required />
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-customer_address"></div>
                </div>

                <div class="hidden">
                    <div class="col-span-2 w-full">
                        <x-input.textarea id="shipping_address" name="shipping_address" placeholder="Jl. XXX, XXX, XXX">
                            Alamat Pengiriman
                        </x-input.textarea>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-shipping_address"></div>
                    </div>

                    <div class="w-full">
                        <x-input.basic id="customer_fax" name="customer_fax" placeholder="XXXXXXX" required>
                            Fax
                        </x-input.basic>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-customer_fax"></div>
                    </div>

                    <div class="w-full">
                        <x-input.phone-number id="customer_telp" name="customer_telp" placeholder="08123456XXXX" required>
                            Telepon
                        </x-input.phone-number>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-customer_telp"></div>
                    </div>
                </div>

                <div class="col-span-2 w-full">
                    <x-input.currency id="total_bill" name="total_bill" placeholder="Rp. XXX.XXX,-" required readonly>
                        Total Tagihan
                    </x-input.currency>
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-total_bill"></div>
                </div>

                <div class="w-full">
                    <x-input.currency id="remaining_bill" name="remaining_bill" placeholder="Rp. XXX.XXX,-" required
                        readonly>
                        Sisa Tagihan (Database)

                        <x-popover id="popover-remaining_bill">
                            Jika sisa tagihan di sistem dan BSI berbeda, silahkan kontak IT terlebih dahulu untuk
                            pengecekan.
                        </x-popover>

                    </x-input.currency>
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-remaining_bill"></div>
                </div>

                <div class="w-full">
                    <x-input.currency id="remaining_bill_bsi" name="remaining_bill_bsi" placeholder="Rp. XXX.XXX,-"
                        readonly>
                        Sisa Tagihan (BSI)
                    </x-input.currency>
                </div>

                <div class="col-span-2 w-full">
                    <x-input.date id="assign_date" name="assign_date"
                        value="{{ Carbon\Carbon::tomorrow()->isoFormat('YYYY-MM-DD') }}"
                        placeholder="{{ Carbon\Carbon::tomorrow()->isoFormat('YYYY-MM-DD') }}" required>
                        Jadwal
                    </x-input.date>
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-assign_date"></div>
                </div>

            </div>

            <div class="relative inline-flex w-full gap-4">

                <x-button.primary id="store" type="button">
                    <x-slot name="icon">
                        <x-icons.angle-right class="h-5 w-5 text-blue-500 dark:text-white" />
                    </x-slot>
                    Submit
                </x-button.primary>

                <x-button.danger id="no_sr_reset" type="button">
                    <x-slot name="icon">
                        <x-icons.close class="h-5 w-5 text-blue-500 dark:text-white" />
                    </x-slot>
                    Reset
                </x-button.danger>

            </div>
        </form>
    </div>
@endsection
@push('script')
    @vite(['resources/js/pages/collect-task/add.js'])
@endpush
