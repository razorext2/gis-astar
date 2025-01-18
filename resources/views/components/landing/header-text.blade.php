<div class="relative z-10 mb-0 px-6 md:mb-10 md:grid md:grid-cols-1" data-aos="fade-down">
	<div class="h-full items-center justify-center py-5 text-left text-black md:flex md:flex-col md:text-center">
		<x-landing.heading-text>
			{{ $title }}
		</x-landing.heading-text>

		<x-landing.paragraph class="text-sm md:text-lg">
			{!! $slot !!}
		</x-landing.paragraph>

		<x-landing.paragraph class="text-sm md:text-base">
			Tekan tombol
			<span class="text-lg font-bold text-black dark:text-white md:text-xl">
				[-]
			</span>
			untuk melihat tutorial
		</x-landing.paragraph>
	</div>
</div>
