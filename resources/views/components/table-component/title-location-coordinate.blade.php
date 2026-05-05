<div class="flex flex-col gap-[0.175rem]">
    <div class="flex w-full flex-col items-start gap-0.5 lg:flex-row lg:items-center lg:gap-2">
        @if ($data->no_sr)
            <span class="rounded-md bg-blue-400 px-1.5 py-0.5 text-xs dark:bg-blue-800">{{ $data->no_sr }}</span>
        @endif
        @if ($data->tipe_tagihan)
            <span
                class="bg-{{ $data->tipe_tagihan == 'idcppn' ? 'green' : 'red' }}-400 dark:bg-{{ $data->tipe_tagihan == 'idcppn' ? 'green' : 'red' }}-800 rounded-md px-1.5 py-0.5 text-xs">{{ $data->tipe_tagihan }}</span>
        @endif
        @if ($data->tipe_kunjungan)
            @php
                $tp = match ((string) $data->tipe_kunjungan) {
                    'ATRBRG' => [
                        'color' => 'bg-purple-400 dark:bg-purple-800 text-purple-800 dark:text-purple-400',
                        'label' => 'Antar Barang (SR)',
                    ],
                    'JPTBRG' => [
                        'color' => 'bg-fuscia-400 dark:bg-fuscia-800 text-fuscia-800 dark:text-fuscia-400',
                        'label' => 'Jemput Barang',
                    ],
                    'ATRTEK' => [
                        'color' => 'bg-blue-400 dark:bg-blue-800 text-blue-800 dark:text-blue-400',
                        'label' => 'Antar Teknisi',
                    ],
                    'JPTTEK' => [
                        'color' => 'bg-emerald-400 dark:bg-emerald-800 text-emerald-800 dark:text-emerald-400',
                        'label' => 'Jemput Teknisi',
                    ],
                    default => [
                        'color' => 'bg-yellow-400 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-400',
                        'label' => 'Lainnya',
                    ],
                };
            @endphp

            <span class="{{ $tp['color'] }} rounded-md px-1.5 py-0.5 text-xs">{{ $tp['label'] }}</span>
        @endif
    </div>
    <span class="w-full text-wrap">{{ $data->title }} </span>
    <span class="w-full text-wrap text-xs">{{ $data->lokasi }}</span>
    @if ($data->latitude && $data->longitude)
        <span class="w-full text-xs text-zinc-400">
            <a class="inline-flex underline"
                href="https://www.google.com/maps/search/?api=1&query={{ $data->latitude }},{{ $data->longitude }}"
                target="_blank">
                {{ $data->latitude }}, {{ $data->longitude }}
                <x-icons.arrow-up class="h-4 w-4 rotate-45" />
            </a>
        </span>
    @endif
</div>
