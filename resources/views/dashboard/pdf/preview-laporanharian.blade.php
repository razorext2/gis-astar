<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Kerja</title>

    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            color: #2d3748;
            margin: 30px;
        }

        /* HEADER */
        .header {
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .no {
            font-size: 12px;
            color: #718096;
            margin-top: 4px;
        }

        /* INFO CARD */
        .info-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 16px;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 4px 0;
        }

        .label {
            color: #718096;
            font-size: 11px;
        }

        .value {
            font-weight: bold;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        /* SECTION DATE */
        .section-date {
            margin-top: 15px;
            font-weight: bold;
            font-size: 13px;
            color: #1a202c;
            border-left: 4px solid #ce3131;
            padding-left: 8px;
        }

        /* ACTIVITY TABLE */
        .activity-table {
            width: 100%;
            margin-top: 8px;
            border-collapse: collapse;
        }

        .activity-table th {
            text-align: left;
            font-size: 11px;
            color: #718096;
            padding: 6px;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-table td {
            padding: 8px 6px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: top;
        }

        .time {
            width: 120px;
            font-weight: bold;
            color: #b02b2b;
        }

        /* SIGNATURE */
        .signature {
            width: 100%;
            margin-top: 50px;
        }

        .signature td {
            width: 50%;
            text-align: center;
        }

        .signature-line {
            /* margin-top: 60px; */
            border-top: 1px solid #000;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
        }

        .name {
            margin-top: 5px;
            font-weight: bold;
        }

        /* PAGE BREAK CONTROL */
        .page-break {
            page-break-after: always;
        }

        .avoid-break {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table width="100%" style="border-bottom:2px solid #e2e8f0; padding-bottom:10px; margin-bottom:20px;">
        <tr>
            <!-- Logo -->
            <td width="80" style="vertical-align:top;">
                <img src="https://attendance.indodacin.com/assets/img/logo.png" style="height:25px;">
            </td>

            <!-- Title -->
            <td style="vertical-align:middle; text-align: center;">
                <div style="font-size:24px; font-weight:bold; letter-spacing:1px;">
                    LAPORAN KERJA
                </div>
                <div style="font-size:12px; color:#718096; margin-top:4px;">
                    NO: {{ $data->nomor_vt }}
                </div>
            </td>

            <!-- Spacer kanan biar center tetap balance -->
            <td width="80"></td>
        </tr>
    </table>

    <!-- INFO -->
    <div class="info-card">
        <table class="info-table">
            <tr>
                <td>
                    <div class="label">Tanggal</div>
                    <div class="value">
                        {{ \Carbon\Carbon::parse($data->assign_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm') }}
                    </div>
                </td>
                <td>
                    <div class="label">Customer</div>
                    <div class="value">{{ $data->project->customer_name }}</div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <div class="label">Nama Teknisi/Mekanik</div>
                    <div class="value">{{ $data->assignTo->name }}</div>
                </td>
                <td width="50%">
                    <div class="label">Bagian</div>
                    <div class="value">{{ $data->assignTo->pegawai->jabatanRelasi->nama_jabatan }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- ACTIVITIES -->
    @foreach ($data->dailyReports as $dailies => $items)
        <div class="avoid-break">

            <div class="section-date">
                {{ \Carbon\Carbon::parse($items->report_date)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
            </div>

            <table class="activity-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Kegiatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items->hourlyReport as $hourly)
                        <tr>
                            <td class="time">
                                {{ $hourly->start_time }} - {{ $hourly->end_time }}
                            </td>
                            <td>
                                {!! nl2br($hourly->notes) !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Tidak ada aktivitas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    @endforeach

    <!-- SIGNATURE -->
    <table class="signature avoid-break">
        <tr>
            <td>
                <p style="margin:0px; padding: 0px;">Customer</p>
                <p style="margin: 0px; padding: 0px; font-weight: bold;">{{ $data->project->customer_name }}</p>
            </td>
            <td></td>
            <td>Teknisi/Mekanik</td>
        </tr>
        <tr>
            <td>
                <div>
                    <img style="height: 100px"
                        src="{{ asset('storage/' . $data->signature->getSignatureImagePath() ?? null) }}" />
                </div>
                <div class="signature-line"></div>
                <div class="name">{{ $data->customer_name }}</div>
            </td>
            <td></td>
            <td>
                <div>
                    <img style="height: 100px"
                        src="{{ asset('storage/' . $data->assignTo->signature->getSignatureImagePath()) }}" />
                </div>
                <div class="signature-line"></div>
                <div class="name">
                    {{ $data->assignTo->name }}
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
