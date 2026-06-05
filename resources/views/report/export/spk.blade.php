<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th style="font-weight: bold;" colspan="2">Laporan SPK</th>
            <th style="font-weight: bold;" colspan="8">{{ $fromDate . ' s/d ' . $toDate }}</th>
        </tr>
        <tr style="height: 50px;">
            <th style="width: 55px; border: 1px solid black; text-align: center; font-weight: bold;">#</th>
            <th style="width: 140px; border: 1px solid black; text-align: center; font-weight: bold;">No. Order</th>
            <th style="width: 180px; border: 1px solid black; text-align: center; font-weight: bold;">Customer</th>
            <th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tipe Tagihan</th>
            <th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl Cetak</th>
            <th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Tgl Kirim</th>
            <th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">Status</th>
            <th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">Status Approval
            <th style="width: 150px; border: 1px solid black; text-align: center; font-weight: bold;">SPK Dibatalkan?
            </th>
            <th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Dibuat Oleh</th>
            <th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Assign Ke</th>
            <th style="width: 120px; border: 1px solid black; text-align: center; font-weight: bold;">Divalidasi Oleh
            </th>
            <th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Dibuat Tgl</th>
            <th style="width: 100px; border: 1px solid black; text-align: center; font-weight: bold;">Divalidasi Tgl
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $item)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $i + 1 }}</td>
                <td style="border: 1px solid black;">{{ $item->nomor_order ?? '-' }}</td>
                <td style="border: 1px solid black;">{{ $item->customer['nama_perusahaan'] ?? $item->company_name }}
                </td>
                <td style="border: 1px solid black; text-align: center;">{{ strtoupper($item->tipe_tagihan ?? '-') }}
                </td>
                <td style="border: 1px solid black; text-align: center;">{{ $item->tgl_cetak ?? '-' }}</td>
                <td style="border: 1px solid black; text-align: center;">
                    @if (isset($item->tgl_kirim))
                        {{ is_numeric($item->tgl_kirim) ? $item->tgl_kirim . ' Hari' : $item->tgl_kirim }}
                    @else
                        -
                    @endif
                </td>
                <td style="border: 1px solid black;">{{ $item->status_description }}</td>
                <td style="border: 1px solid black;">{{ $item->status_approval_description }}</td>
                <td style="border: 1px solid black;">{{ $item->is_cancelled ? 'Ya' : 'Tidak' }}</td>
                <td style="border: 1px solid black;">{{ $item->addedBy->name ?? '-' }}</td>
                <td style="border: 1px solid black;">{{ $item->assignTo->name ?? '-' }}</td>
                <td style="border: 1px solid black;">{{ $item->approvedBy->name ?? '-' }}</td>
                <td style="border: 1px solid black; text-align: center;">
                    {{ $item->created_at?->format('d/m/Y H:i:s') ?? '-' }}
                </td>
                <td style="border: 1px solid black; text-align:center;">
                    {{ $item->approved_at?->format('d/m/Y H:i:s') ?? '-' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
