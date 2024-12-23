<div class="p-auto relative m-auto mb-2 flex flex-col">
	<!-- Tombol Previous -->
	<button
		class="absolute -bottom-2.5 left-0 h-10 w-10 -translate-y-1/2 transform rounded-full border border-gray-300 bg-white p-2 text-gray-800 transition-all duration-500 hover:bg-gray-300 dark:border-gray-700 dark:bg-[#18181b] dark:text-gray-300 dark:hover:bg-gray-900 dark:hover:text-white"
		id="prevButton">
		&#8592;
	</button>

	<div class="hide-scroll-bar mb-6 flex snap-x scroll-ps-6 overflow-x-scroll pb-8" id="scrollContainer">
		<div class="flex flex-nowrap gap-6">

			@php
				$cards = [
				    [
				        'id' => 'cardOntime-chart',
				        'dataName' => 'data-ontime-counts',
				        'color' => 'green',
				        'label' => 'Masuk Tepat Waktu',
				        'data' => '[0,3,2]',
				        'total' => '10',
				    ],
				    [
				        'id' => 'cardLate-chart',
				        'dataName' => 'data-late-counts',
				        'color' => 'red',
				        'label' => 'Terlambat',
				        'data' => '[0,1,1]',
				        'total' => '10',
				    ],
				    [
				        'id' => 'cardOuttime-chart',
				        'dataName' => 'data-outtime-counts',
				        'color' => 'blue',
				        'label' => 'Keluar Tepat Waktu',
				        'data' => '[0,5,8]',
				        'total' => '10',
				    ],
				    [
				        'id' => 'cardKecepatan-chart',
				        'dataName' => 'data-fast-counts',
				        'color' => 'orange',
				        'label' => 'Pulang Cepat',
				        'data' => '[0,8,5]',
				        'total' => '10',
				    ],
				];
			@endphp

			{{ $slot }}

			@foreach ($cards as $card)
				<x-card.card-carousel-item id="{{ $card['id'] }}" :dataName="$card['dataName']" :color="$card['color']" :label="$card['label']"
					:data="$card['data']" :total="$card['total']" />
			@endforeach
		</div>
	</div>

	<!-- Tombol Next -->
	<button
		class="absolute -bottom-2.5 right-0 h-10 w-10 -translate-y-1/2 transform rounded-full border border-gray-300 bg-white p-2 text-gray-800 transition-all duration-500 hover:bg-gray-300 dark:border-gray-700 dark:bg-[#18181b] dark:text-gray-300 dark:hover:bg-gray-900 dark:hover:text-white"
		id="nextButton">
		&#8594;
	</button>
</div>
