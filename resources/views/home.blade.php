<x-landing.layout :title="$title">
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden md:py-12 lg:py-32" id="Home">
        <x-landing.landing-background></x-landing.landing-background>

        <x-landing.header-text>
            <x-slot name="title">{{ $title }}</x-slot>
            Klik tombol start, kemudian biarkan aplikasi mendeteksi wajah anda. <br />
            Informasi mengenai anda akan muncul di bagian sebelah kanan<br />
        </x-landing.header-text>

        <div class="relative mx-2 mb-5 rounded-lg border border-zinc-200 bg-white/60 shadow-lg dark:border-zinc-800 dark:bg-dark-primary/70 lg:mx-auto lg:p-4"
            id="scan" data-aos="zoom-in-up" data-aos-delay="50">

            <div class="grid h-auto grid-cols-1 lg:w-[900px] lg:grid-cols-3 lg:gap-4">

                <div class="video-container col-span-1 h-auto p-3 text-center lg:col-span-2 lg:p-0" data-aos="zoom-in"
                    data-aos-delay="100">
                    <x-landing.stream-attend></x-landing.stream-attend>
                    <div class="mt-3 inline-flex w-full gap-2 lg:px-0">
                        <x-landing.button-primary class="w-full" id="startButton"
                            type="button">Start</x-landing.button-primary>
                        <x-landing.button-danger class="w-full" id="endAttendance"
                            type="button">Stop</x-landing.button-danger>
                    </div>
                    <x-landing.console-log></x-landing.console-log>
                </div>

                <!-- #region -->
                <div class="col-span-1 px-3 pb-3 md:px-3 md:pb-3 lg:col-span-1 lg:p-0" data-aos="zoom-in"
                    data-aos-delay="100">
                    <div class="mb-4 rounded-lg border border-zinc-200 p-2 text-center dark:border-zinc-800 dark:bg-dark-primary"
                        data-aos="fade-left" data-aos-delay="100">
                        <x-landing.paragraph class="text-xl font-bold">INFORMASI</x-landing.paragraph>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-1">
                        <x-landing.canvas-attend :imgID="'canvLogo'" :canvID="'canvAttend'"></x-landing.canvas-attend>
                        <div class="relative flex h-auto w-full flex-col rounded-lg border border-zinc-200 p-4 leading-normal dark:border-zinc-800 lg:justify-between"
                            data-aos="fade-left" data-aos-delay="100">
                            <div id="pegawaiKosong">
                                <x-landing.list></x-landing.list>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script defer src="{{ asset('face-api.min.js') }}"></script>
        @vite('resources/js/landing/faceDetection.js')
    @endpush
</x-landing.layout>
