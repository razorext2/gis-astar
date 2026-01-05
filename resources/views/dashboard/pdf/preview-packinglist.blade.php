<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Packing List</title>

    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
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

        .justify-center {
            justify-content: center;
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

        .border-b {
            border-bottom: 2px solid #000;
        }

        .page-break {
            page-break-before: always;
            break-before: page;
        }
    </style>
</head>

<body>
    <div id="item-details" class="relative" style="min-height: 100vh">
        <div id="header" class="flex w-full justify-center" style="margin-bottom: 40px">
            <h4 class="text-center"
                style="
                        padding: 0.5rem;
                        border: 4px solid #000;
                        width: fit-content;
                    ">
                Daftar Alat & Barang yang Dibawa
            </h4>
        </div>
    </div>

    <div class="page-break"></div>

    <div id="packing-list" class="relative" style="min-height: 100vh">
        <div id="header" class="flex flex-col">
            <div class="flex w-full justify-center" style="margin-bottom: 40px">
                <h4 class="text-center"
                    style="
                            padding: 0.5rem;
                            border: 4px solid #000;
                            width: fit-content;
                        ">
                    Berita Acara Serah Terima Barang / Packing List
                </h4>
            </div>

            {{-- header bagian informasi tanggal dan nama customer --}}
            <table class="w-full">
                <tr>
                    <td>Pada hari ini tanggal:</td>
                    <td colspan="2">
                        {{ today()->locale('id')->format('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Telah dikirim/ diserah-terimakan barang untuk atas
                        nama:
                    </td>
                </tr>
                <tr>
                    <td width="50%"></td>
                    <td class="border-b">
                        {{ $data['nama_customer' ?? '-'] }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="border-b">
                        <p></p>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="border-b">
                        <p></p>
                    </td>
                    <td></td>
                </tr>
            </table>

            {{-- header untuk nama barang dan jumlah --}}
            <table width="100%" style="margin-top: 20px; margin-bottom: 20px">
                <tr>
                    <td width="20%">{{ $data['jumlah_barang'] }}</td>
                    <td>{{ $data['nama_barang'] }}</td>
                </tr>
            </table>
        </div>

        <div id="content" class="flex flex-col text-justify">
            <p>Detail Barang:</p>

            <table id="barangTable" width="100%">
                @php $total = 0; @endphp @foreach ($data['daftar_part'] as $index => $row)
                    @php $total += $row['jumlah']; @endphp
                    <tr>
                        <td width="2.5%">{{ $index + 1 }}</td>
                        <td class="border-b" width="55%" style="padding-left: 0.5em">
                            {{ $row['nama_part'] }}
                        </td>
                        <td class="border-b text-center">
                            {{ $row['jumlah'] }}
                        </td>
                        <td class="border-b text-center">
                            {{ $row['satuan'] }}
                        </td>
                        <td class="border-b text-center">{{ $row['pack'] }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td width="2.5%"></td>
                    <td class="border-b" style="font-weight: bold">
                        Total item
                    </td>
                    <td colspan="3" class="border-b text-center" style="font-weight: bold">
                        {{ $total }} Koli
                    </td>
                </tr>
            </table>
        </div>

        <div id="footer" class="w-full">
            <p>Note :</p>

            <p>{!! nl2br(e($data['note'])) !!}</p>

            <p>
                Demikianlah Berita Acara Serah Terima Barang / Packing List
                ini dibuat, agar dapat dipergunakan dengan baik Material
                yang tertera di atas telah diterima dengan baik dan sesuai.
            </p>

            <br />

            <table class="w-full">
                <tr>
                    <td class="text-center" colspan="2"></td>
                    <td class="text-center" width="33%">
                        Medan, {{ today()->locale('id')->format('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Dikirim Oleh:</td>
                    <td class="text-center">Dibawa & Diserahkan Oleh:</td>
                    <td class="text-center">Diterima Oleh:</td>
                </tr>
                <tr>
                    <td colspan="3" height="60px"></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"></td>
                </tr>
                <tr>
                    <td class="text-center" style="text-decoration: underline">
                        S u r y a C a i
                    </td>
                    <td class="text-center">
                        <span
                            style="
                                    border-bottom: 1px solid #000;
                                    padding: 0 0.5em 0 0.5em;
                                ">{{ $data['nama_ekspedisi'] }}</span>
                    </td>
                    <td class="text-center">
                        a/n :
                        <span
                            style="
                                    border-bottom: 1px solid #000;
                                    padding: 0 0.5em 0 0.5em;
                                ">{{ $data['contact_person'] }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"></td>
                    <td class="text-center">
                        {{ $data['nama_customer'] }}
                    </td>
                </tr>
            </table>

            <p style="font-style: italic">Catatan:</p>

            <ul style="font-size: 0.75em">
                <li>
                    Semua biaya yang terjadi dalam Perjalanan merupakan
                    tanggung jawab pihak pengangkutan.
                </li>
                <li>
                    Semua biaya yang terjadi di Lokasi merupakan tanggung
                    jawab Penerima barang ( Customers ) Sesuai dengan
                    perjanjian & kontrak yang disepakati.
                </li>
            </ul>
        </div>
    </div>
</body>

</html>
