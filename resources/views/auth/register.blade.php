<x-guest-layout>
    <div class="mx-auto w-full max-w-md">
        <div class="flex w-full flex-col rounded-3xl bg-white p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 sm:p-10">
            
            <div class="mb-8 border-b border-zinc-100 pb-5 dark:border-zinc-800">
                <h2 class="text-left text-3xl font-black tracking-tight text-zinc-900 dark:text-white">
                    Registrasi
                </h2>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    Daftar akun baru untuk mengakses sistem laporan.
                </p>
            </div>

            <form class="w-full" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-5 flex w-full flex-col">
                    <x-input-label class="mb-2 text-sm font-semibold text-zinc-700 dark:text-zinc-300" for="name" :value="__('Name')" />
                    <x-text-input class="block w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-zinc-900 placeholder-zinc-400 focus:border-red-500 focus:bg-white focus:ring-red-500 dark:border-zinc-700 dark:bg-dark-secondary dark:text-white dark:placeholder-zinc-500 dark:focus:border-red-500" 
                        id="name" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email Address -->
                <div class="mb-5 flex w-full flex-col">
                    <x-input-label class="mb-2 text-sm font-semibold text-zinc-700 dark:text-zinc-300" for="email" :value="__('Email Account')" />
                    <x-text-input class="block w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-zinc-900 placeholder-zinc-400 focus:border-red-500 focus:bg-white focus:ring-red-500 dark:border-zinc-700 dark:bg-dark-secondary dark:text-white dark:placeholder-zinc-500 dark:focus:border-red-500" 
                        id="email" name="email" type="email" :value="old('email')" required autocomplete="username" placeholder="contoh@indodacin.com" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <!-- Password -->
                <div class="mb-5 flex w-full flex-col">
                    <x-input-label class="mb-2 text-sm font-semibold text-zinc-700 dark:text-zinc-300" for="password" :value="__('Password')" />
                    <x-text-input class="block w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-zinc-900 placeholder-zinc-400 focus:border-red-500 focus:bg-white focus:ring-red-500 dark:border-zinc-700 dark:bg-dark-secondary dark:text-white dark:placeholder-zinc-500 dark:focus:border-red-500" 
                        id="password" name="password" type="password" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-8 flex w-full flex-col">
                    <x-input-label class="mb-2 text-sm font-semibold text-zinc-700 dark:text-zinc-300" for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input class="block w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-zinc-900 placeholder-zinc-400 focus:border-red-500 focus:bg-white focus:ring-red-500 dark:border-zinc-700 dark:bg-dark-secondary dark:text-white dark:placeholder-zinc-500 dark:focus:border-red-500" 
                        id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                </div>

                <div class="flex w-full flex-col">
                    <button class="flex w-full items-center justify-center rounded-xl bg-red-600 py-3.5 text-sm font-bold tracking-wide text-white transition-all hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-dark-primary shadow-lg shadow-red-600/20" type="submit">
                        {{ __('Registrasi Akun') }}
                        <x-icons.arrow-right class="ml-2 h-4 w-4" />
                    </button>

                    <div class="mt-6 flex items-center justify-center">
                        @if (Route::has('login'))
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Sudah punya akun? </span>
                            <a class="ml-1 text-sm font-bold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors" href="{{ route('login') }}">
                                {{ __('Sign In') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
