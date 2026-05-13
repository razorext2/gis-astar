<nav
    class="fixed top-0 z-40 w-full border-b border-zinc-200 bg-white/60 px-4 py-2.5 shadow-sm backdrop-blur-2xl dark:border-zinc-800 dark:bg-dark-primary/60 dark:shadow-none md:bg-white md:backdrop-blur-none md:dark:bg-dark-primary lg:px-6">
    <div class="flex items-center justify-between gap-2">

        {{-- Logo & Title --}}
        <div :class="openSidebar ? 'translate-x-0 sm:-translate-x-40' : 'translate-x-20 sm:translate-x-20'"
            class="flex shrink-0 items-center justify-start transition-all duration-500 ease-out">
            <a class="flex items-center gap-1.5 sm:gap-2" href="{{ config('app.url') }}">
                <img class="h-6 w-auto object-contain sm:h-8" src="{{ asset('assets/img/logo.png') }}" alt="Indodacin Logo"
                    loading="lazy" />
                <span
                    class="hidden text-sm font-semibold italic text-zinc-600 dark:text-zinc-400 sm:block">attendance</span>
            </a>
        </div>

        {{-- Points (Teknisi) --}}
        <div id="point-container" class="hidden sm:block">
            @if (auth()->user()->hasRole('Teknisi'))
                @livewire('widget.technician.points-accumulation')
            @endif
        </div>

        {{-- Right Actions --}}
        <div class="flex items-center justify-end gap-2 sm:gap-3">

            @livewire('utils.ping-checker')

            {{-- Notification --}}
            <div id="notifications">
                <button
                    class="relative rounded-xl p-2 text-zinc-500 transition-colors hover:bg-zinc-100 hover:text-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-300 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white dark:focus:ring-zinc-700"
                    id="notificationButton" data-dropdown-toggle="notification-dropdown"
                    data-dropdown-placement="bottom-end" data-dropdown-offset-distance="11" type="button">
                    <span class="sr-only">View notifications</span>
                    @livewire('notification-bell')
                </button>

                {{-- Notification Dropdown --}}
                <div class="z-50 my-3 hidden !w-[100vw] max-w-none sm:!w-[384px]" id="notification-dropdown">
                    <div
                        class="mx-4 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-lg dark:border-zinc-800 dark:bg-dark-primary sm:mx-0">
                        <div
                            class="flex items-center justify-between border-b border-zinc-200 px-4 py-3 dark:border-zinc-800">
                            <div class="flex items-center gap-2">
                                <div class="h-1.5 w-1.5 rounded-full bg-red-600 shadow-[0_0_6px_rgba(220,38,38,0.5)]">
                                </div>
                                <p class="text-sm font-bold text-zinc-800 dark:text-white">Notifikasi</p>
                            </div>
                        </div>

                        <div class="max-h-72 overflow-y-auto md:max-h-96" id="notificationContainer"></div>

                        <div class="border-t border-zinc-200 px-4 py-3 dark:border-zinc-800">
                            <a class="text-sm font-semibold text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                href="{{ route('notifications.index') }}">
                                Lihat semua notifikasi →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Notification --}}

            {{-- Profile --}}
            <div id="profile-content">
                <button
                    class="flex rounded-full ring-2 ring-zinc-200 transition-all hover:ring-red-500 focus:outline-none dark:ring-zinc-700 dark:hover:ring-red-600"
                    id="user-menu-button" data-dropdown-toggle="profile-dropdown" data-dropdown-placement="bottom-end"
                    data-dropdown-offset-distance="13" type="button" aria-expanded="false">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-9 w-9 rounded-full object-cover"
                        src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
                        alt="user photo" loading="lazy" onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">
                </button>

                {{-- Profile Dropdown --}}
                <div class="z-50 my-3 hidden w-60 overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-lg dark:border-zinc-800 dark:bg-dark-primary"
                    id="profile-dropdown">

                    {{-- User Info --}}
                    <div class="flex items-center gap-3 border-b border-zinc-200 px-4 py-3.5 dark:border-zinc-800">
                        <img class="h-9 w-9 shrink-0 rounded-full object-cover ring-2 ring-zinc-200 dark:ring-zinc-700"
                            src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
                            alt="user photo" loading="lazy"
                            onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-zinc-900 dark:text-white">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    {{-- Menu Items --}}
                    <ul class="py-1.5" aria-labelledby="dropdown-item">
                        <li>
                            <a class="flex items-center gap-2.5 px-4 py-2 text-sm font-medium text-zinc-600 transition-colors hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white"
                                href="{{ route('profile.me') }}">
                                My Profile
                            </a>
                        </li>
                        <li>
                            <form id="editProfile" action="{{ route('profile.edit') }}"
                                onclick="event.preventDefault();"></form>
                            <button
                                class="flex w-full items-center gap-2.5 px-4 py-2 text-left text-sm font-medium text-zinc-600 transition-colors hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white"
                                form="editProfile" type="submit">
                                Account Settings
                            </button>
                        </li>
                        @hasanyrole(['Admin', 'HRD', 'Management', 'Management-PKU', 'Management-JKT',
                            'Management-Special'])
                            <li>
                                @livewire('utils.update-log')
                            </li>
                        @endhasanyrole
                        <li>
                            <div class="flex items-center justify-between px-4 py-2.5">
                                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Theme</span>
                                <div class="flex items-center gap-1.5">
                                    <x-button-dark />
                                    <x-button-light />
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex cursor-pointer items-center justify-between px-4 py-2.5 transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800"
                                @click.stop="dynamicBg = !dynamicBg">
                                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Dynamic Bg</span>
                                <button type="button"
                                    class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-dark-primary"
                                    role="switch" :aria-checked="dynamicBg.toString()">
                                    <span class="sr-only">Toggle dynamic background</span>
                                    <span aria-hidden="true"
                                        :class="dynamicBg ? 'bg-red-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                        class="pointer-events-none absolute mx-auto h-4 w-8 rounded-full transition-colors duration-200 ease-in-out"></span>
                                    <span aria-hidden="true" :class="dynamicBg ? 'translate-x-4' : 'translate-x-0'"
                                        class="pointer-events-none absolute left-0.5 inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition-transform duration-200 ease-in-out"></span>
                                </button>
                            </div>
                        </li>
                    </ul>

                    {{-- Sign Out & Install --}}
                    <ul class="border-t border-zinc-200 py-1.5 dark:border-zinc-800" aria-labelledby="dropdown-item">
                        <li>
                            <form id="logout" method="post" action="{{ route('logout') }}"
                                onclick="event.preventDefault();">@csrf</form>
                            <button
                                class="flex w-full items-center gap-2.5 px-4 py-2 text-left text-sm font-medium text-red-600 transition-colors hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/20 dark:hover:text-red-300"
                                form="logout" type="submit">
                                Sign Out
                            </button>
                        </li>
                        <li class="flex items-center px-4 py-2" id="installAppContainer">
                            <x-button.danger wire:navigate class="w-full justify-center" id="installApp">
                                Install App
                            </x-button.danger>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- End Profile --}}

        </div>
    </div>
</nav>
