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

        .flex {
            display: flex;
        }

        .flex-row {
            flex-direction: row;
        }

        .flex-col {
            flex-direction: column;
        }

        .justify-between {
            justify-content: space-between;
        }

        .w-full {
            width: 100%;
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
    </style>
</head>

<body class="relative" style="min-height: 100vh">
    <div id="header" class="flex flex-col">
        <table class="w-full">
            <tr>
                <td width="20%">Nomor</td>
                <td width="5%">:</td>
                <td>{{ $data['nomor_order'] ?? '-' }}</td>
                <td width="50%" class="text-right">Lembaran 5</td>
            </tr>
            <tr>
                <td width="20%">Tanggal SPK</td>
                <td width="5%">:</td>
                <td colspan="2">{{ $data['tgl_cetak'] ?? '-' }}</td>
            </tr>
            <tr>
                <td width="20%">Tanggal Selesai</td>
                <td width="5%">:</td>
                <td colspan="2">{{ $data['tgl_kirim'] ?? '-' }}</td>
            </tr>
        </table>

        <h2 class="text-center uppercase underline">
            Surat Perintah Kerja
        </h2>
    </div>

    <div id="content" class="flex flex-col text-justify">
        <p style="margin-bottom: 10px">
            Mohon dapat dilaksanakan / dikerjakan, hal - hal dibawah ini :
        </p>

        <p class="font-semibold uppercase">
            @forelse ($data['barang'] as $barang)
                {{ $barang['nama_barang'] . ' (' . $barang['jumlah_unit'] . ' Unit)' }}{{ $loop['last'] ? '.' : ',' }}
            @empty
                Tidak ada barang yang dilist.
            @endforelse
        </p>

        <p style="margin-top: 10px">
            {{ $data['keterangan'] ?? '-' }}
        </p>
    </div>

    <div id="footer" style="margin-top: 100px" class="w-full">
        <table class="w-full">
            <tr height="40px">
                <td colspan="3" class="uppercase">waktu penyerahan :</td>
            </tr>
            <tr>
                <td colspan="2" class="uppercase" width="15%">untuk</td>
                <td>{{ $data['nama_customer'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="uppercase" width="15%">alamat</td>
                <td>{{ $data['alamat_customer'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="uppercase" width="15%">c. personel</td>
                <td>{{ $data['contact_person'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="uppercase" width="15%">no tlp / hp</td>
                <td>{{ $data['no_telp'] ?? '-' }}</td>
            </tr>
        </table>

        <table class="w-full" style="margin-top: 10px">
            <tr>
                <td></td>
                <td></td>
                <td width="30%" class="text-center">
                    <p style="margin: 6px">Medan, Tanggal</p>
                    <p style="margin: 6px">Dilaksanakan Oleh,</p>
                </td>
            </tr>
            <tr>
                <td>Dibuat Oleh,</td>
                <td></td>
                <td class="text-center">Bagian Mekanik</td>
            </tr>
            <tr>
                <td height="60px" colspan="3"></td>
            </tr>
            <tr>
                <td class="underline">({{ $data['assign_to'] }})</td>
                <td></td>
                <td class="text-center underline">
                    (_____________________)
                </td>
            </tr>
            <tr>
                <td colspan="3" height="40px" class="text-center">Disetujui Oleh,</td>
            </tr>
            <tr>
                <td height="60px" colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3" class="underline" class="text-center">(Suriyatini)</td>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
