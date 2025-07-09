<div class="flex w-fit items-center">
	@php
		$storage_path = "labels/{$data->pegawaiRelasi->kode_pegawai}/capturedImg/{$data->photoURL}.png";
		$img_check = Storage::disk('public')->exists($storage_path);
		$image_path = asset(sha1('libs') . '/' . $data->photoURL . '.png');
		$no_image_path = asset('assets/img/noImage.webp');
	@endphp

	<img class="min-w-12 rounded-lg object-cover transition-all duration-500 hover:scale-125 md:max-w-36" id="documentations"
		onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
		data-url="{{ $img_check ? $image_path : $no_image_path }}" src="{{ $img_check ? $image_path : $no_image_path }}"
		alt="" onclick="javascript:void(0)" loading="lazy">
</div>
