<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    @livewireStyles()

    <!-- Fonts -->
    <link href="{{ asset('assets/img/logo.ico') }}" rel="icon" />
    <link href="https://fonts.bunny.net" rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body id="container" class="relative min-h-screen overflow-x-hidden bg-white antialiased dark:bg-zinc-950"
    onmousemove="document.getElementById('container').style.setProperty('--mouse-x', event.clientX + 'px'); document.getElementById('container').style.setProperty('--mouse-y', event.clientY + 'px');">

    <x-utils.dynamic-background />

    @if (session('status'))
        <div class="fixed bottom-5 right-5 z-50 flex w-full max-w-xs scale-90 transform items-center divide-x rounded-lg transition duration-300"
            id="toast-bottom-right" role="alert" x-data="{ showToast: true }" x-init="setTimeout(() => showToast = false, 3000)" x-show="showToast"
            x-transition:enter="transition ease-in duration-300" x-transition:enter-start="transform scale-90 opacity-0"
            x-transition:enter-end="transform scale-100 opacity-100"
            x-transition:leave="transition ease-out duration-300"
            x-transition:leave-start="transform scale-100 opacity-100"
            x-transition:leave-end="transform scale-90 opacity-0">
            <div class="mb-4 flex w-full max-w-xs items-center rounded-lg bg-white p-4 text-gray-500 shadow ring-1 ring-zinc-200 dark:bg-dark-primary dark:text-white dark:ring-zinc-800"
                id="toast-success" role="alert">
                <div
                    class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-500 dark:text-white">
                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 mt-0.5 text-sm font-normal text-black"><x-auth.auth-session-status class="mb-4"
                        :status="session('status')" />
                </div>
                <x-button.secondary
                    class="!ms-auto !h-8 !w-8 !p-1.5 !bg-transparent !shadow-none ring-0 sm:-mx-1.5 sm:-my-1.5"
                    type="button" aria-label="Close" @click="showToast = false">
                    <span class="sr-only">Close</span>
                    <x-icons.close class="h-3 w-3" />
                </x-button.secondary>
            </div>
        </div>
    @endif

    {{-- Fixed Logo Top-Left --}}
    <div class="fixed left-6 top-5 z-50 hidden md:block">
        <img src="{{ asset('assets/img/logo.png') }}" class="h-10 w-auto object-contain drop-shadow-sm"
            alt="Indodacin Logo">
    </div>

    <div class="container mx-auto flex min-h-screen items-center justify-center px-6">
        <div class="flex w-full max-w-6xl flex-col justify-between gap-10 md:flex-row md:items-center">

            {{-- Branding Area --}}
            <div class="flex w-full flex-col items-center text-center md:w-1/2 md:items-start md:text-left">

                <h1
                    class="flex flex-col items-center text-center text-4xl font-black leading-tight tracking-tight text-zinc-900 drop-shadow-sm dark:text-white md:items-start md:text-left md:text-5xl lg:text-[3.5rem]">
                    <span>Indodacin</span>
                    <span x-data="{
                        words: ['Presisi Utama', 'Pasti Presisi', 'Pasti Berkualitas', 'Pasti Pas'],
                        currentWord: '',
                        wordIndex: 0,
                        charIndex: 0,
                        isDeleting: false,
                        type() {
                            const current = this.words[this.wordIndex];
                    
                            if (this.isDeleting) {
                                this.currentWord = current.substring(0, this.charIndex - 1);
                                this.charIndex--;
                            } else {
                                this.currentWord = current.substring(0, this.charIndex + 1);
                                this.charIndex++;
                            }
                    
                            let typeSpeed = 100 - Math.random() * 50;
                            if (this.isDeleting) typeSpeed /= 2.5; // Delete faster
                    
                            if (!this.isDeleting && this.currentWord === current) {
                                typeSpeed = 2000; // Pause at the end before deleting
                                this.isDeleting = true;
                            } else if (this.isDeleting && this.currentWord === '') {
                                this.isDeleting = false;
                                this.wordIndex = (this.wordIndex + 1) % this.words.length;
                                typeSpeed = 500; // Pause before starting new word
                            }
                    
                            setTimeout(() => this.type(), typeSpeed);
                        }
                    }" x-init="setTimeout(() => type(), 800)"
                        class="bg-gradient-to-r from-red-400 to-red-700 bg-clip-text text-transparent after:animate-pulse after:content-['|'] dark:from-rose-300 dark:to-red-500">
                        <span x-text="currentWord">Presisi Utama</span>
                    </span>
                </h1>
                <p class="mx-auto mt-4 max-w-md text-base leading-relaxed text-zinc-600 dark:text-zinc-300 md:mx-0">
                    Sistem informasi terpadu untuk koordinasi, pelaporan, dan manajemen data operasional secara
                    langsung.
                </p>
            </div>

            {{-- Form Area Slot --}}
            <div class="z-10 flex w-full justify-center pb-10 md:w-1/2 md:justify-end md:pb-0">
                {{ $slot }}
            </div>

        </div>
    </div>

    @livewireScripts()
</body>

</html>
