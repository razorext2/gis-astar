@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6 xl:w-6/12 2xl:w-1/3">
        <div
            class="rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 sm:p-6">
            <div class="max-w-xl">
                <header class="flex flex-row gap-x-3">
                    <div class="max-w-xs">
                        <x-button.danger href="{{ route('division.index') }}" wire:navigate>
                            <x-slot name="icon">
                                <x-icons.angle-left class="h-6 w-6" />
                            </x-slot>
                            {{ __('Kembali') }}
                        </x-button.danger>
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
                        <x-button.success type="submit">
                            {{ __('Submit') }}
                            <x-slot name="icon">
                                <x-icons.checklist-stepper class="h-5 w-5" />
                            </x-slot>
                        </x-button.success>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
