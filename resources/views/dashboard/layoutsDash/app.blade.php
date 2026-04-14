<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('dashboard.layoutsDash.head')
</head>

<body id="container" class="relative bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100"
    x-data="{ openSidebar: true }"
    onmousemove="document.getElementById('container').style.setProperty('--mouse-x', event.clientX + 'px'); document.getElementById('container').style.setProperty('--mouse-y', event.clientY + 'px');">

    <x-utils.dynamic-background />

    <div class="relative z-10 mb-5 flex min-h-screen flex-col">
        @if (session('status'))
            <x-notification-popup>
                {{ session('status') }}
            </x-notification-popup>
        @endif

        @include('dashboard.layoutsDash.navbar')

        @include('dashboard.layoutsDash.sidebar')

        <div :class="openSidebar ? 'max-w-screen-xl sm:ml-72 xl:ml-96' : 'mx-0 md:mx-12 lg:mx-20 xl:mx-44 max-w-screen-2xl'"
            class="mb-20 mt-32 px-4 transition-all duration-300 ease-in-out sm:mt-24 md:mb-4">

            {{-- breadcrumb --}}
            @livewire('utils.breadcrumb')

            {{-- title --}}
            <div class="grid grid-cols-1">
                @include('dashboard.layoutsDash.title')
            </div>

            {{-- carousel for cards --}}
            @livewire('components.card')

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
    <div class="fixed inset-0 z-50 bg-white dark:bg-zinc-950 md:z-[9999]" id="preloader">
    </div>

    <!-- js -->
    @include('dashboard.layoutsDash.js')
</body>

</html>
