<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Permohonan Cuti Tahunan</title>
    <style type="text/css">
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            margin: 0;
            padding: 40px;
            box-sizing: border-box;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .uppercase {
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mb-8 {
            margin-bottom: 32px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .mt-8 {
            margin-top: 32px;
        }

        .indent {
            padding-left: 40px;
        }

        .border-bottom {
            border-bottom: 1px solid #000;
            display: inline-block;
        }

        .w-full {
            width: 100%;
        }

        .signature-table td {
            text-align: center;
            vertical-align: bottom;
            padding: 0;
        }

        .line {
            border-bottom: 1px solid #000;
            margin: 5px 0;
        }

        .checkbox {
            display: inline-block;
            width: 14px;
            height: 14px;
            line-height: 14px;
            font-size: 14px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #000;
            margin-right: 5px;
        }

        .watermark {
            position: absolute;
            top: 35%;
            left: 10%;
            transform: rotate(-45deg);
            font-size: 100px;
            color: #ff0000;
            opacity: 0.2;
            font-weight: bold;
            border: 15px solid #ff0000;
            padding: 20px;
            z-index: -1;
            text-align: center;
            letter-spacing: 5px;
        }
    </style>
</head>

<body>
    @if (in_array($data->status, ['rejected', 'auto_reject', 'cancelled']))
        <div class="watermark">DITOLAK</div>
    @endif
    <h3 class="mb-8 text-center font-bold" style="padding-top:0; margin-top: 0;">PERMOHONAN CUTI TAHUNAN</h3>

    <table class="mb-4">
        <tr>
            <td width="60%">
                Kepada Yth,<br />
                Pimpinan / Bag. Personalia<br />
                di tempat
            </td>
            <td width="40%" class="text-right" style="vertical-align: top">
                Medan, Tgl. {{ \Carbon\Carbon::parse($data->created_at)->locale('id')->isoFormat('D MMMM Y') }}
            </td>
        </tr>
    </table>

    <p>Dengan hormat,</p>

    <div class="indent mb-4">
        <p>Saya yang bertanda tangan dibawah ini :</p>
        <table style="width: 80%; margin-left: 20px">
            <tr>
                <td width="15%">Nama</td>
                <td width="5%">:</td>
                <td>{{ $data->user->name }}</td>
            </tr>
            <tr>
                <td>Bagian</td>
                <td>:</td>
                <td> {{ $data->user->pegawai->jabatanRelasi->divisionRelasi->nama_divisi ?? '-' }} </td>
            </tr>
        </table>
    </div>

    <div style="line-height: 1.8">
        Dengan ini mengajukan permohonan cuti selama
        <span class="border-bottom" style="min-width: 50px; text-align: center">
            {{ $data->total_days }}
        </span>
        hari terhitung tanggal
        <span class="border-bottom" style="min-width: 100px; text-align: center">
            {{ \Carbon\Carbon::parse($data->start_date)->locale('id')->isoFormat('D MMMM Y') }}
        </span>
        s/d
        <span class="border-bottom" style="min-width: 100px; text-align: center">
            {{ \Carbon\Carbon::parse($data->end_date)->locale('id')->isoFormat('D MMMM Y') }}
        </span>
        dan kembali masuk kerja pada tanggal
        <span class="border-bottom" style="min-width: 100px; text-align: center">
            {{ \Carbon\Carbon::parse($data->end_date)->addDay()->locale('id')->isoFormat('D MMMM Y') }}
        </span>.
        Selama menjalani cuti, tugas saya didelegasikan / dialihkan
        kepada
        <span class="border-bottom" style="min-width: 150px; text-align: center">
            {{ $data->backupPerson->name ?? '-' }}
        </span>
        adapun cuti saya pergunakan untuk
        <span class="border-bottom" style="min-width: 200px; text-align: center">
            {{ $data->reason }}
        </span>
        <br />
        @php
            $hrdApproved = $data->histories
                ->where('action', 'approve')
                ->where('status_from', 'pending_hrd')
                ->isNotEmpty();
            $balance = $data->user->currentLeaveBalance();
        @endphp
        Sisa cuti periode tahun
        <span class="border-bottom" style="min-width: 50px; text-align: center;">{!! $hrdApproved && $balance ? $balance->year : '&nbsp;' !!}</span>
        selama
        <span class="border-bottom" style="min-width: 50px; text-align: center;">{!! $hrdApproved && $balance ? $balance->remaining_quota : '&nbsp;' !!}</span>
        hari. *)
    </div>

    @php
        $actionBackup = $data->histories->where('status_from', 'pending_backup')->first();
        $actionSpv = $data->histories->where('status_from', 'pending_spv')->first();

        $historyBackup = $data->histories->where('action', 'approve')->where('status_from', 'pending_backup')->first();

        $historySpv = $data->histories->where('action', 'approve')->where('status_from', 'pending_spv')->first();

        $historyHrd = $data->histories->where('action', 'approve')->where('status_from', 'pending_hrd')->first();

        $historyMgmt = $data->histories
            ->where('action', 'final_approve')
            ->where('status_from', 'pending_management')
            ->first();

        $pemohon = $data->user;
        $backup = $historyBackup ? $historyBackup->actedByUser : null;
        $spv = $historySpv ? $historySpv->actedByUser : null;
        $hrd = $historyHrd ? $historyHrd->actedByUser : null;
        $mgmt = $historyMgmt ? $historyMgmt->actedByUser : null;
    @endphp

    <div class="line" style="margin-top: 20px"></div>
    <p class="font-bold" style="padding: 0; margin: 0">
        Konfirmasi Pimpinan Bagian / Atasan langsung sbb :
    </p>
    <div class="line" style="margin-bottom: 20px"></div>

    {{-- Konfirmasi Atasan --}}
    <div style="margin-bottom: 8px;">
        <span class="checkbox" style="font-family: DejaVu Sans, sans-serif;">
            {!! $actionSpv && in_array($actionSpv->action, ['approve', 'final_approve']) ? '&#10004;' : '&nbsp;' !!}
        </span>
        Cuti dapat disetujui.
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td width="42.5%" style="vertical-align: bottom; padding: 0;">
                <span class="checkbox" style="font-family: DejaVu Sans, sans-serif;">{!! $actionSpv && $actionSpv->action === 'reject' ? '&#10004;' : '&nbsp;' !!}</span>
                Cuti tidak dapat disetujui, dengan alasan :
            </td>
            <td width="57.5%" style="vertical-align: bottom; padding: 0; border-bottom: 1px solid #000;">
                {!! $actionSpv && $actionSpv->action === 'reject' ? e($actionSpv->note) : '&nbsp;' !!}
            </td>
        </tr>
    </table>

    <div style="border-bottom: 1px solid #000; margin-top: 5px; margin-bottom: 10px;">&nbsp;</div>

    {{-- Konfirmasi Personil Pengganti --}}
    <div style="margin-bottom: 8px;">
        <span class="checkbox" style="font-family: DejaVu Sans, sans-serif;">
            {!! $actionBackup && in_array($actionBackup->action, ['approve', 'final_approve']) ? '&#10004;' : '&nbsp;' !!}
        </span>
        Personil yang ditunjuk disetujui.
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
        <tr>
            <td width="55%" style="vertical-align: bottom; padding: 0;">
                <span class="checkbox" style="font-family: DejaVu Sans, sans-serif;">
                    {!! $actionBackup && $actionBackup->action === 'reject' ? '&#10004;' : '&nbsp;' !!}
                </span>
                Personil yang ditunjuk tidak disetujui. Digantikan oleh
            </td>
            <td width="45%" style="vertical-align: bottom; padding: 0; border-bottom: 1px solid #000;">
                {!! $actionBackup && $actionBackup->action === 'reject' ? e($actionBackup->note) : '&nbsp;' !!}
            </td>
        </tr>
    </table>

    <table class="signature-table w-full" style="margin-top: 20px">
        <tr>
            <td width="20%">Pemohon,</td>
            <td width="20%">Personil Pengganti,</td>
            <td width="20%">Bag. Personalia,</td>
            <td width="20%">Mandor,</td>
            <td width="20%">Diketahui oleh,</td>
        </tr>
        <tr>
            <td style="height: 85px">
                @if ($pemohon && $pemohon->signature)
                    <img src="{{ public_path('storage/' . $pemohon->signature->getSignatureImagePath()) }}"
                        style="max-height: 80px; max-width: 100%;">
                @endif
            </td>
            <td style="height: 85px">
                @if ($backup && $backup->signature)
                    <img src="{{ public_path('storage/' . $backup->signature->getSignatureImagePath()) }}"
                        style="max-height: 80px; max-width: 100%;">
                @endif
            </td>
            <td style="height: 85px">
                @if ($hrd && $hrd->signature)
                    <img src="{{ public_path('storage/' . $hrd->signature->getSignatureImagePath()) }}"
                        style="max-height: 80px; max-width: 100%;">
                @endif
            </td>
            <td style="height: 85px">
                @if ($spv && $spv->signature)
                    <img src="{{ public_path('storage/' . $spv->signature->getSignatureImagePath()) }}"
                        style="max-height: 80px; max-width: 100%;">
                @endif
            </td>
            <td style="height: 85px">
                @if ($mgmt && $mgmt->signature)
                    <img src="{{ public_path('storage/' . $mgmt->signature->getSignatureImagePath()) }}"
                        style="max-height: 80px; max-width: 100%;">
                @endif
            </td>
        </tr>
        <tr>
            <td>
                (<span class="border-bottom" style="display: inline-block;width: 70%;text-align: center;">
                    {{ explode(' ', $pemohon->name)[0] }}
                </span>)
            </td>
            <td>
                (<span class="border-bottom" style="display: inline-block; width: 70%; text-align: center;">
                    {{ $backup ? explode(' ', $backup->name)[0] : '' }}
                </span>)
            </td>
            <td>
                (<span class="border-bottom" style="display: inline-block; width: 70%; text-align: center;">
                    {{ $hrd ? explode(' ', $hrd->name)[0] : '' }}
                </span>)
            </td>
            <td>
                (<span class="border-bottom" style="display: inline-block; width: 70%; text-align: center;">
                    {{ $spv ? explode(' ', $spv->name)[0] : '' }}
                </span>)
            </td>
            <td>
                (<span class="border-bottom" style="display: inline-block; width: 70%; text-align: center;">
                    {{ $mgmt ? explode(' ', $mgmt->name)[0] : '' }}
                </span>)
            </td>
        </tr>

    </table>

    <div class="line" style="margin-top: 20px"></div>
    <p class="font-bold" style="padding: 0; margin: 0;">Jawaban Permohonan Cuti</p>
    <div class="line" style="margin-bottom: 15px"></div>

    @php
        $mgmtApproved = $historyMgmt !== null;
    @endphp
    <div style="line-height: 1.8; margin-bottom: 15px">
        Pelaksanaan cuti mulai tanggal
        <span class="border-bottom" style="min-width: 150px; text-align: center;">{!! $mgmtApproved ? \Carbon\Carbon::parse($data->start_date)->locale('id')->isoFormat('D MMMM Y') : '&nbsp;' !!}</span>
        s/d
        <span class="border-bottom" style="min-width: 150px; text-align: center;">{!! $mgmtApproved ? \Carbon\Carbon::parse($data->end_date)->locale('id')->isoFormat('D MMMM Y') : '&nbsp;' !!}</span>
        dalam bentuk
        <span class="border-bottom" style="min-width: 150px; text-align: center;">{!! $mgmtApproved ? e($data->leaveType->name) : '&nbsp;' !!}</span>
        selama
        <span class="border-bottom" style="min-width: 50px; text-align: center;">{!! $mgmtApproved ? $data->total_days : '&nbsp;' !!}</span>
        hari.<br />
        Cuti periode tahun
        <span class="border-bottom" style="min-width: 80px; text-align: center;">{!! $hrdApproved && $balance ? $balance->year : '&nbsp;' !!}</span>
        masih tersisa
        <span class="border-bottom" style="min-width: 50px; text-align: center;">{!! $hrdApproved && $balance ? $balance->remaining_quota : '&nbsp;' !!}</span>
        hari. *)
    </div>

    <table style="width: 100%">
        <tr>
            <td width="50%" style="vertical-align: bottom; padding: 0;">
                Diterima oleh : <span class="border-bottom"
                    style="min-width: 150px; text-align: center;">{!! $mgmt ? e(explode(' ', $mgmt->name)[0]) : '&nbsp;' !!}</span>
            </td>
            <td width="50%" style="vertical-align: bottom; padding: 0; text-align: right;">
                T. Tangan :
                @if ($mgmt && $mgmt->signature)
                    <img src="{{ public_path('storage/' . $mgmt->signature->getSignatureImagePath()) }}"
                        style="max-height: 80px; vertical-align: bottom;">
                @else
                    <span class="border-bottom" style="min-width: 150px">&nbsp;</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="mt-4" style="font-size: 12px">
        *) Diisi oleh Bag. Personalia
    </div>

    <div style="text-align: right; font-size: 10px; margin-top: 20px">
        C.008/09
    </div>
</body>

</html>
