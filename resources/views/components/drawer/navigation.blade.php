<div {{ $attributes }} class="fixed bottom-0 left-1/2 z-[51] w-full max-w-lg -translate-x-1/2 md:hidden">
    <div class="h-16 w-full rounded-t-2xl border-t border-gray-200 bg-white dark:border-gray-700 dark:bg-dark-primary">
        <div class="mx-auto grid h-full max-w-lg grid-cols-5">
            <x-drawer.button href="{{ route('dashboard') }}" :label="'Home'" :active="Route::is('dashboard')">
                <x-icons.home
                    class="{{ Route::is('dashboard') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
            </x-drawer.button>

            <x-drawer.button href="{{ route('attendanceIn.index') }}" :label="'Masuk'" :active="Route::is('attendanceIn.index')">
                <x-icons.arrow-left-bracket
                    class="{{ Route::is('attendanceIn.index') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
            </x-drawer.button>

            <div class="flex items-center justify-center">
                <button
                    class="group absolute bottom-8 inline-flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 font-medium outline outline-8 outline-blue-300 transition-transform duration-500 ease-in-out will-change-transform hover:scale-110 hover:bg-blue-700 hover:outline-blue-200"
                    data-drawer-target="drawer-swipe" data-drawer-toggle="drawer-swipe" data-drawer-placement="bottom"
                    data-drawer-edge="true" data-drawer-edge-offset="-bottom-20" type="button"
                    aria-controls="drawer-swipe">
                    <x-icons.bar
                        class="h-8 w-8 text-white transition-transform duration-500 ease-in-out will-change-transform group-hover:size-9 group-hover:rotate-90 group-hover:text-gray-100" />
                    <span class="sr-only">Menu</span>
                </button>
            </div>

            <x-drawer.button href="{{ route('attendanceOut.index') }}" :label="'Keluar'" :active="Route::is('attendanceOut.index')">
                <x-icons.arrow-right-bracket
                    class="{{ Route::is('attendanceOut.index') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
            </x-drawer.button>

            <x-drawer.button href="{{ route('profile.edit') }}" :label="'Profile'" :active="Route::is('profile.edit')">
                <x-icons.profile-card
                    class="{{ Route::is('profile.*') ? 'text-red-600' : 'text-gray-400' }} h-6 w-6 group-hover:text-red-600" />
            </x-drawer.button>
        </div>
    </div>
</div>
