@php
    $menu = config('navigation');
@endphp

<!-- Sidebar Navigation -->
<aside
    class="left-0 top-0 z-40 hidden h-screen min-w-[265px] flex-col bg-white pb-14 shadow-sm transition-all duration-300 ease-out dark:bg-[#09090b] dark:shadow-none md:fixed md:flex"
    id="logo-sidebar" aria-label="Sidebar" :class="openSidebar ? 'translate-x-0' : '-translate-x-72'">

    {{-- Header / Toggle --}}
    <div id="tombolSidebar" :class="openSidebar ? 'translate-x-0' : 'absolute translate-x-24 bg-white dark:bg-[#09090b]'"
        class="mx-auto flex w-full justify-between rounded-br-2xl p-5 shadow-md drop-shadow-lg transition-all duration-200 ease-out dark:border-b-[1px] dark:border-r-[4px] dark:border-red-800 dark:shadow-none dark:drop-shadow-none">
        <div class="flex items-center justify-start">
            <a class="flex items-center" href="{{ config('app.url') }}">
                <img class="h-8" src="{{ asset('assets/img/logo.png') }}" alt="Indodacin Logo" loading="lazy" />
            </a>
        </div>
        <button @click="openSidebar = !openSidebar" class="rounded-lg px-2 py-1">
            <span x-show="!openSidebar">
                <x-icons.open-sidebar-alt data-tooltip-target="open-sidebar-alt"
                    class="h-6 w-6 text-gray-800 transition-all duration-300 ease-in-out hover:scale-110 dark:text-white" />
                <div id="open-sidebar-alt" role="tooltip"
                    class="shadow-xs tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700">
                    Buka Sidebar
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </span>
            <span x-show="openSidebar">
                <x-icons.close-sidebar-alt data-tooltip-target="close-sidebar-alt"
                    class="h-6 w-6 text-gray-800 transition-all duration-300 ease-in-out hover:scale-110 dark:text-white" />
                <div id="close-sidebar-alt" role="tooltip"
                    class="shadow-xs tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700">
                    Tutup Sidebar
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </span>
        </button>
    </div>

    {{-- Navigation Links --}}
    <div class="overflow-y-scroll p-5" wire:scroll>
        <ul class="space-y-2 font-medium">

            @foreach ($menu as $item)
                @php
                    // ── Guard check ───────────────────────────────────────────
                    $guard = $item['guard'] ?? null;
                    $canSee = match (true) {
                        $guard === null => true,
                        $guard[0] === 'any_permission' => auth()->user()->hasAnyPermission($guard[1]),
                        $guard[0] === 'role' => auth()->user()->hasRole($guard[1]),
                        $guard[0] === 'can' => auth()->user()->can($guard[1]),
                        default => true,
                    };
                @endphp

                @if ($canSee)

                    @if (empty($item['submenu'] ?? []))
                        {{-- ── Simple link ────────────────────────────────── --}}
                        @php
                            $isActive = collect($item['check'])->contains(fn($r) => Route::is($r));
                        @endphp
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="{{ $isActive ? 'text-red-600 font-bold bg-gray-100 dark:bg-dark-primary' : 'text-gray-900 dark:text-gray-300' }} group flex flex-row items-center rounded-xl p-2 hover:text-red-600"
                                {{ $item['navigate'] ?? true ? 'wire:navigate' : '' }}>

                                <x-dynamic-component :component="'icons.' . $item['icon']"
                                    class="{{ $isActive ? 'text-red-600' : '' }} h-6 w-6 group-hover:text-red-600" />

                                <span class="ms-3 inline-flex text-sm group-hover:text-red-600">
                                    {{ $item['label'] }}
                                    @if ($item['counter'] ?? null)
                                        @if (!($item['counter_permission'] ?? null) || auth()->user()->can($item['counter_permission']))
                                            @livewire($item['counter'])
                                        @endif
                                    @endif
                                </span>
                            </a>
                        </li>
                    @else
                        {{-- ── Group with submenu ──────────────────────────── --}}
                        @php
                            // Derive active routes from all submenu check arrays
                            $groupRoutes = collect($item['submenu'])->pluck('check')->flatten()->all();
                        @endphp

                        <x-dashboard.sidebar-group :label="$item['label']" :icon="$item['icon']" :routes="$groupRoutes">

                            @foreach ($item['submenu'] as $sub)
                                @php
                                    $perm = $sub['permission'] ?? null;
                                    $subCan = match (true) {
                                        $perm === null => true,
                                        is_array($perm) => auth()->user()->hasAnyPermission($perm),
                                        default => auth()->user()->can($perm),
                                    };
                                @endphp

                                @if ($subCan)
                                    <x-dashboard.sidebar-sublink :href="route($sub['route'])" :icon="$sub['icon']" :check="$sub['check']"
                                        :navigate="$sub['navigate'] ?? true">
                                        {{ $sub['label'] }}
                                        @if ($sub['counter'] ?? null)
                                            @if (!($sub['counter_permission'] ?? null) || auth()->user()->can($sub['counter_permission']))
                                                @livewire($sub['counter'])
                                            @endif
                                        @endif
                                    </x-dashboard.sidebar-sublink>
                                @endif
                            @endforeach

                        </x-dashboard.sidebar-group>
                    @endif

                @endif
            @endforeach

        </ul>
    </div>

    <!-- start footer -->
    @include('dashboard.layoutsDash.footer')
    <!-- footer -->
</aside>
