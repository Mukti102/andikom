<!DOCTYPE html>
<html>
<body style="margin: 0; padding: 0; font-family: sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 20px auto; background: #fff; border-radius: 8px; overflow: hidden;">
        <tr style="background: #0d6efd; color: #fff;">
            <td style="padding: 20px; text-align: center;">
                <h3 style="margin: 0;">Notifikasi Pembayaran Baru</h3>
            </td>
        </tr>
        
        <tr style="padding: 20px;">
            <td style="padding: 20px;">
                <p>Halo Admin,</p>
                <p>Terdapat konfirmasi pembayaran baru yang menunggu verifikasi Anda:</p>
                
                <table width="100%" style="border-collapse: collapse; margin-top: 15px;">
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Peserta:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $pembayaran->tagihan->pendaftaran->peserta->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Kursus:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $pembayaran->tagihan->pendaftaran->course->name_paket }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Nominal:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Status:</strong></td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">
                            <span style="color: #ffc107; font-weight: bold;">{{ strtoupper($pembayaran->status_verifikasi) }}</span>
                        </td>
                    </tr>
                </table>

                <div style="margin-top: 25px; text-align: center;">
                    <a href="{{ url('/admin/pembayaran/' . $pembayaran->id) }}" 
                       style="background: #0d6efd; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                       Verifikasi Pembayaran
                    </a>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>