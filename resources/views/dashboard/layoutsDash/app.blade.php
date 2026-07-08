{{-- Goal: Main dashboard layout container, Livewire: None, Alpine: Yes --}}
<!DOCTYPE html>
<html class="{{ isset($_COOKIE['color-theme']) && $_COOKIE['color-theme'] === 'dark' ? 'dark' : '' }}"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('dashboard.layoutsDash.head')
</head>

<body id="container" class="relative bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100"
    x-data="{ openSidebar: true, menuSearch: '', dynamicBg: localStorage.getItem('dynamicBg') === null ? false : localStorage.getItem('dynamicBg') === 'true' }" x-init="$watch('dynamicBg', value => localStorage.setItem('dynamicBg', value));
    $watch('openSidebar', value => window.toggleLenis && window.toggleLenis(!value));
    window.toggleLenis && window.toggleLenis(!openSidebar);" :class="{ 'no-blur': !dynamicBg }">

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

    {{-- preload --}}
    @persist('preloader')
        <x-utils.preloader x-show="dynamicBg" />
    @endpersist

    {{-- Floating Actions Stack (Scroll to Top, Report Approvals, Leave Approvals) --}}
    <x-dashboard.floating-actions>
        {{-- Report Approval FABs (semua halaman, tanpa auto-open) --}}
        @include('dashboard.partials.report-approval-popups')

        {{-- Leave Approval Popup: auto-open hanya di halaman dashboard --}}
        <livewire:dashboard.leave-approval-popup :autoPop="Route::is('dashboard')" />
    </x-dashboard.floating-actions>

    <!-- js -->
    @include('dashboard.layoutsDash.js')
    @stack('modals')
</body>

</html>
