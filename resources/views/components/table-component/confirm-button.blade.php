<x-button.primary id="verifikasiBtn-{{ $data->id }}" wire:key="verifikasi-btn-{{ $data->id }}"
    wire:click="$dispatch('verifikasi', {id: {{ $data->id }}})">Verifikasi</x-button.primary>
