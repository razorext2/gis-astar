<x-drawer.navigation />

<!-- drawer component -->
<div class="fixed bottom-12 z-50 mx-auto w-11/12 translate-y-full overflow-y-auto rounded-t-2xl border bg-white transition-transform dark:border-gray-700 dark:bg-dark-primary md:hidden"
    id="drawer-swipe" aria-labelledby="drawer-swipe-label" tabindex="-1">
    <div class="cursor-pointer p-4 hover:bg-gray-50 dark:hover:bg-gray-700" data-drawer-toggle="drawer-swipe">
        <span class="absolute left-1/2 top-3 h-1 w-8 -translate-x-1/2 rounded-xl bg-gray-300 dark:bg-gray-600"></span>
    </div>
    <div class="grid max-h-96 grid-cols-3 gap-6 overflow-y-auto px-4 pb-[60px] pt-4 lg:grid-cols-4">

        @foreach ($drawerLinks as $item)
            @php
                $isActive = Route::is($item['check']);
                $icon = $iconMap[$item['icon']] ?? null;
            @endphp

            @can($item['permission'])
                <a class="{{ $isActive ? 'bg-gray-100 dark:bg-gray-700' : 'dark:bg-dark-primary bg-white' }} group cursor-pointer rounded-xl p-4 hover:bg-gray-100 dark:hover:bg-gray-600"
                    href="{{ route($item['link']) }}">
                    <div
                        class="{{ $isActive ? 'bg-gray-100 dark:bg-gray-700' : 'dark:bg-gray-600 bg-gray-200' }} mx-auto mb-2 flex h-[48px] max-h-[48px] w-[48px] max-w-[48px] items-center justify-center rounded-xl group-hover:bg-gray-100 dark:group-hover:bg-gray-600">

                        @if ($icon)
                            <x-dynamic-component :component="'icons.' . $icon"
                                class="{{ $isActive ? 'text-red-600' : 'text-gray-400' }} h-7 w-7 transition-transform duration-500 ease-in-out group-hover:scale-125 group-hover:text-red-600" />
                        @endif

                    </div>
                    <div
                        class="{{ $isActive ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400 ' }} text-center text-sm font-medium group-hover:text-gray-900 group-hover:dark:text-white">
                        {{ $item['label'] }}
                    </div>
                </a>
            @endcan
        @endforeach
    </div>
</div>
