@php
    $menu = config('navigation');
@endphp

<!-- Sidebar Navigation -->
<aside
    class="left-0 top-0 z-[60] hidden h-screen w-[272px] flex-col border-r border-zinc-200/50 bg-white/80 pb-14 backdrop-blur-xl transition-all duration-300 ease-out dark:border-white/5 dark:bg-zinc-950/80 dark:shadow-none md:fixed md:flex"
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

    {{-- Search Bar --}}
    <div class="px-5 pt-4" x-show="openSidebar">
        <div class="group relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <x-icons.search
                    class="h-4 w-4 text-zinc-400 transition-colors duration-200 group-focus-within:text-red-600" />
            </div>
            <input type="text" x-model="menuSearch"
                class="block w-full rounded-xl border-zinc-200 bg-zinc-50/50 py-2.5 pl-10 pr-3 text-sm tracking-wide text-zinc-900 placeholder-zinc-400 transition-all duration-200 focus:border-red-600 focus:bg-white focus:ring-4 focus:ring-red-600/5 dark:border-white/5 dark:bg-white/5 dark:text-white dark:placeholder-zinc-500 dark:focus:border-red-500"
                placeholder="Cari Menu..." />
            <button x-show="menuSearch" @click="menuSearch = ''"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-zinc-400 hover:text-red-500">
                <x-icons.close class="h-4 w-4" />
            </button>
        </div>
    </div>

    {{-- Navigation Links --}}
    <div class="overflow-x-hidden overflow-y-scroll p-5" wire:scroll>
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

                    @if (($item['type'] ?? '') === 'header')
                        {{-- ── Header / Spacer ────────────────────────────────── --}}
                        <li x-show="!menuSearch || '{{ strtolower($item['label']) }}'.includes(menuSearch.toLowerCase())"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0" class="px-4 py-2">
                            <span
                                class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-400 dark:text-zinc-500">
                                {{ $item['label'] }}
                            </span>
                        </li>
                    @elseif (empty($item['submenu'] ?? []))
                        {{-- ── Simple link ────────────────────────────────── --}}
                        @php
                            $isActive = collect($item['check'])->contains(fn($r) => Route::is($r));
                        @endphp
                        <li x-show="!menuSearch || '{{ strtolower($item['label']) }}'.includes(menuSearch.toLowerCase())"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            <a href="{{ route($item['route']) }}"
                                class="{{ $isActive ? 'bg-zinc-100/80 dark:bg-white/5 text-red-600 dark:text-red-400 font-bold border-l-4 border-red-600' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }} group relative flex items-center gap-3.5 rounded-r-2xl px-4 py-3 transition-all duration-200"
                                {{ $item['navigate'] ?? true ? 'wire:navigate' : '' }}>

                                <x-dynamic-component :component="'icons.' . $item['icon']"
                                    class="{{ $isActive ? 'text-red-600' : 'text-zinc-400 group-hover:text-red-600' }} h-5 w-5 flex-shrink-0 transition-colors duration-200" />

                                <div class="flex flex-1 items-center justify-between overflow-hidden">
                                    <span
                                        class="whitespace-normal break-words text-sm tracking-wide transition-colors duration-200">
                                        {{ $item['label'] }}
                                    </span>

                                    @if ($item['counter'] ?? null)
                                        <div class="flex-shrink-0">
                                            @if (!($item['counter_permission'] ?? null) || auth()->user()->can($item['counter_permission']))
                                                @livewire($item['counter'])
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </li>
                    @else
                        {{-- ── Group with submenu ──────────────────────────── --}}
                        @php
                            // Derive active routes and search terms
                            $groupRoutes = collect($item['submenu'])->pluck('check')->flatten()->all();
                            $searchTerms = collect($item['submenu'])
                                ->pluck('label')
                                ->push($item['label'])
                                ->map(fn($l) => strtolower($l))
                                ->toJson();
                        @endphp

                        <x-dashboard.sidebar-group :label="$item['label']" :icon="$item['icon']" :routes="$groupRoutes"
                            :search-terms="$searchTerms">

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
                                        :navigate="$sub['navigate'] ?? true" :counter="($sub['counter'] ?? null) &&
                                        (!($sub['counter_permission'] ?? null) ||
                                            auth()->user()->can($sub['counter_permission']))
                                            ? $sub['counter']
                                            : null">
                                        {{ $sub['label'] }}
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
