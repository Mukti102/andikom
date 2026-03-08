<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcment->title }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f9; color: #333;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        
        <tr>
            <td style="padding: 40px 20px; text-align: center; 
                background-color: {{ $announcment->type == 'danger' ? '#dc3545' : ($announcment->type == 'warning' ? '#ffc107' : '#0d6efd') }};">
                <h1 style="margin: 0; color: #ffffff; font-size: 24px; text-transform: uppercase; letter-spacing: 1px;">
                    Pengumuman Baru
                </h1>
            </td>
        </tr>

        <tr>
            <td style="padding: 40px 30px;">
                <h2 style="margin-top: 0; color: #1a1a1a; font-size: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">
                    {{ $announcment->title }}
                </h2>
                <p style="font-size: 16px; line-height: 1.6; color: #555; white-space: pre-line;">
                    {{ $announcment->message }}
                </p>
                
                <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-left: 4px solid #0d6efd; border-radius: 4px;">
                    <p style="margin: 0; font-size: 14px; color: #777;">
                        <strong>Status:</strong> 
                        <span style="color: {{ $announcment->type == 'danger' ? '#dc3545' : '#0d6efd' }}; text-transform: capitalize;">
                            {{ $announcment->type }}
                        </span>
                    </p>
                </div>
            </td>
        </tr>

        <tr>
            <td style="padding: 0 30px 40px; text-align: center;">
                <a href="{{ config('app.url') }}" style="display: inline-block; padding: 14px 30px; background-color: #0d6efd; color: #ffffff; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);">
                    Buka Aplikasi
                </a>
            </td>
        </tr>

        <tr>
            <td style="padding: 20px; background-color: #f4f7f9; text-align: center; font-size: 12px; color: #999;">
                <p style="margin: 0 0 10px;">Email ini dikirim secara otomatis oleh sistem LKP ANDIKOM.</p>
                <p style="margin: 0;">&copy; {{ date('Y') }} ANDIKOM Bojonegoro. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>