@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="flex flex-col gap-5">
        {{-- Main Profile Section --}}
        <div
            class="flex flex-col rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
            <div class="flex flex-col gap-6">

                <div class="flex items-center gap-2 border-b border-zinc-200 pb-4 dark:border-zinc-800">
                    <div class="h-2 w-2 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)] dark:bg-red-700"></div>
                    <h3 class="text-base font-bold tracking-wider text-zinc-800 dark:text-white md:text-xl">
                        Informasi Pegawai
                    </h3>
                </div>

                <div
                    class="grid items-start space-y-6 tracking-wide lg:grid-cols-[1.5fr,1fr] lg:space-x-10 lg:space-y-0 xl:space-x-16">

                    {{-- Left Info Area --}}
                    <div class="flex flex-col gap-6">

                        {{-- User Header --}}
                        <div class="flex flex-row items-center gap-x-5">
                            <div class="group relative">
                                <div
                                    class="absolute -inset-0.5 rounded-[0.85rem] bg-gradient-to-br from-red-500 to-red-700 opacity-60 blur-sm transition-opacity duration-500 group-hover:opacity-100 dark:from-red-600/50 dark:to-red-900/50">
                                </div>
                                <img class="relative h-20 w-20 rounded-xl border-2 border-white object-cover shadow-sm dark:border-dark-secondary lg:h-24 lg:w-24"
                                    src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
                                    alt="user photo" loading="lazy"
                                    onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">
                            </div>

                            <div class="flex flex-col gap-y-1">
                                <span
                                    class="w-fit rounded bg-red-50 px-2 py-0.5 text-[0.65rem] font-bold uppercase tracking-widest text-red-600 dark:bg-red-500/10 dark:text-red-400">
                                    {{ auth()->user()->roles->first()->name ?? 'User' }}
                                </span>
                                <h4 class="text-xl font-black text-zinc-900 dark:text-white lg:text-2xl">
                                    {{ auth()->user()->name }}</h4>
                                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                                    {{ auth()->user()->bio ?? 'Biografi belum disetel' }}</p>
                            </div>
                        </div>

                        {{-- Data Lists --}}
                        <div class="mt-2 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="flex flex-col gap-y-4">
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        Kode Jari</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ $data->kode_pegawai ?? '—' }}</dd>
                                </dl>
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        NIK Pegawai</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ $data->nik_pegawai ?? '—' }}</dd>
                                </dl>
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        Nama Panggilan</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ $data->nick_name ?? '—' }}</dd>
                                </dl>
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        Gender</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ $data->gender ?? '—' }}</dd>
                                </dl>
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        Tanggal Lahir</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ optional($data)->tgl_lahir ? \Carbon\Carbon::parse($data->tgl_lahir)->translatedFormat('d F Y') : '—' }}
                                    </dd>
                                </dl>
                            </div>

                            <div class="flex flex-col gap-y-4">
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        No. Telp/WA</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ $data->no_telp ?? '—' }}</dd>
                                </dl>
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        Alamat</dt>
                                    <dd class="mt-1 text-sm font-medium leading-relaxed text-zinc-800 dark:text-zinc-300">
                                        {{ $data->alamat ?? '—' }}</dd>
                                </dl>
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        Jabatan</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ $data->jabatanRelasi->nama_jabatan ?? '—' }}</dd>
                                </dl>
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        Golongan</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ $data->golonganRelasi->nama_golongan ?? '—' }}</dd>
                                </dl>
                                <dl>
                                    <dt
                                        class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                        Storage</dt>
                                    <dd class="mt-1 text-sm font-medium text-zinc-800 dark:text-zinc-300">
                                        {{ $data->storage ?? '—' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    {{-- Right Info Area : Permissions --}}
                    <div
                        class="h-full rounded-xl bg-zinc-50 p-4 shadow ring-1 ring-zinc-200 dark:bg-dark-secondary dark:ring-zinc-800 lg:p-6">
                        <div class="flex flex-col space-y-3">
                            <div class="flex items-center gap-2">
                                <x-icons.badge-check class="h-5 w-5 text-zinc-400 dark:text-zinc-500" />
                                <p class="text-sm font-bold text-zinc-700 dark:text-zinc-300">Hak Akses (Permissions)</p>
                            </div>

                            <div
                                class="custom-scrollbar mt-1 flex max-h-80 min-h-72 flex-row flex-wrap content-start gap-1.5 overflow-y-auto pr-2">
                                @forelse (auth()->user()->getPermissionsViaRoles() as $permission)
                                    <span
                                        class="w-fit rounded-md border border-zinc-200 bg-white px-2.5 py-1 text-xs font-medium text-zinc-600 shadow-sm transition hover:border-red-300 hover:text-red-700 dark:border-zinc-700 dark:bg-dark-primary dark:text-zinc-400 dark:hover:border-red-500 dark:hover:text-red-400">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <p class="text-xs italic text-zinc-500">Tidak ada permission.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Bottom Sections --}}
        <div class="flex flex-col items-stretch gap-4 lg:flex-row">

            {{-- Call To Action Widget --}}
            <div
                class="group relative flex-1 content-center overflow-hidden rounded-xl bg-gradient-to-br from-red-600 to-red-800 px-6 py-10 shadow-md shadow-red-200 ring-1 ring-red-500/50 dark:from-dark-secondary dark:to-dark-primary dark:shadow-none dark:ring-zinc-800">
                {{-- Decorative background glow --}}
                <div
                    class="absolute -right-12 -top-12 h-44 w-44 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-150 dark:bg-red-900/10"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                </div>

                <div class="relative z-10 flex flex-col items-center gap-y-4">
                    <div
                        class="rounded-full p-4 dark:border dark:border-zinc-700 dark:bg-dark-secondary/50"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                        <x-icons.file-pen class="h-10 w-10 text-white drop-shadow-sm dark:text-red-400" />
                    </div>

                    <div class="text-center">
                        <h3 class="text-xl font-bold tracking-wide text-white drop-shadow-sm lg:text-2xl">Mulai buat
                            laporanmu!</h3>
                        <p class="mx-auto mt-2 max-w-sm text-sm text-red-100 dark:text-zinc-400">
                            Pelaporan yang konsisten mempermudah koordinasi dan tata kelola data sistem secara menyeluruh.
                        </p>
                    </div>

                    <div class="mt-2 flex w-full flex-wrap justify-center gap-3">
                        @can('collect-create')
                            <x-button.link href="{{ route('collect.index') }}"
                                class="w-full min-w-[140px] justify-center border-none !bg-white font-semibold !text-red-700 drop-shadow-sm hover:!bg-red-50 dark:!border-zinc-700 dark:!bg-dark-primary dark:!text-white dark:hover:!border-red-500 sm:w-auto">
                                <x-slot name="icon">Koletor</x-slot>
                                <x-icons.arrow-right class="h-4 w-4 -rotate-45" />
                            </x-button.link>
                        @endcan
                        @can('driver-create')
                            <x-button.link href="{{ route('driver.create') }}"
                                class="w-full min-w-[140px] justify-center border-none !bg-white font-semibold !text-red-700 drop-shadow-sm hover:!bg-red-50 dark:!border-zinc-700 dark:!bg-dark-primary dark:!text-white dark:hover:!border-red-500 sm:w-auto">
                                <x-slot name="icon">Driver</x-slot>
                                <x-icons.arrow-right class="h-4 w-4 -rotate-45" />
                            </x-button.link>
                        @endcan
                        @can('sales-create')
                            <x-button.link href="{{ route('sales.create') }}"
                                class="w-full min-w-[140px] justify-center border-none !bg-white font-semibold !text-red-700 drop-shadow-sm hover:!bg-red-50 dark:!border-zinc-700 dark:!bg-dark-primary dark:!text-white dark:hover:!border-red-500 sm:w-auto">
                                <x-slot name="icon">Sales</x-slot>
                                <x-icons.arrow-right class="h-4 w-4 -rotate-45" />
                            </x-button.link>
                        @endcan
                        @can('technician-create')
                            <x-button.link href="{{ route('technician.index') }}"
                                class="w-full min-w-[140px] justify-center border-none !bg-white font-semibold !text-red-700 drop-shadow-sm hover:!bg-red-50 dark:!border-zinc-700 dark:!bg-dark-primary dark:!text-white dark:hover:!border-red-500 sm:w-auto">
                                <x-slot name="icon">Teknisi</x-slot>
                                <x-icons.arrow-right class="h-4 w-4 -rotate-45" />
                            </x-button.link>
                        @endcan
                    </div>
                </div>
            </div>

            {{-- Calendar Widget --}}
            @if (auth()->user()->kode_pegawai)
                <div
                    class="flex-1 items-start rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-dark-primary">
                    @livewire('utils.attendance-calendar')
                </div>
            @endif
        </div>

    </div>
@endsection
