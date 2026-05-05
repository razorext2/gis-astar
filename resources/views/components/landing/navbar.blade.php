<nav
    class="border-b border-zinc-200 bg-white/60 backdrop-blur-md p-4 shadow-md dark:border-zinc-800 dark:bg-dark-primary/60 dark:backdrop-blur-md dark:shadow-none md:block lg:p-8">
    <div class="center mx-auto flex max-w-screen-xl flex-wrap items-center justify-between">

        <a class="flex items-center space-x-3 md:mx-auto md:mb-4 lg:mx-0 lg:mb-0 rtl:space-x-reverse" href="#">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Indodacin Logo" loading="lazy" />
        </a>

        <button
            class="inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-sm text-zinc-500 hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-200 md:hidden"
            data-collapse-toggle="mega-menu-full" type="button" aria-controls="mega-menu-full" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <x-icons.three-dots class="h-5 w-5" />
        </button>

        <div class="mx-auto hidden w-full items-center justify-between font-medium md:order-1 md:flex md:w-auto lg:mx-0"
            id="mega-menu-full">
            <ul
                class="mt-4 flex flex-col items-center rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-dark-primary md:mt-0 md:flex-row md:space-x-8 md:border-0 md:bg-white md:p-0 rtl:space-x-reverse">
                <x-landing.nav-link href="{{ route('landing.page') }}" :active="request()->is('/')">Home</x-landing.nav-link>
                <x-landing.nav-link href="{{ route('photo.regist') }}" :active="request()->is('photo-regist')">Registrasi</x-landing.nav-link>
                <x-landing.nav-link href="#scan" :active="request()->is('#scan')">Absen</x-landing.nav-link>
                <x-landing.nav-guide></x-landing.nav-guide>
                <x-landing.nav-link href="{{ auth()->user() ? route('dashboard') : route('login') }}" :active="request()->is('login')">
                    {{ auth()->user() ? 'Dashboard' : 'Login' }}
                </x-landing.nav-link>
            </ul>
            <div class="ml-4 gap-x-2 md:grid md:grid-cols-2">
                <x-button-dark />
                <x-button-light />
            </div>
        </div>
    </div>

    <div class="mt-1 hidden bg-white/60 backdrop-blur-md dark:bg-dark-primary/60 md:bg-white/60" id="mega-menu-full-dropdown">
        <div
            class="mx-auto grid max-w-screen-lg px-4 py-5 text-zinc-900 transition duration-1000 ease-in-out dark:text-white sm:grid-cols-1 md:px-6">
            <ul class="space-y-4 text-left text-zinc-500">
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5.917 5.724 10.5 15 1.5" />
                    </svg>
                    <span class="dark:text-white">Tekan tombol <i
                            class="text-xl font-bold text-black dark:text-zinc-50">[Enter]</i>
                        untuk start dan stop kamera</span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5.917 5.724 10.5 15 1.5" />
                    </svg>
                    <span class="dark:text-white">Tekan tombol <i
                            class="text-xl font-bold text-black dark:text-zinc-50">[*]</i>
                        untuk
                        melakukan refresh</span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5.917 5.724 10.5 15 1.5" />
                    </svg>
                    <span class="dark:text-white">Tekan tombol <i
                            class="text-xl font-bold text-black dark:text-zinc-50">[/]</i>
                        untuk melakukan pendaftaran</span></span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5.917 5.724 10.5 15 1.5" />
                    </svg>
                    <span class="dark:text-white">Lepas semua hal yang menutupi wajah. Pastikan wajah menghadap ke
                        kamera.</span></span>
                </li>
                <li class="flex items-center space-x-3 rtl:space-x-reverse">
                    <svg class="h-3.5 w-3.5 flex-shrink-0 text-green-500" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5.917 5.724 10.5 15 1.5" />
                    </svg>
                    <span class="dark:text-white">Jika wajah berhasil terdeteksi dan sudah muncul data nya, silahkan
                        stop
                        aplikasi.</span></span>
                </li>
            </ul>

        </div>
    </div>
</nav>
