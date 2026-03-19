<!DOCTYPE html>
<html>

<head>
    <title>Notifikasi Pendaftaran Baru</title>
</head>

<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo Admin,</h2>
    <p>Ada peserta baru yang baru saja mendaftar ke sistem:</p>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 150px; font-weight: bold;">Nama Lengkap</td>
            <td>: {{ $peserta->nama_lengkap }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">NIS</td>
            <td>: {{ $peserta->nis }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Asal Sekolah</td>
            <td>: {{ $peserta->asal_sekolah ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">No. HP</td>
            <td>: {{ $peserta->no_hp }}</td>
        </tr>
    </table>

    <p>Silakan login ke panel admin untuk melakukan verifikasi dokumen.</p>

    <div style="margin-top: 20px;">
        <a href="{{ route('admin.peserta.index') }}"
            style="background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Buka Dashboard Admin
        </a>
    </div>

    <p style="margin-top: 40px; font-size: 0.8em; color: #777;">Email ini dikirim otomatis oleh sistem.</p>
</body>

</html>
