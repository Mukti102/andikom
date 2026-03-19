<!DOCTYPE html>
<html>
<head>
    <title>Akun Aktif</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 10px; shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="color: #28a745;">Selamat!</h1>
        </div>
        
        <p>Halo <strong>{{ $peserta->nama_lengkap }}</strong>,</p>
        
        <p>Kami senang memberitahu Anda bahwa tim admin telah selesai memverifikasi dokumen Anda. Saat ini, status pendaftaran Anda telah <strong>AKTIF</strong>.</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-left: 4px solid #28a745; margin: 20px 0;">
            <p style="margin: 0;"><strong>Detail Akun:</strong></p>
            <ul style="list-style: none; padding: 0;">
                <li>NIS: {{ $peserta->nis }}</li>
                <li>Email: {{ $peserta->user->email }}</li>
            </ul>
        </div>

        <p>Anda sekarang dapat masuk ke sistem untuk melihat jadwal, materi, atau informasi penting lainnya.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" 
               style="background-color: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
               Login ke Akun Anda
            </a>
        </div>

        <p>Jika Anda memiliki pertanyaan, jangan ragu untuk membalas email ini atau menghubungi bagian administrasi.</p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
        <p style="font-size: 0.8em; color: #777; text-align: center;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Semua Hak Dilindungi.
        </p>
    </div>
</body>
</html>