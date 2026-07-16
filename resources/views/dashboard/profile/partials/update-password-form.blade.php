<div class="rounded-xl border border-zinc-200 p-4 shadow-md dark:border-zinc-800 lg:p-6"
    x-bind:class="dynamicBg ?
        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
    <header class="mb-6 border-b border-zinc-200 pb-5 dark:border-zinc-800">
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
            <x-button.success type="submit">
                <x-slot name="icon">
                    <x-icons.lock class="h-4 w-4" />
                </x-slot>
                {{ __('Perbarui Sandi') }}
            </x-button.success>

            @if (session('status') === 'password-updated')
                <p class="text-sm font-medium text-green-600 dark:text-green-400" x-data="{ show: true }" x-show="show"
                    x-transition x-init="setTimeout(() => show = false, 2500)">
                    {{ __('Kata sandi diperbarui!') }}
                </p>
            @endif
        </div>
    </form>
</div>
