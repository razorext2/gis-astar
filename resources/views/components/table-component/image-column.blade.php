<div class="flex w-fit items-center">
	@php
		$storage_path = "labels/{$data->pegawaiRelasi->kode_pegawai}/capturedImg/{$data->photoURL}.png";
		$img_check = Storage::disk('public')->exists($storage_path);
		$image_path = asset(sha1('libs') . '/' . $data->photoURL . '.png');
		$no_image_path = asset('assets/img/noImage.webp');
	@endphp

	<img class="h-10 w-10 min-w-[2.5rem] rounded-lg object-cover ring-1 ring-zinc-200 dark:ring-zinc-800 shadow-sm hover:brightness-95 cursor-pointer transition-all" id="documentations"
		onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
		data-url="{{ $img_check ? $image_path : $no_image_path }}" src="{{ $img_check ? $image_path : $no_image_path }}"
		alt="" onclick="javascript:void(0)" loading="lazy">
</div>
