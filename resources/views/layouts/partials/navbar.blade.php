{{-- Goal: Non-floating dashboard header — clean h-16 edge-to-edge, Livewire: Yes, Alpine: Yes --}}
<nav x-data="{
    navVisible: true,
    lastScrollY: 0,
    isMobile() { return window.innerWidth < 768; },
    handleScroll() {
        if (!this.isMobile()) { this.navVisible = true; return; }
        const y = window.scrollY;
        if (y <= 0 || y < this.lastScrollY) { this.navVisible = true; }
        else if (y > this.lastScrollY && y > 60) { this.navVisible = false; }
        this.lastScrollY = y;
    }
}" x-init="
    window.addEventListener('scroll', () => handleScroll(), { passive: true });
    window.addEventListener('resize', () => { if (!isMobile()) navVisible = true; }, { passive: true });"
    :class="[
        openSidebar ? 'md:ml-68' : '',
        dynamicBg
            ? 'bg-glass-light/98 border-glass-border-light backdrop-blur-xl dark:bg-glass-dark/98 dark:border-glass-border-dark'
            : 'bg-white/98 border-zinc-200/80 dark:bg-dark-primary/98 dark:border-zinc-800/70'
    ]"
    :style="{ transform: !navVisible ? 'translateY(-100%)' : 'translateY(0)' }"
    style="transition: margin-left 300ms ease-out, transform 280ms cubic-bezier(0.4,0,0.2,1);"
    class="fixed left-0 right-0 top-0 z-30 flex h-16 items-center border-b px-3 sm:px-5 lg:px-6" x-cloak>

    {{-- ── Inner wrapper ── --}}
    <div class="flex w-full items-center gap-3">

        {{-- ─── LEFT: Toggle + Logo + Breadcrumb ─── --}}
        <div class="flex min-w-0 flex-1 items-center gap-2">

            {{-- Sidebar toggle (desktop) --}}
            <button @click="openSidebar = !openSidebar"
                x-data="{ tapping: false }" x-on:mousedown="tapping = true" x-on:touchstart="tapping = true"
                x-on:animationend="tapping = false" x-on:animationcancel="tapping = false"
                :class="{ 'is-tapping': tapping }"
                class="liquid-btn hidden h-9 w-9 shrink-0 items-center justify-center rounded-lg text-zinc-500 transition-all duration-150 hover:bg-zinc-100 hover:text-zinc-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 md:flex dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
                aria-label="Toggle sidebar">
                <x-icons.bar class="h-5 w-5" x-show="!openSidebar" />
                <x-icons.close class="h-5 w-5" x-show="openSidebar" />
            </button>

            {{-- App brand — hidden when sidebar open on desktop --}}
            <div :class="openSidebar ? 'md:max-w-0 md:opacity-0 md:pointer-events-none md:-translate-x-3' : 'max-w-40 opacity-100 translate-x-0'"
                class="flex shrink-0 overflow-hidden transition-[opacity,transform,max-width] duration-300 ease-out">
                <a href="{{ config('app.url') }}" class="flex items-center gap-2 rounded-lg px-1 py-0.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500">
                    <img class="h-7 w-7 rounded-lg object-contain sm:h-8 sm:w-8"
                        src="{{ asset('images/brand/logo.png') }}" alt="SIPROMATA Logo" loading="lazy" />
                    <span class="hidden whitespace-nowrap text-sm font-black tracking-wide text-zinc-900 sm:block dark:text-white">
                        SIPROMATA
                    </span>
                </a>
            </div>

            {{-- Divider + Breadcrumb portal --}}
            <div id="navbar-breadcrumb-container"
                class="flex h-6 min-w-0 items-center border-l border-zinc-200/60 pl-3 sm:pl-4 dark:border-zinc-700/60">
            </div>
        </div>

        {{-- ─── CENTER: Technician Points ─── --}}
        <div id="point-container" class="hidden sm:block">
            @if (auth()->user()->hasRole('Teknisi'))
                <livewire:widget.technician.points-accumulation />
            @endif
        </div>

        {{-- ─── RIGHT: Actions ─── --}}
        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">

            {{-- Ping status --}}
            <livewire:utils.ping-checker />

            {{-- ── Notifications ── --}}
            <div id="notifications" class="relative" x-data="{
                open: false,
                dropdownStyle: '',
                updatePosition() {
                    const btn = document.getElementById('notificationButton');
                    if (!btn) return;
                    const rect = btn.getBoundingClientRect();
                    const top = rect.bottom + 8;
                    if (window.innerWidth < 640) {
                        this.dropdownStyle = `position:fixed;top:${top}px;left:12px;right:12px;width:auto;`;
                    } else {
                        const right = window.innerWidth - rect.right;
                        this.dropdownStyle = `position:fixed;top:${top}px;right:${right}px;width:380px;`;
                    }
                }
            }" @click.outside="open = false">
                <button id="notificationButton" type="button" wire:ignore
                    @click="open = !open; if(open) { Livewire.dispatch('notification-received'); updatePosition(); }"
                    class="relative flex h-9 w-9 items-center justify-center rounded-lg text-zinc-500 transition-all duration-150 hover:bg-zinc-100 hover:text-zinc-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
                    aria-label="Lihat notifikasi">
                    <livewire:notification-bell />
                </button>

                {{-- Notification dropdown --}}
                <template x-teleport="body">
                    <div x-show="open" @click.outside="open = false" style="display:none;"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1 scale-[0.97]"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-1 scale-[0.97]"
                        :style="dropdownStyle"
                        x-bind:class="dynamicBg
                            ? 'bg-glass-light backdrop-blur-xl border-glass-border-light shadow-[0_4px_24px_rgba(0,0,0,0.10),0_1px_4px_rgba(0,0,0,0.06)] dark:bg-glass-dark dark:border-glass-border-dark dark:shadow-[0_4px_24px_rgba(0,0,0,0.45)]'
                            : 'bg-white border-zinc-200 shadow-[0_4px_24px_rgba(0,0,0,0.08),0_1px_3px_rgba(0,0,0,0.05)] dark:bg-dark-primary dark:border-zinc-800 dark:shadow-[0_4px_24px_rgba(0,0,0,0.4)]'"
                        class="z-[200] origin-top-right overflow-hidden rounded-2xl border"
                        id="notification-dropdown" wire:ignore.self>

                        {{-- Header --}}
                        <div class="flex items-center gap-2.5 border-b border-zinc-100 px-4 py-3 dark:border-zinc-800">
                            <span class="inline-flex h-2 w-2 rounded-full bg-red-500 shadow-[0_0_6px_rgba(239,68,68,0.5)]"></span>
                            <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Notifikasi</span>
                        </div>

                        {{-- List --}}
                        <div class="max-h-72 overflow-y-auto md:max-h-96" id="notificationContainer">
                            <livewire:utils.notification-dropdown />
                        </div>

                        {{-- Footer --}}
                        <div class="border-t border-zinc-100 px-4 py-2.5 dark:border-zinc-800">
                            <a href="{{ route('notifications.index') }}"
                                class="text-xs font-semibold text-red-500 transition-colors hover:text-red-600 dark:text-red-400 dark:hover:text-red-300">
                                Lihat semua notifikasi →
                            </a>
                        </div>
                    </div>
                </template>
            </div>
            {{-- /Notifications --}}

            {{-- ── Profile ── --}}
            <div id="profile-content" class="relative" x-data="{
                open: false,
                dropdownStyle: 'top:0;right:0;',
                updatePosition() {
                    const btn = document.getElementById('user-menu-button');
                    if (!btn) return;
                    const rect = btn.getBoundingClientRect();
                    this.dropdownStyle = `position:fixed;top:${rect.bottom + 8}px;right:${window.innerWidth - rect.right}px;`;
                }
            }" @click.outside="open = false">

                {{-- Avatar trigger --}}
                <button id="user-menu-button" type="button"
                    @click="open = !open; if(open) updatePosition()"
                    :aria-expanded="open.toString()"
                    class="flex h-9 w-9 items-center justify-center rounded-full ring-2 ring-red-500/60 transition-all duration-150 hover:ring-red-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 dark:ring-red-500/50 dark:hover:ring-red-400"
                    aria-label="Buka menu pengguna">
                    <img class="h-8 w-8 rounded-full object-cover"
                        src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('images/defaults/profile-picture-5.jpg') }}"
                        alt="Foto {{ auth()->user()->name }}" loading="lazy"
                        onerror="this.src='{{ asset('images/defaults/noImage.webp') }}'">
                </button>

                {{-- Profile dropdown --}}
                <template x-teleport="body">
                    <div x-show="open" @click.outside="open = false" style="display:none;"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1 scale-[0.97]"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-1 scale-[0.97]"
                        :style="dropdownStyle"
                        x-bind:class="dynamicBg
                            ? 'bg-glass-light backdrop-blur-xl border-glass-border-light shadow-[0_4px_24px_rgba(0,0,0,0.10),0_1px_4px_rgba(0,0,0,0.06)] dark:bg-glass-dark dark:border-glass-border-dark dark:shadow-[0_4px_24px_rgba(0,0,0,0.45)]'
                            : 'bg-white border-zinc-200 shadow-[0_4px_24px_rgba(0,0,0,0.08),0_1px_3px_rgba(0,0,0,0.05)] dark:bg-dark-primary dark:border-zinc-800 dark:shadow-[0_4px_24px_rgba(0,0,0,0.4)]'"
                        class="z-[200] w-64 origin-top-right overflow-hidden rounded-2xl border"
                        id="profile-dropdown">

                        {{-- User identity header --}}
                        <div class="flex items-center gap-3 border-b border-zinc-100 px-4 py-3.5 dark:border-zinc-800">
                            <img class="h-10 w-10 shrink-0 rounded-full object-cover ring-2 ring-zinc-200 dark:ring-zinc-700"
                                src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('images/defaults/profile-picture-5.jpg') }}"
                                alt="Foto {{ auth()->user()->name }}" loading="lazy"
                                onerror="this.src='{{ asset('images/defaults/noImage.webp') }}'">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-50">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                        </div>

                        {{-- Navigation items --}}
                        <ul class="py-1" role="menu">
                            <li role="none">
                                <a href="{{ route('profile.me') }}" wire:navigate
                                    class="flex w-full items-center gap-2.5 px-4 py-2 text-sm text-zinc-700 transition-colors hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800/70 dark:hover:text-white"
                                    role="menuitem">
                                    My Profile
                                </a>
                            </li>
                            <li role="none">
                                <form id="editProfile" action="{{ route('profile.edit') }}" onclick="event.preventDefault();"></form>
                                <button form="editProfile" type="submit"
                                    class="flex w-full items-center gap-2.5 px-4 py-2 text-left text-sm text-zinc-700 transition-colors hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800/70 dark:hover:text-white"
                                    role="menuitem">
                                    Account Settings
                                </button>
                            </li>
                            @hasanyrole(['Admin', 'HRD', 'Management', 'Management-PKU', 'Management-JKT', 'Management-Special'])
                                <li role="none">
                                    <livewire:utils.update-log />
                                </li>
                            @endhasanyrole
                        </ul>

                        {{-- Preferences section --}}
                        <div class="border-t border-zinc-100 dark:border-zinc-800">
                            {{-- Theme toggle --}}
                            <div class="flex items-center justify-between px-4 py-2.5">
                                <span class="text-sm text-zinc-600 dark:text-zinc-300">Tema</span>
                                <div class="flex items-center gap-1.5">
                                    <x-button.dark />
                                    <x-button.light />
                                </div>
                            </div>

                            {{-- Dynamic background toggle --}}
                            <div class="flex cursor-pointer items-center justify-between px-4 py-2.5 transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/60"
                                @click.stop="dynamicBg = !dynamicBg">
                                <span class="text-sm text-zinc-600 dark:text-zinc-300">Latar Dinamis</span>
                                <button type="button" role="switch" :aria-checked="dynamicBg.toString()"
                                    class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer items-center rounded-full transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-zinc-900"
                                    :class="dynamicBg ? 'bg-red-500' : 'bg-zinc-300 dark:bg-zinc-600'">
                                    <span class="sr-only">Toggle latar dinamis</span>
                                    <span class="pointer-events-none inline-block h-3.5 w-3.5 translate-x-0.5 transform rounded-full bg-white shadow-sm ring-0 transition-transform duration-200"
                                        :class="dynamicBg ? 'translate-x-4' : 'translate-x-0.5'"></span>
                                </button>
                            </div>
                        </div>

                        {{-- Sign out --}}
                        <div class="border-t border-zinc-100 py-1 dark:border-zinc-800">
                            <form id="logout" method="post" action="{{ route('logout') }}" onclick="event.preventDefault();">@csrf</form>
                            <button form="logout" type="submit"
                                class="flex w-full items-center gap-2.5 px-4 py-2 text-left text-sm font-medium text-red-500 transition-colors hover:bg-red-50 hover:text-red-600 dark:text-red-400 dark:hover:bg-red-500/10 dark:hover:text-red-300"
                                role="menuitem">
                                Sign Out
                            </button>
                        </div>
                    </div>
                </template>
            </div>
            {{-- /Profile --}}

        </div>
        {{-- /Right Actions --}}

    </div>
</nav>
