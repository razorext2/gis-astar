<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('dashboard.layoutsDash.head')
</head>

<body id="container" class="bg-gray-100 dark:bg-[#09090b]" x-data="{ openSidebar: true }">

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
        @persist('card-carousel')
            @livewire('components.card')
        @endpersist

        {{-- announcement --}}
        @livewire('utils.announcement-container')

        {{-- main content --}}
        @yield('content')

    </div>

    {{-- bikin navigasi ala android --}}
    @persist('mobile-drawer')
        <x-drawer.mobile-menu />
    @endpersist

    {{-- preload --}}
    <div class="fixed inset-0 z-50 bg-white dark:bg-[#09090b] md:z-[9999]" id="preloader">
    </div>

    {{-- scroll to top --}}
    <div x-data="scrollToggle()" x-init="init()">
        <a href="javascript:void(0)" @click="handleScroll" :class="atTop ? 'rotate-0' : 'rotate-180'"
            class="fixed bottom-4 right-4 h-fit w-fit rounded-full bg-red-600 p-2.5 transition-all duration-300 ease-in-out lg:block">
            <x-icons.carred-down class="h-6 w-6 text-white" id="scroll-to-top-icon" />
        </a>
    </div>

    <!-- js -->
    @include('dashboard.layoutsDash.js')
    <script>
        function scrollToggle() {
            return {
                atTop: true,
                atBottom: false,

                init() {
                    this.onScroll()
                    window.addEventListener('scroll', () => this.onScroll())
                },

                onScroll() {
                    const bottomOffset =
                        document.documentElement.scrollHeight - window.innerHeight

                    this.atTop = window.scrollY <= 10
                    this.atBottom = window.scrollY >= bottomOffset - 10
                },

                handleScroll() {
                    if (this.atTop) {
                        // scroll ke PALING BAWAH
                        window.scrollTo({
                            top: document.documentElement.scrollHeight,
                            behavior: 'smooth'
                        })
                    } else {
                        // scroll ke PALING ATAS
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        })
                    }
                }
            }
        }
    </script>
</body>

</html>
