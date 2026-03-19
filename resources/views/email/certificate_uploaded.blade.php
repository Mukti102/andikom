@component('mail::message')
    # Halo, {{ $nilai->pendaftaran->peserta->nama_lengkap }}!

    Selamat! Kami informasikan bahwa sertifikat untuk paket pelatihan **{{ $nilai->pendaftaran->course->name_paket }}**
    telah berhasil diterbitkan.

    **Detail Sertifikat:**
    * **Nomor Sertifikat:** {{ $nilai->nomor_sertifikat }}
    * **Status:** Lulus / Tersedia

    Anda dapat melihat detail nilai dan mengunduh sertifikat Anda melalui tombol di bawah ini:

    @component('mail::button', ['url' => asset('storage/' . $nilai->certificate_path)])
        Lihat Sertifikat
    @endcomponent

    Jika tombol di atas tidak berfungsi, silakan klik tautan di bawah ini:
    <{{ config('app.url') . '/dashboard' }}>

        Terima kasih telah mengikuti pelatihan bersama kami. Teruslah berkarya!

        Salam,
        **{{ config('app.name') }} Team**
    @endcomponent
