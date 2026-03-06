<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $guarded = ['id'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_tool');
    }
}
