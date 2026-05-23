{{-- Goal: Premium blueprint footer with technical drawing animation, Livewire: None, Alpine: None --}}
{{-- ═══════════════════════════════════════════════
     PREMIUM FOOTER
     ═══════════════════════════════════════════════ --}}
<footer class="cp-footer-premium py-[clamp(4rem,3rem+5vw,8rem)] relative overflow-hidden">
    {{-- Siluet timbangan raksasa --}}
    <svg class="cp-footer-scale-logo" viewBox="0 0 24 24">
        <path
            d="M12 2a1 1 0 0 1 1 1v1.07A7.002 7.002 0 0 1 19 11v1h1a1 1 0 1 1 0 2h-1v1a7.002 7.002 0 0 1-6 6.93V21a1 1 0 1 1-2 0v-1.07A7.002 7.002 0 0 1 5 13v-1h1a1 1 0 1 1 0-2h-1V9a7.002 7.002 0 0 1 6-6.93V3a1 1 0 0 1 1-1zm0 4a5 5 0 0 0-4.995 4.783L7 11v1h10v-1a5 5 0 0 0-5-5zm-5 8a5.002 5.002 0 0 0 4.93 4.93V14H7zm10 0h-4.93v4.93A5.002 5.002 0 0 0 17 14z" />
    </svg>

    {{-- Blueprint Technical Drawing (Precision Scale sketch) --}}
    <svg class="cp-footer-drawing" viewBox="0 0 100 100">
        <rect x="10" y="80" width="80" height="8" rx="2" />
        <line x1="50" y1="20" x2="50" y2="80" />
        <line x1="20" y1="28" x2="80" y2="28" />
        <circle cx="50" cy="28" r="6" />
        <line x1="50" y1="28" x2="50" y2="23" />
        <line x1="20" y1="28" x2="20" y2="55" />
        <path d="M10 55 h20 l-4 10 h-12 z" />
        <line x1="80" y1="28" x2="80" y2="55" />
        <path d="M70 55 h20 l-4 10 h-12 z" />
        <rect x="25" y="74" width="6" height="6" />
        <rect x="33" y="76" width="4" height="4" />
        <rect x="39" y="77" width="3" height="3" />
        <circle cx="50" cy="50" r="30" stroke-dasharray="2 4" />
        <line x1="5" y1="50" x2="95" y2="50" stroke-dasharray="1 5" />
    </svg>

    <div class="cp-container z-[2] relative">
        <h2 class="cp-display text-[clamp(2rem,1.5rem+3vw,4rem)] font-medium leading-[1.1] text-white mb-16 max-w-[700px] cp-reveal">
            Presisi dalam<br />
            <span class="cp-italic opacity-80">Setiap Solusi.</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16">
            <div class="cp-footer-col cp-reveal">
                <a href="#hero" class="cp-display font-medium text-2xl tracking-tight text-white"
                    style="font-size: 1.75rem; display: inline-block; margin-bottom: 0.5rem;">Indo<span class="text-[#ac3630]">dacin</span></a>
                <p>
                    Pionir manufaktur timbangan presisi di Indonesia sejak 1950. Berkomitmen menghadirkan kualitas
                    terbaik bagi kemajuan industri nasional.
                </p>
            </div>

            <div class="cp-footer-col cp-reveal">
                <h4>Kantor Pusat</h4>
                <p>
                    Jl. Brigjend Zein Hamid KM 7.5<br />
                    Titi Kuning, Medan<br />
                    Sumatera Utara 20143, Indonesia<br />
                    Tel: +62 61 846 2612
                </p>
            </div>

            <div class="cp-footer-col cp-reveal">
                <h4>Cabang & Depo</h4>
                <a href="https://maps.google.com/?q=Indodacin+Pekanbaru" target="_blank"
                    rel="noopener">Pekanbaru, Riau</a>
                <a href="https://maps.google.com/?q=Indodacin+Jakarta" target="_blank" rel="noopener">Jakarta</a>
                <a href="#contact">Kalimantan Barat</a>
                <a href="#contact">Kalimantan Utara</a>
            </div>

            <div class="cp-footer-col cp-reveal">
                <h4>Menu Utama</h4>
                <a href="#about">Tentang Kami</a>
                <a href="#services">Layanan & Produk</a>
                <a href="#showcase">Portofolio</a>
                <a href="#history">Sejarah Perjalanan</a>
                <a href="#contact">Hubungi Kontak</a>
            </div>
        </div>

        <div class="cp-footer-bottom-row cp-reveal">
            <p>&copy; {{ date('Y') }} PT. Indodacin Presisi Utama. All rights reserved.</p>
            <div class="cp-footer-socials">
                <a href="#" class="cp-footer-social-btn" aria-label="Facebook">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                    </svg>
                </a>
                <a href="#" class="cp-footer-social-btn" aria-label="Instagram">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                    </svg>
                </a>
                <a href="#" class="cp-footer-social-btn" aria-label="LinkedIn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                        <rect x="2" y="9" width="4" height="12" />
                        <circle cx="4" cy="4" r="2" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>

