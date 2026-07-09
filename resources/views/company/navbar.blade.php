{{-- Goal: Navigation navbar & mobile drawer menu, Livewire: None, Alpine: Yes --}}
{{-- ═══════════════════════════════════════════════
     NAVBAR
     ═══════════════════════════════════════════════ --}}
<nav class="cp-navbar" id="navbar">
    <div class="cp-container flex justify-between items-center">
        <a href="#hero" class="cp-display font-medium text-2xl tracking-tight pointer-events-auto">Indo<span class="cp-accent-text">dacin</span></a>

        <!-- Floating Gooey Navigation Capsule -->
        <div x-data="{ hoveredIndex: null, theme: 'red' }" @theme-changed.window="theme = $event.detail" class="hidden md:flex relative items-stretch rounded-full p-[4px] pointer-events-auto nav-capsule">
            
            <!-- Background Gooey Layer (Filtered) -->
            <div class="absolute inset-[4px] flex items-stretch pointer-events-none filter-goo gap-3">
                <!-- Item 0: Tentang -->
                <div class="flex items-center justify-center rounded-full transition-all duration-500 ease-out text-transparent select-none text-xs font-bold uppercase tracking-wider px-5 py-2"
                     :class="theme === 'white' ? (hoveredIndex === 0 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#fffdf0] dark:bg-zinc-700' : 'bg-white dark:bg-zinc-800') : (hoveredIndex === 0 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#bd3d37]' : 'bg-[#ac3630]')">
                    Tentang
                </div>
                <!-- Item 1: Layanan -->
                <div class="flex items-center justify-center rounded-full transition-all duration-500 ease-out text-transparent select-none text-xs font-bold uppercase tracking-wider px-5 py-2"
                     :class="theme === 'white' ? (hoveredIndex === 1 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#fffdf0] dark:bg-zinc-700' : 'bg-white dark:bg-zinc-800') : (hoveredIndex === 1 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#bd3d37]' : 'bg-[#ac3630]')">
                    Layanan
                </div>
                <!-- Item 2: Portofolio -->
                <div class="flex items-center justify-center rounded-full transition-all duration-500 ease-out text-transparent select-none text-xs font-bold uppercase tracking-wider px-5 py-2"
                     :class="theme === 'white' ? (hoveredIndex === 2 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#fffdf0] dark:bg-zinc-700' : 'bg-white dark:bg-zinc-800') : (hoveredIndex === 2 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#bd3d37]' : 'bg-[#ac3630]')">
                    Portofolio
                </div>
                <!-- Item 3: Sejarah -->
                <div class="flex items-center justify-center rounded-full transition-all duration-500 ease-out text-transparent select-none text-xs font-bold uppercase tracking-wider px-5 py-2"
                     :class="theme === 'white' ? (hoveredIndex === 3 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#fffdf0] dark:bg-zinc-700' : 'bg-white dark:bg-zinc-800') : (hoveredIndex === 3 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#bd3d37]' : 'bg-[#ac3630]')">
                    Sejarah
                </div>
                <!-- Item 4: Kontak -->
                <div class="flex items-center justify-center rounded-full transition-all duration-500 ease-out text-transparent select-none text-xs font-bold uppercase tracking-wider px-5 py-2"
                     :class="theme === 'white' ? (hoveredIndex === 4 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#fffdf0] dark:bg-zinc-700' : 'bg-white dark:bg-zinc-800') : (hoveredIndex === 4 ? 'scale-x-[1.3] scale-y-[1.1] bg-[#bd3d37]' : 'bg-[#ac3630]')">
                    Kontak
                </div>
            </div>

            <!-- Foreground Interactive Layer (Unfiltered) -->
            <div class="relative z-10 flex items-stretch gap-3">
                <a href="#about" @mouseenter="hoveredIndex = 0" @mouseleave="hoveredIndex = null"
                   class="px-5 py-2 text-xs font-bold uppercase tracking-wider transition-colors duration-300"
                   :class="theme === 'white' ? 'text-zinc-800 dark:text-zinc-200 hover:text-zinc-950 dark:hover:text-white' : 'text-zinc-50 hover:text-white'">
                    Tentang
                </a>
                <a href="#services" @mouseenter="hoveredIndex = 1" @mouseleave="hoveredIndex = null"
                   class="px-5 py-2 text-xs font-bold uppercase tracking-wider transition-colors duration-300"
                   :class="theme === 'white' ? 'text-zinc-800 dark:text-zinc-200 hover:text-zinc-950 dark:hover:text-white' : 'text-zinc-50 hover:text-white'">
                    Layanan
                </a>
                <a href="#showcase" @mouseenter="hoveredIndex = 2" @mouseleave="hoveredIndex = null"
                   class="px-5 py-2 text-xs font-bold uppercase tracking-wider transition-colors duration-300"
                   :class="theme === 'white' ? 'text-zinc-800 dark:text-zinc-200 hover:text-zinc-950 dark:hover:text-white' : 'text-zinc-50 hover:text-white'">
                    Portofolio
                </a>
                <a href="#history" @mouseenter="hoveredIndex = 3" @mouseleave="hoveredIndex = null"
                   class="px-5 py-2 text-xs font-bold uppercase tracking-wider transition-colors duration-300"
                   :class="theme === 'white' ? 'text-zinc-800 dark:text-zinc-200 hover:text-zinc-950 dark:hover:text-white' : 'text-zinc-50 hover:text-white'">
                    Sejarah
                </a>
                <a href="#contact" @mouseenter="hoveredIndex = 4" @mouseleave="hoveredIndex = null"
                   class="px-5 py-2 text-xs font-bold uppercase tracking-wider transition-colors duration-300"
                   :class="theme === 'white' ? 'text-zinc-800 dark:text-zinc-200 hover:text-zinc-950 dark:hover:text-white' : 'text-zinc-50 hover:text-white'">
                    Kontak
                </a>
            </div>
        </div>

        <button class="cp-hamburger md:hidden flex flex-col justify-between w-6 h-5 bg-transparent border-none cursor-pointer pointer-events-auto" aria-label="Menu">
            <span class="w-full h-[2px] bg-[#1f1818] rounded-full transition-all duration-300"></span>
            <span class="w-full h-[2px] bg-[#1f1818] rounded-full transition-all duration-300"></span>
            <span class="w-full h-[2px] bg-[#1f1818] rounded-full transition-all duration-300"></span>
        </button>
    </div>
</nav>

{{-- Mobile Menu --}}
<div class="cp-mobile-menu fixed inset-0 bg-[#faf8f5] z-[150] flex flex-col items-center justify-center gap-8 translate-x-full transition-transform duration-500">
    <button class="cp-mobile-close absolute top-8 right-8 text-4xl text-[#1f1818] bg-transparent border-none cursor-pointer" aria-label="Close menu">&times;</button>
    <a href="#about" class="text-2xl cp-display hover:text-[#ac3630] transition-colors">Tentang</a>
    <a href="#services" class="text-2xl cp-display hover:text-[#ac3630] transition-colors">Layanan</a>
    <a href="#showcase" class="text-2xl cp-display hover:text-[#ac3630] transition-colors">Portofolio</a>
    <a href="#history" class="text-2xl cp-display hover:text-[#ac3630] transition-colors">Sejarah</a>
    <a href="#contact" class="text-2xl cp-display hover:text-[#ac3630] transition-colors">Kontak</a>
</div>

<!-- SVG Gooey Filter -->
<svg class="absolute pointer-events-none" style="top: -9999px; left: -9999px; width: 1px; height: 1px;" xmlns="http://www.w3.org/2000/svg" version="1.1">
    <defs>
        <filter id="goo" x="-20%" y="-20%" width="140%" height="140%">
            <feGaussianBlur in="SourceGraphic" stdDeviation="8" result="blur" />
            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" />
        </filter>
    </defs>
</svg>
