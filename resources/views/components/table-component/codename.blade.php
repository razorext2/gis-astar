@props(['data'])

@php
	$pegawai = $data->pegawaiRelasi;
	$date = \Carbon\Carbon::parse($data->jam_masuk)->format('Y-m-d');

	if ($pegawai) {
	    $url = route('pegawai.timeline', $pegawai->kode_pegawai) . '?date=' . $date;
	}
@endphp

<div class="flex flex-col gap-1">
	<span class="text-sm">{{ $pegawai->kode_pegawai ?? '-' }}</span>
	<a target="_blank" class="underline transition-colors duration-500 hover:text-blue-600"
		href="{{ $url }}">{{ $pegawai->nick_name ?? '-' }}</a>
</div>
