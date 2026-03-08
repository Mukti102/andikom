<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $guarded = ['id'];

    // Di dalam model Jadwal.php
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
}
