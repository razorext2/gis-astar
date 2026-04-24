@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6 xl:w-6/12 2xl:w-1/3">
        <div
            class="rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 sm:p-6">
            <div class="max-w-xl">
                <header class="flex flex-row gap-x-3">
                    <div class="max-w-xs">
                        <x-button.link class="w-fit ring-1 ring-red-700 dark:bg-red-800 dark:text-white"
                            href="{{ route('division.index') }}" wire:navigate>
                            <x-slot name="icon">
                                <x-icons.angle-left class="h-6 w-6 text-red-500 dark:text-white" />
                            </x-slot>
                            Kembali
                        </x-button.link>
                    </div>
                    <h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('Tambah Data Divisi') }}
                    </h2>

                </header>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
                </p>

                <form class="mt-4" action="{{ route('division.store') }}" method="POST">
                    @csrf
                    <div class="mb-4 grid gap-6 sm:mb-5 sm:gap-6">
                        <div class="w-full">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="kode_divisi">Kode Divisi</label>
                            <input
                                class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-zinc-200 p-2.5 text-sm text-gray-900"
                                id="kode_divisi" name="kode_divisi" type="text" placeholder="Kode Divisi" required="">
                        </div>
                        <div class="w-full">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="divisi">Nama
                                Divisi</label>
                            <input
                                class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-zinc-200 bg-white p-2.5 text-sm text-gray-900"
                                id="divisi" name="divisi" type="text" placeholder="Divisi" required="">
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button
                            class="inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 hover:bg-blue-800 hover:text-white focus:text-white focus:ring-4 focus:ring-blue-300 dark:bg-blue-800 dark:text-white dark:ring-zinc-800 dark:hover:bg-blue-900"
                            type="submit">
                            Submit
                            <svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
