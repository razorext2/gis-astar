{{-- Goal: Render employee code & name with inactive indicator in tables, Livewire: -, Alpine: - --}}
@php
    $date = \Carbon\Carbon::parse($waktu)->format('Y-m-d');
    $url = ($pegawai && \Illuminate\Support\Facades\Route::has('pegawai.timeline')) ? route('pegawai.timeline', $pegawai->kode_pegawai) . '?date=' . $date : '#';
@endphp

<div class="flex flex-col gap-0.5">
    <span class="text-sm">{{ $pegawai->kode_pegawai ?? '-' }}</span>

    <span class="text-sm inline-flex items-center gap-1.5">
        @if(auth()->user()?->can('attendance-approve') && $pegawai)
            <a target="_blank" class="underline transition-colors duration-500 hover:text-blue-600"
                href="{{ $url }}">{{ $pegawai->nick_name ?? '-' }}</a>
        @else
            <span>{{ $pegawai->nick_name ?? '-' }}</span>
        @endif

        <x-dashboard.badge-inactive :is_active="$pegawai->userRelasi?->is_active ?? true" />
    </span>
</div>

