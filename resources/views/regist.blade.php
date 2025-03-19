<x-landing.layout :title="$title">
	<div class="relative flex min-h-screen flex-col justify-center overflow-hidden md:py-12 lg:py-32" id="Home"
		data-aos="fade-down">
		<x-landing.landing-background></x-landing.landing-background>

		<x-landing.header-text>
			<x-slot name="title">{{ $title }}</x-slot>
			Masukkan kode pegawai anda, kemudian start kamera <br />
			Proses pengambilan gambar akan dilakukan sebanyak <span class="font-bold dark:text-white"> DUA </span> kali <br />
			<x-slot name="text">
				Tekan tombol
				<span class="text-xl font-bold text-black dark:text-white">
					[-]
				</span>
				untuk melihat tutorial
			</x-slot>
		</x-landing.header-text>

		<div
			class="relative mx-2 mb-5 rounded-lg border border-gray-200 bg-white/70 p-0 dark:border-gray-700 dark:bg-dark-primary/70 lg:mx-auto lg:p-4"
			id="scan" data-aos="zoom-in-up" data-aos-delay="50">
			<form id="photoForm" action="{{ route('photo.registProcess') }}" method="POST" enctype="multipart/form-data">
				<div class="grid h-auto grid-cols-1 gap-4 lg:w-[900px] lg:grid-cols-3">
					@csrf
					<div class="video-container col-span-1 h-auto p-3 text-center lg:col-span-2 lg:p-0" data-aos="zoom-in"
						data-aos-delay="100">
						<x-landing.stream-attend></x-landing.stream-attend>

						<div class="mt-3 inline-flex w-full lg:px-0">
							<div class="relative w-full">
								<input
									class="peer block w-full appearance-none rounded-lg border border-gray-200 bg-transparent px-2.5 pb-2.5 pt-4 text-sm text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-0 dark:border-gray-700 dark:bg-gray-500 dark:text-white"
									id="floating_outlined" id="kodePegawai" name="kode_pegawai" type="text" placeholder=" " required />

								<label
									class="absolute start-1 top-2 z-10 origin-[0] -translate-y-4 scale-75 transform bg-white px-2 text-sm text-gray-500 duration-300 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 peer-focus:px-2 peer-focus:text-blue-600 dark:bg-gray-500 dark:text-white dark:peer-focus:rounded-xl dark:peer-focus:text-white rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4"
									for="floating_outlined">Kode Pegawai</label>
							</div>
						</div>

						{{-- foto yang akan dikirimkan untuk registrasi --}}
						<input id="photo1Data" name="photo1" type="hidden">
						<input id="photo2Data" name="photo2" type="hidden">

						<div class="mt-3 inline-flex w-full gap-2" data-aos="fade-right" data-aos-delay="150">
							<x-landing.button-primary class="w-full" id="capturePhoto" type="button">Start Kamera</x-landing.button-primary>
							<x-landing.button-confirm class="w-full" type="submit">Upload Photos</x-landing.button-confirm>
						</div>

						{{-- console log --}}
						<x-landing.console-log></x-landing.console-log>
					</div>

					<div class="col-span-1 px-3 pb-3 md:px-3 md:pb-3 lg:col-span-1 lg:p-0" data-aos="zoom-in" data-aos-delay="100">
						<div class="grid grid-cols-1 gap-4">
							<div class="rounded-lg border border-gray-200 p-2 text-center dark:border-gray-700 dark:bg-dark-primary"
								data-aos="fade-left" data-aos-delay="100">
								<x-landing.paragraph class="text-xl font-bold">INFORMASI</x-landing.paragraph>
							</div>

							<x-landing.canvas-attend :imgID="'canvLogo'" :canvID="'canvRegist'" />
							<x-landing.canvas-attend :imgID="'canvLogo'" :canvID="'canvRegistt'" />
						</div>
					</div>
				</div>
			</form>
		</div>

	</div>
	@push('script')
		@vite(['resources/js/landing/main.js'])
	@endpush
</x-landing.layout>
