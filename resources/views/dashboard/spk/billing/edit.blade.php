@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="grid grid-cols-1 gap-6">

        <div
            class="grid w-full grid-cols-1 rounded-xl bg-white/60 py-2 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 lg:p-6">

            <div class="flex flex-col px-3 md:mb-2 lg:p-0">

                <span class="text-xl font-semibold text-gray-900 dark:bg-dark-primary dark:text-white">
                    Update Nomor Tagihan
                </span>

                <p class="mt-0.5 text-base text-gray-600 dark:text-gray-400">
                    Silahkan isi nomor penagihan menggunakan nomor SR ataupun Faktur Pajak sesuai dengan data SPK.
                </p>

            </div>

            @livewire('handler.spk.billing-update', ['id' => $id])

        </div>
    </div>
@endsection
