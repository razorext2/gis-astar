{{-- Goal: Template Excel export poin per teknisi, Livewire: TechPointTransactionExport, Alpine: none --}}
@foreach ($data as $row)
    <table>
        <tr>
            <td style="font-weight: bold;">Periode</td>
            <td>:</td>
            <td colspan="4" style="text-align: right">
                {{ Carbon\Carbon::parse($row->from_date)->locale('id')->isoFormat('D MMM YYYY') }} s/d
                {{ Carbon\Carbon::parse($row->to_date)->locale('id')->isoFormat('D MMM YYYY') }}
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nama Teknisi</td>
            <td>:</td>
            <td colspan="4" style="text-align: right; width: 150px;">
                {{ $row->pegawai->full_name ?? 'Teknisi belum terdaftar' }}
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold;">Rincian Poin Didapat</td>
        </tr>
        <tr>
            <td style="font-weight: bold; background-color: #f0f0f0;">No. Kunjungan</td>
            <td style="font-weight: bold; background-color: #f0f0f0;">Customer</td>
            <td style="font-weight: bold; background-color: #f0f0f0;">Tgl. Kunjungan</td>
            <td style="font-weight: bold; background-color: #f0f0f0;">Tgl. Dibuat</td>
            <td style="font-weight: bold; background-color: #f0f0f0; text-align: right;">Poin</td>
        </tr>
        @foreach ($row->point as $point)
            <tr>
                <td>{{ $point->from_vt }}</td>
                <td>{{ $point->customer_contact ?? '-' }}</td>
                <td>{{ $point->visit_date ? Carbon\Carbon::parse($point->visit_date)->locale('id')->isoFormat('D MMM YYYY') : '-' }}
                </td>
                <td>{{ Carbon\Carbon::parse($point->created_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                <td style="text-align: right;">+ {{ $point->point }} Poin</td>
            </tr>
        @endforeach
        <tr>
            <td style="font-weight: bold;">Total Poin</td>
            <td>:</td>
            <td colspan="3" style="text-align: right; font-weight: bold;">{{ $row->total_points }} Poin</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Redeemed By</td>
            <td>:</td>
            <td colspan="3" style="text-align: right; width: 150px;">{{ $row->redeemedby->name ?? 'N/A' }}</td>
        </tr>
    </table>
@endforeach
