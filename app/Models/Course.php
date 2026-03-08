<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $guarded = ['id'];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'course_id');
    }

    public function materis()
    {
        return $this->hasMany(Materi::class, 'course_id');
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'course_tool');
    }

    // app/Models/Course.php
    public function getSisaSlotAttribute()
    {
        $terisi = $this->pendaftarans()->where('status', 'aktif')->count();
        return $this->max_slot - $terisi;
    }
}
