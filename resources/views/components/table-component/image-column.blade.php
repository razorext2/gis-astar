<div>
	@php
		$storage_path = "labels/{$data->pegawaiRelasi->kode_pegawai}/capturedImg/{$data->photoURL}.png";
		$img_check = Storage::disk('public')->exists($storage_path);
		$image_path = asset(sha1('libs') . '/' . $data->photoURL . '.png');
		$no_image_path = asset('assets/img/noImage.webp');
	@endphp

	<img class="w-32 rounded-lg blur-sm transition-all duration-300 hover:blur-none"
		src="{{ $img_check ? $image_path : $no_image_path }}" alt="image description">
</div>
