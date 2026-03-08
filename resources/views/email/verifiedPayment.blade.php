<!DOCTYPE html>
<html>

<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 20px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <tr
            style="background-color: {{ $pembayaran->status_verifikasi == 'completed' ? '#198754' : '#dc3545' }}; color: #fff;">
            <td style="padding: 30px; text-align: center;">
                <h1 style="margin: 0; font-size: 24px;">
                    {{ $pembayaran->status_verifikasi == 'completed' ? 'Pembayaran Berhasil Diverifikasi!' : 'Pembayaran Ditolak' }}
                </h1>
            </td>
        </tr>

        <tr style="padding: 20px;">
            <td style="padding: 30px;">
                <p style="font-size: 16px; color: #333;">Halo
                    <strong>{{ $pembayaran->tagihan->pendaftaran->peserta->user->name }}</strong>,
                </p>

                @if ($pembayaran->status_verifikasi == 'completed')
                    <p style="color: #555; line-height: 1.6;">
                        Selamat! Pembayaran Anda untuk kursus
                        <strong>{{ $pembayaran->tagihan->pendaftaran->course->name_paket }}</strong> telah kami terima
                        dan diverifikasi. Anda sekarang memiliki akses penuh ke materi pembelajaran.
                    </p>
                @else
                    <p style="color: #555; line-height: 1.6;">
                        Mohon maaf, pembayaran Anda belum dapat kami proses.
                    </p>
                    <div style="background: #fff3f3; border-left: 4px solid #dc3545; padding: 15px; margin: 20px 0;">
                        <strong style="color: #dc3545;">Alasan:</strong><br>
                        {{ $pembayaran->reason }}
                    </div>
                    <p style="color: #555;">Silakan perbaiki bukti pembayaran atau hubungi admin jika ada kendala.</p>
                @endif

                <div style="margin-top: 30px; text-align: center;">
                    <a href="{{ route('user.tagihan', $pembayaran->tagihan->id) }}"
                        style="background: #0d6efd; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 50px; font-weight: bold;">
                        {{ $pembayaran->status_verifikasi == 'completed' ? 'Mulai Belajar' : 'Perbaiki Pembayaran' }}
                    </a>
                </div>
            </td>
        </tr>

        <tr style="background-color: #f8f9fa;">
            <td style="padding: 20px; text-align: center; color: #888; font-size: 12px;">
                © {{ date('Y') }} LKP ANDIKOM. Jika Anda merasa tidak melakukan transaksi ini, abaikan email ini.
            </td>
        </tr>
    </table>
</body>

</html>
