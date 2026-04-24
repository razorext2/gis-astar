@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6">
        <div
            class="grid gap-4 rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 sm:p-6">

            <div class="w-full">
                <header class="flex flex-row gap-x-4">

                    <div class="max-w-xs">
                        <x-button.danger href="{{ route('driver.index') }}" wire:navigate>
                            <x-slot name="icon">
                                <x-icons.angle-left class="h-6 w-6" />
                            </x-slot>
                            {{ __('Kembali') }}
                        </x-button.danger>
                    </div>

                    <h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('Tambah Laporan Driver') }}
                    </h2>

                </header>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
                </p>
            </div>

            <div class="w-full">

                <div class="grid gap-4 md:grid-cols-2" id="laporan-content">
                    <div class="col-span-2 w-full lg:col-span-1">
                        <x-input.basic id="kode_pegawai" name="kode_pegawai"
                            value="{{ Auth::user()->kode_pegawai ?? '28101999' }}" readonly>
                            Kode Pegawai
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 w-full lg:col-span-1">
                        <x-input.basic id="employee_name" name="employee_name"
                            value="{{ Auth::user()->name ?? 'Superadmin' }}" readonly>
                            Nama Pegawai
                        </x-input.basic>
                    </div>

                    <div class="col-span-2 w-full">
                        <x-input.select id="tipe_kunjungan" name="tipe_kunjungan" :defaultOption="'Pilih Tujuan Perjalanan'" :options="[
                            'JPTBRG' => 'Jemput Barang',
                            'ATRTEK' => 'Antar Teknisi',
                            'JPTTEK' => 'Jemput Teknisi',
                            'DLL' => 'Lain - Lain',
                        ]">
                            <x-slot name="textLabel">Tujuan Perjalanan</x-slot>
                        </x-input.select>
                    </div>

                    <div class="col-span-2 w-full">
                        <x-input.basic id="title" name="title" placeholder="Kunjungan ke toko xxx" required>
                            Judul Laporan
                        </x-input.basic>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-title"></div>
                    </div>

                    <div class="col-span-2 w-full">
                        <x-input.basic id="lokasi" name="lokasi" placeholder="Jl. XXXX" required>
                            Lokasi
                        </x-input.basic>
                        <div class="mt-2 hidden text-sm text-red-500" id="alert-lokasi"></div>
                    </div>

                    <div class="col-span-2 w-full">
                        <x-input.select id="status_pengantaran" name="status_pengantaran" :defaultOption="'Pilih Status Pengantaran'"
                            :options="[
                                1 => 'Belum Diterima',
                                2 => 'Sudah Diterima',
                            ]" :labels="true" :textLabel="'Status Pengantaran'" />
                    </div>

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
                            </div>
                        </div>

                        <div class="mt-2 hidden text-sm text-red-500" id="alert-images"></div>
                    </div>

                    <div class="col-span-2 w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="keterangan">Keterangan</label>

                        <x-input.textarea id="keterangan" name="keterangan" :labels="false" :rows="15" />

                        <div class="mt-2 hidden text-sm text-red-500" id="alert-keterangan"></div>
                    </div>
                    <input class="w-full rounded-lg border border-zinc-200 bg-gray-400 p-2.5 text-sm text-gray-900"
                        id="longitude" name="longitude" type="hidden" readonly>

                    <input class="w-full rounded-lg border border-zinc-200 bg-gray-400 p-2.5 text-sm text-gray-900"
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
    @vite(['resources/js/pages/driver/add.js'])
@endpush
