@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full space-y-6">
        <div
            class="rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none sm:p-6">
            <div class="w-full">
                <header class="flex items-center">

                    <x-button.danger class="my-auto me-4 max-h-10" href="{{ route('dayoff.index') }}" wire:navigate>
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.danger>

                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('Edit Pengajuan Off') }}
                    </h2>

                </header>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
                </p>

                <div class="mb-4 grid grid-cols-2 gap-6 sm:mb-5 sm:gap-6">
                    <input id="id" name="id" type="hidden" value="{{ $data->id ?? 'N/A' }}">

                    <div class="w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="kode_pegawai">Kode
                            Pegawai</label>
                        <input
                            class="block w-full cursor-not-allowed rounded-lg border border-zinc-200 p-2.5 text-sm text-gray-900 dark:border-zinc-800 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                            id="kode_pegawai" name="kode_pegawai" type="text"
                            value="{{ old('kode_pegawai', $data->kode_pegawai) }}" placeholder="Kode pegawai" readonly>
                    </div>

                    <div class="w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="name">Nama
                            Pegawai</label>
                        <input class="block w-full rounded-lg border border-zinc-200 bg-white p-2.5 text-sm text-gray-900"
                            id="name" name="name" type="text"
                            value="{{ old('full_name', $data->pegawaiRelasi->full_name) }}" placeholder="Nama karyawan.."
                            readonly>
                        <div class="autocomplete-results" id="autocomplete-results"></div>
                    </div>

                    <div class="col-span-2 w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                            for="dayoff_for">Peruntukan</label>
                        <select
                            class="focus:ring-primary-500 focus:border-primary-500 block w-full rounded-lg border border-zinc-200 bg-white p-2.5 text-sm text-gray-900"
                            id="dayoff_for" name="dayoff_for">
                            <option selected>Pilih</option>
                            <option value="Izin" @if ($data->dayoff_for == 'Izin') selected @endif> Izin </option>
                            <option value="Sakit" @if ($data->dayoff_for == 'Sakit') selected @endif> Sakit </option>
                            <option value="Absen" @if ($data->dayoff_for == 'Absen') selected @endif> Absen </option>
                            <option value="PC" @if ($data->dayoff_for == 'PC') selected @endif> Pulang Cepat
                            </option>
                        </select>
                        <div class="mt-2 text-sm text-red-500" id="alert-dayoff_for"></div>
                    </div>

                    <div class="w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="start-time">Start
                            time:</label>
                        <input
                            class="block w-full rounded-lg border border-zinc-200 bg-white p-2.5 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-white dark:text-gray-800 dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="tgl_dari" name="tgl_dari" type="datetime-local"
                            value="{{ old('tgl_dari', $data->tgl_dari) }}" required />
                        <div class="mt-2 text-sm text-red-500" id="alert-tgl_dari"></div>
                    </div>

                    <div class="w-full">
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="end-time">End
                            time:</label>
                        <input
                            class="block w-full rounded-lg border border-zinc-200 bg-white p-2.5 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-white dark:text-gray-800 dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            id="tgl_hingga" name="tgl_hingga" type="datetime-local"
                            value="{{ old('tgl_hingga', $data->tgl_hingga) }}" required />
                        <div class="mt-2 text-sm text-red-500" id="alert-tgl_hingga"></div>
                    </div>
                </div>

                <div class="mb-4 w-full">
                    <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Lampiran</p>
                    <p class="mb-2 text-xs text-red-500"> *Lampiran tidak dapat diubah setelah pengajuan diajukan. Lampiran
                        dapat
                        berisi surat sakit, surat izin, surat absen, atau surat pulang cepat. </p>

                    @php
                        $urls = json_decode($data->url, true);
                    @endphp

                    <div class="flex items-center">
                        @foreach ($urls as $url => $key)
                            <img src="{{ $key }}" alt=""
                                class="w-56 rounded-lg transition-transform duration-300 hover:scale-110">
                        @endforeach
                    </div>

                </div>

                <div class="relative mb-4 w-full">
                    <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                        Keterangan
                    </label>
                    <div class="h-32 w-full" id="editor"></div>
                    <input id="keterangan" name="keterangan" type="hidden">
                    <input type="hidden" id="data" value="{{ $data->keterangan }}">
                    <div class="mt-2 text-sm text-red-500" id="alert-keterangan"></div>
                    <div class="mt-2 text-sm text-red-500" id="alert-image"></div>
                </div>

                <div class="relative w-full">

                    <x-button.primary id="store" type="button">
                        <x-slot name="icon">
                            <x-icons.angle-right class="h-5 w-5 text-blue-500 dark:text-white" />
                        </x-slot>
                        Submit
                    </x-button.primary>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    @vite('resources/js/pages/dayoff/edit.js')
@endpush
