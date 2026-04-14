<section class="space-y-4">
    <header class="border-b border-red-200 pb-5 dark:border-red-900/30">
        <div class="flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30">
                <svg class="h-4 w-4 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <h2 class="text-base font-bold text-red-700 dark:text-red-400">
                {{ __('Hapus Akun') }}
            </h2>
        </div>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            {{ __('Setelah akun dihapus, semua data akan dihapus secara permanen. Pastikan sudah mengunduh data penting Anda sebelum melanjutkan.') }}
        </p>
    </header>

    <button
        class="inline-flex items-center gap-2 rounded-xl border border-red-300 bg-white px-4 py-2.5 text-sm font-semibold text-red-700 shadow-sm transition-all duration-200 hover:bg-red-600 hover:text-white hover:shadow-md hover:shadow-red-500/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-800 dark:bg-transparent dark:text-red-400 dark:hover:bg-red-700 dark:hover:text-white dark:focus:ring-offset-zinc-900"
        x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>
        {{ __('Hapus Akun Ini') }}
    </button>

    <x-auth.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form class="p-6 dark:bg-zinc-900" method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-5 flex items-center gap-3">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                    <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-zinc-900 dark:text-white">
                        {{ __('Hapus akun secara permanen?') }}
                    </h2>
                    <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">
                        {{ __('Tindakan ini tidak dapat dibatalkan.') }}
                    </p>
                </div>
            </div>

            <p class="mb-5 text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Semua data akan dihapus permanent. Masukkan kata sandi Anda untuk mengkonfirmasi.') }}
            </p>

            <div class="mb-5">
                <x-input-label class="sr-only" for="password" value="{{ __('Password') }}" />
                <x-text-input
                    class="block w-full rounded-xl border-0 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 ring-1 ring-zinc-200 placeholder:text-zinc-400 focus:ring-2 focus:ring-red-500 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:placeholder:text-zinc-500"
                    id="password" name="password" type="password" placeholder="{{ __('Masukkan kata sandi') }}"
                    autocomplete="current-password" />
                <x-input-error class="mt-1.5" :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="inline-flex items-center rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 shadow-sm transition-colors hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    {{ __('Batal') }}
                </button>
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-red-700 hover:shadow-md hover:shadow-red-500/20">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-auth.modal>
</section>
