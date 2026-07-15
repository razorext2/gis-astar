@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none sm:p-6 md:max-w-lg lg:max-w-xl xl:max-w-2xl"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <div>
            <span class="text-xl font-semibold text-gray-900 dark:text-white">
                Tambah Event
            </span>

            <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                Silahkan isi data event sesuai dengan form yang diberikan.
            </p>
        </div>

        <form method="POST" action="{{ route('event.store') }}" class="grid grid-cols-2 gap-4">
            @csrf
            <div class="col-span-2 w-full">
                <x-input.basic id="event_name" class="@error('event_name') border-red-500 @enderror" required name="event_name"
                    placeholder="Nama Event" value="{{ old('event_name') }}">
                    Nama Event
                </x-input.basic>

                @error('event_name')
                    <span class="error text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2 w-full">
                <x-input.basic id="location" class="@error('location') border-red-500 @enderror" required name="location"
                    placeholder="Lokasi" value="{{ old('location') }}">
                    Lokasi Event Diselenggarakan
                </x-input.basic>

                @error('location')
                    <span class="error text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label for="start_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Mulai</label>

                <input
                    class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    type="date" id="start_date" required name="start_date" placeholder="Tanggal Mulai"
                    value="{{ old('start_date') }}">

                @error('start_date')
                    <span class="error text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label for="end_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tanggal
                    Selesai</label>

                <input
                    class="block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    type="date" id="end_date" required name="end_date" placeholder="Tanggal Selesai"
                    value="{{ old('end_date') }}">

                @error('end_date')
                    <span class="error text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 flex w-full flex-col">
                <label for="description" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                    Event</label>
                <x-input.textarea id="description" class="@error('description') border-red-500 @enderror" required
                    name="description" :labels="false"
                    placeholder="Deskripsi event">{{ old('description') }}</x-input.textarea>

                @error('description')
                    <span class="error text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 w-full">
                <x-input.select labels="true" textLabel="Status Event" class="@error('status') border-red-500 @enderror"
                    id="status" required name="status" :defaultOption="'Pilih Status'" :options="[
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'ongoing' => 'Sedang Berlangsung',
                    ]"
                    value="{{ old('status') }}" />

                @error('status')
                    <span class="error text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative col-span-2 w-full">
                <x-button.primary class="float-right" id="store" type="submit">
                    <x-slot name="icon">
                        <x-icons.angle-right class="icon h-5 w-5" />
                    </x-slot>
                    Simpan Data
                </x-button.primary>
            </div>
        </form>
    </div>
@endsection
