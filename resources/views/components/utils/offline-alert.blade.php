{{-- Goal: Offline indicator alert component, Livewire: -, Alpine: Yes --}}
<div x-data="{ offline: !navigator.onLine }" {{ $attributes }} @offline.window="offline = true" @online.window="offline = false"
    x-show="offline" style="display: none;" x-transition>
    <x-notification-alert :id="'offline-alert'" type="offline">
        <x-slot name="title">
            KONEKSI TERPUTUS
        </x-slot>
        <x-slot name="desc">
            Kamu sedang dalam kondisi offline. Periksa koneksi internetmu untuk melanjutkan aktivitas.
        </x-slot>
    </x-notification-alert>
</div>
