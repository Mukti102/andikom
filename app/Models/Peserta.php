<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'nis',
        'nama_lengkap',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat_sekarang',
        'pekerjaan',
        'no_hp',
        'asal_sekolah',
        'nama_ayah',
        'nama_ibu',
        'hp_orang_tua',
        'status_tempat_tinggal',
        'status_aktif'
    ];

    /**
     * Relasi Balik ke User (Satu Peserta memiliki satu akun User)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'peserta_id');
    }

    public function documents()
    {
        return $this->hasOne(Document::class, 'peserta_id');
    }
}
