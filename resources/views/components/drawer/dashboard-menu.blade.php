<div class="grid cursor-pointer grid-cols-3 items-center justify-between gap-2 text-gray-500">

    @forelse ($links as $item)
        @php
            $icon = $icons[$item['icon']] ?? null;
        @endphp

        @can($item['permission'])
            <x-menu.mobile-link href="{{ route($item['link']) }}" :label="$item['label']">
                <x-dynamic-component :component="'icons.' . $icon" class="h-7 w-7 text-red-500" />
            </x-menu.mobile-link>
        @endcan
    @empty
        <div class="col-span-3 flex items-center">
            <span class="text-center font-semibold text-red-500">
                Anda belum memiliki akses ke menu apapun.
            </span>
        </div>
    @endforelse

</div>
