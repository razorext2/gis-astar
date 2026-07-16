@extends('dashboard.collect-task.index')
@section('subcontent')
    <div class="flex h-auto items-center justify-center">
        <div class="grid w-full grid-cols-2 gap-2 rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 dark:shadow-none md:gap-4 md:p-6"
            x-bind:class="dynamicBg ?
                'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

            {{-- filter --}}
            <div class="col-span-2 mb-4">
                <x-filter.filter-bar>
                    @can('collect-approve')
                        <div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
                            <x-filter.filter-input-text id="no_sr" name="kode-pegawai" :text="'no SR'">
                                <x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                            </x-filter.filter-input-text>
                        </div>
                    @endcan

                    <div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
                        <x-filter.filter-input-text id="customer_name" name="customer_name" :text="'nama customer'">
                            <x-icons.font-case class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                        </x-filter.filter-input-text>
                    </div>

                    <div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
                        <x-filter.filter-input-select id="sr_type" name="sr_type" :options="[
                            'TTT' => 'Tanda Terima Tagihan',
                            'TTST' => 'Tanda Terima Sertifikat Tera',
                            'AT' => 'Ambil Tagihan',
                            'ABL' => 'Antar Bon Lunas',
                        ]"
                            default-option="Filter by SR type" />
                    </div>

                    <div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
                        <x-filter.date-range />
                    </div>

                </x-filter.filter-bar>
            </div>
            {{-- end filter --}}

            <div class="col-span-2" x-data="{ openRow: null }">
                <x-dashboard.table id="dataTable" data-url="{{ route('collect-task.showdata') }}" :tablename="[
                    '0' => '#',
                    '1' => 'Aksi',
                    '2' => 'Tipe',
                    '3' => 'Nama Customer',
                    '4' => 'Jadwal',
                    '5' => 'Tagihan',
                    '6' => 'Kontak',
                ]" />
            </div>
        </div>
    </div>
@endsection
