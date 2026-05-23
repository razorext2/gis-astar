{{-- Goal: Staggered showcase portfolio grid, Livewire: None, Alpine: None --}}
{{-- ═══════════════════════════════════════════════
     SHOWCASE SECTION (Staggered Grid)
     ═══════════════════════════════════════════════ --}}
<section class="cp-section" id="showcase">
    <div class="cp-container">
        <div class="cp-divider"></div>

        <div style="max-width: 600px; margin-bottom: clamp(3rem, 2rem + 4vw, 6rem);">
            <p class="cp-label cp-reveal" style="margin-bottom: 1rem;">Portofolio</p>
            <h2 class="cp-display cp-display-lg cp-reveal">
                Karya &<br />
                <span class="cp-italic cp-accent-text">Keahlian</span> Kami.
            </h2>
        </div>

        <div class="cp-showcase-grid">
            {{-- Item 1 --}}
            <div class="cp-staggered-item" data-scroll-speed="0.05">
                <div class="cp-staggered-img-wrap group overflow-hidden">
                    <img src="{{ asset('assets/img/company/showcase-weighbridge.png') }}"
                        class="cp-parallax-img" alt="Timbangan Jembatan" loading="lazy" />
                </div>
                <div class="mt-5">
                    <h3 class="cp-display text-[clamp(1.125rem,1rem+0.5vw,1.5rem)] font-medium leading-tight mb-1">Timbangan Jembatan 80T</h3>
                    <p class="text-sm text-[#6b5c54]">Instalasi weighbridge full loadcell untuk pabrik CPO</p>
                </div>
            </div>

            {{-- Item 2 --}}
            <div class="cp-staggered-item" data-scroll-speed="0.1">
                <div class="cp-staggered-img-wrap group overflow-hidden">
                    <img src="{{ asset('assets/img/company/showcase-precision.png') }}"
                        class="cp-parallax-img" alt="Sistem Kontrol Digital" loading="lazy" />
                </div>
                <div class="mt-5">
                    <h3 class="cp-display text-[clamp(1.125rem,1rem+0.5vw,1.5rem)] font-medium leading-tight mb-1">Sistem Kontrol Digital</h3>
                    <p class="text-sm text-[#6b5c54]">Panel monitoring real-time dengan integrasi PLC</p>
                </div>
            </div>

            {{-- Item 3 --}}
            <div class="cp-staggered-item" data-scroll-speed="0.05">
                <div class="cp-staggered-img-wrap group overflow-hidden">
                    <img src="{{ asset('assets/img/company/showcase-workshop.png') }}" 
                        class="cp-parallax-img" alt="Workshop Manufaktur" loading="lazy" />
                </div>
                <div class="mt-5">
                    <h3 class="cp-display text-[clamp(1.125rem,1rem+0.5vw,1.5rem)] font-medium leading-tight mb-1">Workshop Manufaktur</h3>
                    <p class="text-sm text-[#6b5c54]">Fasilitas produksi modern di Medan, Sumatera Utara</p>
                </div>
            </div>

            {{-- Item 4 --}}
            <div class="cp-staggered-item" data-scroll-speed="0.1">
                <div class="cp-staggered-img-wrap group overflow-hidden">
                    <img src="{{ asset('assets/img/company/showcase-software.png') }}" 
                        class="cp-parallax-img" alt="Software Penimbangan" loading="lazy" />
                </div>
                <div class="mt-5">
                    <h3 class="cp-display text-[clamp(1.125rem,1rem+0.5vw,1.5rem)] font-medium leading-tight mb-1">Software Penimbangan</h3>
                    <p class="text-sm text-[#6b5c54]">Dashboard IoT dan otomasi penimbangan custom</p>
                </div>
            </div>
        </div>
    </div>
</section>
