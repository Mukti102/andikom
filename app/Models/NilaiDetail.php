<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiDetail extends Model
{
    protected $guarded = ['id'];

    public function nilai()
    {
        return $this->belongsTo(Nilai::class, 'nilai_id');
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'tool_id');
    }
}
