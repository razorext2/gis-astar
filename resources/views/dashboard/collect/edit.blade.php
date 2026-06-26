@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6">
        <div
            class="grid gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">

            <div class="w-full">
                <header class="flex items-center">

                    <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('collect.index') }}" wire:navigate>
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <h2 class="text-lg text-gray-900 dark:text-gray-300">
                        Ubah: <span class="font-bold lowercase text-white">{{ $data->title ?? 'N/A' }}</span>
                    </h2>
                </header>
            </div>

            <div class="w-full">

                <div class="grid gap-4 md:grid-cols-2" id="laporan-content">
                    <input id="id" name="id" type="hidden" value="{{ $data->id ?? 'N/A' }}">

                    <div class="col-span-2 w-full lg:col-span-1">
                        <x-input.basic class="cursor-not-allowed" id="no_sr" name="no_sr"
                            value="{{ $data->no_sr ?? 'N/A' }}" readonly>
                            No. Tagihan
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 w-full lg:col-span-1">
                        <x-input.basic class="cursor-not-allowed" id="title" name="title"
                            value="{{ match ($data->bill_type) {
                                'idcnonppn' => $data->collectTaskRelasi->customer_name,
                                'idcppn' => $data->collectTaskPpnRelasi->customer_name,
                                'idyppn' => $data->collectIdyPpnRelasi->customer_name,
                                default => 'N/A',
                            } }}"
                            readonly>
                            Nama Customer
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 w-full">
                        <x-input.basic class="cursor-not-allowed" id="location" name="location"
                            value="{{ $data->location ?? 'N/A' }}" readonly>
                            Alamat Customer
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 w-full lg:col-span-1">
                        <x-input.basic class="cursor-not-allowed" id="total_bill" name="total_bill"
                            value="{{ Number::currency(
                                match ($data->bill_type) {
                                    'idcnonppn' => $data->collectTaskRelasi->total_bill,
                                    'idcppn' => $data->collectTaskPpnRelasi->total_bill,
                                    'idyppn' => $data->collectIdyPpnRelasi->total_bill,
                                    default => 0,
                                },
                                'IDR',
                                'id',
                            ) }}"
                            readonly>
                            Total Tagihan
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 w-full lg:col-span-1">
                        <x-input.basic class="cursor-not-allowed" id="remaining_bill" name="remaining_bill"
                            value="{{ Number::currency(
                                match ($data->bill_type) {
                                    'idcnonppn' => $data->collectTaskRelasi->remaining_bill,
                                    'idcppn' => $data->collectTaskPpnRelasi->remaining_bill,
                                    'idyppn' => $data->collectIdyPpnRelasi->remaining_bill,
                                    default => 0,
                                },
                                'IDR',
                                'id',
                            ) }}"
                            readonly>
                            Sisa Tagihan
                        </x-input.basic>
                    </div>

                    <input id="remain" name="remain" type="hidden"
                        value="{{ match ($data->bill_type) {
                            'idcnonppn' => $data->collectTaskRelasi->remaining_bill,
                            'idcppn' => $data->collectTaskPpnRelasi->remaining_bill,
                            'idyppn' => $data->collectIdyPpnRelasi->remaining_bill,
                            default => 0,
                        } }}">

                    <div class="col-span-2 w-full">
                        <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dokumentasi</p>
                        <p class="mb-2 text-xs text-red-500"> *Dokumentasi tidak dapat diubah setelah laporan diinput. </p>

                        <x-button.primary id="capture-button" type="button">
                            <x-slot name="icon">
                                <x-icons.plus class="icon h-5 w-5 text-blue-500 dark:text-white" />
                            </x-slot>
                            Ambil Foto
                        </x-button.primary>

                        <div class="relative overflow-auto">
                            <div class="mt-2 flex overflow-x-auto" id="captured-images">
                                <!-- Thumbnail gambar yang diambil akan muncul di sini -->
                                @if ($data->photoCollectRelasi)
                                    @foreach ($data->photoCollectRelasi as $photo)
                                        <div class="relative me-2 flex-none items-center gap-4">
                                            <img class="h-36 w-36 rounded-xl border object-cover" id="documentations"
                                                onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                                data-url="{{ asset($photo->photourl) }}"
                                                src="{{ asset($photo->photourl) }}" alt=""
                                                onclick="javascript:void(0)" loading="lazy">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="mt-2 hidden text-sm text-red-500" id="alert-images"></div>
                    </div>

                    <div class="col-span-2 w-full lg:col-span-1" id="have_paid_container">
                        <x-input.select id="have_paid" name="have_paid" value="{{ $data->have_paid }}" :options="[
                            '5' => 'Antar Bon Lunas',
                            '3' => 'Tanda terima',
                            '0' => 'Belum bayar',
                            '1' => 'Cicil',
                            '2' => 'Lunas',
                            '4' => 'Ada Kendala',
                        ]"
                            default-option="Pilih status">
                            <x-slot name="textLabel">
                                Status Pembayaran
                            </x-slot>
                        </x-input.select>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-have_paid"></div>
                    </div>

                    <div class="col-span-2 w-full lg:col-span-1" id="payment_type_container">
                        <x-input.select id="payment_type" name="payment_type" value="{{ $data->payment_type }}"
                            :options="[
                                '0' => 'Tidak ada',
                                '1' => 'Cash',
                                '2' => 'Transfer',
                                '3' => 'Giro',
                            ]" default-option="Pilih status">
                            <x-slot name="textLabel">
                                Metode Pembayaran
                            </x-slot>
                        </x-input.select>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-payment_type"></div>
                    </div>

                    <div class="col-span-2 hidden w-full" id="no_giro_container">
                        <x-input.basic id="no_giro" name="no_giro" :value="$data->no_giro" placeholder="cth: 1234567890">
                            No. Giro
                        </x-input.basic>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-no_giro"></div>
                    </div>

                    <div class="col-span-2 w-full" id="payment_amount_container">
                        <x-input.currency id="payment_amount" name="payment_amount" :value="$data->payment_amount" required>
                            Total Bayar
                        </x-input.currency>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-payment_amount"></div>
                    </div>

                    <div class="col-span-2 w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="keterangan">Keterangan</label>
                        <div class="h-32 w-full" id="editor"></div>
                        <input id="keterangan" name="keterangan" type="hidden">

                        <input type="hidden" id="data" value="{{ $data->keterangan }}">
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-keterangan"></div>
                    </div>

                    <input class="hidden w-full rounded-lg border border-zinc-200 bg-gray-400 p-2.5 text-sm text-gray-900"
                        id="longitude" name="longitude" type="hidden" readonly>

                    <input class="hidden w-full rounded-lg border border-zinc-200 bg-gray-400 p-2.5 text-sm text-gray-900"
                        id="latitude" name="latitude" type="hidden" readonly>

                    <div class="mb-4 hidden text-sm text-red-500" id="alert-coordinate"></div>

                    <div class="relative col-span-2 w-full">
                        <x-button.success class="float-right" id="store" type="button">
                            <x-slot name="icon">
                                <x-icons.checklist-stepper class="icon h-5 w-5" />
                            </x-slot>
                            {{ __('Simpan laporan') }}
                        </x-button.success>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('modals')
        @livewire('utils.camera-stream-modal')
    @endpush
@endsection
@push('script')
    @vite(['resources/js/pages/collect/edit.js'])
@endpush
