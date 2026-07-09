{{-- Goal: Mobile Drawer Menu with dynamic background, Livewire: None, Alpine: dynamicBg scope from parent --}}
<x-drawer.navigation />

{{-- Backdrop overlay — closes drawer when clicking outside --}}
<div
    x-data="{
        isOpen: false,
        init() {
            const drawer = document.getElementById('drawer-swipe');
            if (!drawer) return;
            const observer = new MutationObserver(() => {
                this.isOpen = !drawer.classList.contains('translate-y-full');
            });
            observer.observe(drawer, { attributes: true, attributeFilter: ['class'] });
        }
    }"
    x-show="isOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="document.querySelector('[data-drawer-toggle=\'drawer-swipe\']').click()"
    class="fixed inset-0 z-[149] bg-black/40 md:hidden"
    style="display:none;">
</div>

<!-- drawer component -->
<div x-data="{ search: '' }"
    class="fixed bottom-0 left-0 right-0 z-[150] mx-auto w-[96vw] max-w-lg translate-y-full overflow-hidden rounded-t-2xl border-x border-t pb-16 shadow-[0_-10px_40px_-15px_rgba(0,0,0,0.3)] transition-[transform] duration-[420ms] ease-[cubic-bezier(0.16,1,0.3,1)] will-change-transform [transform-style:preserve-3d] [backface-visibility:hidden] md:hidden"
    :class="dynamicBg
        ? 'bg-glass-light border-glass-border-light backdrop-blur-md dark:bg-glass-dark dark:border-glass-border-dark'
        : 'bg-white border-zinc-200 dark:bg-dark-primary dark:border-zinc-800'"
    id="drawer-swipe" aria-labelledby="drawer-swipe-label" tabindex="-1">

    <!-- Drag Handle -->
    <div class="cursor-pointer p-5 transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-900"
        data-drawer-toggle="drawer-swipe">
        <span
            class="absolute left-1/2 top-4 h-1.5 w-12 -translate-x-1/2 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
    </div>

    <!-- Live Search Field -->
    <div class="px-5 pb-4">
        <div class="group relative">
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4">
                <x-icons.search class="h-5 w-5 text-zinc-400 transition-colors group-focus-within:text-red-500" />
            </div>
            <input type="text" x-model="search"
                class="block w-full rounded-lg border-0 bg-zinc-50/50 p-3.5 ps-11 text-sm text-zinc-900 ring-1 ring-zinc-200 transition-all focus:ring-2 focus:ring-red-500 dark:bg-zinc-900/50 dark:text-white dark:placeholder-zinc-500 dark:ring-zinc-800"
                placeholder="Cari menu...">
        </div>
    </div>

    <!-- Menu Grid -->
    <div
        class="custom-scrollbar grid max-h-[60vh] grid-cols-3 gap-x-2 gap-y-6 overflow-y-auto px-4 pb-12 pt-2 md:grid-cols-4">

        @foreach ($drawerLinks as $item)
            @php
                // Unified guard check — same pattern as desktop sidebar
                $guard = $item['guard'] ?? null;
                $canSee = match (true) {
                    $guard === null => true,
                    $guard[0] === 'any_permission' => auth()->user()->hasAnyPermission($guard[1]),
                    $guard[0] === 'role' => auth()->user()->hasRole($guard[1]),
                    $guard[0] === 'can' => auth()->user()->can($guard[1]),
                    default => true,
                };

                $isActive = Route::is($item['check']);
            @endphp

            @if ($canSee)
                <a x-show="search === '' || '{{ addslashes(strtolower($item['label'])) }}'.includes(search.toLowerCase())"
                    x-transition.opacity.duration.300ms
                    class="{{ $isActive ? 'bg-red-50/50 dark:bg-red-500/10 ring-1 ring-red-200 dark:ring-red-900/50' : 'bg-transparent hover:bg-zinc-100 dark:hover:bg-zinc-800/50' }} group flex cursor-pointer flex-col items-center rounded-xl p-3 transition-all duration-300"
                    href="{{ route($item['link']) }}">

                    <div
                        class="{{ $isActive ? 'bg-red-600 text-white shadow-md shadow-red-500/30' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400 group-hover:bg-white dark:group-hover:bg-zinc-700 group-hover:shadow-sm group-hover:text-zinc-900 dark:group-hover:text-zinc-100 ring-1 ring-zinc-200 dark:ring-zinc-700' }} mb-3 flex h-14 w-14 items-center justify-center rounded-lg transition-all duration-300 group-hover:-translate-y-1 [transform:translate3d(0,0,0)] [backface-visibility:hidden]">
                        <x-dynamic-component :component="'icons.' . $item['icon']"
                            class="{{ $isActive ? '' : 'group-hover:scale-110' }} h-7 w-7 transition-transform duration-300 [transform:translate3d(0,0,0)]" />
                    </div>

                    <div
                        class="{{ $isActive ? 'text-red-700 dark:text-red-400 font-bold' : 'text-zinc-600 dark:text-zinc-400 font-medium group-hover:text-zinc-900 dark:group-hover:text-zinc-200' }} line-clamp-2 text-center text-xs tracking-tight transition-colors">
                        {{ $item['label'] }}
                    </div>
                </a>
            @endif
        @endforeach

        <!-- Empty State -->
        <div x-show="!$el.parentNode.querySelector('a:not([style*=\'display: none\'])')"
            class="col-span-3 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400" style="display: none;">
            Menu tidak ditemukan.
        </div>
    </div>
</div>
