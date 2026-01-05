@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex flex-col gap-2 lg:gap-4 rounded-xl bg-white py-2 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 lg:p-6">

        <div class="w-full p-2 lg:p-0 flex flex-col">
            <h3 class="text-lg dark:text-white font-semibold text-gray-800">Purchasing Request</h3>
            <p class="text-sm dark:text-gray-400 text-gray-600">
                Update nomor PR terlebih dahulu agar laporan produksi dapat diupdate oleh team produksi.
            </p>
        </div>

        {{-- table here --}}
        <div>
            @livewire('purchasing-request-table')
        </div>

    </div>
@endsection
