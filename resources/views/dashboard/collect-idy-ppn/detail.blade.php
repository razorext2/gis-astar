@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="grid gap-4">
        <div
            class="grid gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
            <header class="flex items-center">

                <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('collect-idy-ppn.index') }}" wire:navigate>
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>

                <h2 class="text-lg text-gray-900 dark:text-gray-300">
                    Detail tagihan: <span class="font-bold lowercase text-white">{{ $data->customer_name }}
                        ({{ $data->customer_recipient }})</span>
                </h2>
            </header>

            <div class="grid gap-2 md:grid-cols-2">
                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">No. SR</p>
                    <p class="text-navy-700 text-base font-medium dark:text-white">
                        {{ $data->no_sr ?? 'N/A' }}
                    </p>
                </div>

                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Tanggal SR Dibuat</p>
                    <p class="text-navy-700 text-base font-medium dark:text-white">
                        {{ \Carbon\carbon::parse($data->sr_date)->locale('id')->isoFormat('D MMMM YYYY hh:mm:ss') ?? 'N/A' }}
                    </p>
                </div>

                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Nama Customer</p>
                    <p class="text-navy-700 text-base font-medium dark:text-white">
                        {{ $data->customer_name ?? 'N/A' }}
                    </p>
                </div>

                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Alamat Customer</p>
                    <p class="text-navy-700 text-base font-medium dark:text-white">
                        {{ $data->customer_address ?? 'N/A' }}
                    </p>
                </div>

                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">No. Telepon</p>
                    <p class="text-navy-700 text-base font-medium dark:text-white">
                        {{ $data->customer_telp ?? 'N/A' }}
                    </p>
                </div>

                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">No. Fax</p>
                    <p class="text-navy-700 text-base font-medium dark:text-white">
                        {{ $data->customer_fax ?? 'N/A' }}
                    </p>
                </div>

                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Total Tagihan</p>
                    <p class="text-navy-700 text-base font-medium dark:text-white">
                        {{ Number::currency($data->total_bill ?? 0, 'IDR', 'id') }}
                    </p>
                </div>

                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700 lg:col-span-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Sisa Tagihan</p>
                    <p class="text-navy-700 text-base font-medium dark:text-white">
                        {{ Number::currency($data->remaining_bill ?? 0, 'IDR', 'id') }}
                    </p>
                </div>

                <div
                    class="col-span-2 flex flex-col items-start justify-center rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-300">Status</p>
                    <p class="text-navy-700 pt-1.5 text-base font-medium dark:text-white">
                        @php
                            $bill_status = $data->bill_status;
                        @endphp

                        @if ($bill_status == 0)
                            <span
                                class="rounded-lg bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800 ring-1 ring-zinc-200 dark:bg-yellow-900 dark:text-yellow-300 dark:ring-zinc-800">
                                Belum ditagih.
                            </span>
                        @elseif ($bill_status == 1)
                            <span
                                class="rounded-lg bg-blue-100 px-4 py-2 text-sm font-medium text-blue-800 ring-1 ring-zinc-200 dark:bg-blue-900 dark:text-blue-300 dark:ring-zinc-800">
                                Tagihan berjalan.
                            </span>
                        @elseif ($bill_status == 2)
                            <span
                                class="rounded-lg bg-green-100 px-4 py-2 text-sm font-medium text-green-800 ring-1 ring-zinc-200 dark:bg-green-900 dark:text-green-300 dark:ring-zinc-800">
                                Tagihan selesai. (divalidasi oleh: {{ $user->name ?? 'N/A' }})
                            </span>
                        @else
                            <span
                                class="rounded-lg bg-red-100 px-4 py-2 text-sm font-medium text-red-800 ring-1 ring-zinc-200 dark:bg-red-900 dark:text-red-300 dark:ring-zinc-800">
                                Tagihan tertunda
                            </span>
                        @endif

                    </p>
                </div>

                @can('collect-idy-ppn-validate')
                    @if ($data->bill_status == 1)
                        <div class="col-span-2 mt-2 flex flex-col justify-end" id="action">
                            <div class="text-right">

                                <x-button.success class="confirm-btn float-right" id="confirm-btn"
                                    data-id="{{ $data->id }}" type="button">
                                    <x-slot name="icon">
                                        <x-icons.angle-right class="h-5 w-5" />
                                    </x-slot>
                                    Tutup Tagihan
                                </x-button.success>

                            </div>
                        </div>
                    @endif
                @endcan
            </div>
        </div>

        <div
            class="grid gap-6 rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
            <header class="flex items-center">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                    Detail penagihan:
                </h2>
            </header>

            <div class="grid gap-4 md:grid-cols-2">
                @php
                    $total = 0;
                @endphp
                @foreach ($collect->where('status', 1) as $item)
                    @php
                        $total += $item->payment_amount;
                    @endphp
                    <a class="group col-span-2 transition-all duration-200 ease-in-out hover:scale-105"
                        href="{{ route('collect.show', $item->id) }}" target="_blank">
                        <div
                            class="relative flex flex-col rounded-xl border border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-gray-700">

                            <div
                                class="absolute -top-3 max-w-fit self-center rounded-full bg-green-500 p-0.5 ring-1 ring-zinc-200 group-hover:animate-spin dark:ring-zinc-800">
                                <x-icons.badge-check class="h-5 w-5 text-white" />
                            </div>

                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ \Carbon\carbon::parse($item->updated_at)->locale('id')->isoFormat('DD MMMM YYYY, HH:MM:ss') }}
                                |
                                {{ $item->title ?? 'N/A' }}
                            </p>
                            <p class="text-navy-700 text-base font-medium dark:text-white">
                                Oleh: {{ $item->pegawaiRelasi->full_name ?? 'N/A' }}
                            </p>

                            @php
                                if ($item->have_paid == 0) {
                                    $status = 'Belum bayar';
                                } elseif ($item->have_paid == 1) {
                                    $status = 'Cicilan';
                                } elseif ($item->have_paid == 2) {
                                    $status = 'Lunas';
                                } elseif ($item->have_paid == 3) {
                                    $status = 'Tanda terima';
                                } elseif ($item->have_paid == 4) {
                                    $status = 'Ada Kendala';
                                } elseif ($item->have_paid == 5) {
                                    $status = 'Antar bon lunas';
                                } else {
                                    $status = 'Tidak diketahui';
                                }

                                if ($item->payment_type == 0) {
                                    $type = 'Tidak ada';
                                } elseif ($item->payment_type == 1) {
                                    $type = 'Cash';
                                } elseif ($item->payment_type == 2) {
                                    $type = 'Transfer';
                                } elseif ($item->payment_type == 3) {
                                    $type = 'Giro';
                                } else {
                                    $type = 'Tidak diketahui';
                                }
                            @endphp

                            <div class="relative mt-2 w-full p-1 text-right">
                                <table class="float-right w-full dark:text-gray-100 lg:w-1/2 xl:w-1/3">
                                    <tr>
                                        <th>Status Pembayaran:</th>
                                        <td>{{ $status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Metode:</th>
                                        <td>{{ $type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah:</th>
                                        <td>{{ Number::currency($item->payment_amount ?? 0, 'IDR', 'id') }}</td>
                                    </tr>

                                </table>
                            </div>

                        </div>
                    </a>
                @endforeach

                <div class="col-span-2 rounded-xl px-1 text-right dark:text-gray-200">
                    <p class="font-bold">
                        Total Pembayaran: {{ Number::currency($total ?? 0, 'IDR', 'id') }}
                    </p>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const validate_by = "{{ Auth::user()->kode_pegawai ?? 0 }}";
    </script>
    @vite('resources/js/pages/collect-idy-ppn/detail.js')
@endpush
