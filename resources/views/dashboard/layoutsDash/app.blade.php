{{-- Goal: Main dashboard layout container, Livewire: None, Alpine: Yes --}}
<!DOCTYPE html>
<html class="{{ isset($_COOKIE['color-theme']) && $_COOKIE['color-theme'] === 'dark' ? 'dark' : '' }} scroll-smooth"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('dashboard.layoutsDash.head')
</head>

<body id="container" class="relative bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100"
    x-data="{ openSidebar: true, menuSearch: '', dynamicBg: localStorage.getItem('dynamicBg') === null ? false : localStorage.getItem('dynamicBg') === 'true' }" x-init="$watch('dynamicBg', value => localStorage.setItem('dynamicBg', value))" :class="{ 'no-blur': !dynamicBg }">

    <div x-show="dynamicBg" x-transition.opacity.duration.500ms>
        <x-utils.dynamic-background />
    </div>

    <div class="relative z-10 mb-5 flex min-h-screen flex-col">
        @if (session('status'))
            <x-notification-popup>
                {{ session('status') }}
            </x-notification-popup>
        @endif

        @include('dashboard.layoutsDash.navbar')

        @include('dashboard.layoutsDash.sidebar')

        <div :class="openSidebar ? 'max-w-screen-xl sm:ml-72 xl:ml-96' : 'mx-0 md:mx-12 lg:mx-20 xl:mx-44 max-w-screen-2xl'"
            class="mb-20 mt-[6.5rem] px-4 transition-all duration-300 ease-in-out md:mb-4">

            {{-- breadcrumb --}}
            @livewire('utils.breadcrumb')

            {{-- title --}}
            <div class="grid grid-cols-1">
                @include('dashboard.layoutsDash.title')
            </div>

            {{-- announcement --}}
            @livewire('utils.announcement-container')

            {{-- main content --}}
            @yield('content')

        </div>

    </div>

    {{-- bikin navigasi ala android --}}
    @persist('mobile-drawer')
        <x-drawer.mobile-menu />
    @endpersist

    {{-- scroll to top --}}
    <div x-data="scrollToggle()" x-init="init()">
        <a href="javascript:void(0)" @click="handleScroll" :class="atTop ? 'rotate-0' : 'rotate-180'"
            class="fixed bottom-24 right-4 z-50 h-fit w-fit rounded-full bg-red-600 p-2.5 transition-all duration-300 ease-in-out hover:bg-red-700 md:bottom-8 md:right-8 lg:block">
            <x-icons.carred-down class="h-6 w-6 text-white" id="scroll-to-top-icon" />
        </a>
    </div>

    {{-- preload --}}
    @persist('preloader')
        <x-utils.preloader x-show="dynamicBg" />
    @endpersist

    <!-- js -->
    @include('dashboard.layoutsDash.js')
    @stack('modals')
</body>

</html>
