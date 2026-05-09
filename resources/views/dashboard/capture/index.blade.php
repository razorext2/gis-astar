@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative overflow-hidden rounded-xl bg-white/60 p-4 text-zinc-900 shadow-2xl ring-1 ring-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:text-white dark:ring-zinc-800 md:p-6"
        id="Scan" data-aos="fade-up">

        {{-- Background Decoration --}}
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-red-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"></div>

        <div class="relative grid h-auto w-full grid-cols-1 gap-4 lg:grid-cols-3">

            {{-- Scanner Section (Large) --}}
            <div class="lg:col-span-2" data-aos="zoom-in" data-aos-delay="100">
                <div class="relative h-[32rem] w-full overflow-hidden rounded-2xl bg-zinc-100 shadow-inner dark:bg-black">
                    {{-- Default State Image --}}
                    <div class="absolute inset-0 flex items-center justify-center bg-cover bg-center bg-no-repeat grayscale"
                        style="background-image: url('{{ asset('assets/img/noCamera.webp') }}');">
                        <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
                    </div>

                    {{-- Local Video Feed --}}
                    <video id="video" class="absolute left-0 top-0 h-full w-full scale-x-[-1] object-cover"
                        autoplay></video>

                    {{-- Face Recognition Canvas Overlay --}}
                    <canvas class="absolute inset-0 z-10 h-full w-full object-cover" id="canvas"></canvas>

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

                {{-- Action Controls --}}
                <div class="mt-4 flex flex-col gap-4">
                    <x-button.primary class="group w-full !py-4 !text-lg" id="startButton">
                        <x-slot name="icon">
                            <x-icons.play class="h-5 w-5 transition-transform group-hover:scale-110" />
                        </x-slot>
                        MULAI SCAN WAJAH
                    </x-button.primary>

                    <div id="error"
                        class="hidden rounded-xl border border-red-200 bg-red-50 p-4 text-center text-sm font-semibold text-red-600 shadow-sm dark:border-red-900/30 dark:bg-red-900/20 dark:text-red-400">
                    </div>
                </div>
            </div>

            {{-- Information Panel --}}
            <div class="flex flex-col gap-4" data-aos="fade-left" data-aos-delay="200">
                {{-- Panel Header --}}
                <div
                    class="flex items-center justify-between rounded-xl bg-zinc-100 p-4 ring-1 ring-zinc-200 dark:bg-zinc-800/50 dark:ring-zinc-800">
                    <h2 class="flex items-center gap-2 text-lg font-black tracking-tight dark:text-white">
                        <x-icons.info class="h-5 w-5 text-red-500" />
                        IDENTITAS
                    </h2>
                </div>

                {{-- Identification Thumbnail --}}
                <div class="group relative overflow-hidden rounded-xl bg-zinc-100 ring-1 ring-zinc-200 dark:bg-zinc-900">
                    <img class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-110"
                        id="canvLogo" src="{{ asset('assets/img/noImage.webp') }}" alt="User">
                    <canvas class="absolute inset-0 h-full w-full object-cover" id="canvAttend"></canvas>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 p-4">
                        <p class="text-xs font-medium text-white/70">CAPTURED PREVIEW</p>
                    </div>
                </div>

                {{-- Data List --}}
                <div class="flex-1 space-y-4 rounded-xl bg-zinc-100 p-5 ring-1 ring-zinc-200 dark:bg-zinc-800/30 dark:ring-zinc-800"
                    id="pegawaiKosong">
                    <div class="space-y-4">
                        {{-- Data Items --}}
                        <div
                            class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Lokasi</span>
                            <span id="lokasi" class="text-sm font-bold text-zinc-700 dark:text-zinc-200">-</span>
                        </div>

                        <div
                            class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Kode Pegawai</span>
                            <span
                                class="text-sm font-bold text-zinc-700 dark:text-zinc-200">{{ Auth::user()->kode_pegawai }}</span>
                            <input id="kode_pegawai" name="kode_pegawai" type="hidden"
                                value="{{ Auth::user()->kode_pegawai }}">
                        </div>

                        <div
                            class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">NIK Pegawai</span>
                            <span
                                class="text-sm font-bold text-zinc-700 dark:text-zinc-200">{{ $data->nik_pegawai ?? 'N/A' }}</span>
                        </div>

                        <div
                            class="flex flex-col gap-1 border-b border-zinc-200 pb-3 last:border-0 last:pb-0 dark:border-zinc-800">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Nama Lengkap</span>
                            <span
                                class="text-sm font-bold text-zinc-700 dark:text-zinc-200">{{ $data->full_name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    {{-- Hidden Hooks for Backend --}}
                    <div class="hidden">
                        <input type="hidden" id="specifiedLat" value="{{ $data->latitude ?? 'N/A' }}">
                        <input type="hidden" id="specifiedLng" value="{{ $data->longitude ?? 'N/A' }}">
                        <input type="hidden" id="radius" value="{{ $data->radius ?? 'N/A' }}">
                        <input type="hidden" id="movementThreshold" value="50">
                        <input type="hidden" id="kodePegawai" value="{{ $data->kode_pegawai }}">
                    </div>
                </div>

                {{-- Footer Info --}}
                <div class="rounded-lg bg-red-50 p-3 text-[10px] text-red-600 dark:bg-red-900/10 dark:text-red-400">
                    <strong>PENTING:</strong> Pastikan wajah berada di area frame digital untuk akurasi optimal.
                </div>
            </div>

        </div>
    </div>
@endsection
