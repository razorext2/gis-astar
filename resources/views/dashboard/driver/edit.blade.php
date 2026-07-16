{{-- Goal: Edit Driver Page, Livewire: - (uses native js), Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="grid w-full gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <div class="w-full">
            <header class="flex items-center">
                <x-button.danger href="{{ route('driver.index') }}" class="my-auto me-4 max-h-10" wire:navigate>
                    <x-icons.angle-left class="h-5 w-5" />
                </x-button.danger>

                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('Ubah Driver') }}
                </h2>

            </header>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
            </p>
        </div>

        <div class="w-full">

            <div class="grid gap-4 md:grid-cols-2" id="laporan-content">
                <input id="id" type="hidden" value="{{ $data->id }}" required>

                <div class="{{ $data->kode_pegawai ?? 'hidden' }} col-span-2 w-full lg:col-span-1">
                    <x-input.basic id="kode_pegawai" name="kode_pegawai" value="{{ $data->kode_pegawai ?? '' }}" readonly>
                        Kode Pegawai
                    </x-input.basic>
                </div>

                <div class="{{ $data->user ? '' : 'hidden' }} col-span-2 w-full lg:col-span-1">
                    <x-input.basic id="employee_name" name="employee_name" value="{{ $data->user->name ?? '-' }}" readonly>
                        Nama Pegawai
                    </x-input.basic>
                </div>

                <div class="col-span-2 w-full">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="tipe_kunjungan">
                        Tujuan Perjalanan
                    </label>

                    <select
                        class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="tipe_kunjungan" name="tipe_kunjungan">
                        <option>Pilih Tujuan</option>
                        <option value="ATRBRG" {{ $data->tipe_kunjungan == 'ATRBRG' ? 'selected' : '' }}>Antar Barang
                            (SR)</option>
                        <option value="JPTBRG" {{ $data->tipe_kunjungan == 'JPTBRG' ? 'selected' : '' }}>Jemput Barang
                        </option>
                        <option value="ATRTEK" {{ $data->tipe_kunjungan == 'ATRTEK' ? 'selected' : '' }}>Antar Teknisi
                        </option>
                        <option value="JPTTEK" {{ $data->tipe_kunjungan == 'JPTTEK' ? 'selected' : '' }}>Jemput Teknisi
                        </option>
                        <option value="DLL" {{ $data->tipe_kunjungan == 'DLL' ? 'selected' : '' }}>Lain - Lain
                        </option>
                    </select>
                </div>

                <div class="col-span-2 w-full">
                    <x-input.basic id="title" name="title" value="{{ $data->title }}" placeholder="Judul laporan"
                        required>
                        Judul Laporan
                    </x-input.basic>
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-title"></div>
                </div>

                <div class="col-span-2 w-full">
                    <x-input.basic id="lokasi" name="lokasi" value="{{ $data->lokasi }}"
                        placeholder="Jl. XXX, XXX, XXX" required>
                        Lokasi
                    </x-input.basic>
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-lokasi"></div>
                </div>

                <div class="col-span-2 w-full">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="status_pengantaran">
                        Status Pengantaran
                    </label>

                    <select
                        class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        id="status_pengantaran" name="status_pengantaran">
                        <option>Pilih Status Pengantaran</option>
                        <option value="1" {{ $data->status_pengantaran == 1 ? 'selected' : '' }}>Belum Diterima
                        </option>
                        <option value="2" {{ $data->status_pengantaran == 2 ? 'selected' : '' }}>Sudah Diterima
                        </option>
                    </select>
                </div>

                <div class="col-span-2 w-full">
                    <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Dokumentasi</p>
                    <p class="mb-2 text-xs text-red-500"> *Dokumentasi tidak dapat diubah setelah laporan diinput. </p>

                    @if (count($data->photoCollect))

                        <div class="relative overflow-auto">
                            <div class="flex overflow-x-auto" id="captured-images">

                                <!-- Thumbnail gambar yang diambil akan muncul di sini -->
                                @if ($data->photoCollect)
                                    @foreach ($data->photoCollect as $photo)
                                        <div class="relative me-2 flex-none items-center gap-4 rounded-xl p-2">
                                            <img class="h-36 w-36 rounded-xl object-cover ring-1 ring-zinc-200 transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg dark:ring-zinc-800"
                                                id="documentations"
                                                onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                                data-url="{{ asset($photo->photourl) }}"
                                                src="{{ asset($photo->photourl) }}" alt=""
                                                onclick="javascript:void(0)" loading="lazy">
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    @endif

                    <div class="mt-2 hidden text-sm text-red-500" id="alert-images"></div>
                </div>

                <div class="col-span-2 w-full">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                        for="keterangan">Keterangan</label>
                    <div class="h-32 w-full" id="editor"></div>
                    <input id="keterangan" name="keterangan" type="hidden">
                    <input type="hidden" id="data" value="{{ $data->keterangan }}">
                    <div class="mt-2 hidden text-sm text-red-500" id="alert-keterangan"></div>
                </div>

                <div class="mb-4 hidden text-sm text-red-500" id="alert-coordinate"></div>

                <div class="relative col-span-2 w-full">
                    <x-button.success class="float-right" id="store" type="button">
                        <x-slot name="icon">
                            <x-icons.checklist-stepper class="icon h-5 w-5" />
                        </x-slot>
                        {{ __('Simpan perubahan') }}
                    </x-button.success>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('script')
    @vite(['resources/js/pages/driver/edit.js'])
@endpush
