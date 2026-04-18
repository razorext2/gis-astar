@php
    $date = \Carbon\Carbon::parse($waktu)->format('Y-m-d');

    $url = route('pegawai.timeline', $pegawai->kode_pegawai) . '?date=' . $date;
@endphp

<div class="flex flex-col gap-1">
    <span class="text-sm">{{ $pegawai->kode_pegawai ?? '-' }}</span>

    @can('attendance-approve')
        <a target="_blank" class="underline transition-colors duration-500 hover:text-blue-600"
            href="{{ $url }}">{{ $pegawai->nick_name ?? '-' }}</a>
    @else
        <span class="text-sm">{{ $pegawai->nick_name ?? '-' }}</span>
    @endcan
</div>
