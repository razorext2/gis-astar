@php
	$status_map = [
	    0 => [
	        'color' => 'yellow',
	        'status' => 'Diajukan',
	    ],
	    1 => [
	        'color' => 'green',
	        'status' => 'Diterima',
	    ],
	    2 => [
	        'color' => 'red',
	        'status' => 'Ditolak',
	    ],
	];

	$text = $status_map[$status]['status'];
	$color = $status_map[$status]['color'];
@endphp

<div class="flex w-full min-w-32 flex-col gap-1 text-wrap lg:items-center">
	<div class="flex flex-row gap-1.5 lg:items-center">
		<span
			class="bg-{{ $color }}-400 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300 rounded-lg px-2 py-0.5 text-xs font-normal text-gray-800">
			{{ $text }}
		</span>
		<span class="{{ $verified == 'verified' ? 'text-green-600' : 'text-red-600' }} text-xs capitalize text-gray-400">
			{{ $verified }} </span>
	</div>
	<span class="font-medium capitalize dark:text-gray-200"> {{ $similarity }} </span>
	<span class="rounded-lg bg-gray-200 px-3 py-0.5 text-xs capitalize text-gray-800"> {{ $verified_by }} </span>
</div>
