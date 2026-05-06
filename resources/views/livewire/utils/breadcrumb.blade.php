<nav class="mb-6 flex" aria-label="Breadcrumb">
    <ol
        class="inline-flex items-center gap-1 rounded-xl border border-zinc-200 bg-white/40 px-4 py-2 shadow-sm backdrop-blur-md dark:border-zinc-800/50 dark:bg-zinc-950/40 md:gap-2">
        @foreach ($crumbs as $i => $crumb)
            <li class="flex items-center">
                <div class="flex items-center">
                    @if ($i > 0)
                        {{-- Sharp Red Dot Separator --}}
                        <div class="mx-3 h-1 w-1 rounded-full bg-red-600 shadow-[0_0_8px_rgba(220,38,38,0.5)]"></div>
                    @endif

                    @php
                        $isLast = $loop->last;
                    @endphp

                    @if (!$isLast)
                        <a href="{{ $crumb['url'] }}"
                            class="group flex items-center text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-500 transition-all hover:text-red-600 dark:text-zinc-400 dark:hover:text-red-500">
                            @if ($i === 0)
                                <x-icons.home class="me-2 h-3.5 w-3.5 transition-transform group-hover:scale-110" />
                            @endif
                            {{ $crumb['title'] }}
                        </a>
                    @else
                        <span
                            class="flex items-center text-[10px] font-black uppercase tracking-[0.15em] text-red-600 dark:text-red-500">
                            @if ($i === 0)
                                <x-icons.home class="me-2 h-3.5 w-3.5" />
                            @endif
                            {{ $crumb['title'] }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
