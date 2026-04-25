<div class="flex flex-col gap-4 lg:gap-6 xl:flex-row">
    <div class="relative grow">
        <div class="relative flex w-full flex-col gap-2 rounded-lg ring-1 ring-zinc-200 dark:ring-0">
            <video id="video" class="min-h-96 rounded-lg bg-dark-primary lg:min-h-[460px]"
                style="background: url('{{ asset('assets/img/noCamera.webp') }}') center center / cover no-repeat;"></video>
            <canvas id="canvas" class="absolute left-0 top-0 h-full w-full rounded-lg"></canvas>
        </div>

        <div class="absolute bottom-4 flex w-full justify-center px-2">
            <x-button.primary id="snap" class="!z-40 !w-fit !rounded-lg !p-2 !ring-0">
                <x-slot name="icon">
                    <x-icons.video-camera class="h-5 w-5" />
                </x-slot>
                Mulai Kamera
            </x-button.primary>
        </div>
    </div>

    <div class="flex flex-col gap-2">
        <p class="text-xl font-bold text-black dark:text-white">INFORMASI</p>
        <div
            class="relative flex h-auto w-full flex-col rounded-lg p-4 leading-normal ring-1 ring-zinc-200 dark:ring-zinc-800">

            <ul class="space-y-4 text-left text-gray-500 dark:text-white">
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <x-icons.check class="h-3.5 w-3.5 flex-shrink-0 text-green-500" />
                    <span>
                        Lokasi:
                        <span id="longitude"></span>, <span id="latitude"></span>
                    </span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <x-icons.check class="h-3.5 w-3.5 flex-shrink-0 text-green-500" />
                    <span>Kode Pegawai: {{ Auth::user()->kode_pegawai ?? 'N/A' }} </span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <x-icons.check class="h-3.5 w-3.5 flex-shrink-0 text-green-500" />
                    <span>Nama: {{ Auth::user()->name ?? 'N/A' }}</span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <x-icons.check class="h-3.5 w-3.5 flex-shrink-0 text-green-500" />
                    <span>Jabatan: {{ Auth::user()->pegawai->jabatanRelasi->nama_jabatan ?? 'N/A' }}</span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <x-icons.check class="h-3.5 w-3.5 flex-shrink-0 text-green-500" />
                    <span>Golongan: {{ Auth::user()->pegawai->golonganRelasi->nama_golongan ?? 'N/A' }}</span>
                </li>
            </ul>

        </div>
    </div>
</div>
