<section>
    <header class="mb-6 border-b border-zinc-100 pb-5 dark:border-zinc-800">
        <h2 class="text-base font-bold text-zinc-900 dark:text-white">
            {{ __('Ubah Kata Sandi') }}
        </h2>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
            {{ __('Gunakan kata sandi yang panjang dan acak agar akun Anda tetap aman.') }}
        </p>
    </header>

    <form class="space-y-4" method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <x-text-input class="hidden" id="username" name="username" type="hidden" autocomplete="username" />

        <div>
            <x-input-label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" />
            <x-text-input
                class="mt-1 block w-full rounded-xl border-0 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 ring-1 ring-zinc-200 placeholder:text-zinc-400 focus:ring-2 focus:ring-red-500 dark:bg-zinc-800/50 dark:text-white dark:ring-zinc-700 dark:placeholder:text-zinc-500 dark:focus:ring-red-500"
                id="update_password_current_password" name="current_password" type="password"
                autocomplete="current-password" />
            <x-input-error class="mt-1.5" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <x-input-label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                for="update_password_password" :value="__('Kata Sandi Baru')" />
            <x-text-input
                class="mt-1 block w-full rounded-xl border-0 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 ring-1 ring-zinc-200 placeholder:text-zinc-400 focus:ring-2 focus:ring-red-500 dark:bg-zinc-800/50 dark:text-white dark:ring-zinc-700 dark:placeholder:text-zinc-500 dark:focus:ring-red-500"
                id="update_password_password" name="password" type="password" autocomplete="new-password" />
            <x-input-error class="mt-1.5" :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <x-input-label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-text-input
                class="mt-1 block w-full rounded-xl border-0 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 ring-1 ring-zinc-200 placeholder:text-zinc-400 focus:ring-2 focus:ring-red-500 dark:bg-zinc-800/50 dark:text-white dark:ring-zinc-700 dark:placeholder:text-zinc-500 dark:focus:ring-red-500"
                id="update_password_password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password" />
            <x-input-error class="mt-1.5" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-md hover:shadow-red-500/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                {{ __('Perbarui Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm font-medium text-green-600 dark:text-green-400" x-data="{ show: true }" x-show="show"
                    x-transition x-init="setTimeout(() => show = false, 2500)">
                    {{ __('Kata sandi diperbarui!') }}
                </p>
            @endif
        </div>
    </form>
</section>
