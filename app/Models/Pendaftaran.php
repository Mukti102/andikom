<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $guarded = ['id'];

    protected $attributes = [
        'status' => 'aktif',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'pendaftaran_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
