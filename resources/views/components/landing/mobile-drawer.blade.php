<div class="fixed bottom-0 left-1/2 z-[51] w-full max-w-lg -translate-x-1/2 md:hidden">
    <div class="h-16 w-full rounded-t-2xl border-t border-zinc-200 bg-white dark:border-zinc-800 dark:bg-dark-primary">
        <div class="mx-auto grid h-full max-w-lg grid-cols-5">

            <x-drawer.button href="{{ route('landing.page') }}" :label="'Home'" :active="Route::is('landing.page')">
                <path
                    d="M18.0003 14L19.4724 15.7175C20.9131 17.3984 21.6335 18.2389 21.6511 18.9504C21.6665 19.5688 21.3948 20.1595 20.9153 20.5503C20.3635 21 19.2566 21 17.0428 21H6.95778C4.74382 21 3.63684 21 3.0851 20.5503C2.60558 20.1595 2.3339 19.5688 2.34925 18.9504C2.36691 18.2388 3.08734 17.3983 4.52821 15.7174L6.00034 14M19.0001 10C19.0001 13.866 15.8661 17 12.0001 17C8.13406 17 5.00006 13.866 5.00006 10C5.00006 6.13401 8.13406 3 12.0001 3C15.8661 3 19.0001 6.13401 19.0001 10ZM15.0001 10C15.0001 11.6569 13.6569 13 12.0001 13C10.3432 13 9.00006 11.6569 9.00006 10C9.00006 8.34315 10.3432 7 12.0001 7C13.6569 7 15.0001 8.34315 15.0001 10Z"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </x-drawer.button>

            <x-drawer.button href="{{ route('photo.regist') }}" :label="'Registrasi'" :active="Route::is('photo.regist')">
                <path
                    d="M18 9H14M18 12H14M12 15.5C11.7164 14.3589 10.481 13.5 9 13.5C7.519 13.5 6.28364 14.3589 6 15.5M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V15.8C3 16.9201 3 17.4802 3.21799 17.908C3.40973 18.2843 3.71569 18.5903 4.09202 18.782C4.51984 19 5.07989 19 6.2 19ZM10 9.5C10 10.0523 9.55228 10.5 9 10.5C8.44772 10.5 8 10.0523 8 9.5C8 8.94772 8.44772 8.5 9 8.5C9.55228 8.5 10 8.94772 10 9.5Z"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </x-drawer.button>

            <div class="flex items-center justify-center">
                <a class="group absolute bottom-7 inline-flex h-14 w-14 items-center justify-center rounded-full bg-red-600 font-medium outline outline-8 outline-red-300 hover:bottom-6 hover:size-16 hover:bg-red-700 hover:outline-red-200"
                    href="">

                    <svg class="h-8 w-8 stroke-white group-hover:size-9 group-hover:stroke-gray-100" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M3 3V8M3 8H8M3 8L6 5.29168C7.59227 3.86656 9.69494 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21C7.71683 21 4.13247 18.008 3.22302 14"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>

                    <span class="sr-only">Refresh</span>
                </a>
            </div>

            <x-drawer.button :label="'Registrasi'">
                <path
                    d="M21 12C21 16.9706 16.9706 21 12 21M21 12C21 7.02944 16.9706 3 12 3M21 12C21 13.6569 16.9706 15 12 15C7.02944 15 3 13.6569 3 12M21 12C21 10.3431 16.9706 9 12 9C7.02944 9 3 10.3431 3 12M12 21C7.02944 21 3 16.9706 3 12M12 21C10.3431 21 9 16.9706 9 12C9 7.02944 10.3431 3 12 3M12 21C13.6569 21 15 16.9706 15 12C15 7.02944 13.6569 3 12 3M3 12C3 7.02944 7.02944 3 12 3"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </x-drawer.button>

            <x-drawer.button href="{{ route('dashboard') }}" :label="'Registrasi'" :active="Route::is('dashboard')">
                <path d="M13 3H12C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21H13M17 8L21 12M21 12L17 16M21 12H9"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </x-drawer.button>

        </div>
    </div>
</div>
