<ol class="relative border-s border-gray-200 dark:border-gray-700">
	@foreach ($points as $point)
		<li class="mb-10 ms-6">
			<span
				class="absolute -start-3 flex h-6 w-6 items-center justify-center rounded-full bg-green-100 ring-4 ring-green-200 dark:bg-green-900 dark:ring-green-700">
				<x-icons.date class="h-2.5 w-2.5 text-green-800 dark:text-green-300" />
			</span>
			<h3 class="mb-1 flex items-center text-lg font-semibold text-gray-900 dark:text-white">
				Point didapatkan
				<span
					class="me-2 ms-3 rounded-lg bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
					+ {{ $point->point }}
				</span>
			</h3>
			<time class="mb-2 block text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
				Pukul
				{{ $point->created_at->format('H:i:s, d M Y') }}
			</time>
			<p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
				Anda mendapatkan poin dari laporan kunjungan dengan kode <b class="text-green-700">{{ $point->from_vt }}</b> yang
				telah disetujui.
			</p>
		</li>
	@endforeach
</ol>
