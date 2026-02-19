<div class="grid w-full grid-cols-1 gap-y-4">

    <div class="flex w-full flex-col items-center gap-2 md:flex-row lg:gap-4">
        @php
            $options = [];

            $user = auth()->user();

            if ($user->can('sales-export-medan') || $user->can('attendance-approve')) {
                $options['Sales'] = 'Sales Medan';
            }

            if ($user->can('sales-export-agrotec') || $user->can('attendance-approve')) {
                $options['Sales-Agrotec'] = 'Sales Agrotec';
            }

            if ($user->can('sales-export-pku') || $user->can('attendance-approve')) {
                $options['Sales-PKU'] = 'Sales Pekanbaru';
            }

            if ($user->can('sales-export-jkt') || $user->can('attendance-approve')) {
                $options['Sales-JKT'] = 'Sales Jakarta';
            }

            if ($user->can('sales-export-idy') || $user->can('attendance-approve')) {
                $options['Sales-IDY'] = 'Sales Indodaya';
            }

            if ($user->can('sales-export-kurir-bank') || $user->can('attendance-approve')) {
                $options['Kurir-Bank'] = 'Kurir Bank';
            }

            if ($user->can('driver-list-jkt') || $user->can('driver-approve') || $user->can('attendance-approve')) {
                $options['Driver-Jkt'] = 'Driver Jakarta';
            }

            if ($user->can('driver-list-medan') || $user->can('driver-approve') || $user->can('attendance-approve')) {
                $options['Driver-Medan'] = 'Driver Medan';
            }

            if ($user->can('attendance-approve')) {
                $options['Employee'] = 'Karyawan';
            }

            if ($user->can('technician-approve') || $user->can('attendance-approve')) {
                $options['Teknisi'] = 'Teknisi';
            }

            if ($user->can('spk-list') || $user->can('attendance-approve')) {
                $options['Mekanik'] = 'Mekanik';
            }
        @endphp

        <x-input.select wire:model.live="role" :labels="false" id="role" name="role" :defaultOption="'Pilih Role'"
            placeholder="Role" :options="$options" />

        <input type="date" wire:model.live="date"
            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
    </div>

    <div class="flex w-full flex-col gap-2 lg:gap-4" wire:poll.300s>
        <div class="grid grid-cols-1 gap-2 lg:gap-4 xl:grid-cols-2">
            @forelse ($data as $index => $row)
                @php
                    $storage_path = "labels/{$row->pegawaiRelasi->kode_pegawai}/capturedImg/{$row->photoURL}.png";
                    $img_check = Storage::disk('public')->exists($storage_path);
                    $image_path = asset(sha1('libs') . '/' . $row->photoURL . '.png');
                    $no_image_path = asset('assets/img/noImage.webp');
                @endphp

                <div wire:click="openModal({{ $row->id }})"
                    class="relative flex cursor-pointer flex-col items-center rounded-lg border-gray-200 ring-1 ring-gray-200 transition-transform duration-300 hover:scale-95 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-700 dark:ring-0 dark:hover:bg-gray-700 lg:flex-row">

                    @php $lateDuration = $this->getLateDuration($row->waktuori); @endphp

                    @if ($lateDuration)
                        <span class="absolute right-2 top-2 rounded-lg bg-red-800 px-2 py-1 text-xs text-white">
                            - {{ $lateDuration }}
                        </span>
                    @endif

                    <img class="h-44 w-full rounded-t-lg object-cover lg:h-full lg:w-48 lg:rounded-none lg:rounded-s-lg xl:h-44 xl:w-44"
                        src="{{ $img_check ? $image_path : $no_image_path }}" alt=""
                        onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">

                    <div class="flex flex-col justify-between gap-y-1 p-4 leading-normal">
                        <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white lg:text-xl">
                            {{ $row->pegawaiRelasi->full_name }}
                        </h5>
                        <p class="text-sm text-gray-700 dark:text-gray-400">
                            Melakukan <span class="text-red-400">checkout</span> pada pukul
                            <span class="text-red-400">{{ \Carbon\Carbon::parse($row->waktuori)->format('H:i:s') }}
                                ({{ $row->timezone ?? '-' }})
                            </span>
                        </p>
                        @if ($row->keterangan)
                            <div class="flex w-full flex-row items-center gap-x-1">

                                @if ($row->position_status == 1)
                                    <x-icons.exclamation-circle class="h-4 w-4 text-yellow-500" />
                                @elseif($row->position_status == 2)
                                    <x-icons.check-circle class="h-4 w-4 text-red-500" />
                                @elseif($row->position_status == 3)
                                    <x-icons.minus-circle class="h-4 w-4 text-red-500" />
                                @else
                                    <x-icons.question-circle class="h-4 w-4 text-gray-500" />
                                @endif

                                <p class="w-fit text-wrap text-justify text-sm text-gray-700 dark:text-gray-400">
                                    {{ $row->keterangan }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="col-span-2 w-full text-center text-gray-800 dark:text-white"> Belum ada data. </p>
            @endforelse
        </div>

        <div class="col-span-2 w-full">
            {{ $data->links() }}
        </div>

    </div>

    <div wire:show="showModalOut" wire:click="set('showModalOut', false)" wire:transition.duration.300ms
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
        @if ($showModalOut)
            <!-- Modal box -->
            <div
                class="mx-2 flex flex-col gap-2 rounded-xl bg-white p-4 shadow-2xl dark:bg-gray-800 sm:mx-0 md:w-1/3 lg:p-6">
                <h2 class="text-center text-2xl font-semibold text-gray-900 dark:text-white lg:text-3xl">Detail
                </h2>
                <div class="flex w-full flex-col gap-2 text-gray-800 dark:text-white">

                    <div class="h-72 lg:h-96">
                        <img onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}'"
                            class="h-full w-full rounded-md object-cover"
                            src="{{ asset(sha1('libs') . '/' . $attendance->photoURL . '.png') }}" alt="">
                    </div>

                    <a href="{{ route('pegawai.detail', $attendance->pegawaiRelasi->id) }}" target="_blank"
                        class="w-fit text-lg font-semibold hover:underline lg:text-2xl">
                        {{ $attendance->pegawaiRelasi->full_name }}
                    </a>
                    <p class="text-sm text-gray-700 dark:text-gray-400">Melakukan <span
                            class="text-red-400">checkout</span> pada
                        pukul
                        <span
                            class="text-green-400">{{ \Carbon\Carbon::parse($attendance->waktuori)->format('H:i:s') }}
                            ({{ $attendance->timezone ?? '-' }})</span> di
                        <span class="text-green-400">{{ $address }}</span>
                    </p>

                    <a class="flex flex-row"
                        href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                        target="_blank">Lihat lokasi <x-icons.arrow-right class="ml-1 h-5 w-5 -rotate-45" /></a>

                    <div class="flex justify-between">
                        <p class="text-xs">Coord: {{ $attendance->latitude }}, {{ $attendance->longitude }} </p>
                        <p class="text-xs">Created at: {{ $attendance->created_at }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <x-button.primary class="w-full justify-center" wire:click="set('showModalOut', false)">
                        Ok
                    </x-button.primary>
                </div>
            </div>
        @endif
    </div>
</div>
