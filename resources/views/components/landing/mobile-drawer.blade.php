{{-- Goal: Mobile navigation bottom drawer menu, Livewire: None, Alpine: None --}}
<div class="fixed bottom-0 left-1/2 z-[51] w-full max-w-lg -translate-x-1/2 md:hidden">
    <div class="h-16 w-full rounded-t-2xl border-t border-zinc-200 bg-white dark:border-zinc-800 dark:bg-dark-primary">
        <div class="mx-auto grid h-full max-w-lg grid-cols-5">

            <x-drawer.button href="{{ route('landing.page') }}" :label="'Home'" :active="Route::is('landing.page')">
                <x-icons.home
                    class="{{ Route::is('landing.page') ? 'text-red-600 dark:text-red-500' : 'text-zinc-400 dark:text-zinc-500' }} h-6 w-6 transition-all duration-300 group-hover:text-red-500 dark:group-hover:text-red-400" />
            </x-drawer.button>

            <x-drawer.button href="{{ route('photo.regist') }}" :label="'Registrasi'" :active="Route::is('photo.regist')">
                <x-icons.profile-card
                    class="{{ Route::is('photo.regist') ? 'text-red-600 dark:text-red-500' : 'text-zinc-400 dark:text-zinc-500' }} h-6 w-6 transition-all duration-300 group-hover:text-red-500 dark:group-hover:text-red-400" />
            </x-drawer.button>

            <div class="flex items-center justify-center">
                <a class="group absolute bottom-7 inline-flex h-14 w-14 items-center justify-center rounded-full bg-red-600 font-medium outline outline-8 outline-red-300 hover:bottom-6 hover:size-16 hover:bg-red-700 hover:outline-red-200"
                    href="">

                    <x-icons.refresh class="h-8 w-8 stroke-white group-hover:size-9 group-hover:stroke-zinc-100" />

                    <span class="sr-only">Refresh</span>
                </a>
            </div>

            <x-drawer.button :label="'Website'">
                <x-icons.globe
                    class="h-6 w-6 text-zinc-400 transition-all duration-300 group-hover:text-red-500 dark:text-zinc-500 dark:group-hover:text-red-400" />
            </x-drawer.button>

            <x-drawer.button href="{{ route('dashboard') }}" :label="'Dashboard'" :active="Route::is('dashboard')">
                <x-icons.arrow-right-bracket
                    class="{{ Route::is('dashboard') ? 'text-red-600 dark:text-red-500' : 'text-zinc-400 dark:text-zinc-500' }} h-6 w-6 transition-all duration-300 group-hover:text-red-500 dark:group-hover:text-red-400" />
            </x-drawer.button>

        </div>
    </div>
</div>
