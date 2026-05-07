<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Pembayaran</title>
</head>

<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4; padding:30px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td align="center"
                            style="background:#2563eb; color:#ffffff; padding:30px 20px;">
                            <h1 style="margin:0; font-size:24px;">
                                Reminder Pembayaran
                            </h1>
                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td style="padding:30px; color:#333333;">

                            <p style="font-size:16px;">
                                Halo,
                            </p>

                            <p style="font-size:16px; line-height:1.8;">
                                Kami ingin mengingatkan bahwa Anda memiliki tagihan pembayaran yang belum dibayar.
                            </p>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse; margin-top:20px;">

                                <tr style="background:#f9fafb;">
                                    <td style="border:1px solid #e5e7eb;">
                                        <strong>Angsuran Ke</strong>
                                    </td>
                                    <td style="border:1px solid #e5e7eb;">
                                        {{ $tagihan->angsuran_ke }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #e5e7eb;">
                                        <strong>Jatuh Tempo</strong>
                                    </td>
                                    <td style="border:1px solid #e5e7eb;">
                                        {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->translatedFormat('d F Y') }}
                                    </td>
                                </tr>

                                <tr style="background:#f9fafb;">
                                    <td style="border:1px solid #e5e7eb;">
                                        <strong>Nominal</strong>
                                    </td>
                                    <td style="border:1px solid #e5e7eb;">
                                        Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #e5e7eb;">
                                        <strong>Status</strong>
                                    </td>
                                    <td style="border:1px solid #e5e7eb;">
                                        <span style="
                                            padding:5px 10px;
                                            background:#fef3c7;
                                            color:#92400e;
                                            border-radius:5px;
                                            font-size:12px;
                                            font-weight:bold;
                                        ">
                                            {{ strtoupper($tagihan->status) }}
                                        </span>
                                    </td>
                                </tr>

                            </table>

                            <p style="margin-top:30px; font-size:15px; line-height:1.8;">
                                Mohon segera melakukan pembayaran sebelum tanggal jatuh tempo agar tidak terjadi keterlambatan.
                            </p>

                            <p style="font-size:15px;">
                                Terima kasih.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center"
                            style="background:#f9fafb; padding:20px; font-size:12px; color:#6b7280;">
                            © {{ date('Y') }} Sistem Pembayaran
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>