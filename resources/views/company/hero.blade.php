{{-- Goal: Hero banner section with floating scatter cards, Livewire: None, Alpine: None --}}
{{-- ═══════════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════════ --}}
<section class="cp-hero relative flex min-h-screen items-center justify-center overflow-hidden pb-12 pt-24"
    id="hero">
    {{-- Floating Scatter Cards --}}
    <div class="cp-scatter-container">
        <div class="cp-scatter-card cp-scatter-card-1"><img src="{{ asset('images/scales/CRANE SCALE.webp') }}"
                alt="Crane Scale"></div>
        <div class="cp-scatter-card cp-scatter-card-2"><img src="{{ asset('images/scales/FLOOR SCALE.png') }}"
                alt="Floor Scale"></div>
        <div class="cp-scatter-card cp-scatter-card-3"><img
                src="{{ asset('images/scales/MOISTURE BALANCE TERBUKA.webp') }}" alt="Moisture Balance Terbuka"></div>
        <div class="cp-scatter-card cp-scatter-card-4"><img src="{{ asset('images/scales/MOISTURE BALANCE.webp') }}"
                alt="Moisture Balance"></div>
        <div class="cp-scatter-card cp-scatter-card-5"><img src="{{ asset('images/scales/Presica FB530.webp') }}"
                alt="Presica FB530"></div>
        <div class="cp-scatter-card cp-scatter-card-6"><img src="{{ asset('images/scales/TIMBANGAN JEMBATAN.webp') }}"
                alt="Timbangan Jembatan"></div>
        <div class="cp-scatter-card cp-scatter-card-7"><img
                src="{{ asset('images/scales/Timbangan Digital Laboratorium Vernier VAB 2104.webp') }}"
                alt="Timbangan Digital Laboratorium"></div>
        <div class="cp-scatter-card cp-scatter-card-8"><img
                src="{{ asset('images/scales/Timbangan Duduk Per Rong Vang - Kapasitas 10 kg.webp') }}"
                alt="Timbangan Duduk 10kg"></div>
        <div class="cp-scatter-card cp-scatter-card-9"><img
                src="{{ asset('images/scales/Timbangan Duduk Per Rong Vang - Kapasitas 60 kg.webp') }}"
                alt="Timbangan Duduk 60kg"></div>
        <div class="cp-scatter-card cp-scatter-card-10"><img
                src="{{ asset('images/scales/Timbangan Gantung - HANOI - HNA 100 - Kapasitas 100 kg.webp') }}"
                alt="Timbangan Gantung 100kg"></div>
        <div class="cp-scatter-card cp-scatter-card-11"><img
                src="{{ asset('images/scales/Timbangan Mekanik - CB 1000.webp') }}" alt="Timbangan Mekanik CB 1000">
        </div>
        <div class="cp-scatter-card cp-scatter-card-12"><img
                src="{{ asset('images/scales/Timbangan Mekanik - CB 500.webp') }}" alt="Timbangan Mekanik CB 500">
        </div>
        <div class="cp-scatter-card cp-scatter-card-13"><img src="{{ asset('images/scales/Timer scale.png') }}"
                alt="Timer Scale"></div>
        <div class="cp-scatter-card cp-scatter-card-14"><img src="{{ asset('images/scales/Waterproof.png') }}"
                alt="Waterproof Scale"></div>
        <div class="cp-scatter-card cp-scatter-card-15"><img src="{{ asset('images/scales/digital touch 2.png') }}"
                alt="Digital Touch 2"></div>
        <div class="cp-scatter-card cp-scatter-card-16"><img src="{{ asset('images/scales/digital touch.png') }}"
                alt="Digital Touch"></div>
        <div class="cp-scatter-card cp-scatter-card-17"><img src="{{ asset('images/scales/timbangan dapur.png') }}"
                alt="Timbangan Dapur"></div>
        <div class="cp-scatter-card cp-scatter-card-18"><img
                src="{{ asset('images/scales/timbangan heavy duty.png') }}" alt="Timbangan Heavy Duty"></div>
    </div>

    <div class="cp-container z-[2] flex min-h-[70vh] flex-col items-center justify-center text-center">
        <p class="cp-label font-sans font-bold tracking-[0.16em]" style="margin-bottom: 1.5rem;">Sejak 1950 — Medan,
            Indonesia</p>

        <h1
            class="font-sans text-5xl font-extrabold uppercase leading-[1.05] tracking-tight text-zinc-950 md:text-7xl lg:text-8xl">
            Presisi dalam Setiap <br class="hidden md:inline" />
            <span class="text-[#ac3630]">Solusi Industri.</span>
        </h1>

        <p class="cp-body-lg cp-hero-tagline mx-auto mt-6 max-w-[650px]">
            PT. Indodacin Presisi Utama adalah pionir manufaktur timbangan presisi
            di Indonesia, melayani kebutuhan penimbangan industri dari skala
            laboratorium hingga jembatan timbang berkapasitas 100 ton.
        </p>

        <div class="cp-hero-meta mt-10 flex items-center justify-center gap-4">
            <a href="#about" class="cp-btn cp-btn-blue">
                Kenali Kami
                <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 16 16"
                    fill="none">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
            <a href="#contact" class="cp-btn cp-btn-outline">Hubungi Kami</a>
        </div>
    </div>

    <div
        class="cp-hero-scroll-indicator absolute bottom-8 left-1/2 z-[2] flex -translate-x-1/2 flex-col items-center gap-3">
        <span class="font-sans text-[0.6875rem] font-semibold uppercase tracking-[0.16em] text-[#ac3630]"
            style="writing-mode: vertical-rl; font-size: 0.625rem;">SCROLL</span>
        <div class="relative h-12 w-[1px] overflow-hidden bg-[#1f1818]/15">
            <div class="absolute left-0 top-0 h-1/2 w-full animate-bounce rounded-full bg-[#ac3630]"></div>
        </div>
    </div>
</section>
