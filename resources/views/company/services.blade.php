{{-- Goal: Interactive Pinned Stacking Slideshow (Services), Livewire: None, Alpine: None --}}
{{-- ═══════════════════════════════════════════════
     INTERACTIVE SLIDESHOW (SERVICES) SECTION
═══════════════════════════════════════════════ --}}
<section class="cp-slideshow-section" id="services">

    {{-- 1. Sliding Background Layers --}}
    <div class="cp-slide cp-slide-1">
        <div class="cp-slide-bg-wrap">
            <img src="{{ asset('assets/img/company/showcase-weighbridge.png') }}" class="cp-slide-bg"
                alt="Timbangan Jembatan Indodacin">
        </div>
        <div class="cp-slide-overlay"></div>
    </div>

    <div class="cp-slide cp-slide-2">
        <div class="cp-slide-bg-wrap">
            <img src="{{ asset('assets/img/company/showcase-precision.png') }}" class="cp-slide-bg"
                alt="Timbangan Industri Indodacin">
        </div>
        <div class="cp-slide-overlay"></div>
    </div>

    <div class="cp-slide cp-slide-3">
        <div class="cp-slide-bg-wrap">
            <img src="{{ asset('assets/img/company/showcase-software.png') }}" class="cp-slide-bg"
                alt="Software Otomasi Indodacin">
        </div>
        <div class="cp-slide-overlay"></div>
    </div>

    <div class="cp-slide cp-slide-4">
        <div class="cp-slide-bg-wrap">
            <img src="{{ asset('assets/img/company/showcase-workshop.png') }}" class="cp-slide-bg"
                alt="Servis & Kalibrasi Indodacin">
        </div>
        <div class="cp-slide-overlay"></div>
    </div>

    {{-- 2. Pinned Text Content Layer (Overlays the sliding backgrounds) --}}
    <div class="cp-slides-content-overlay">
        <div class="cp-slide-container-inner">

            {{-- Content 1: Timbangan Jembatan --}}
            <div class="cp-slide-content cp-slide-content-1">
                <div class="w-full flex flex-col relative pt-8 md:pt-12">
                    
                    <!-- Center Badge -->
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 z-20">
                        <div class="cp-slide-badge">
                            <span class="px-5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] sm:text-xs font-bold tracking-widest uppercase inline-block">
                                Timbangan Jembatan
                            </span>
                        </div>
                    </div>

                    <!-- Full Width Progress Line -->
                    <div class="cp-slide-indicator w-full z-10 mt-6">
                        <div class="w-full flex justify-between items-end pb-3">
                            <span class="text-white font-sans text-sm tracking-widest">01</span>
                            <span class="text-white/40 font-sans text-sm tracking-widest">04</span>
                        </div>
                        <div class="w-full h-[1px] bg-white/20 relative overflow-hidden">
                            <div class="cp-slide-progress absolute left-0 top-0 h-full w-full bg-white origin-left scale-x-0"></div>
                        </div>
                    </div>

                    <!-- Bottom Content -->
                    <div class="w-full flex flex-col lg:flex-row justify-between items-start pt-6 lg:pt-10">
                        <div class="w-full lg:w-1/4 mb-6 lg:mb-0 hidden md:block">
                            <p class="text-white/70 font-sans text-xs tracking-widest uppercase">Skala Berat Besar</p>
                        </div>
                        
                        <div class="w-full lg:w-1/2 flex flex-col items-center text-center">
                            <h2 class="cp-slide-title cp-display text-[clamp(2rem,2.5vw+1.5rem,4rem)] leading-[1.1] text-white mb-8">
                                Jembatan timbang digital berkapasitas tinggi hingga 100 ton.
                            </h2>
                            <a href="#contact" class="cp-slide-btn cp-btn bg-white text-zinc-900 hover:bg-zinc-200 border-none px-8 py-3 rounded-full text-sm font-bold tracking-wider uppercase transition-colors pointer-events-auto">
                                Konsultasi Produk
                            </a>
                        </div>
                        
                        <div class="w-1/4 hidden lg:block"></div>
                    </div>
                </div>
            </div>

            {{-- Content 2: Timbangan Industri --}}
            <div class="cp-slide-content cp-slide-content-2">
                <div class="w-full flex flex-col relative pt-8 md:pt-12">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 z-20">
                        <div class="cp-slide-badge">
                            <span class="px-5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] sm:text-xs font-bold tracking-widest uppercase inline-block">
                                Timbangan Industri
                            </span>
                        </div>
                    </div>

                    <div class="cp-slide-indicator w-full z-10 mt-6">
                        <div class="w-full flex justify-between items-end pb-3">
                            <span class="text-white font-sans text-sm tracking-widest">02</span>
                            <span class="text-white/40 font-sans text-sm tracking-widest">04</span>
                        </div>
                        <div class="w-full h-[1px] bg-white/20 relative overflow-hidden">
                            <div class="cp-slide-progress absolute left-0 top-0 h-full w-full bg-white origin-left scale-x-0"></div>
                        </div>
                    </div>

                    <div class="w-full flex flex-col lg:flex-row justify-between items-start pt-6 lg:pt-10">
                        <div class="w-full lg:w-1/4 mb-6 lg:mb-0 hidden md:block">
                            <p class="text-white/70 font-sans text-xs tracking-widest uppercase">Solusi Manufaktur</p>
                        </div>
                        
                        <div class="w-full lg:w-1/2 flex flex-col items-center text-center">
                            <h2 class="cp-slide-title cp-display text-[clamp(2rem,2.5vw+1.5rem,4rem)] leading-[1.1] text-white mb-8">
                                Solusi penimbangan pabrikasi, CPO, karet & tapioka.
                            </h2>
                            <a href="#contact" class="cp-slide-btn cp-btn bg-white text-zinc-900 hover:bg-zinc-200 border-none px-8 py-3 rounded-full text-sm font-bold tracking-wider uppercase transition-colors pointer-events-auto">
                                Konsultasi Produk
                            </a>
                        </div>
                        
                        <div class="w-1/4 hidden lg:block"></div>
                    </div>
                </div>
            </div>

            {{-- Content 3: Software & Otomasi --}}
            <div class="cp-slide-content cp-slide-content-3">
                <div class="w-full flex flex-col relative pt-8 md:pt-12">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 z-20">
                        <div class="cp-slide-badge">
                            <span class="px-5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] sm:text-xs font-bold tracking-widest uppercase inline-block">
                                Software & Otomasi
                            </span>
                        </div>
                    </div>

                    <div class="cp-slide-indicator w-full z-10 mt-6">
                        <div class="w-full flex justify-between items-end pb-3">
                            <span class="text-white font-sans text-sm tracking-widest">03</span>
                            <span class="text-white/40 font-sans text-sm tracking-widest">04</span>
                        </div>
                        <div class="w-full h-[1px] bg-white/20 relative overflow-hidden">
                            <div class="cp-slide-progress absolute left-0 top-0 h-full w-full bg-white origin-left scale-x-0"></div>
                        </div>
                    </div>

                    <div class="w-full flex flex-col lg:flex-row justify-between items-start pt-6 lg:pt-10">
                        <div class="w-full lg:w-1/4 mb-6 lg:mb-0 hidden md:block">
                            <p class="text-white/70 font-sans text-xs tracking-widest uppercase">Digitalisasi</p>
                        </div>
                        
                        <div class="w-full lg:w-1/2 flex flex-col items-center text-center">
                            <h2 class="cp-slide-title cp-display text-[clamp(2rem,2.5vw+1.5rem,4rem)] leading-[1.1] text-white mb-8">
                                Integrasi dashboard IoT pintar untuk monitoring real-time.
                            </h2>
                            <a href="#contact" class="cp-slide-btn cp-btn bg-white text-zinc-900 hover:bg-zinc-200 border-none px-8 py-3 rounded-full text-sm font-bold tracking-wider uppercase transition-colors pointer-events-auto">
                                Konsultasi Produk
                            </a>
                        </div>
                        
                        <div class="w-1/4 hidden lg:block"></div>
                    </div>
                </div>
            </div>

            {{-- Content 4: Servis & Kalibrasi --}}
            <div class="cp-slide-content cp-slide-content-4">
                <div class="w-full flex flex-col relative pt-8 md:pt-12">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 z-20">
                        <div class="cp-slide-badge">
                            <span class="px-5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] sm:text-xs font-bold tracking-widest uppercase inline-block">
                                Servis & Kalibrasi
                            </span>
                        </div>
                    </div>

                    <div class="cp-slide-indicator w-full z-10 mt-6">
                        <div class="w-full flex justify-between items-end pb-3">
                            <span class="text-white font-sans text-sm tracking-widest">04</span>
                            <span class="text-white/40 font-sans text-sm tracking-widest">04</span>
                        </div>
                        <div class="w-full h-[1px] bg-white/20 relative overflow-hidden">
                            <div class="cp-slide-progress absolute left-0 top-0 h-full w-full bg-white origin-left scale-x-0"></div>
                        </div>
                    </div>

                    <div class="w-full flex flex-col lg:flex-row justify-between items-start pt-6 lg:pt-10">
                        <div class="w-full lg:w-1/4 mb-6 lg:mb-0 hidden md:block">
                            <p class="text-white/70 font-sans text-xs tracking-widest uppercase">Purna Jual</p>
                        </div>
                        
                        <div class="w-full lg:w-1/2 flex flex-col items-center text-center">
                            <h2 class="cp-slide-title cp-display text-[clamp(2rem,2.5vw+1.5rem,4rem)] leading-[1.1] text-white mb-8">
                                Layanan perawatan berkala, kalibrasi, & tera ulang bersertifikat.
                            </h2>
                            <a href="#contact" class="cp-slide-btn cp-btn bg-white text-zinc-900 hover:bg-zinc-200 border-none px-8 py-3 rounded-full text-sm font-bold tracking-wider uppercase transition-colors pointer-events-auto">
                                Hubungi Layanan
                            </a>
                        </div>
                        
                        <div class="w-1/4 hidden lg:block"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
