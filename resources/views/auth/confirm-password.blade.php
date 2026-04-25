<x-guest-layout>
    <div class="mx-auto w-full max-w-md">
        <div
            class="flex w-full flex-col rounded-3xl bg-white p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-zinc-200 dark:bg-dark-primary dark:ring-zinc-800 sm:p-10">

            <div class="mb-6 pb-2">
                <a href="{{ route('login') }}"
                    class="mb-6 inline-flex items-center text-sm font-semibold text-zinc-500 transition-colors hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white">
                    <x-icons.arrow-left class="mr-2 h-4 w-4" />
                    Kembali
                </a>
                <h2 class="mb-2 text-left text-3xl font-black tracking-tight text-zinc-900 dark:text-white">
                    Konfirmasi Password
                </h2>
                <div class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('Ini adalah area aman aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.') }}
                </div>
            </div>

            <form class="w-full" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="mb-8 flex w-full flex-col">
                    <x-input-label class="mb-2 text-sm font-semibold text-zinc-700 dark:text-zinc-300" for="password"
                        :value="__('Password')" />
                    <x-text-input
                        class="block w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-3 text-zinc-900 placeholder-zinc-400 focus:border-red-500 focus:bg-white focus:ring-red-500 dark:border-zinc-700 dark:bg-dark-secondary dark:text-white dark:placeholder-zinc-500 dark:focus:border-red-500"
                        id="password" name="password" type="password" required autocomplete="current-password"
                        placeholder="••••••••" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <div class="flex w-full flex-col">
                    <button
                        class="flex w-full items-center justify-center rounded-xl bg-red-600 py-3.5 text-sm font-bold tracking-wide text-white shadow-lg shadow-red-600/20 transition-all hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-dark-primary"
                        type="submit">
                        {{ __('Konfirmasi') }}
                        <x-icons.badge-check class="ml-2 h-5 w-5" />
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
