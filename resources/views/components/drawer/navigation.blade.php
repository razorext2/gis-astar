<div {{ $attributes }} class="fixed bottom-3 left-1/2 z-[160] w-[92vw] max-w-sm -translate-x-1/2 md:hidden">
    <!-- iOS Glass Navigation Container -->
    <div
        class="border-zinc-8000 h-[70px] w-full rounded-full border bg-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.1)] backdrop-blur-2xl transition-colors dark:border-white/10 dark:bg-dark-primary/60 dark:shadow-zinc-950/50">
        <div class="mx-auto grid h-full max-w-sm grid-cols-5 px-3">

            <x-drawer.button href="{{ route('dashboard') }}" :label="'Home'" :active="Route::is('dashboard')">
                <x-icons.home
                    class="{{ Route::is('dashboard') ? 'text-red-600 dark:text-red-500 scale-110 drop-shadow-sm' : 'text-zinc-400 dark:text-zinc-500' }} h-[26px] w-[26px] transition-all duration-300 group-hover:scale-110 group-hover:text-red-500 dark:group-hover:text-red-400" />
            </x-drawer.button>

            <x-drawer.button href="{{ route('attendanceIn.index') }}" :label="'Masuk'" :active="Route::is('attendanceIn.index')">
                <x-icons.arrow-left-bracket
                    class="{{ Route::is('attendanceIn.index') ? 'text-red-600 dark:text-red-500 scale-110 drop-shadow-sm' : 'text-zinc-400 dark:text-zinc-500' }} h-[26px] w-[26px] transition-all duration-300 group-hover:scale-110 group-hover:text-red-500 dark:group-hover:text-red-400" />
            </x-drawer.button>

            <!-- Center Contained Action Button -->
            <div class="relative flex items-center justify-center">
                <button
                    class="group flex h-[52px] w-[52px] items-center justify-center rounded-full bg-gradient-to-tr from-red-600 to-red-500 shadow-[0_8px_20px_-4px_rgba(220,38,38,0.4)] transition-all duration-300 ease-out will-change-transform hover:scale-105 hover:shadow-[0_12px_25px_-4px_rgba(220,38,38,0.5)] active:scale-95"
                    data-drawer-target="drawer-swipe" data-drawer-toggle="drawer-swipe" data-drawer-placement="bottom"
                    data-drawer-backdrop="false" data-drawer-edge="true" data-drawer-edge-offset="-bottom-[6rem]"
                    type="button" aria-controls="drawer-swipe">
                    <x-icons.bar
                        class="h-6 w-6 text-white transition-transform duration-500 ease-in-out group-hover:rotate-180 group-hover:scale-110" />
                    <span class="sr-only">Menu Drawer</span>
                </button>
            </div>

            <x-drawer.button href="{{ route('attendanceOut.index') }}" :label="'Keluar'" :active="Route::is('attendanceOut.index')">
                <x-icons.arrow-right-bracket
                    class="{{ Route::is('attendanceOut.index') ? 'text-red-600 dark:text-red-500 scale-110 drop-shadow-sm' : 'text-zinc-400 dark:text-zinc-500' }} h-[26px] w-[26px] transition-all duration-300 group-hover:scale-110 group-hover:text-red-500 dark:group-hover:text-red-400" />
            </x-drawer.button>

            <x-drawer.button href="{{ route('profile.edit') }}" :label="'Profile'" :active="Route::is('profile.edit')">
                <x-icons.profile-card
                    class="{{ Route::is('profile.*') ? 'text-red-600 dark:text-red-500 scale-110 drop-shadow-sm' : 'text-zinc-400 dark:text-zinc-500' }} h-[26px] w-[26px] transition-all duration-300 group-hover:scale-110 group-hover:text-red-500 dark:group-hover:text-red-400" />
            </x-drawer.button>

        </div>
    </div>
</div>
