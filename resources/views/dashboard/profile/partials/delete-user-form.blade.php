{{-- Goal: User profile account deletion form, Livewire: None, Alpine: modal trigger --}}
<div
    class="col-span-full space-y-4 rounded-xl border border-red-200 bg-red-50/80 p-6 shadow-sm dark:border-red-900/30 dark:bg-red-950/80 sm:p-8">
    <header class="border-b border-red-200 pb-5 dark:border-red-900/30">
        <div class="flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30">
                <x-icons.exclamation-triangle class="h-4 w-4 text-red-600 dark:text-red-400" />
            </div>
            <h2 class="text-base font-bold text-red-700 dark:text-red-400">
                {{ __('Hapus Akun') }}
            </h2>
        </div>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
            {{ __('Setelah akun dihapus, semua data akan dihapus secara permanen. Pastikan sudah mengunduh data penting Anda sebelum melanjutkan.') }}
        </p>
    </header>

    <x-button.danger x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        <x-slot name="icon">
            <x-icons.trash class="h-4 w-4" />
        </x-slot>
        {{ __('Hapus Akun Ini') }}
    </x-button.danger>

    <x-auth.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form class="p-6 dark:bg-zinc-900" method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-5 flex items-center gap-3">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                    <x-icons.exclamation-triangle class="h-5 w-5 text-red-600 dark:text-red-400" />
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
                <x-button.danger type="button" x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-button.danger>
                <x-button.danger type="submit">
                    <x-slot name="icon">
                        <x-icons.trash class="h-4 w-4" />
                    </x-slot>
                    {{ __('Hapus Akun') }}
                </x-button.danger>
            </div>
        </form>
    </x-auth.modal>
</div>
