<div class="mb-4 grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
    @can('spk-create')
        <x-card.quick-action href="{{ route('spk.create') }}" label="Buat SPK Baru" icon="plus" color="red" />
    @endcan

    @can('invoice-list')
        <x-card.quick-action href="{{ route('invoice.all.index') }}" label="Daftar Tagihan" icon="file-invoice"
            color="blue" />
    @endcan

    @can('spk-approve')
        <x-card.quick-action href="{{ route('spk.index') }}" label="Validasi SPK" icon="clipboard-check" color="emerald" />
    @endcan

    @can('point-redeem')
        <x-card.quick-action href="{{ route('points.index') }}" label="Poin Teknisi" icon="star" color="amber" />
    @endcan
</div>
