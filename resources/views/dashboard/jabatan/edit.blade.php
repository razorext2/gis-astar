@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6 xl:w-6/12 2xl:w-1/3">
        <div
            class="rounded-xl bg-white/60 p-4 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 sm:p-6">
            <div class="max-w-xl">
                <header class="flex flex-row">
                    <x-button.danger href="{{ route('jabatan.index') }}" class="mb-4 mr-3">
                        <x-slot name="icon">
                            <x-icons.angle-left class="h-6 w-6" />
                        </x-slot>
                        {{ __('Kembali') }}
                    </x-button.danger>
                    <h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('Edit Data Jabatan') }}
                    </h2>

                </header>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
                </p>

                <form class="mt-4" action="{{ route('jabatan.update', $jabatan) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="mb-4 grid gap-6 sm:mb-5 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="nama_jabatan">Nama
                                Jabatan</label>
                            <input
                                class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-zinc-200 p-2.5 text-sm text-gray-900"
                                id="nama_jabatan" name="nama_jabatan" type="text" value="{{ $jabatan->nama_jabatan }}"
                                placeholder="Nama Jabatan" required="">
                        </div>
                        <div class="w-full">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="divisi">Divisi</label>
                            <select
                                class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-zinc-200 bg-white p-2.5 text-sm text-gray-900"
                                id="divisi" name="divisi">
                                <option selected>Pilih</option>
                                @foreach ($division as $data)
                                    <option value="{{ $data->id }}" @if ($data->id == $jabatan->divisi) selected @endif>
                                        {{ $data->nama_divisi }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="w-full">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                for="penempatan">Penempatan</label>
                            <select
                                class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-zinc-200 bg-white p-2.5 text-sm text-gray-900"
                                id="penempatan" name="penempatan">
                                <option selected>Pilih</option>
                                @foreach ($placement as $data)
                                    <option value="{{ $data->id }}" @if ($data->id == $jabatan->penempatan) selected @endif>
                                        {{ $data->penempatan }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                    <div class="flex items-center">
                        <x-button.success type="submit">
                            {{ __('Update') }}
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
