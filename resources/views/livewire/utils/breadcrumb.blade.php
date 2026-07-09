{{-- Goal: Render dynamic breadcrumb navigation with truncated segment titles, Livewire: Utils\Breadcrumb, Alpine: None --}}
@php
    $total = count($crumbs);
    $displayCrumbs = [];
    if ($total >= 4) {
        $displayCrumbs[] = $crumbs[0];
        $displayCrumbs[] = $crumbs[1];
        $displayCrumbs[] = ['is_ellipsis' => true];
        $displayCrumbs[] = $crumbs[$total - 1];
    } else {
        $displayCrumbs = $crumbs;
    }
@endphp

<nav class="mb-6 flex" aria-label="Breadcrumb">
    <ol :class="dynamicBg
        ?
        'border-glass-border-light bg-glass-light backdrop-blur-md shadow-md dark:border-glass-border-dark dark:bg-glass-dark dark:shadow-none' :
        'border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-dark-primary'"
        class="inline-flex items-center gap-1 rounded-xl border px-4 py-2 md:gap-2">
        @foreach ($displayCrumbs as $i => $crumb)
            <li class="flex items-center">
                <div class="flex items-center">
                    @if ($i > 0)
                        <x-icons.angle-right class="mx-2 h-3.5 w-3.5 text-zinc-400 dark:text-zinc-500" />
                    @endif

                    @if (isset($crumb['is_ellipsis']))
                        <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-400 dark:text-zinc-500">
                            ...
                        </span>
                    @else
                        @php
                            $isLast = $loop->last;
                            $isFirst = $i === 0;
                        @endphp

                        @if (!$isLast)
                            <a href="{{ $crumb['url'] }}"
                                class="group flex items-center whitespace-nowrap text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 transition-all hover:text-red-600 dark:text-zinc-400 dark:hover:text-red-500">
                                @if ($isFirst)
                                    <x-icons.home class="me-2 h-3.5 w-3.5 transition-transform group-hover:scale-110" />
                                @endif
                                {{ $crumb['title'] }}
                            </a>
                        @else
                            <span
                                class="flex items-center whitespace-nowrap text-[10px] font-black uppercase tracking-[0.15em] text-red-600 dark:text-red-500">
                                @if ($isFirst)
                                    <x-icons.home class="me-2 h-3.5 w-3.5" />
                                @endif
                                {{ $crumb['title'] }}
                            </span>
                        @endif
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
