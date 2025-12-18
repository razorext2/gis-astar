<div
    class="flex w-full flex-col gap-2 rounded-xl border border-gray-200 bg-white p-4 text-gray-800 dark:border-gray-700 dark:bg-dark-primary dark:text-white lg:block lg:flex-row lg:gap-4 xl:p-6">
    <h2 class="font-base text-sm text-gray-400">
        Presentasi Pengisian Laporan Kunjungan
    </h2>

    <div class="grid gap-2 lg:grid-cols-2">
        <div class="flex flex-col gap-2">
            <p class="text-base font-medium text-gray-900 underline underline-offset-4 dark:text-white lg:text-lg"> Bulan
                {{ today()->locale('id')->isoFormat('MMMM YYYY') }}
            </p>
            <table class="w-full">
                <tr>
                    <td>Draft</td>
                    <td> {{ $draft }} </td>
                </tr>
                <tr>
                    <td>Diajukan</td>
                    <td>{{ $requested }}</td>
                </tr>
                <tr>
                    <td>Butuh Revisi</td>
                    <td>{{ $revised }}</td>
                </tr>
                <tr>
                    <td>Diterima</td>
                    <td>{{ $accepted }}</td>
                </tr>
                <tr>
                    <td>Ditolak</td>
                    <td>{{ $rejected }}</td>
                </tr>
            </table>
        </div>
        <div class="flex flex-col gap-2">
            <p class="text-base font-medium text-gray-900 underline underline-offset-4 dark:text-white lg:text-lg">
                Persentase Bulanan (API)
            </p>

            @foreach ($data as $month => $items)
                @php
                    if (count($items) > 0 && $items[0]['TotalKunjungan'] > 0) {
                        $percentage = ($items[0]['SudahTerisi'] / $items[0]['TotalKunjungan']) * 100;
                        $label = $items[0]['SudahTerisi'] . '/' . $items[0]['TotalKunjungan'];
                    } else {
                        $percentage = 0;
                        $label = '0/0';
                    }
                @endphp
                <div>
                    <p class="mb-1 text-sm text-gray-800 dark:text-white">
                        {{ \Carbon\Carbon::parse($month)->locale('id')->format('F Y') }}
                    </p>
                    <div class="w-full rounded-full bg-gray-200 dark:bg-gray-700">
                        @php
                            if ($percentage <= 50) {
                                $colorClass = 'bg-red-600';
                            } elseif ($percentage <= 80) {
                                $colorClass = 'bg-yellow-600';
                            } else {
                                $colorClass = 'bg-green-600';
                            }
                        @endphp
                        <div class="{{ $colorClass }} rounded-full p-0.5 text-center text-xs font-medium leading-none text-blue-100"
                            style="width: {{ $percentage }}%">
                            {{ $label }}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
