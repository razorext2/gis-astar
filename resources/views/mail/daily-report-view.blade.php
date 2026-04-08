<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Harian</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:20px;">
        <tr>
            <td align="center">

                <!-- Container -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden;">

                    <!-- Header (Logo) -->
                    <tr>
                        <td align="center" style="padding:20px; background-color:#cb2828;">
                            <img src="https://attendance.indodacin.com/assets/img/logo.png" alt="Logo Perusahaan"
                                style="height:50px;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; color:#333;">
                            <p style="font-size:16px; line-height:1.6;">
                                Terimakasih <strong>{{ $namaPenanggungJawab }}</strong>, telah memberikan kami
                                kepercayaan untuk melaksanakan pelayanan yang Anda pilih.
                            </p>

                            <p style="font-size:16px; line-height:1.6;">
                                Berikut kami lampirkan rekap laporan harian dari Staff kami
                                <strong>[{{ $namaStaff }}]</strong> yang melaksanakan tugas di
                                <strong>{{ $namaPerusahaan }}</strong>.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:15px; text-align:center; font-size:12px; color:#999;">
                            © {{ date('Y') }} PT. Indodacin Presisi Utama
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
