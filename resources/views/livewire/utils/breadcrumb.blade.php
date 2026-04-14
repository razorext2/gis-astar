<nav class="mb-4 flex" aria-label="Breadcrumb">
    <ol
        class="inline-flex flex-wrap items-center gap-2 rounded-2xl border border-zinc-200 bg-white/50 px-3 py-2 shadow-sm backdrop-blur-sm dark:border-zinc-800 dark:bg-zinc-900/50 md:gap-3 md:px-4">
        @foreach ($crumbs as $i => $crumb)
            <li class="flex items-center">
                <div class="flex items-center">
                    @if ($i > 0)
                        {{-- Separator --}}
                        <svg class="mx-1 h-3 w-3 text-zinc-400 dark:text-zinc-600 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    @else
                        {{-- Home Icon for First Item --}}
                        <x-icons.home
                            class="me-2 h-4 w-4 text-zinc-400 transition-colors group-hover:text-red-500 dark:text-zinc-500" />
                    @endif

                    @php
                        $isLast = $loop->last;
                    @endphp

                    @if (!$isLast)
                        <a href="{{ $crumb['url'] }}"
                            class="group flex items-center text-sm font-medium text-zinc-500 transition-colors hover:text-red-600 dark:text-zinc-400 dark:hover:text-red-500">
                            {{ $crumb['title'] }}
                        </a>
                    @else
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">
                            {{ $crumb['title'] }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
