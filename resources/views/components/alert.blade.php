<div class="fixed bottom-28 z-[100] flex h-auto w-full scale-90 transform items-center divide-x rounded-xl opacity-0 transition duration-300 md:bottom-5"
    id="toast-bottom-right" role="alert">
    <div class="toast-bottom-right mx-auto flex w-full max-w-xs items-center rounded-xl p-4 text-zinc-500 ring-1 ring-zinc-200 dark: dark:text-zinc-100 dark:ring-zinc-800 md:fixed md:bottom-0 md:right-5 md:mx-0"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'"
        id="toast-success" role="alert">
        <div
            class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-500">
            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal text-black dark:text-white">{{ session('success') }}</div>
        <button
            class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-md bg-transparent p-1.5 text-zinc-400 hover:bg-zinc-100/50 hover:text-zinc-900 focus:ring-2 focus:ring-zinc-200 dark:hover:bg-zinc-800/50 dark:hover:text-white"
            data-dismiss-target="#toast-success" type="button" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
</div>
