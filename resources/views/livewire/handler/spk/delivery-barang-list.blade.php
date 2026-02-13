{{-- riwayat pengiriman --}}
<div id="delivery-history-section" class="flex w-full flex-col gap-2 lg:gap-4">
    <div id="delivery-history-header">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-white lg:text-lg">
            Riwayat Pengiriman
        </h3>

        <p class="text-base text-gray-600 dark:text-gray-400">
            Berikut ini adalah riwayat pengiriman SPK ini:
        </p>
    </div>

    <div id="delivery-history-content" class="grid w-full gap-2 lg:grid-cols-2 lg:gap-4">
        @forelse ($deliveries as $row)
            <div id="delivery-history-content-child"
                class="flex flex-col gap-2 rounded-lg border-[1px] border-gray-200 bg-gray-100 p-2 text-sm dark:border-gray-600 dark:bg-gray-600 lg:p-4">

                <span class="w-full text-center text-xs font-semibold text-gray-800 dark:text-white">
                    {{ \Carbon\Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}
                </span>

                <table id="delivery-history-content-table" class="w-full dark:text-gray-400">
                    <tr>
                        <td>Via</td>
                        <td class="w-8 text-center">:</td>
                        <td class="text-right text-gray-800 dark:text-white">{{ ucfirst($row->via) }}</td>
                    </tr>

                    @if ($row['via'] === 'laut')
                        <tr>
                            <td>Partay</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->partay ?? '-' }} </td>
                        </tr>
                        <tr>
                            <td>No. Container </td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->no_container ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Kapal</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->nama_kapal ?? '-' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>Nomor SR</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->nomor_sr ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Kode Jari Supir </td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->id_supir ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td>Nama Supir </td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->nama_supir ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td>No. Telp </td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->no_telp_supir ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>No. Plat</td>
                            <td class="w-8 text-center">:</td>
                            <td class="text-right text-gray-800 dark:text-white">
                                {{ $row->no_plat ?? '-' }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td>Estimasi Berat Barang</td>
                        <td class="w-8 text-center">:</td>
                        <td class="text-right text-gray-800 dark:text-white">
                            {{ $row->berat ?? '-' }} </td>
                    </tr>
                    <tr>
                        <td>ETD</td>
                        <td class="w-8 text-center">:</td>
                        <td class="text-right text-gray-800 dark:text-white">
                            {{ $row->etd ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>ETA</td>
                        <td class="w-8 text-center">:</td>
                        <td class="text-right text-gray-800 dark:text-white">
                            {{ $row->eta ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td>Catatan</td>
                        <td class="w-8 text-center">:</td>
                        <td class="text-right text-gray-800 dark:text-white">
                            {{ $row->note ?? '-' }}
                        </td>
                    </tr>
                </table>

                @if ($row->via != 'supir')
                    <div class="flex w-full flex-col gap-1">
                        <p
                            class="text-center font-semibold text-gray-800 underline underline-offset-2 dark:text-gray-400">
                            Barang yang
                            dibawah</p>
                        <ul class="text-gray-600 dark:text-white">
                            @foreach ($row->product_details as $key => $barang)
                                <li class="flex gap-x-2">
                                    <span>{{ $key + 1 }}. </span>
                                    <span>
                                        {{ $barang['nama_barang'] ?? '-' }}
                                        ({{ $barang['qty_barang'] ?? 0 }}
                                        {{ $barang['satuan_barang'] ?? '' }})
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        @empty
            <p class="col-span-2 text-center text-sm italic text-red-500">Belum ada riwayat pengiriman.</p>
        @endforelse
    </div>

    {{ $deliveries->links(data: ['scrollTo' => '#delivery-history-section']) }}
</div>
{{-- end riwayat pengiriman --}}
