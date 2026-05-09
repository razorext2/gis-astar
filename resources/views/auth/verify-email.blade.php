<x-guest-layout>
    <div class="mx-auto w-full max-w-md">
        <div class="flex w-full flex-col rounded-xl bg-white/60 backdrop-blur-md p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-zinc-200 dark:bg-dark-primary/60 dark:backdrop-blur-md dark:ring-zinc-800 sm:p-10">
            
            <div class="mb-6 pb-2">
                <div class="mb-6 inline-flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                    <x-icons.send-right class="h-6 w-6 text-red-600 dark:text-red-400" />
                </div>
                <h2 class="mb-2 text-left text-3xl font-black tracking-tight text-zinc-900 dark:text-white">
                    Verifikasi Email
                </h2>
                <div class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    {{ __('Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami akan mengirimkan ulang.') }}
                </div>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 rounded-xl bg-green-50 p-4 text-sm font-medium text-green-700 ring-1 ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20">
                    {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.') }}
                </div>
            @endif

            <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto text-center sm:text-left">
                    @csrf
                    <button class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-6 py-3 text-sm font-bold tracking-wide text-white transition-all hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-dark-primary shadow-lg shadow-red-600/20 sm:w-auto" type="submit">
                        {{ __('Kirim Ulang Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto text-center sm:text-right">
                    @csrf
                    <button type="submit" class="inline-flex items-center text-sm font-semibold text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white transition-colors">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</x-guest-layout>
