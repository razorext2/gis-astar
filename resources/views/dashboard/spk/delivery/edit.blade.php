@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="grid grid-cols-1 gap-6">

        <div
            class="grid w-full grid-cols-1 rounded-xl border border-zinc-200 bg-white/60 py-2 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">

                <div class="flex items-center gap-x-2">
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">
                        Update Pengiriman <span class="text-green-500">
                            [{{ $data->customer['nama_perusahaan'] }}]
                        </span>
                    </p>

                    @if ($data->is_using_company_driver)
                        <span class='w-fit rounded-lg bg-blue-400 px-2.5 py-1 text-center text-xs text-blue-700'>
                            Supir Perusahaan
                        </span>
                    @endif

                    @if ($data->is_picked_up_by_customer)
                        <span class='w-fit rounded-lg bg-purple-400 px-2.5 py-1 text-center text-xs text-purple-700'>
                            Dijemput Customer
                        </span>
                    @endif
                </div>

                <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    SPK: {{ $data->nomor_order }}
                </p>

                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                    Halaman ini digunakan untuk memperbarui detail pengiriman produk yang telah selesai diproses dan
                    siap
                    dikirim.
                </p>

            </div>

            @livewire('handler.spk.delivery-update', ['id' => $id])

        </div>
    </div>
@endsection
