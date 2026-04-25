<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    {{-- Scanner Section (Large) --}}
    <div class="lg:col-span-2" data-aos="zoom-in" data-aos-delay="100">
        <div class="relative h-[32rem] w-full overflow-hidden rounded-2xl bg-zinc-100 shadow-inner dark:bg-black">
            {{-- Default State Image --}}
            <div class="absolute inset-0 flex items-center justify-center bg-cover bg-center bg-no-repeat grayscale"
                style="background-image: url('{{ asset('assets/img/noCamera.webp') }}');">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
            </div>

            {{-- Local Video Feed --}}
            <video id="video" class="absolute left-0 top-0 h-full w-full scale-x-[-1] object-cover" autoplay></video>

            {{-- Canvas Overlay --}}
            <canvas id="canvas" class="absolute inset-0 z-10 h-full w-full object-cover"></canvas>

            {{-- Technical Viewfinder Overlays --}}
            <div class="pointer-events-none absolute inset-0 z-20">
                {{-- Corners --}}
                <div class="absolute left-6 top-6 h-8 w-8 border-l-4 border-t-4 border-red-500/60"></div>
                <div class="absolute right-6 top-6 h-8 w-8 border-r-4 border-t-4 border-red-500/60"></div>
                <div class="absolute bottom-6 left-6 h-8 w-8 border-b-4 border-l-4 border-red-500/60"></div>
                <div class="absolute bottom-6 right-6 h-8 w-8 border-b-4 border-r-4 border-red-500/60"></div>

                {{-- Scanning Line Animation --}}
                <div
                    class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-transparent via-red-500 to-transparent opacity-30 shadow-[0_0_15px_rgba(239,68,68,0.5)]">
                </div>
            </div>
        </div>

        {{-- Action Control --}}
        <div class="mt-6">
            <x-button.primary id="snap" class="group w-full !py-4 !text-lg !shadow-xl">
                <x-slot name="icon">
                    <x-icons.video-camera class="h-5 w-5 transition-transform group-hover:scale-110" />
                </x-slot>
                MULAI KAMERA RUTE
            </x-button.primary>
        </div>
    </div>

    {{-- Information Panel --}}
    <div class="flex flex-col gap-6" data-aos="fade-left" data-aos-delay="200">
        <div class="space-y-4 rounded-xl bg-zinc-100 p-5 ring-1 ring-zinc-200 dark:bg-zinc-800/30 dark:ring-zinc-800">
            <div class="space-y-4">
                {{-- Data Items --}}
                <div
                    class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Lokasi Koordinat</span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">
                        <span id="longitude"></span>, <span id="latitude"></span>
                    </span>
                </div>

                <div
                    class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Kode Pegawai</span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">
                        {{ Auth::user()->kode_pegawai ?? 'N/A' }}
                    </span>
                </div>

                <div
                    class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Nama Lengkap</span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">
                        {{ Auth::user()->name ?? 'N/A' }}
                    </span>
                </div>

                <div
                    class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Jabatan</span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">
                        {{ Auth::user()->pegawai->jabatanRelasi->nama_jabatan ?? 'N/A' }}
                    </span>
                </div>

                <div
                    class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Golongan</span>
                    <span class="text-sm font-bold text-zinc-700 dark:text-zinc-200">
                        {{ Auth::user()->pegawai->golonganRelasi->nama_golongan ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Footer Insight --}}
        <div class="rounded-lg bg-red-50 p-3 text-[10px] text-red-600 dark:bg-red-900/10 dark:text-red-400">
            <strong>SISTEM RUTE:</strong> Posisi Anda akan dipetakan secara *realtime* untuk verifikasi absensi dinamis.
        </div>
    </div>
</div>
