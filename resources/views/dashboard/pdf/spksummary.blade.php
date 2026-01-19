<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Surat Perintah Kerja</title>

    <style type="text/css">
        body {
            margin: 0;
            padding: 32px;
            box-sizing: border-box;
        }

        .p-0 {
            padding: 0;
        }

        .m-0 {
            margin: 0;
        }

        .flex {
            display: flex;
        }

        .w-full {
            width: 100%;
        }

        .h-full {
            height: 100%;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .underline {
            text-decoration: underline;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .text-justify {
            text-align: justify;
        }

        .font-semibold {
            font-weight: 600;
        }

        .relative {
            position: relative;
        }

        .page-break {
            page-break-before: always;
            break-before: page;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }
    </style>
</head>

<body class="relative" style="min-height: 100vh">
    <div id="header" class="flex flex-col">
        <table id="table-header" class="w-full">
            <tr>
                <td width="20%">Nomor</td>
                <td width="5%">:</td>
                <td>{{ $data->nomor_order ?? '-' }}</td>
                <td width="50%" class="text-right">Lembaran _</td>
            </tr>
            <tr>
                <td width="20%">Tanggal SPK</td>
                <td width="5%">:</td>
                <td colspan="2">
                    {{ $data->tgl_cetak ? \Carbon\Carbon::parse($data->tgl_cetak)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                </td>
            </tr>
            <tr>
                <td width="20%">Waktu Penyerahan</td>
                <td width="5%">:</td>
                <td colspan="2">
                    @if ($data->tgl_kirim <= 1)
                        SEGERA
                    @else
                        {{ $data->tgl_kirim . ' Hari' }}
                    @endif
                </td>
            </tr>
        </table>

        <h2 id="title-header" class="text-center uppercase underline">
            Surat Perintah Kerja
        </h2>
    </div>

    <div id="content" class="flex flex-col text-justify">
        <p style="padding: 0; margin: 0">
            Mohon dapat dilaksanakan / dikerjakan, hal - hal dibawah ini :
        </p>

        <div id="list-barang-container">
            <ul id="list-barang" style="list-style: lower-alpha">
                @forelse ($data->products as $item)
                    <li>
                        <p style="padding: 0; margin: 0" class="font-semibold">
                            {{ $item['jumlah_unit'] }} Unit {{ $item['nama_barang'] }}
                        </p>
                        <span>
                            {!! nl2br(e($item['spesifikasi'] ?? '')) !!}
                        </span>
                    </li>
                @empty
                @endforelse
            </ul>
        </div>

        <p>{!! nl2br(e($data['keterangan'] ?? '')) !!}</p>
    </div>

    <div class="page-break"></div>

    <div id="footer" class="h-full w-full">
        <table id="sign-header-table" class="w-full">
            <tr>
                <td colspan="3" class="uppercase">waktu penyerahan :</td>
            </tr>
            <tr>
                <td class="uppercase" width="20%">untuk</td>
                <td colspan="2">{{ $data->customer['nama_perusahaan'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="uppercase" width="20%">alamat</td>
                <td colspan="2">{{ $data->customer['alamat'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="uppercase" width="20%">c. person</td>
                <td colspan="2">{{ $data->customer['contact_person'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="uppercase" width="20%">no tlp / hp</td>
                <td colspan="2">{{ $data->customer['no_hp'] ?? '-' }}</td>
            </tr>
        </table>

        <table class="w-full" style="margin-top: 100px">
            <tr>
                <td width="33%"></td>
                <td width="34%"></td>
                <td width="33%">
                    <p style="margin: 0">
                        Medan, {{ today()->locale('id')->isoFormat('D MMMM Y') }}
                    </p>
                    <p style="margin: 0">Dilaksanakan Oleh,</p>
                </td>
            </tr>

            <tr>
                <td>Dibuat Oleh,</td>
                <td></td>
                <td>Mekanik/Produksi</td>
            </tr>

            <tr style="padding:0; margin: 0;">
                <td style="position:relative; padding: 0; line-height: 0;">
                    <div style="position: relative; height: 115px;">

                        @if ($data->addedBy->signature)
                            <img class="items-center"
                                src="{{ asset('storage/' . $data->addedBy->signature->getSignatureImagePath()) }}"
                                style="position: absolute; top:0; left:20%; width: 125px;display: block;margin: 0;">

                            <span style="position: absolute; right: 10px;bottom: 10;font-size: 10px;line-height: 1;">
                                Digitally sign at:<br>{{ $data->created_at }}
                            </span>
                        @endif

                        <p style="position: absolute; width:100%;  bottom: -20px; text-decoration: underline;">
                            ({{ $data->addedBy->name }})
                        </p>
                    </div>
                </td>
                <td>{{-- cell kosong --}}</td>
                <td style="position:relative; padding: 0; line-height: 0;">
                    <div style="position: relative; height: 115px;">
                        {{-- <img class="items-center" src="{{ asset('storage/' . $data['assign_to_signature_img']) }}"
                            style="position: absolute; top:0; left:20%; width: 125px;display: block;margin: 0;">

                        <span style="position: absolute; right: 10px;bottom: 10;font-size: 10px;line-height: 1;">
                            Digitally sign at:<br>{{ now() }}
                        </span> --}}

                        <p style="position: absolute; width:100%;  bottom: -20px; text-decoration: underline;">
                            ({{ $data->assignTo->name }})
                        </p>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="3" height="20px"></td>
            </tr>

            <tr>
                <td colspan="3">Disetujui Oleh,</td>
            </tr>

            <tr style="vertical-align: top;">
                <td style="position:relative; padding: 0; line-height: 0;">
                    <div style="position: relative; height: 115px;">
                        @if ($data->approvedBy?->signature)
                            <img class="items-center"
                                src="{{ asset('storage/' . $data->approvedBy->signature->getSignatureImagePath()) }}"
                                style="position: absolute; top:0; left:20%; width: 125px;display: block;margin: 0;">

                            <span style="position: absolute; right: 10px;bottom: 10;font-size: 10px;line-height: 1;">
                                Digitally sign at:<br>{{ $data->approved_at }}
                            </span>
                        @endif

                        <p style="position: absolute; width:100%; bottom: -20px; text-decoration: underline;">
                            ({{ $data->approvedBy->name ?? 'Suriatini' }})
                        </p>
                    </div>
                </td>

                <td style="vertical-align: top;"></td>
                <td style="vertical-align: top;"></td>
            </tr>
        </table>
    </div>
</body>

</html>
